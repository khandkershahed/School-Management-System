<?php

namespace App\Support;

use App\Models\Exam;
use App\Models\Post;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Read-only dashboard projections. No writes, migrations, or business-rule changes.
 * All monetary amounts remain grouped by their stored currency_code.
 */
class WyzeekDashboardOverview
{
    public static function admin(): array
    {
        $today = Carbon::today();
        $lastSeven = $today->copy()->subDays(6);
        $months = [];

        for ($index = 5; $index >= 0; $index--) {
            $month = $today->copy()->startOfMonth()->subMonths($index);
            $months[] = [
                'label' => $month->format('M'),
                'year' => $month->format('Y'),
                'value' => DB::table('students')->whereNull('deleted_at')
                    ->where('created_at', '>=', $month->toDateTimeString())
                    ->where('created_at', '<', $month->copy()->addMonth()->toDateTimeString())
                    ->count(),
            ];
        }

        $invoiceCounts = DB::table('fee_invoices')
            ->where('created_at', '>=', $today->copy()->startOfMonth()->subMonths(5))
            ->selectRaw('YEAR(created_at) AS y, MONTH(created_at) AS m, COUNT(*) AS total')
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')->get()
            ->keyBy(fn ($row) => $row->y . '-' . $row->m);

        $receiptCounts = DB::table('receipt_students')
            ->where('created_at', '>=', $today->copy()->startOfMonth()->subMonths(5))
            ->selectRaw('YEAR(created_at) AS y, MONTH(created_at) AS m, COUNT(*) AS total')
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')->get()
            ->keyBy(fn ($row) => $row->y . '-' . $row->m);

        $monthlyDocuments = [];
        foreach ($months as $index => $point) {
            $month = $today->copy()->startOfMonth()->subMonths(5 - $index);
            $key = $month->year . '-' . $month->month;
            $monthlyDocuments[] = [
                'label' => $month->format('M'),
                'invoices' => (int) ($invoiceCounts->get($key)->total ?? 0),
                'receipts' => (int) ($receiptCounts->get($key)->total ?? 0),
            ];
        }

        $todayAttendance = DB::table('attendances')->whereDate('attendence_date', $today->toDateString());
        $todayTotal = (clone $todayAttendance)->count();
        $todayPresent = (clone $todayAttendance)->where('attendence_status', true)->count();

        $classes = DB::table('classrooms')
            ->leftJoin('students', function ($join) {
                $join->on('students.classroom_id', '=', 'classrooms.id')
                    ->whereNull('students.deleted_at');
            })
            ->select('classrooms.id', 'classrooms.name')
            ->selectRaw('COUNT(students.id) AS total')
            ->groupBy('classrooms.id', 'classrooms.name')
            ->orderByDesc('total')->orderBy('classrooms.name')
            ->limit(8)->get()->map(fn ($row) => [
                'name' => $row->name,
                'value' => (int) $row->total,
            ])->all();

        $invoiceCurrency = DB::table('fee_invoices')
            ->select('currency_code')->selectRaw('COUNT(*) AS documents, SUM(amount) AS total')
            ->groupBy('currency_code')->get()->keyBy('currency_code');
        $receiptCurrency = DB::table('receipt_students')
            ->select('currency_code')->selectRaw('COUNT(*) AS documents, SUM(debit) AS total')
            ->groupBy('currency_code')->get()->keyBy('currency_code');
        $currencyCodes = $invoiceCurrency->keys()->merge($receiptCurrency->keys())->unique()->sort()->values();
        $currencySummary = $currencyCodes->map(function ($code) use ($invoiceCurrency, $receiptCurrency) {
            $invoices = $invoiceCurrency->get($code);
            $receipts = $receiptCurrency->get($code);
            return [
                'code' => $code ?: 'Unspecified',
                'invoices' => (int) ($invoices->documents ?? 0),
                'invoiced' => (float) ($invoices->total ?? 0),
                'receipts' => (int) ($receipts->documents ?? 0),
                'receipt_debits' => (float) ($receipts->total ?? 0),
            ];
        })->all();

        return [
            'as_of' => $today->format('d M Y'),
            'kpis' => [
                'attendance_today' => $todayTotal,
                'present_today' => $todayPresent,
                'present_rate' => $todayTotal ? round($todayPresent * 100 / $todayTotal, 1) : null,
                'exam_count' => DB::table('exams')->count(),
                'invoice_count' => DB::table('fee_invoices')->count(),
                'receipt_count' => DB::table('receipt_students')->count(),
                'post_count' => DB::table('posts')->count(),
                'active_students' => DB::table('students')->whereNull('deleted_at')->where('graduated', false)->where('leaved', false)->count(),
                'record_count' => DB::table('attendances')->count() + DB::table('fee_invoices')->count()
                    + DB::table('receipt_students')->count() + DB::table('posts')->count(),
            ],
            'enrollments' => self::withBarHeights($months, 'value'),
            'documents' => self::withBarHeights($monthlyDocuments, 'invoices', 'receipts'),
            'attendance' => self::attendanceDays($lastSeven, $today),
            'classes' => self::withBarWidths($classes),
            'currencies' => $currencySummary,
            'recent_students' => Student::with('classroom')->latest()->take(6)->get(),
            'recent_exams' => Exam::with('subject')->latest()->take(5)->get(),
            'recent_posts' => Post::latest()->take(5)->get(),
        ];
    }

