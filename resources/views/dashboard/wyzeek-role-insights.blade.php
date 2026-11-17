@php($roleOverview = \App\Support\WyzeekDashboardOverview::role($role, (int) auth()->id()))
<section class="wyz-insights wyz-role-insights" aria-labelledby="wyz-role-overview-heading">
    <header class="wyz-insights-header">
        <div><span class="wyz-insights-eyebrow">WYZEEK • PERSONAL OVERVIEW</span>
            <h2 id="wyz-role-overview-heading">{{ $roleOverview['heading'] }}</h2>
            <p>Live information limited to the signed-in {{ $role }} profile.</p>
        </div>
    </header>
    <div class="wyz-kpis">
        <article class="wyz-kpi"><span>Related
                students</span><strong>{{ number_format($roleOverview['students']) }}</strong><small>{{ $role === 'parent' ? 'Linked children' : ($role === 'student' ? 'Own student profile' : 'Students in assigned classrooms') }}</small>
        </article>
        <article class="wyz-kpi"><span>Related
                classrooms</span><strong>{{ number_format($roleOverview['classrooms']) }}</strong><small>Linked
                classroom records</small></article>
        <article class="wyz-kpi"><span>Attendance
                entries</span><strong>{{ number_format($roleOverview['attendance_count']) }}</strong><small>Recorded for
                these students</small></article>
        <article class="wyz-kpi"><span>Present
                rate</span><strong>{{ $roleOverview['present_rate'] === null ? '—' : $roleOverview['present_rate'] . '%' }}</strong><small>Based
                on recorded entries only</small></article>
        @if ($role !== 'teacher')
            <article class="wyz-kpi"><span>Fee
                    invoices</span><strong>{{ number_format($roleOverview['invoice_count']) }}</strong><small>Invoice
                    count, not amount due</small></article>
        @endif
    </div>
    <div class="wyz-insights-grid">
        <article class="wyz-panel">
            <header class="wyz-panel-head">
                <div>
                    <h3>Attendance • 7 days</h3>
                    <p>Attendance for linked student profiles only</p>
                </div>
            </header>
            <div class="wyz-legend"><span><i class="wyz-dot is-present"></i> Present</span><span><i
                        class="wyz-dot is-absent"></i> Absent</span></div>
            <div class="wyz-day-list">
                @foreach ($roleOverview['attendance'] as $day)
                    <div class="wyz-day-row"><span>{{ $day['label'] }}<small>{{ $day['date'] }}</small></span>
                        <div class="wyz-stacked" title="{{ $day['present'] }} present, {{ $day['absent'] }} absent">
                            @if ($day['total'])
                                <div class="wyz-stacked-present" style="width: {{ $day['present_pct'] }}%"></div>
                                <div class="wyz-stacked-absent" style="width: {{ $day['absent_pct'] }}%"></div>
                            @endif
                        </div><strong>{{ $day['total'] }}</strong>
                    </div>
                @endforeach
            </div>
        </article>
        <article class="wyz-panel wyz-table-panel">
            <header class="wyz-panel-head">
                <div>
                    <h3>{{ $roleOverview['heading'] }} details</h3>
                    <p>{{ $role === 'teacher' ? 'Student counts per assigned classroom' : ($role === 'student' ? 'Fee invoice count for your own record' : 'Attendance entries per linked child') }}
                    </p>
                </div>
            </header>
            <div class="wyz-table-scroll">
                <table class="wyz-table">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Details</th>
                            <th scope="col">
                                {{ $role === 'teacher' ? 'Students' : ($role === 'student' ? 'Invoices' : 'Attendance entries') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roleOverview['rows'] as $row)
                            <tr>
                                <th scope="row">{{ $row['name'] }}</th>
                                <td>{{ $row['subtitle'] }}</td>
                                <td>{{ number_format($row['total']) }}</td>
                            </tr>
                        @empty<tr>
                                <td colspan="3" class="wyz-empty">No linked profile or records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </article>
    </div>
    <p class="wyz-insights-footnote">This is a read-only summary. Only records related to your existing profile are
        queried. No changes are made to attendance or financial data.</p>
</section>
