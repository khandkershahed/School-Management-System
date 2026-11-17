@extends('layouts.master')

@section('Pagetitle', 'Grades')

@section('Content')

    <div class="py-6 sm:py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Main Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

                <div class="p-4 sm:p-6">
                    {{-- Toolbar --}}
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                        <div>
                            <h1 class="text-xl sm:text-2xl font-bold text-slate-900">{{ trans('main.grades') ?? 'Grades' }}
                            </h1>
                            <p class="text-sm text-slate-500 mt-1">Manage school grades and academic levels.</p>
                        </div>

                        {{-- Add Button --}}
                        <button type="button" data-modal-target="grade-modal" data-modal-toggle="grade-modal"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold rounded-xl transition-all shadow-sm shrink-0">
                            <i class="fa-solid fa-plus"></i>
                            {{ trans('main.add-grade') }}
                        </button>
                    </div>

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="mb-6 rounded-xl bg-red-50 p-4 border border-red-100 text-red-700 text-sm">
                            <div class="flex items-start">
                                <i class="fa-solid fa-circle-exclamation mt-0.5 mr-3 text-lg"></i>
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    {{-- Livewire Table --}}
                    {{-- overflow-x-auto ensures the table scrolls on mobile instead of breaking the layout --}}
                    <div class="overflow-x-auto">
                        <livewire:grade-table/>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- ========================================= --}}
    {{-- ADD GRADE MODAL --}}
    {{-- ========================================= --}}
    <div id="grade-modal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-[100] hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center bg-slate-900/50 backdrop-blur-sm">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-2xl shadow-xl">

                {{-- Close Button --}}
                <button type="button"
                    class="absolute top-4 right-4 text-slate-400 bg-transparent hover:bg-slate-100 rounded-lg text-sm p-1.5 inline-flex items-center"
                    data-modal-hide="grade-modal">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>

                {{-- Form Content --}}
                <div class="px-6 py-6">
                    <h3 class="mb-5 text-xl font-bold text-slate-900">{{ trans('main.add-grade') }}</h3>

                    <form class="space-y-4" action="{{ route('grade.store') }}" method="post">
                        @csrf

                        {{-- Grade Name (Arabic) --}}
                        <div>
                            <label for="gradename_ar" class="block mb-2 text-sm font-semibold text-slate-700">
                                {{ trans('main.grade-name-ar') }}
                            </label>
                            <input type="text" name="name_ar" id="gradename_ar" value="{{ old('name_ar') }}"
                                class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block p-3 transition-all">
                        </div>

                        {{-- Grade Name (English) --}}
                        <div>
                            <label for="gradename_en" class="block mb-2 text-sm font-semibold text-slate-700">
                                {{ trans('main.grade-name-en') }}
                            </label>
                            <input type="text" name="name_en" id="gradename_en" value="{{ old('name_en') }}"
                                class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block p-3 transition-all">
                        </div>

                        {{-- Grade Notes --}}
                        <div>
                            <label for="message" class="block mb-2 text-sm font-semibold text-slate-700">
                                {{ trans('main.grade-notes') }}
                            </label>
                            <textarea id="message" name="notes" rows="3"
                                class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block p-3 transition-all">{{ old('notes') }}</textarea>
                        </div>

                        {{-- Submit Button --}}
                        <div class="pt-2">
                            <button type="submit"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] text-white font-bold rounded-xl text-sm px-5 py-3.5 transition-all shadow-lg shadow-indigo-500/30">
                                {{ trans('main.add') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
