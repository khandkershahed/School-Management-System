@php
    $currentRoute = Route::currentRouteName();
    $isAdmin = auth()->user()->isAdmin();

    // Helper for active links
    $activeClass = fn($routes) => in_array($currentRoute, (array)$routes)
        ? 'bg-slate-900 text-white shadow-md'
        : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900';
@endphp

<aside
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-200 flex flex-col transition-transform duration-300 lg:static lg:translate-x-0 shrink-0 h-full">

    <!-- Brand -->
    <div class="h-16 flex items-center justify-between px-6 border-b border-slate-100">
        <a href="{{ route('master') }}" class="flex items-center gap-3">
            <img src="{{ asset('assets/img/logo-ct.png') }}" alt="Logo" class="h-7 w-auto">
            <span class="font-bold text-slate-800 tracking-tight text-lg">{{ config('app.name') }}</span>
        </a>
        <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-slate-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    <!-- Navigation -->
    <div class="flex-1 overflow-y-auto p-4 space-y-2">

        <!-- Dashboard -->
        <a href="{{ route('master') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ $activeClass('master') }}">
            <i class="fa-solid fa-house w-5 text-center"></i> Dashboard
        </a>

        @if($isAdmin)
        <!-- Users -->
        <div x-data="{ open: {{ in_array($currentRoute, ['register','users','users.add','user-role.index','students.index','teachers.index','parents.index']) ? 'true' : 'false' }} }">
            <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-900 transition-all rounded-xl hover:bg-slate-50">
                <div class="flex items-center gap-3"><i class="fa-solid fa-users w-5 text-center"></i> Manage Users</div>
                <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" x-collapse class="mt-1 space-y-1 pl-11">
                <a href="{{ route('students.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ $activeClass(['students.index','student.info']) }}">Students</a>
                <a href="{{ route('teachers.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ $activeClass(['teachers.index','teacher.info']) }}">Teachers</a>
                <a href="{{ route('parents.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ $activeClass(['parents.index','parent.info']) }}">Parents</a>
                <a href="{{ route('users.add') }}" class="block px-3 py-2 rounded-lg text-sm {{ $activeClass(['users.add','register']) }}">Register User</a>
            </div>
        </div>
        @endif

        <!-- Academics -->
        <div x-data="{ open: {{ in_array($currentRoute, ['classrooms.index','grade','subjects.index','exams.index','attendances.index','meetings.index']) ? 'true' : 'false' }} }">
            <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-900 transition-all rounded-xl hover:bg-slate-50">
                <div class="flex items-center gap-3"><i class="fa-solid fa-book w-5 text-center"></i> Academics</div>
                <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" x-collapse class="mt-1 space-y-1 pl-11">
                <a href="{{ route('classrooms.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ $activeClass('classrooms.index') }}">Classrooms</a>
                <a href="{{ route('grade') }}" class="block px-3 py-2 rounded-lg text-sm {{ $activeClass('grade') }}">Grades</a>
                <a href="{{ route('subjects.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ $activeClass('subjects.index') }}">Subjects</a>
                <a href="{{ route('exams.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ $activeClass('exams.index') }}">Exams</a>
                <a href="{{ route('attendances.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ $activeClass('attendances.index') }}">Attendance</a>
                <a href="{{ route('meetings.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ $activeClass('meetings.index') }}">Meetings</a>
            </div>
        </div>

        <!-- Finance -->
        @if($isAdmin)
        <div x-data="{ open: {{ in_array($currentRoute, ['fees.index','feesinvoices.index','receipts.index','payments.index']) ? 'true' : 'false' }} }">
            <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-900 transition-all rounded-xl hover:bg-slate-50">
                <div class="flex items-center gap-3"><i class="fa-solid fa-file-invoice-dollar w-5 text-center"></i> Finance</div>
                <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" x-collapse class="mt-1 space-y-1 pl-11">
                <a href="{{ route('fees.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ $activeClass('fees.index') }}">Fee Structures</a>
                <a href="{{ route('feesinvoices.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ $activeClass('feesinvoices.index') }}">Invoices</a>
                <a href="{{ route('payments.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ $activeClass('payments.index') }}">Payments</a>
            </div>
        </div>
        @endif

        <!-- Admin Settings -->
        @if($isAdmin)
        <a href="{{ route('settings.academic_years.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ $activeClass('settings.academic_years.index') }}">
            <i class="fa-solid fa-gear w-5 text-center"></i> Settings
        </a>
        @endif

        <a href="{{ route('posts.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ $activeClass('posts.index') }}">
            <i class="fa-solid fa-bullhorn w-5 text-center"></i> Notice Board
        </a>

    </div>
</aside>
