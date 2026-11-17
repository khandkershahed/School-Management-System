<div class="py-6 sm:py-12 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header & Controls --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 sm:p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-slate-900">
                        {{ trans('main.check-attendance-for-classroom', ['classroom' => $classroom->name]) }}
                    </h1>
                    <p class="text-sm text-slate-500 mt-1 flex items-center gap-2">
                        <i class="fa-regular fa-calendar text-slate-400"></i>
                        {{ trans('main.for-today', ['date' => date('Y-m-d')]) }}
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    {{-- Search (App-like) --}}
                    <div class="relative flex-1 sm:w-64">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="search" wire:model="search" autocomplete="off"
                            class="block w-full pl-10 pr-4 py-2.5 text-sm text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                            placeholder="{{ trans('main.search') }}..." />
                    </div>

                    {{-- Export Button --}}
                    <button wire:click='exportAttendanceForToday()' wire:loading.attr='disabled'
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold rounded-xl transition-all shadow-sm shrink-0">
                        <i class="fa fa-download"></i>
                        <span class="hidden sm:inline">{{ trans('main.export-attendance-for-today') }}</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- MAIN FORM --}}
        {{-- Added pb-56 for mobile to prevent the sticky button from covering the last card --}}
        <form method="post" action="{{ route('attendance.store') }}" class="relative pb-56 sm:pb-0">
            @csrf

            {{-- ========================================= --}}
            {{-- MOBILE VIEW: APP-LIKE CARDS (Hidden on desktop) --}}
            {{-- ========================================= --}}
            <div class="md:hidden space-y-3">
                @forelse ($this->getFilteredStudents() as $student)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 flex flex-col gap-4 relative overflow-hidden">

                        {{-- Student Info --}}
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <img class="w-12 h-12 rounded-full object-cover border-2 border-slate-100"
                                    src="{{ $student->user->profile_photo_url }}" alt="{{ $student->user->name }}" />
                                <div>
                                    <div class="text-base font-bold text-slate-900 leading-tight">
                                        {{ $student->name ?? '-' }}</div>
                                    <div class="text-xs text-slate-500 truncate w-40">{{ $student->user->email }}</div>
                                </div>
                            </div>
                            {{-- Absence Badge --}}
                            <div class="flex flex-col items-end">
                                <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">{{ __('main.absence-times') }}</span>
                                <span class="inline-flex items-center justify-center px-2 py-1 rounded-md bg-red-50 text-red-600 font-bold text-sm">
                                    {{ $student->countAbsentAttendances() }}
                                </span>
                            </div>
                        </div>

                        {{-- Attendance Toggles (Big Tap Targets) --}}
                        @if (isset($student->attendances()->where('attendence_date', date('Y-m-d'))->first()->student_id))
                            {{-- Already Taken (Disabled State) --}}
                            <div class="flex items-center gap-2 p-1 bg-slate-50 rounded-xl border border-slate-100">
                                <div class="flex-1 text-center py-2 {{ $student->attendances()->latest()->first()->attendence_status == true ? 'bg-emerald-500 text-white shadow-md' : 'text-slate-400' }} rounded-lg text-sm font-bold transition-all">
                                    {{ trans('main.presence') }}
                                </div>
                                <div class="flex-1 text-center py-2 {{ $student->attendances()->latest()->first()->attendence_status == false ? 'bg-red-500 text-white shadow-md' : 'text-slate-400' }} rounded-lg text-sm font-bold transition-all">
                                    {{ trans('main.absent') }}
                                </div>
                            </div>
                        @else
                            {{-- Interactive State --}}
                            <div class="grid grid-cols-2 gap-2">
                                {{-- Present Button --}}
                                <label class="cursor-pointer">
                                    <input type="radio" name="attendances[{{ $student->id }}]" value="presence" class="peer sr-only">
                                    <div class="w-full text-center py-3 rounded-xl border-2 border-slate-100 bg-slate-50 text-slate-500 font-bold text-sm transition-all peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700 peer-checked:shadow-inner">
                                        <i class="fa-solid fa-check-circle mr-2"></i> {{ trans('main.presence') }}
                                    </div>
                                </label>

                                {{-- Absent Button --}}
                                <label class="cursor-pointer">
                                    <input type="radio" name="attendances[{{ $student->id }}]" value="absent" class="peer sr-only">
                                    <div class="w-full text-center py-3 rounded-xl border-2 border-slate-100 bg-slate-50 text-slate-500 font-bold text-sm transition-all peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-700 peer-checked:shadow-inner">
                                        <i class="fa-solid fa-times-circle mr-2"></i> {{ trans('main.absent') }}
                                    </div>
                                </label>
                            </div>
                        @endif

                        <input type="hidden" name="grade_id" value="{{ $student->grade_id }}">
                        <input type="hidden" name="classroom_id" value="{{ $student->classroom_id }}">
                    </div>
                @empty
                    <div class="bg-white rounded-2xl p-8 text-center border border-slate-200 shadow-sm">
                        <p class="text-slate-500">{{ __('main.no-students') }}</p>
                    </div>
                @endforelse
            </div>

            {{-- ========================================= --}}
            {{-- DESKTOP VIEW: CLEAN TABLE (Hidden on mobile) --}}
            {{-- ========================================= --}}
            <div class="hidden md:block bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-left">
                                {{ __('main.studentname') }}</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">
                                {{ __('main.absence-times') }}</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center w-1/3">
                                {{ __('main.attendance') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse ($this->getFilteredStudents() as $student)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img class="w-10 h-10 rounded-full object-cover" src="{{ $student->user->profile_photo_url }}" alt="{{ $student->user->name }}" />
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-slate-900">{{ $student->name ?? '-' }}</div>
                                            <div class="text-xs text-slate-500">{{ $student->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-md bg-red-50 text-red-600 font-bold text-sm">
                                        {{ $student->countAbsentAttendances() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if (isset($student->attendances()->where('attendence_date', date('Y-m-d'))->first()->student_id))
                                        {{-- Read Only View --}}
                                        <div class="flex items-center justify-center gap-4">
                                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $student->attendances()->latest()->first()->attendence_status == true ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-400' }}">
                                                {{ trans('main.presence') }}
                                            </span>
                                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $student->attendances()->latest()->first()->attendence_status == false ? 'bg-red-100 text-red-700' : 'bg-slate-100 text-slate-400' }}">
                                                {{ trans('main.absent') }}
                                            </span>
                                        </div>
                                    @else
                                        {{-- Interactive View --}}
                                        <div class="flex items-center justify-center gap-4">
                                            <label class="inline-flex items-center cursor-pointer">
                                                <input type="radio" name="attendances[{{ $student->id }}]" value="presence"
                                                    class="w-4 h-4 text-emerald-600 bg-slate-100 border-slate-300 focus:ring-emerald-500 focus:ring-2">
                                                <span class="ml-2 text-sm font-medium text-slate-700">{{ trans('main.presence') }}</span>
                                            </label>
                                            <label class="inline-flex items-center cursor-pointer">
                                                <input type="radio" name="attendances[{{ $student->id }}]" value="absent"
                                                    class="w-4 h-4 text-red-600 bg-slate-100 border-slate-300 focus:ring-red-500 focus:ring-2">
                                                <span class="ml-2 text-sm font-medium text-slate-700">{{ trans('main.absent') }}</span>
                                            </label>
                                        </div>
                                    @endif
                                    <input type="hidden" name="grade_id" value="{{ $student->grade_id }}">
                                    <input type="hidden" name="classroom_id" value="{{ $student->classroom_id }}">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center text-slate-500">
                                    {{ __('main.no-students') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ========================================= --}}
            {{-- STICKY SUBMIT BUTTON --}}
            {{-- ========================================= --}}
            {{-- bottom-24 pushes it above the mobile floating nav bar --}}
            <div class="fixed bottom-24 left-0 right-0 p-4 bg-white backdrop-blur-md border-t border-slate-200 sm:static sm:bg-transparent sm:border-0 sm:mt-6 sm:p-0 z-40 flex justify-end">
                <button type="submit"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] text-white text-base font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition-all">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    {{ trans('main.attendance-check') }}
                </button>
            </div>
        </form>
    </div>
</div>
