<div x-data="{ sidebarOpen: window.innerWidth >= 1280 }" @toggle-sidebar.window="sidebarOpen = !sidebarOpen"
    @keydown.escape.window="if (window.innerWidth < 1280) sidebarOpen = false">

    {{-- Mobile/Tablet Backdrop Overlay --}}
    <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false" x-cloak
        class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-xs xl:hidden">
    </div>

    <aside id="aside"
        :class="sidebarOpen
            ?
            'translate-x-0 xl:w-64 xl:ml-4 xl:opacity-100' :
            '-translate-x-full xl:translate-x-0 xl:w-0 xl:ml-0 xl:border-0 xl:opacity-0 pointer-events-none xl:pointer-events-auto'"
        class="fixed inset-y-0 left-0 z-50 w-64 my-4 h-[calc(100dvh-2rem)] flex flex-col bg-white dark:bg-gray-950 rounded-2xl shadow-xl border border-slate-200 transition-all duration-300 ease-in-out xl:static overflow-hidden shrink-0">

        @php
            $currentRoute = Route::currentRouteName();
            $isAdmin = auth()->user()->isAdmin();
            $isTeacher = auth()->user()->isTeacher();
            $isParent = auth()->user()->isParent();
            $isStudent = auth()->user()->isStudent();

            // Minimal Active State (Soft background, dark text)
            $activeClass = fn($routes) => in_array($currentRoute, (array) $routes)
                ? 'bg-slate-100 text-slate-900 font-semibold'
                : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900';
        @endphp

        <!-- Brand (Logo ONLY, no text) -->
        <div class="h-16 flex items-center justify-between px-6 border-b border-slate-100 shrink-0 bg-blue-800 relative">
            <a href="{{ route('master') }}" class="flex items-center justify-center w-full">
                <img src="{{ asset('assets/img/wyzeek-logo-dark.png') }}" alt="WYZEEK"
                    class="h-9 w-auto object-contain">
            </a>
            <!-- Mobile/Tablet Close Button -->
            <button @click="sidebarOpen = false" data-wyz-close-sidebar type="button"
                class="xl:hidden text-white/70 hover:text-white absolute right-4 rtl:left-4 rtl:right-auto transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Scrollable Navigation -->
        <div class="flex-1 min-h-0 overflow-y-auto p-4 space-y-6 custom-scrollbar">

            <!-- DASHBOARD -->
            <div>
                <a href="{{ route('master') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all {{ $activeClass('master') }}">
                    <i class="fa-solid fa-house w-5 text-center"></i> {{ trans('main-sidebar.dashboard') }}
                </a>
            </div>

            <!-- 1. ADMISSION & REGISTRATION -->
            @if ($isAdmin)
                <div x-data="{ open: {{ in_array($currentRoute, ['register', 'users', 'users.add', 'user-role.index', 'students.index', 'student.info', 'teachers.index', 'teacher.info', 'parents.index']) ? 'true' : 'false' }} }">
                    <div class="px-3 mb-2 text-xs font-bold tracking-wider text-slate-400 uppercase">Admission &
                        Registration</div>
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full px-3 py-2 text-sm text-slate-600 hover:text-slate-900 transition-all rounded-xl hover:bg-slate-50">
                        <div class="flex items-center gap-3"><i class="fa-solid fa-user-plus w-5 text-center"></i>
                            Manage People</div>
                        <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"
                            :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-collapse class="mt-1 space-y-1 ps-10">
                        <a href="{{ route('students.index') }}"
                            class="block px-3 py-2 rounded-lg text-sm {{ $activeClass(['students.index', 'student.info']) }}">Students</a>
                        <a href="{{ route('teachers.index') }}"
                            class="block px-3 py-2 rounded-lg text-sm {{ $activeClass(['teachers.index', 'teacher.info']) }}">Teachers</a>
                        <a href="{{ route('parents.index') }}"
                            class="block px-3 py-2 rounded-lg text-sm {{ $activeClass(['parents.index', 'parent.info']) }}">Parents</a>
                        <a href="{{ route('users.add') }}"
                            class="block px-3 py-2 rounded-lg text-sm {{ $activeClass(['users.add', 'register']) }}">Register
                            User</a>
                    </div>
                </div>
            @endif

            <!-- 2. ATTENDANCE -->
            @if ($isAdmin || $isTeacher)
                <div>
                    <div class="px-3 mb-2 text-xs font-bold tracking-wider text-slate-400 uppercase">Attendance</div>
                    <a href="{{ route('attendances.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all {{ $activeClass(['attendances.index', 'attendance.classroom']) }}">
                        <i class="fa-solid fa-clipboard-user w-5 text-center"></i> Take Attendance
                    </a>
                    <a href="{{ route('attendance.report.export') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all {{ $activeClass('attendance.report.export') }}">
                        <i class="fa-solid fa-download w-5 text-center"></i> Attendance Report
                    </a>
                </div>
            @endif

            <!-- 3. EXAM & RESULT -->
            @if ($isAdmin || $isTeacher)
                <div x-data="{ open: {{ in_array($currentRoute, ['classrooms.index', 'grade', 'subjects.index', 'exams.index', 'exams.create']) ? 'true' : 'false' }} }">
                    <div class="px-3 mb-2 text-xs font-bold tracking-wider text-slate-400 uppercase">Exams & Academics
                    </div>
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full px-3 py-2 text-sm text-slate-600 hover:text-slate-900 transition-all rounded-xl hover:bg-slate-50">
                        <div class="flex items-center gap-3"><i class="fa-solid fa-book w-5 text-center"></i> Academics
                        </div>
                        <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"
                            :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-collapse class="mt-1 space-y-1 ps-10">
                        <a href="{{ route('exams.index') }}"
                            class="block px-3 py-2 rounded-lg text-sm {{ $activeClass(['exams.index', 'exams.create']) }}">Exams
                            & Results</a>
                        <a href="{{ route('subjects.index') }}"
                            class="block px-3 py-2 rounded-lg text-sm {{ $activeClass('subjects.index') }}">Subjects</a>
                        <a href="{{ route('classrooms.index') }}"
                            class="block px-3 py-2 rounded-lg text-sm {{ $activeClass('classrooms.index') }}">Classrooms</a>
                        <a href="{{ route('grade') }}"
                            class="block px-3 py-2 rounded-lg text-sm {{ $activeClass('grade') }}">Grades</a>
                    </div>
                </div>
            @endif

            <!-- 4. FEES & ACCOUNTS -->
            @if ($isAdmin)
                <div x-data="{ open: {{ in_array($currentRoute, ['fees.index', 'feesinvoices.index', 'receipts.index', 'payments.index', 'processingfees.index']) ? 'true' : 'false' }} }">
                    <div class="px-3 mb-2 text-xs font-bold tracking-wider text-slate-400 uppercase">Fees & Accounts
                    </div>
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full px-3 py-2 text-sm text-slate-600 hover:text-slate-900 transition-all rounded-xl hover:bg-slate-50">
                        <div class="flex items-center gap-3"><i
                                class="fa-solid fa-file-invoice-dollar w-5 text-center"></i> Finance</div>
                        <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"
                            :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-collapse class="mt-1 space-y-1 ps-10">
                        <a href="{{ route('feesinvoices.index') }}"
                            class="block px-3 py-2 rounded-lg text-sm {{ $activeClass('feesinvoices.index') }}">Invoices</a>
                        <a href="{{ route('payments.index') }}"
                            class="block px-3 py-2 rounded-lg text-sm {{ $activeClass('payments.index') }}">Payments</a>
                        <a href="{{ route('receipts.index') }}"
                            class="block px-3 py-2 rounded-lg text-sm {{ $activeClass('receipts.index') }}">Receipts</a>
                    </div>
                </div>
            @endif

            <!-- 5. ADMINISTRATION -->
            @if ($isAdmin)
                <div>
                    <div class="px-3 mb-2 text-xs font-bold tracking-wider text-slate-400 uppercase">Administration
                    </div>
                    <a href="{{ route('settings.academic_years.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all {{ $activeClass('settings.academic_years.index') }}">
                        <i class="fa-solid fa-calendar w-5 text-center"></i> Academic Years
                    </a>
                    <a href="{{ route('meetings.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all {{ $activeClass('meetings.index') }}">
                        <i class="fa-solid fa-video w-5 text-center"></i> Online Classes
                    </a>
                    <a href="{{ route('auditlogs.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all {{ $activeClass('auditlogs.index') }}">
                        <i class="fa-solid fa-clipboard-check w-5 text-center"></i> Audit Logs
                    </a>
                </div>

                <!-- 6. RBAC (ROLES) -->
                <div>
                    <div class="px-3 mb-2 text-xs font-bold tracking-wider text-slate-400 uppercase">Security (RBAC)
                    </div>
                    <a href="{{ route('user-role.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all {{ $activeClass('user-role.index') }}">
                        <i class="fa-solid fa-user-shield w-5 text-center"></i> Roles & Permissions
                    </a>
                </div>
            @endif

            <!-- 7. NOTICE UPLOAD -->
            @if (!$isParent)
                <div>
                    <div class="px-3 mb-2 text-xs font-bold tracking-wider text-slate-400 uppercase">Notice Upload</div>
                    <a href="{{ route('posts.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all {{ $activeClass(['posts.index', 'post.show']) }}">
                        <i class="fa-solid fa-bullhorn w-5 text-center"></i> Discussions
                    </a>
                </div>
            @endif

            <!-- 8. AI CHATBOT -->
            <div>
                <div class="px-3 mb-2 text-xs font-bold tracking-wider text-slate-400 uppercase">AI Assistant</div>
                <a href="#" data-wyz-open-ai="true" aria-controls="wyz-ai-dialog"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all">
                    <i class="fa-solid fa-robot w-5 text-center"></i> AI Chatbot
                </a>
            </div>

            <!-- PARENT / STUDENT SPECIFIC -->
            @if ($isParent)
                <div>
                    <div class="px-3 mb-2 text-xs font-bold tracking-wider text-slate-400 uppercase">My Children</div>
                    <a href="{{ route('parent.students.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all {{ $activeClass('parent.students.index') }}">
                        <i class="fa-solid fa-users w-5 text-center"></i> View Students
                    </a>
                    <a href="{{ route('parent.students.attendances') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all {{ $activeClass('parent.students.attendances') }}">
                        <i class="fa-solid fa-clipboard-user w-5 text-center"></i> Attendance
                    </a>
                    <a href="{{ route('parent.students.invoices') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all {{ $activeClass('parent.students.invoices') }}">
                        <i class="fa-solid fa-file-invoice w-5 text-center"></i> Invoices
                    </a>
                </div>
            @endif

        </div>

        <!-- Footer Profile -->
        <div class="p-4 border-t border-slate-100 shrink-0 bg-white dark:bg-gray-950">
            <a href="{{ route('profile.show') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all hover:bg-slate-50 {{ $activeClass('profile.show') }}">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 text-slate-500">
                    <i class="fas fa-user text-sm"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-semibold text-slate-700 truncate w-32">{{ auth()->user()->name }}</span>
                    <span class="text-[11px] text-slate-400">My Profile</span>
                </div>
            </a>
        </div>
    </aside>
</div>

<style>
    /* Custom minimal scrollbar for the sidebar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #cbd5e1;
    }
</style>
