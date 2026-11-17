<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Synthetic school dataset for a SEPARATE LOCAL/STAGING DATABASE ONLY.
 * Never run against the provided live database or a production database.
 * Intentionally does not fabricate audit trails, uploaded media, auth sessions,
 * passwords reset tokens, failed jobs, access tokens, or enum/reference values.
 * Every insert is idempotent: existing records are never updated or deleted.
 */
class WyzeekClientDemoSeeder extends Seeder
{
    private const TAG = '[WYZEEK-DEMO]';

    /** @var array<string, int> */
    private array $inserted = [];

    private function add(string $table, array $identity, array $values = []): int
    {
        $query = DB::table($table);
        foreach ($identity as $column => $value) {
            $query->where($column, $value);
        }
        $existing = $query->value('id');
        if ($existing !== null) {
            return (int) $existing;
        }
        $now = Carbon::now()->toDateTimeString();
        $data = array_merge($identity, $values);
        $data['created_at'] = $now;
        $data['updated_at'] = $now;
        $id = DB::table($table)->insertGetId($data);
        $this->inserted[$table] = ($this->inserted[$table] ?? 0) + 1;
        return (int) $id;
    }

    private function pivot(string $table, array $identity): void
    {
        $query = DB::table($table);
        foreach ($identity as $key => $value) {
            $query->where($key, $value);
        }
        if (!$query->exists()) {
            DB::table($table)->insert(array_merge($identity, [
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]));
            $this->inserted[$table] = ($this->inserted[$table] ?? 0) + 1;
        }
    }

    private function guard(): string
    {
        $required = [
            'academic_years', 'attendances', 'classrooms', 'classroom_subject', 'currencies',
            'events', 'exams', 'fees', 'feetypes', 'fee_invoices', 'fund_accounts',
            'genders', 'grades', 'my_parents', 'nationalities', 'notifications', 'online_classes',
            'payment_students', 'posts', 'post_comments', 'post_downvotes', 'post_upvotes',
            'processing_fees', 'promotions', 'receipt_students', 'religions', 'roles', 'role_user',
            'specializations', 'students', 'student_accounts', 'subjects', 'teachers',
            'teacher_classrooms', 'type__bloods', 'users',
        ];
        foreach ($required as $table) {
            if (!Schema::hasTable($table)) {
                throw new RuntimeException('Missing required migrated table: ' . $table);
            }
        }

        // Keep a stable, randomly generated credential for demo accounts across repeated runs.
        // This file is outside public/ and must not be committed or shared.
        $passwordFile = storage_path('app/wyzeek_demo_password.txt');
        if (is_file($passwordFile)) {
            $password = trim((string) file_get_contents($passwordFile));
            if (strlen($password) < 16) {
                throw new RuntimeException('Invalid demo password file: ' . $passwordFile);
            }
            return $password;
        }

        $password = Str::random(24);
        if (file_put_contents($passwordFile, $password . PHP_EOL, LOCK_EX) === false) {
            throw new RuntimeException('Cannot save demo password to: ' . $passwordFile);
        }
        @chmod($passwordFile, 0600);
        $this->command?->info('Demo account password saved privately at: ' . $passwordFile);

        return $password;
    }

    /** Read a valid referenced ID from the existing imported/reference data. */
    private function first(string $table): int
    {
        $id = DB::table($table)->orderBy('id')->value('id');
        if ($id === null) {
            throw new RuntimeException('Seed reference data first (table empty): ' . $table);
        }
        return (int) $id;
    }

    public function run(): void
    {
        $password = $this->guard();
        $this->command?->warn('Adding synthetic demo records to the currently configured database. Back up this database before running.');
        DB::transaction(function () use ($password): void {
            $this->seedAll($password);
        }, 3);
        foreach ($this->inserted as $table => $count) {
            $this->command?->line($table . ': ' . $count . ' new demo rows');
        }
        $this->command?->info('Completed without modifying or deleting any pre-existing row.');
    }

