@extends('layouts.master')
@section('Pagetitle',"Classrooms")

@section('Content')

<div class="py-6 sm:py-12 bg-slate-50 min-h-screen">
    <div class="max-w-9xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

            <div class="p-4 sm:p-6">
                {{-- Top Toolbar: Actions, Search, Filter --}}
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">

                    {{-- Left Side: Add & Delete Buttons --}}
                    <div class="flex items-center gap-2">
                        <button type="button" data-modal-target="grade-modal" data-modal-toggle="grade-modal"
                                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold rounded-xl transition-all shadow-sm">
                            <i class="fa-solid fa-pen"></i>
                            <span class="hidden sm:inline">{{ trans('main.add-classroom') }}</span>
                            <span class="inline sm:hidden">Add</span>
                        </button>

                        {{-- Delete Selected Button (Hidden by default, revealed by JS) --}}
                        <button type="button" data-modal-target="grade-modal-deleteAll" id="deleteAllbtn" hidden data-modal-toggle="grade-modal-deleteAll"
                                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-xl transition-all shadow-sm">
                            <i class="fa-solid fa-trash"></i>
                            <span class="hidden sm:inline">{{ trans('main.delete-selected') }}</span>
                        </button>
                    </div>

                    {{-- Right Side: Search & Filter --}}
                    <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                        {{-- Search --}}
                        <div class="relative w-full sm:w-64">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400 search-icon transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <form id="live-search-form" method="post" action="{{route("classrooms.search")}}">
                                @csrf
                                <input type="text" id="search_classrooms" autocomplete="off"
                                       class="block w-full pl-10 pr-3 py-2.5 text-sm text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                       placeholder="{{trans('main.search')}}" name="search">
                                <input type="submit" value="Search" style="display: none;">
                            </form>
                            <div id="search-results" class="absolute z-50 bg-white border border-slate-200 rounded-lg my-1 w-full shadow-lg hidden"></div>
                        </div>

                        {{-- Grade Filter --}}
                        <div class="w-full sm:w-48">
                            <form method="post" action="{{route('classroom.filter')}}" id="classroom-form">
                                @csrf
                                <select id="grade-select" name="Grade_id" required
                                        class="block w-full py-2.5 px-3 text-sm text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all appearance-none cursor-pointer">
                                    <option selected disabled>{{trans('main.select-grade')}}</option>
                                    <option value="AllGrades">{{trans('main.all-grades')}}</option>
                                    @forelse ($grades as $grade)
                                        <option value="{{$grade->id}}">{{$grade->name}}</option>
                                    @empty
                                        <option value="">{{ trans('main.no-grade') }}</option>
                                    @endforelse
                                </select>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- ========================================= --}}
                {{-- MOBILE VIEW: APP-LIKE CARDS --}}
                {{-- ========================================= --}}
                <div class="md:hidden space-y-3">
                    @forelse ($classrooms as $classroom)
                        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex flex-col gap-3 relative">
                            <div class="flex items-start justify-between gap-2">
                                <div class="flex items-start gap-3">
                                    <input type="checkbox" value="{{ $classroom->id }}"
                                           class="mt-1 w-5 h-5 text-indigo-600 bg-slate-100 border-slate-300 rounded focus:ring-indigo-500 class-room-checkbox">
                                    <div>
                                        <h3 class="font-bold text-slate-900 text-base leading-tight">{{ $classroom->name }}</h3>
                                        <span class="inline-flex items-center mt-1 px-2 py-0.5 rounded-md bg-indigo-50 text-indigo-700 text-xs font-bold">
                                            {{ $classroom->grade->name ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1">
                                    {{-- Edit Button --}}
                                    <button type="button" data-modal-target="grade-modal{{$classroom->id}}" data-modal-toggle="grade-modal{{$classroom->id}}"
                                            class="p-2 text-slate-400 hover:text-indigo-600 bg-slate-50 rounded-lg transition-colors">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>

                                    {{-- Livewire Delete --}}
                                    <livewire:classroom.classroom-delete :classroom="$classroom" :wire:key="'delete-classroom-mobile-'.$classroom->id" />
                                </div>
                            </div>

                            <p class="text-sm text-slate-500 line-clamp-2">{{ $classroom->description ?? 'No description provided.' }}</p>

                            <div class="pt-3 border-t border-slate-100 flex justify-between items-center mt-1">
                                <a href="{{route('classroom.subjects.index',$classroom->id)}}"
                                   class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 hover:text-indigo-800">
                                    <i class="fa-solid fa-book"></i> {{ trans('main.subjects') ?? 'Subjects' }}
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-2xl p-8 text-center border border-slate-200 shadow-sm">
                            <p class="text-slate-500">{{ __('main.no-classrooms') }}</p>
                        </div>
                    @endforelse
                </div>

                {{-- ========================================= --}}
                {{-- DESKTOP VIEW: CLEAN TABLE --}}
                {{-- ========================================= --}}
                <div class="hidden md:block bg-white rounded-xl border border-slate-200 overflow-hidden">
                    <table class="min-w-full divide-y divide-slate-200 text-sm" id="multiselect-table">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left w-12">
                                    <input id="checkboxAll" type="checkbox" class="w-4 h-4 text-indigo-600 bg-slate-100 border-slate-300 rounded focus:ring-indigo-500 cursor-pointer">
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('#') }}</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('main.classroomname') }}</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('main.description') }}</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('main.grade') }}</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @forelse ($classrooms as $classroom)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" value="{{ $classroom->id }}" class="w-4 h-4 text-indigo-600 bg-slate-100 border-slate-300 rounded focus:ring-indigo-500 cursor-pointer class-room-checkbox">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-slate-500">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-bold text-slate-900">{{ $classroom->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-slate-500 max-w-xs truncate">{{ $classroom->description ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-indigo-50 text-indigo-700 text-xs font-bold">
                                            {{ $classroom->grade->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right flex items-center justify-end gap-3">

                                        <a href="{{route('classroom.subjects.index',$classroom->id)}}" class="text-slate-400 hover:text-indigo-600 transition-colors" title="Subjects">
                                            <i class="fa-solid fa-book fa-lg"></i>
                                        </a>

                                        <button type="button" data-modal-target="grade-modal{{$classroom->id}}" data-modal-toggle="grade-modal{{$classroom->id}}"
                                                class="text-slate-400 hover:text-indigo-600 transition-colors" title="Edit">
                                            <i class="fa-solid fa-pen-to-square fa-lg"></i>
                                        </button>

                                        <livewire:classroom.classroom-delete :classroom="$classroom" :wire:key="'delete-classroom-'.$classroom->id" />
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                        {{ __('main.no-classrooms') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $classrooms->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ========================================= --}}
{{-- EDIT MODALS (Global - Shared by Mobile & Desktop) --}}
{{-- ========================================= --}}
@foreach ($classrooms as $classroom)
    <div id="grade-modal{{$classroom->id}}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-[100] hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center bg-slate-900/50 backdrop-blur-sm">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-2xl shadow-xl">
                <button type="button" class="absolute top-4 right-4 text-slate-400 bg-transparent hover:bg-slate-100 rounded-lg text-sm p-1.5 inline-flex items-center" data-modal-hide="grade-modal{{$classroom->id}}">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
                <div class="px-6 py-6">
                    <h3 class="mb-4 text-xl font-bold text-slate-900">{{ trans('main.edit-classroom') }}</h3>
                    <form class="space-y-4" action="{{route('classroom.update', $classroom->id)}}" method="post">
                        @method('put')
                        @csrf
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-slate-700">{{ trans('main.classroom-name') }}</label>
                            <input type="text" name="name" class="@error('name') is-invalid @enderror w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block p-3" value="{{$classroom->name}}">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-slate-700">{{trans('main.edit-grade')}}</label>
                            <select name="grade" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block p-3">
                                <option selected value="{{$classroom->grade_id}}">{{$classroom->grade->name ?? ''}}</option>
                                @forelse($grades as $grade)
                                    @if($grade->id != $classroom->grade_id)
                                        <option value="{{$grade->id}}">{{trans($grade->name)}}</option>
                                    @endif
                                @empty
                                    <option disabled>{{trans('main.no-grade')}}</option>
                                @endforelse
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-slate-700">{{trans('main.classroom-description')}}</label>
                            <textarea name="description" rows="3" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block p-3">{{$classroom->description}}</textarea>
                        </div>
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm px-5 py-3 transition-colors">{{trans('main.edit')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

{{-- ========================================= --}}
{{-- ADD MODAL (Global) --}}
{{-- ========================================= --}}
<div id="grade-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-[100] hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center bg-slate-900/50 backdrop-blur-sm">
    <div class="relative w-full max-w-3xl max-h-full">
        <div class="relative bg-white rounded-2xl shadow-xl overflow-y-auto max-h-[90vh]">
            <button type="button" class="absolute top-4 right-4 text-slate-400 bg-transparent hover:bg-slate-100 rounded-lg text-sm p-1.5 inline-flex items-center z-10" data-modal-hide="grade-modal">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
            <div class="px-6 py-6">
                <h3 class="mb-4 text-xl font-bold text-slate-900">{{ trans('main.add-classroom') }}</h3>
                <livewire:classroom-form-repeater>
            </div>
        </div>
    </div>
</div>

{{-- ========================================= --}}
{{-- DELETE ALL MODAL --}}
{{-- ========================================= --}}
<div id="grade-modal-deleteAll" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-[100] hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center bg-slate-900/50 backdrop-blur-sm">
    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-2xl shadow-xl p-6 text-center">
            <button type="button" class="absolute top-4 right-4 text-slate-400 bg-transparent hover:bg-slate-100 rounded-lg text-sm p-1.5 inline-flex items-center" data-modal-hide="grade-modal-deleteAll">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
            <div class="w-16 h-16 rounded-full bg-red-50 text-red-500 flex items-center justify-center mx-auto mb-4 mt-2">
                <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
            </div>
            <h3 class="mb-5 text-lg font-bold text-slate-900">{{trans('main.delete-classrooms-title')}}</h3>

            <form action="{{route('classroom.deleteselected')}}" method="post">
                @method("delete")
                @csrf
                <input class="text" type="hidden" id="selected_ids" name="selected_classrooms_ids" value="">

                <div class="flex justify-center gap-3">
                    <button type="submit" id="delete-selected-btn" class="text-white bg-red-600 hover:bg-red-700 font-semibold rounded-xl text-sm px-5 py-2.5 transition-colors w-full">
                        {{trans('main.confirm')}}
                    </button>
                    <button type="button" data-modal-hide="grade-modal-deleteAll" class="text-slate-600 bg-slate-100 hover:bg-slate-200 font-semibold rounded-xl text-sm px-5 py-2.5 transition-colors w-full">
                        {{trans('main.cancel')}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Search Classrooms Script --}}
<script type="module">
    import { setupSearchClassrooms } from "{{ asset('search.js') }}";
    let searchInput = document.getElementById('search_classrooms');
    setupSearchClassrooms(searchInput);
</script>

{{-- Filter & Checkbox Scripts --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Filter Logic
        var gradeSelect = document.getElementById('grade-select');
        var classroomForm = document.getElementById('classroom-form');

        if (gradeSelect && classroomForm) {
            gradeSelect.addEventListener('change', function() {
                classroomForm.submit();
                localStorage.setItem('selectedGrade', this.value);
            });

            var selectedGrade = localStorage.getItem('selectedGrade');
            if (selectedGrade) {
                gradeSelect.value = selectedGrade;
            }
        }

        // Checkbox Select All Logic
        const headerCheckbox = document.getElementById("checkboxAll");
        const classCheckboxes = document.querySelectorAll('.class-room-checkbox');
        const deleteAllbtn = document.getElementById("deleteAllbtn");

        if (headerCheckbox && classCheckboxes.length > 0) {
            headerCheckbox.addEventListener("click", () => {
                classCheckboxes.forEach((checkbox) => {
                    if (checkbox.offsetParent !== null) {
                        checkbox.checked = headerCheckbox.checked;
                    }
                });
                toggleDeleteButton();
            });
        }

        if (classCheckboxes.length > 0) {
            classCheckboxes.forEach(function (checkbox) {
                checkbox.addEventListener("change", toggleDeleteButton);
            });
        }

        function toggleDeleteButton() {
            let isChecked = false;
            classCheckboxes.forEach(function (cb) {
                if (cb.checked && cb.offsetParent !== null) isChecked = true;
            });
            if (deleteAllbtn) {
                deleteAllbtn.hidden = !isChecked;
            }
        }

        // Delete Selected Input Population
        const deleteSelectedBtn = document.getElementById("delete-selected-btn");
        const selectedIdsInput = document.getElementById("selected_ids");

        if (deleteSelectedBtn && selectedIdsInput) {
            deleteSelectedBtn.addEventListener('click', function (e) {
                let selected = new Set();
                document.querySelectorAll('.class-room-checkbox:checked').forEach(function (checkbox) {
                    if (checkbox.offsetParent !== null) {
                        selected.add(checkbox.value);
                    }
                });

                if (selected.size > 0) {
                    selectedIdsInput.value = Array.from(selected).join(',');
                } else {
                    e.preventDefault();
                    alert('Please select at least one classroom to delete.');
                }
            });
        }
    });
</script>

@endsection
