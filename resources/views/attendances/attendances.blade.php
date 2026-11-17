@extends('layouts.master')
@section('Pagetitle',"Attendances")

@section('Content')

<div class="max-w-7xl mx-auto py-6 sm:py-8 px-4 sm:px-6 lg:px-8">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">{{ __('main.attendance-check') }}</h1>
        <p class="text-sm text-slate-500 mt-1">Select a grade and classroom to begin taking attendance.</p>
    </div>

    {{-- Accordion Wrapper (Using Alpine.js) --}}
    <div x-data="{ openGrade: null }" class="space-y-4">
        @forelse ($grades as $grade)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

                {{-- Accordion Header --}}
                <button @click="openGrade = (openGrade === {{ $grade->id }} ? null : {{ $grade->id }})"
                        class="w-full flex items-center justify-between p-4 sm:p-5 text-left focus:outline-none transition-colors hover:bg-slate-50">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600">
                            <i class="fa-solid fa-users-viewfinder"></i>
                        </div>
                        <span class="text-lg font-bold text-slate-800">{{ $grade->name }}</span>
                    </div>
                    {{-- Chevron Icon --}}
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 text-slate-500 transition-transform duration-300"
                         :class="openGrade === {{ $grade->id }} ? 'rotate-180' : ''">
                        <i class="fa-solid fa-chevron-down text-sm"></i>
                    </div>
                </button>

                {{-- Accordion Body --}}
                <div x-show="openGrade === {{ $grade->id }}" x-collapse x-cloak>
                    <div class="border-t border-slate-200 bg-slate-50/50 p-4 sm:p-6">

                        {{-- ========================================= --}}
                        {{-- MOBILE VIEW: CARDS (Hidden on Desktop) --}}
                        {{-- ========================================= --}}
                        <div class="md:hidden space-y-3">
                            @forelse ($grade->classrooms as $classroom)
                                <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm flex items-center justify-between gap-4">
                                    <div>
                                        <h3 class="font-bold text-slate-900">{{ $classroom->name }}</h3>
                                        <p class="text-xs text-slate-500 mt-1 flex items-center gap-1.5">
                                            <i class="fa-solid fa-user-group"></i>
                                            {{ $classroom->countStudents() }} {{ __('main.student-count') }}
                                        </p>
                                    </div>

                                    {{-- App-like Button --}}
                                    <a href="{{ route('attendance.classroom', $classroom->id) }}"
                                       class="shrink-0 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white text-sm font-semibold rounded-lg shadow-sm transition-all">
                                        <i class="fa-solid fa-clipboard-user"></i>
                                        {{ trans('main.attendance-check') }}
                                    </a>
                                </div>
                            @empty
                                <div class="bg-white rounded-xl border border-slate-200 p-6 text-center text-sm text-slate-500">
                                    {{ __('main.no-classrooms') }}
                                </div>
                            @endforelse
                        </div>

                        {{-- ========================================= --}}
                        {{-- DESKTOP VIEW: CLEAN TABLE (Hidden on Mobile) --}}
                        {{-- ========================================= --}}
                        <div class="hidden md:block bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
                            <table class="min-w-full divide-y divide-slate-200 text-sm">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider w-16">#</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('main.classroomname') }}</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('main.student-count') }}</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('main.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse ($grade->classrooms as $classroom)
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $loop->iteration }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="font-bold text-slate-900">{{ $classroom->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 font-bold text-sm">
                                                    {{ $classroom->countStudents() }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                <a href="{{ route('attendance.classroom', $classroom->id) }}"
                                                   class="inline-flex items-center gap-2 px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold rounded-lg transition-all shadow-sm">
                                                    <i class="fa-solid fa-file-lines"></i>
                                                    {{ trans('main.attendance-check') }}
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                                                {{ __('main.no-classrooms') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center shadow-sm">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 text-slate-400 mb-4">
                    <i class="fa-solid fa-folder-open text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-1">{{ trans('main.no-grades') }}</h3>
                <p class="text-sm text-slate-500">There are no grades available at the moment.</p>
            </div>
        @endforelse
    </div>
</div>

@endsection