    private function seedAll(string $password): void
    {
        $genderIds = DB::table('genders')->orderBy('id')->pluck('id')->all();
        $bloodIds = DB::table('type__bloods')->orderBy('id')->pluck('id')->all();
        $religionIds = DB::table('religions')->orderBy('id')->pluck('id')->all();
        $nationality = DB::table('nationalities')->where('name', 'like', '%Bangladeshi%')->value('id');
        $roleIds = DB::table('roles')->pluck('id', 'name');
        $requiredRoles = ['Teacher', 'Student', 'Parent'];
        foreach ($requiredRoles as $role) {
            if (!$roleIds->has($role)) {
                throw new RuntimeException('Missing required role: ' . $role);
            }
        }
        if (!$genderIds || !$bloodIds || !$religionIds || !$nationality || !DB::table('currencies')->where('code', 'BDT')->exists()) {
            throw new RuntimeException('Required reference data missing (genders/bloods/religions/Bangladeshi/BDT).');
        }
        $grades = array_map('intval', DB::table('grades')->orderBy('id')->pluck('id')->all());
        if (count($grades) < 2) {
            throw new RuntimeException('At least two existing education grades are required.');
        }

        // 30 realistic academic year/term records; uniqueness is (name, term).
        for ($i = 0; $i < 30; $i++) {
            $start = 2022 + intdiv($i, 3);
            $term = 'Term ' . (1 + $i % 3);
            $this->add('academic_years', ['name' => $start . '/' . ($start + 1), 'term' => $term], [
                'start_year' => $start, 'end_year' => $start + 1,
                'description' => 'Institutional academic calendar and term schedule',
            ]);
        }

        // Keep the actual 13 grades as real grade levels. Complete the 26 existing classrooms to 30.
        $additional = [
            ['KG3', 0], ['1/3', 1], ['2/3', 2], ['3/3', 3],
        ];
        foreach ($additional as [$label, $gradePosition]) {
            $this->add('classrooms', ['name' => $label], [
                'grade_id' => $grades[$gradePosition % count($grades)],
                'description' => 'Additional classroom section for the academic session',
            ]);
        }
        $classrooms = DB::table('classrooms')->whereNotNull('grade_id')->orderBy('id')->get(['id', 'grade_id'])->all();
        if (count($classrooms) < 30) {
            throw new RuntimeException('Expected >=30 valid classrooms after reference setup.');
        }
        $classForGrade = [];
        foreach ($classrooms as $room) {
            $classForGrade[(int) $room->grade_id] ??= (int) $room->id;
        }

        $firstNames = [
            'Mahmud', 'Nusrat', 'Rafiq', 'Farhana', 'Saif', 'Sadia', 'Imran', 'Maliha',
            'Tamim', 'Jannat', 'Arif', 'Tania', 'Fahim', 'Sharmin', 'Tanvir', 'Nabila',
            'Ashraf', 'Tasnim', 'Sakib', 'Mim', 'Rakib', 'Sultana', 'Hasan', 'Raisa',
            'Nayeem', 'Labiba', 'Sohag', 'Mahjabin', 'Farid', 'Rumana',
        ];
        $lastNames = [
            'Rahman', 'Islam', 'Ahmed', 'Akter', 'Hossain', 'Begum', 'Sarker', 'Chowdhury',
            'Khan', 'Jahan', 'Mollah', 'Talukder', 'Biswas', 'Haque', 'Karim', 'Parvin',
        ];
        $places = ['Sonadanga, Khulna', 'Khalishpur, Khulna', 'Boyra, Khulna', 'Daulatpur, Khulna', 'Shibbari, Khulna'];
        $occupations = ['Bank employee', 'Shop owner', 'Civil engineer', 'Accountant', 'School administrator', 'Healthcare worker', 'Business owner'];
        $hash = Hash::make($password);
        $newUser = function (string $kind, int $num, string $name, ?int $classroomId = null) use ($hash): int {
            return $this->add('users', ['email' => sprintf('%s%03d@wyzeek-demo.example', strtolower($kind), $num)], [
                'name' => $name,
                'password' => $hash,
                'email_verified_at' => Carbon::now()->toDateTimeString(),
                'classroom_id' => $classroomId,
            ]);
        };

        // Add 26 teaching specializations without inventing extra gender, blood or religious categories.
        $specializations = [
            'Bangla', 'General Mathematics', 'English Grammar', 'Primary Science',
            'Bangladesh and Global Studies', 'Information Technology', 'Physics', 'Chemistry',
            'Biology', 'Higher Mathematics', 'Accounting', 'Finance and Banking',
            'Business Entrepreneurship', 'Bangladesh History', 'Geography', 'Economics',
            'Civics', 'Physical Education', 'Health Science', 'Fine Arts',
            'Music Education', 'Religious Studies', 'Environmental Science', 'Agricultural Studies',
            'Career Education', 'Library and Research',
        ];
        foreach ($specializations as $specialization) {
            $this->add('specializations', ['name' => $specialization]);
        }
        $specializationIds = DB::table('specializations')->orderBy('id')->pluck('id')->all();

        $teacherIds = [];
        $parentIds = [];
        $studentIds = [];
        $studentContext = [];
        $parentUsers = [];
        $teacherUsers = [];
        $studentUsers = [];

        // 30 teachers, 30 parents (each with a unique login).
        for ($i = 0; $i < 30; $i++) {
            $teacherName = $firstNames[$i] . ' ' . $lastNames[($i + 3) % count($lastNames)];
            $teacherUser = $newUser('teacher', $i + 1, $teacherName);
            $teacherUsers[] = $teacherUser;
            $this->pivot('role_user', ['role_id' => $roleIds['Teacher'], 'user_id' => $teacherUser]);
            $teacherIds[] = $this->add('teachers', ['user_id' => $teacherUser], [
                'teacher_name' => $teacherName,
                'teacher_job' => $i % 6 === 0 ? 'Senior Teacher' : 'Assistant Teacher',
                'nationality_id' => $nationality,
                'blood_type_id' => $bloodIds[$i % count($bloodIds)],
                'religion_id' => $religionIds[$i % count($religionIds)],
                'specialization_id' => $specializationIds[$i % count($specializationIds)],
                'gender_id' => $genderIds[$i % count($genderIds)],
                'joining_date' => Carbon::parse('2018-01-15')->addMonths($i * 2)->toDateString(),
                'address' => $places[$i % count($places)],
            ]);
            $parentName = $firstNames[($i + 4) % count($firstNames)] . ' ' . $lastNames[($i + 7) % count($lastNames)];
            $parentUser = $newUser('parent', $i + 1, $parentName);
            $parentUsers[] = $parentUser;
            $this->pivot('role_user', ['role_id' => $roleIds['Parent'], 'user_id' => $parentUser]);
            $parentIds[] = $this->add('my_parents', ['user_id' => $parentUser], [
                'Name_Father' => $parentName,
                'Job_Father' => $occupations[$i % count($occupations)],
                'Nationality_Father_id' => $nationality,
                'Blood_Type_Father_id' => $bloodIds[$i % count($bloodIds)],
                'Religion_Father_id' => $religionIds[$i % count($religionIds)],
                'Address_Father' => $places[$i % count($places)],
                'Name_Mother' => $firstNames[($i + 15) % count($firstNames)] . ' ' . $lastNames[$i % count($lastNames)],
                'Job_Mother' => $occupations[($i + 3) % count($occupations)],
                'Nationality_Mother_id' => $nationality,
                'Blood_Type_Mother_id' => $bloodIds[($i + 1) % count($bloodIds)],
                'Religion_Mother_id' => $religionIds[$i % count($religionIds)],
                'Address_Mother' => $places[$i % count($places)],
            ]);
        }

        // 90 students, 3 per classroom, with consistent grade/classroom/parent/user FKs.
        for ($i = 0; $i < 90; $i++) {
            $room = $classrooms[intdiv($i, 3) % 30];
            $gradeId = (int) $room->grade_id;
            $gradePosition = array_search($gradeId, $grades, true);
            $gradePosition = $gradePosition === false ? 0 : (int) $gradePosition;
            $name = $firstNames[($i * 7 + 8) % 30] . ' ' . $lastNames[($i * 3 + 11) % count($lastNames)];
            $userId = $newUser('student', $i + 1, $name, (int) $room->id);
            $studentUsers[] = $userId;
            $this->pivot('role_user', ['role_id' => $roleIds['Student'], 'user_id' => $userId]);
            $id = $this->add('students', ['user_id' => $userId], [
                'name' => $name,
                'gender_id' => $genderIds[$i % count($genderIds)],
                'nationality_id' => $nationality,
                'blood_type_id' => $bloodIds[$i % count($bloodIds)],
                'religion_id' => $religionIds[$i % count($religionIds)],
                'date_birth' => Carbon::create(2020 - $gradePosition, 1 + $i % 12, 1 + $i % 27)->toDateString(),
                'grade_id' => $gradeId,
                'classroom_id' => (int) $room->id,
                'parent_id' => $parentIds[intdiv($i, 3) % count($parentIds)],
                'academic_year' => '2026/2027',
                'graduated' => 0,
                'leaved' => 0,
                'deleted_at' => null,
            ]);
            $studentIds[] = $id;
            $studentContext[] = ['id' => $id, 'grade_id' => $gradeId, 'classroom_id' => (int) $room->id, 'pos' => $gradePosition];
        }

        $subjectNames = [
            'Bangla First Paper', 'Bangla Second Paper', 'English First Paper', 'English Second Paper',
            'General Mathematics', 'Higher Mathematics', 'General Science', 'Physics', 'Chemistry',
            'Biology', 'Bangladesh and Global Studies', 'Information and Communication Technology',
            'Bangladesh History', 'Geography and Environment', 'Civics and Citizenship',
            'Economics', 'Accounting', 'Finance and Banking', 'Business Entrepreneurship',
            'Agricultural Studies', 'Physical Education and Health', 'Arts and Crafts',
            'Religious Education', 'Career Education', 'Environmental Studies',
            'Library Studies', 'Creative Writing', 'Basic Computing', 'Spoken English', 'Research Skills',
        ];
        $subjectIds = [];
        for ($i = 0; $i < 30; $i++) {
            $subjectIds[] = $this->add('subjects', ['name' => $subjectNames[$i]], [
                'teacher_id' => $teacherIds[$i],
                'description' => 'Curriculum subject and weekly academic activities',
            ]);
            $this->pivot('teacher_classrooms', [
                'teacher_id' => $teacherIds[$i], 'classroom_id' => (int) $classrooms[$i]->id,
            ]);
            $this->pivot('classroom_subject', [
                'classroom_id' => (int) $classrooms[$i]->id, 'subject_id' => $subjectIds[$i],
            ]);
        }

        // Dates and status are intentionally plausible; all demo data is synthetic.
        for ($i = 0; $i < 90; $i++) {
            $student = $studentContext[$i];
            $teacher = $teacherIds[intdiv($i, 3) % 30];
            for ($d = 0; $d < 5; $d++) {
                $date = Carbon::parse('2026-11-09')->addDays($d)->toDateString();
                $this->add('attendances', [
                    'student_id' => $student['id'],
                    'attendence_date' => $date,
                    'grade_id' => $student['grade_id'],
                    'classroom_id' => $student['classroom_id'],
                ], [
                    'teacher_id' => $teacher,
                    'attendence_status' => (($i * 3 + $d) % 13 === 0) ? 0 : 1,
                ]);
            }
        }

        $feeTypeNames = [
            'Monthly Tuition', 'Admission Fee', 'Annual Session Fee', 'Examination Fee',
            'Registration Fee', 'Library Fee', 'Laboratory Fee', 'Sports Fee',
            'Activity Fee', 'ICT Lab Fee', 'Transport Fee', 'Identity Card Fee',
            'Field Trip Fee', 'Club Membership', 'Term Assessment Fee',
            'Class Materials Fee', 'Practical Exam Fee', 'Art Materials Fee',
            'Science Fair Fee', 'Health Check Fee', 'Student Welfare Fee',
            'Technology Fee', 'Cultural Programme Fee', 'Student Magazine Fee',
            'School Diary Fee', 'Certificate Fee', 'Annual Development Fee',
            'Learning Resources Fee', 'Model Test Fee', 'Study Tour Fee',
        ];
        $feeTypeIds = [];
        for ($i = 0; $i < 30; $i++) {
            $feeTypeIds[] = $this->add('feetypes', ['name' => $feeTypeNames[$i]], [
                'name_en' => $feeTypeNames[$i],
                'description' => 'Approved category in the school fee schedule',
            ]);
        }

        $noticeTitles = [
            'Parent Teacher Meeting', 'Weekly Academic Activities', 'Library Book Return Reminder',
            'Annual Sports Preparations', 'Science Fair Registration', 'Attendance Reminder',
            'Semester Examination Schedule', 'Class Test Timetable', 'Student Club Registration',
            'Campus Cleanliness Campaign', 'Midterm Results Publication', 'Tuition Payment Notice',
            'ICT Club Workshop', 'Language Competition', 'Annual Cultural Programme',
            'Study Tour Information', 'Classroom Assessment', 'School Holiday Announcement',
            'Health Awareness Session', 'Career Guidance Seminar', 'New Academic Session',
            'Debate Club Session', 'Reading Week', 'Mathematics Olympiad',
            'Art Exhibition', 'Educational Workshop', 'School Magazine Submissions',
            'Examination Preparation', 'Student Council Meeting', 'Closing Ceremony',
        ];
        $postIds = [];
        $invoices = [];
        $receipts = [];
        $payments = [];
        for ($i = 0; $i < 30; $i++) {
            $student = $studentContext[$i];
            $feeAmount = 1750 + ($i % 6) * 250;
            $date = Carbon::parse('2026-10-01')->addDays($i % 28)->toDateString();
            $dueDate = Carbon::parse($date)->addDays(20)->toDateTimeString();
            $feeId = $this->add('fees', ['title' => $feeTypeNames[$i] . ' - Academic Year 2026/2027'], [
                'amount' => $feeAmount, 'currency_code' => 'BDT',
                'feetype_id' => $feeTypeIds[$i],
                'grade_id' => $student['grade_id'],
                'classroom_id' => $student['classroom_id'],
                'description' => 'Approved academic fee for session 2026/2027',
                'year' => '2026/2027', 'due_date' => $dueDate,
            ]);
            $invoiceId = $this->add('fee_invoices', [
                'student_id' => $student['id'], 'fee_id' => $feeId,
            ], [
                'invoice_date' => $date,
                'grade_id' => $student['grade_id'],
                'classroom_id' => $student['classroom_id'],
                'feetype_id' => $feeTypeIds[$i],
                'currency_code' => 'BDT', 'amount' => $feeAmount,
                'description' => 'Term fee invoice issued by the accounts office',
            ]);
            $invoices[] = $invoiceId;
            $this->add('student_accounts', ['student_id' => $student['id'], 'fee_invoice_id' => $invoiceId], [
                'currency_code' => 'BDT', 'debit' => $feeAmount, 'credit' => 0,
                'description' => 'Fee invoice charge', 'type' => 'invoice',
            ]);
            $receiptAmount = 1000 + ($i % 3) * 200;
            $receiptId = $this->add('receipt_students', ['student_id' => $student['id'], 'title' => 'Tuition Receipt ' . sprintf('2026-%04d', $i + 1)], [
                'date' => $date, 'debit' => $receiptAmount, 'currency_code' => 'BDT',
                'description' => 'Payment received at accounts office',
            ]);
            $receipts[] = $receiptId;
            $this->add('fund_accounts', ['receipt_id' => $receiptId], [
                'date' => $date, 'payment_id' => null,
                'debit' => $receiptAmount, 'credit' => 0,
                'currency_code' => 'BDT', 'description' => 'Tuition collection',
            ]);
            $this->add('student_accounts', ['student_id' => $student['id'], 'receipt_id' => $receiptId], [
                'currency_code' => 'BDT', 'debit' => 0, 'credit' => $receiptAmount,
                'description' => 'Fee receipt credited', 'type' => 'receipt',
            ]);
            $refund = 80 + ($i % 4) * 20;
            $paymentId = $this->add('payment_students', ['student_id' => $student['id'], 'title' => 'Approved Refund ' . sprintf('2026-%04d', $i + 1)], [
                'amount' => $refund, 'currency_code' => 'BDT',
                'date' => $date, 'description' => 'Approved student fee refund',
            ]);
            $payments[] = $paymentId;
            $this->add('fund_accounts', ['payment_id' => $paymentId], [
                'receipt_id' => null, 'date' => $date,
                'debit' => 0, 'credit' => $refund, 'currency_code' => 'BDT',
                'description' => 'Student refund disbursed',
            ]);
            $this->add('student_accounts', ['student_id' => $student['id'], 'payment_id' => $paymentId], [
                'currency_code' => 'BDT', 'debit' => $refund, 'credit' => 0,
                'type' => 'payment', 'description' => 'Student fee refund',
            ]);
            $discount = 100 + ($i % 4) * 25;
            $processingId = $this->add('processing_fees', ['student_id' => $student['id'], 'title' => 'Scholarship Adjustment ' . sprintf('2026-%04d', $i + 1)], [
                'amount' => $discount, 'currency_code' => 'BDT',
                'description' => 'Merit / need-based fee adjustment', 'date' => $date,
            ]);
            $this->add('student_accounts', ['student_id' => $student['id'], 'processing_id' => $processingId], [
                'currency_code' => 'BDT', 'debit' => 0, 'credit' => $discount,
                'description' => 'Approved fee waiver', 'type' => 'processingfee',
            ]);
            $this->add('exams', ['name' => $subjectNames[$i] . ' Term ' . (($i % 3) + 1) . ' Assessment'], [
                'subject_id' => $subjectIds[$i], 'term' => ($i % 3) + 1,
                'academic_year' => '2026/2027',
                'description' => 'Written and practical assessment',
            ]);
            $postIds[] = $this->add('posts', ['title' => $noticeTitles[$i]], [
                'user_id' => $teacherUsers[$i], 'grade_id' => $student['grade_id'],
                'classroom_id' => $student['classroom_id'],
                'content' => 'Dear students and guardians, ' . strtolower($noticeTitles[$i]) . ' will be coordinated by the academic office. Please contact the class teacher for the confirmed schedule.',
                'count_upvotes' => 1, 'count_downvotes' => 1,
            ]);
            $this->add('events', ['title' => $noticeTitles[$i]], [
                'start' => Carbon::parse('2026-11-20')->addDays($i)->toDateTimeString(),
                'end' => Carbon::parse('2026-11-20')->addDays($i)->addHours(2)->toDateTimeString(),
            ]);
            $this->add('online_classes', ['meeting_id' => 'WYZEEK-DEMO-' . sprintf('%05d', $i + 1)], [
                'grade_id' => $student['grade_id'], 'classroom_id' => $student['classroom_id'],
                'user_id' => $teacherUsers[$i],
                'topic' => $subjectNames[$i] . ' Practice Class',
                'start_at' => Carbon::parse('2026-11-20')->addDays($i)->setTime(10, 0)->toDateTimeString(),
                'duration' => 45,
                'password' => 'NOT-A-REAL-MEETING',
                'start_url' => 'https://example.invalid/wyzeek/demo-host/' . ($i + 1),
                'join_url' => 'https://example.invalid/wyzeek/demo-join/' . ($i + 1),
                'description' => self::TAG . ' Offline preview only — no actual Zoom meeting',
            ]);
        }
        for ($i = 0; $i < 30; $i++) {
            $post = $postIds[$i];
            $this->add('post_comments', [
                'post_id' => $post, 'user_id' => $parentUsers[$i],
            ], [
                'comment' => 'Thank you for the update. Please share any additional instructions with our class.',
                'count_upvotes' => 0, 'count_downvotes' => 0,
            ]);
            $this->pivot('post_upvotes', ['post_id' => $post, 'user_id' => $studentUsers[$i]]);
            $this->pivot('post_downvotes', ['post_id' => $post, 'user_id' => $studentUsers[($i + 31) % 90]]);
            $uuid = (string) Str::uuid();
            // Give the notification an idempotent identity by recipient+post_id in its JSON data.
            $data = json_encode([
                'post_title' => $noticeTitles[$i], 'post_id' => $post,
                'comment_author_name' => 'WYZEEK Academic Office',
                'comment_author_photo' => null, 'comment_author_id' => $teacherUsers[$i],
                'type' => 'New Comment', 'comment_content' => 'Please review the notice.',
                'message' => 'New discussion: ' . $noticeTitles[$i],
            ], JSON_UNESCAPED_UNICODE);
            $exists = DB::table('notifications')
                ->where('notifiable_type', 'App\\Models\\User')
                ->where('notifiable_id', $parentUsers[$i])
                ->where('data', $data)->exists();
            if (!$exists) {
                DB::table('notifications')->insert([
                    'id' => $uuid, 'type' => 'App\\Notifications\\ReceivedComment',
                    'notifiable_type' => 'App\\Models\\User',
                    'notifiable_id' => $parentUsers[$i],
                    'data' => $data,
                    'read_at' => null,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
                $this->inserted['notifications'] = ($this->inserted['notifications'] ?? 0) + 1;
            }
        }

        // 30 promotions with consistent from/to grades; student_id has a unique constraint.
        $promotionCount = 0;
        foreach ($studentContext as $student) {
            if ($student['pos'] < 1) continue;
            $fromGrade = $grades[$student['pos'] - 1];
            $fromRoom = $classForGrade[$fromGrade] ?? null;
            if (!$fromRoom) continue;
            $this->add('promotions', ['student_id' => $student['id']], [
                'from_grade' => $fromGrade,
                'from_classroom' => $fromRoom,
                'to_grade' => $student['grade_id'],
                'to_classroom' => $student['classroom_id'],
            ]);
            if (++$promotionCount >= 30) break;
        }
        if ($promotionCount !== 30) {
            throw new RuntimeException('Not enough higher-grade students for 30 realistic promotions.');
        }
    }
}