    public static function role(string $role, int $userId): array
    {
        $today = Carbon::today();
        $studentIds = [];
        $classroomIds = [];
        $studentCount = 0;
        $rows = [];
        $heading = 'Personal Overview';

        if ($role === 'teacher') {
            $teacherId = DB::table('teachers')->where('user_id', $userId)->value('id');
            if ($teacherId) {
                $classroomIds = DB::table('teacher_classrooms')->where('teacher_id', $teacherId)
                    ->pluck('classroom_id')->unique()->values()->all();
            }
            $heading = 'My Classes';
            $classCounts = DB::table('students')->whereNull('deleted_at')
                ->whereIn('classroom_id', $classroomIds)
                ->select('classroom_id')->selectRaw('COUNT(*) AS total')
                ->groupBy('classroom_id')->pluck('total', 'classroom_id');
            $studentCount = (int) $classCounts->sum();
            $classNames = DB::table('classrooms')->whereIn('id', $classroomIds)->orderBy('name')->get(['id', 'name']);
            foreach ($classNames as $class) {
                $rows[] = [
                    'name' => $class->name,
                    'subtitle' => 'Assigned classroom',
                    'total' => (int) $classCounts->get($class->id, 0),
                ];
            }
        } elseif ($role === 'student') {
            $student = DB::table('students')->where('user_id', $userId)->whereNull('deleted_at')->first();
            $heading = 'My Attendance & Invoices';
            if ($student) {
                $studentIds = [$student->id];
                $studentCount = 1;
                $classroomIds = [$student->classroom_id];
                $rows[] = [
                    'name' => $student->name,
                    'subtitle' => 'Academic year: ' . $student->academic_year,
                    'total' => DB::table('fee_invoices')->where('student_id', $student->id)->count(),
                ];
            }
        } elseif ($role === 'parent') {
            $parentId = DB::table('my_parents')->where('user_id', $userId)->value('id');
            $heading = 'My Children';
            $children = DB::table('students')->where('parent_id', $parentId ?: 0)
                ->whereNull('deleted_at')->orderBy('name')->get(['id', 'name', 'classroom_id']);
            $studentIds = $children->pluck('id')->all();
            $studentCount = count($studentIds);
            $classroomIds = $children->pluck('classroom_id')->unique()->all();
            foreach ($children as $child) {
                $rows[] = [
                    'name' => $child->name,
                    'subtitle' => 'Student ID #' . $child->id,
                    'total' => DB::table('attendances')->where('student_id', $child->id)->count(),
                ];
            }
        }

        $attendance = DB::table('attendances');
        if ($role === 'teacher') {
            $attendance->whereIn('classroom_id', $classroomIds);
        } else {
            $attendance->whereIn('student_id', $studentIds);
        }
        $total = (clone $attendance)->count();
        $present = (clone $attendance)->where('attendence_status', true)->count();

        return [
            'role' => $role,
            'heading' => $heading,
            'rows' => $rows,
            'students' => $studentCount,
            'classrooms' => count($classroomIds),
            'attendance_count' => $total,
            'present_count' => $present,
            'present_rate' => $total ? round($present * 100 / $total, 1) : null,
            'invoice_count' => $role === 'teacher' ? null : DB::table('fee_invoices')->whereIn('student_id', $studentIds)->count(),
            'attendance' => self::attendanceDays($today->copy()->subDays(6), $today, $role === 'teacher' ? null : $studentIds, $role === 'teacher' ? $classroomIds : null),
        ];
    }

    private static function attendanceDays(Carbon $start, Carbon $end, ?array $studentIds = null, ?array $classroomIds = null): array
    {
        $query = DB::table('attendances')->whereBetween('attendence_date', [$start->toDateString(), $end->toDateString()]);
        if ($studentIds !== null) {
            $query->whereIn('student_id', $studentIds);
        }
        if ($classroomIds !== null) {
            $query->whereIn('classroom_id', $classroomIds);
        }
        $grouped = $query->select('attendence_date')
            ->selectRaw('COUNT(*) AS total')
            ->selectRaw('SUM(CASE WHEN attendence_status = 1 THEN 1 ELSE 0 END) AS present')
            ->groupBy('attendence_date')->get()->keyBy('attendence_date');

        $days = [];
        $day = $start->copy();
        while ($day->lessThanOrEqualTo($end)) {
            $row = $grouped->get($day->toDateString());
            $total = (int) ($row->total ?? 0);
            $present = (int) ($row->present ?? 0);
            $days[] = [
                'label' => $day->format('D'),
                'date' => $day->format('d M'),
                'total' => $total,
                'present' => $present,
                'absent' => $total - $present,
                'present_pct' => $total ? round(100 * $present / $total, 2) : 0,
                'absent_pct' => $total ? round(100 * ($total - $present) / $total, 2) : 0,
            ];
            $day->addDay();
        }
        return $days;
    }

    private static function withBarHeights(array $values, string $first, ?string $second = null): array
    {
        $max = 1;
        foreach ($values as $row) {
            $max = max($max, (int) $row[$first], $second ? (int) $row[$second] : 0);
        }
        foreach ($values as &$row) {
            $row['height'] = $row[$first] ? round($row[$first] * 100 / $max, 2) : 0;
            if ($second) {
                $row['height_two'] = $row[$second] ? round($row[$second] * 100 / $max, 2) : 0;
            }
        }
        unset($row);
        return $values;
    }

    private static function withBarWidths(array $values): array
    {
        $max = max(1, ...array_map(fn ($row) => (int) $row['value'], $values));
        foreach ($values as &$row) {
            $row['width'] = $row['value'] ? round($row['value'] * 100 / $max, 2) : 0;
        }
        unset($row);
        return $values;
    }
}
