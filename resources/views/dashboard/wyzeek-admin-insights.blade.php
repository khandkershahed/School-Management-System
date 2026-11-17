@php($overview = \App\Support\WyzeekDashboardOverview::admin())

<section class="space-y-8 mt-8">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 border-b border-slate-200 pb-4">
        <div>
            <span class="text-xs font-bold tracking-wider text-indigo-600 uppercase mb-1 block">WYZEEK • PAPERLESS OPERATIONS</span>
            <h2 class="text-2xl font-bold text-slate-900">Institution Overview</h2>
            <p class="text-sm text-slate-500 mt-1">Live summaries from existing records. No sample statistics.</p>
        </div>
        <span class="text-sm font-medium text-slate-400 bg-slate-100 px-3 py-1.5 rounded-lg whitespace-nowrap">As of {{ $overview['as_of'] }}</span>
    </div>

    {{-- 8 KPI Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm flex flex-col justify-between">
            <span class="text-sm font-medium text-slate-500">Attendance records today</span>
            <div class="flex items-end justify-between mt-4">
                <strong class="text-3xl font-bold text-slate-900">{{ number_format($overview['kpis']['attendance_today']) }}</strong>
                <span class="text-xs text-slate-400 mb-1">Entries</span>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm flex flex-col justify-between">
            <span class="text-sm font-medium text-slate-500">Present today</span>
            <div class="flex items-end justify-between mt-4">
                <strong class="text-3xl font-bold text-slate-900">{{ number_format($overview['kpis']['present_today']) }}</strong>
                <span class="text-xs font-medium {{ $overview['kpis']['present_rate'] >= 75 ? 'text-emerald-600' : 'text-amber-600' }} mb-1">
                    {{ $overview['kpis']['present_rate'] === null ? '—' : $overview['kpis']['present_rate'] . '%' }}
                </span>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm flex flex-col justify-between">
            <span class="text-sm font-medium text-slate-500">Active students</span>
            <div class="flex items-end justify-between mt-4">
                <strong class="text-3xl font-bold text-slate-900">{{ number_format($overview['kpis']['active_students']) }}</strong>
                <span class="text-xs text-slate-400 mb-1">Enrolled</span>
            </div>
        </div>
        <div class="bg-indigo-600 rounded-2xl border border-indigo-700 p-5 shadow-md flex flex-col justify-between text-white">
            <span class="text-sm font-medium text-indigo-100">Digital transactions</span>
            <div class="flex items-end justify-between mt-4">
                <strong class="text-3xl font-bold">{{ number_format($overview['kpis']['record_count']) }}</strong>
                <span class="text-xs text-indigo-200 mb-1">Total records</span>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm flex flex-col justify-between">
            <span class="text-sm font-medium text-slate-500">Exams created</span>
            <div class="flex items-end justify-between mt-4">
                <strong class="text-3xl font-bold text-slate-900">{{ number_format($overview['kpis']['exam_count']) }}</strong>
                <span class="text-xs text-slate-400 mb-1">Definitions</span>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm flex flex-col justify-between">
            <span class="text-sm font-medium text-slate-500">Fee invoices</span>
            <div class="flex items-end justify-between mt-4">
                <strong class="text-3xl font-bold text-slate-900">{{ number_format($overview['kpis']['invoice_count']) }}</strong>
                <span class="text-xs text-slate-400 mb-1">Issued</span>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm flex flex-col justify-between">
            <span class="text-sm font-medium text-slate-500">Receipt vouchers</span>
            <div class="flex items-end justify-between mt-4">
                <strong class="text-3xl font-bold text-slate-900">{{ number_format($overview['kpis']['receipt_count']) }}</strong>
                <span class="text-xs text-slate-400 mb-1">Recorded</span>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm flex flex-col justify-between">
            <span class="text-sm font-medium text-slate-500">Notices / posts</span>
            <div class="flex items-end justify-between mt-4">
                <strong class="text-3xl font-bold text-slate-900">{{ number_format($overview['kpis']['post_count']) }}</strong>
                <span class="text-xs text-slate-400 mb-1">Published</span>
            </div>
        </div>
    </div>

    {{-- Charts Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Enrollment Trend -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Student enrollment trend</h3>
                    <p class="text-xs text-slate-500 mt-1">New records created in the last 6 months</p>
                </div>
                <span class="bg-slate-100 text-slate-600 text-xs font-semibold px-2.5 py-1 rounded-md">6 months</span>
            </div>
            <div class="flex items-end justify-between h-48 gap-2 mt-4">
                @foreach ($overview['enrollments'] as $month)
                    <div class="flex flex-col items-center justify-end w-full group relative h-full">
                        <span class="text-xs font-bold text-slate-700 mb-2 opacity-0 group-hover:opacity-100 transition-opacity">{{ $month['value'] }}</span>
                        <div class="w-full max-w-[40px] bg-indigo-50 rounded-t-md relative h-full overflow-hidden flex items-end">
                            <div class="w-full bg-indigo-500 rounded-t-md transition-all duration-500" style="height: {{ $month['height'] }}%"></div>
                        </div>
                        <span class="text-[10px] sm:text-xs font-medium text-slate-500 mt-2">{{ $month['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Attendance -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Attendance • last 7 days</h3>
                    <p class="text-xs text-slate-500 mt-1">Present vs absent across recorded entries</p>
                </div>
            </div>
            <div class="flex items-center gap-4 mb-4 text-xs font-medium text-slate-600">
                <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-indigo-500"></span> Present</span>
                <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-slate-200"></span> Absent</span>
            </div>
            <div class="space-y-3">
                @foreach ($overview['attendance'] as $day)
                    <div class="flex items-center gap-4">
                        <div class="w-12 text-xs">
                            <div class="font-semibold text-slate-700">{{ $day['label'] }}</div>
                            <div class="text-[10px] text-slate-400">{{ $day['date'] }}</div>
                        </div>
                        <div class="flex-1 h-3 bg-slate-100 rounded-full overflow-hidden flex">
                            @if ($day['total'])
                                <div class="h-full bg-indigo-500" style="width: {{ $day['present_pct'] }}%"></div>
                                <div class="h-full bg-red-400" style="width: {{ $day['absent_pct'] }}%"></div>
                            @endif
                        </div>
                        <div class="w-8 text-right text-xs font-bold text-slate-700">{{ $day['total'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Classroom Distribution -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Classroom distribution</h3>
                    <p class="text-xs text-slate-500 mt-1">Top classrooms by student count</p>
                </div>
                <span class="bg-slate-100 text-slate-600 text-xs font-semibold px-2.5 py-1 rounded-md">Top 8</span>
            </div>
            <div class="space-y-4">
                @forelse($overview['classes'] as $class)
                    <div>
                        <div class="flex justify-between text-xs font-medium mb-1.5">
                            <span class="text-slate-700">{{ $class['name'] }}</span>
                            <span class="text-slate-900">{{ $class['value'] }}</span>
                        </div>
                        <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-400 rounded-full" style="width: {{ $class['width'] }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-500 text-center py-4">No classroom records yet.</p>
                @endforelse
            </div>
        </div>

        <!-- Financial Activity -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Financial activity</h3>
                    <p class="text-xs text-slate-500 mt-1">Invoice and receipt counts by creation month</p>
                </div>
            </div>
            <div class="flex items-center gap-4 mb-6 text-xs font-medium text-slate-600">
                <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-blue-500"></span> Invoices</span>
                <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-purple-500"></span> Receipts</span>
            </div>
            <div class="flex items-end justify-between h-40 gap-4">
                @foreach ($overview['documents'] as $month)
                    <div class="flex flex-col items-center justify-end w-full h-full gap-2">
                        <div class="flex items-end justify-center w-full gap-1 h-full">
                            <div class="w-1/2 max-w-[20px] bg-blue-500 rounded-t-sm transition-all" style="height: {{ $month['height'] }}%"></div>
                            <div class="w-1/2 max-w-[20px] bg-purple-500 rounded-t-sm transition-all" style="height: {{ $month['height_two'] }}%"></div>
                        </div>
                        <span class="text-[10px] sm:text-xs font-medium text-slate-500">{{ $month['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Tables --}}
    <div class="grid grid-cols-1 gap-6">
        <!-- Fees Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-200">
                <h3 class="text-base font-bold text-slate-900">Fees & accounts • currency-wise</h3>
                <p class="text-xs text-slate-500 mt-1">Stored invoice amounts and receipt debit amounts shown separately.</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-6 py-4">Currency</th>
                            <th class="px-6 py-4">Invoices</th>
                            <th class="px-6 py-4">Invoiced amount</th>
                            <th class="px-6 py-4">Receipts</th>
                            <th class="px-6 py-4">Receipt debit entries</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($overview['currencies'] as $currency)
                            <tr class="hover:bg-slate-50/50">
                                <td class="px-6 py-4 font-bold text-slate-900">{{ $currency['code'] }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $currency['invoices'] }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ number_format($currency['invoiced'], 2) }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $currency['receipts'] }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ number_format($currency['receipt_debits'], 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-6 py-8 text-center text-slate-500">No invoice or receipt records.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- 2 Column Tables --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Students -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-200">
                <h3 class="text-base font-bold text-slate-900">Recent student registrations</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-6 py-4">Student</th>
                            <th class="px-6 py-4">Classroom</th>
                            <th class="px-6 py-4">Created</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($overview['recent_students'] as $student)
                            <tr class="hover:bg-slate-50/50">
                                <td class="px-6 py-4 font-medium text-slate-900">{{ $student->name }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $student->classroom->name ?? '—' }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ optional($student->created_at)->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-6 py-8 text-center text-slate-500">No students have been registered.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Exams -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-200">
                <h3 class="text-base font-bold text-slate-900">Recent examinations</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-6 py-4">Exam</th>
                            <th class="px-6 py-4">Subject</th>
                            <th class="px-6 py-4">Year</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($overview['recent_exams'] as $exam)
                            <tr class="hover:bg-slate-50/50">
                                <td class="px-6 py-4 font-medium text-slate-900">{{ $exam->name }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $exam->subject->name ?? '—' }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $exam->academic_year ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-6 py-8 text-center text-slate-500">No exams have been created.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
