<div class="py-6 sm:py-12 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

            <div class="p-4 sm:p-6">
                {{-- Top Toolbar --}}
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">

                    {{-- Title --}}
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-slate-900">
                            {{ trans('main.classroom-subjects-title', ['classroom' => $classroom->name]) }}
                        </h1>
                        <p class="text-sm text-slate-500 mt-1">Manage subjects and assigned teachers for this classroom.
                        </p>
                    </div>

                    {{-- Search & Delete Actions --}}
                    <div class="flex items-center gap-3 w-full lg:w-auto">

                        {{-- Search --}}
                        <div class="relative w-full sm:w-64">
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

                        {{-- Delete Selected Button --}}
                        <button type="button" data-modal-target="modal-deleteAll" id="deleteAllbtn" hidden
                            data-modal-toggle="modal-deleteAll"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-xl transition-all shadow-sm shrink-0">
                            <i class="fa-solid fa-trash"></i>
                            <span class="hidden sm:inline">{{ trans('main.delete-selected') }}</span>
                        </button>
                    </div>
                </div>

                {{-- ========================================= --}}
                {{-- MOBILE VIEW: APP-LIKE CARDS --}}
                {{-- ========================================= --}}
                <div class="md:hidden space-y-3">
                    @forelse ($classroom_subjects as $classroom_subject)
                        <div
                            class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex items-center justify-between gap-4">
                            <div class="flex items-start gap-3">
                                <input type="checkbox" value="{{ $classroom_subject->id }}"
                                    class="mt-1 w-5 h-5 text-indigo-600 bg-slate-100 border-slate-300 rounded focus:ring-indigo-500 subject-checkbox">
                                <div>
                                    <h3 class="font-bold text-slate-900 text-base leading-tight">
                                        {{ $classroom_subject->name ?? '-' }}
                                    </h3>
                                    <p class="text-xs text-slate-500 mt-1 flex items-center gap-1.5">
                                        <i class="fa-solid fa-chalkboard-user text-slate-400"></i>
                                        {{ $classroom_subject->teacher->teacher_name ?? 'No teacher assigned' }}
                                    </p>
                                </div>
                            </div>

                            {{-- Livewire Delete Button --}}
                            <div class="shrink-0">
                                <livewire:classroom.classroom-subject.classroom-subject-delete :classroom_subject="$classroom_subject"
                                    :wire:key="'delete-subject-mobile-'.$classroom_subject->id" />
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-2xl p-8 text-center border border-slate-200 shadow-sm">
                            <div
                                class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-3 text-slate-400">
                                <i class="fa-solid fa-book-open text-xl"></i>
                            </div>
                            <p class="text-slate-500">{{ __('main.no-subjects') }}</p>
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
                                    <input id="checkboxAll" type="checkbox"
                                        class="w-4 h-4 text-indigo-600 bg-slate-100 border-slate-300 rounded focus:ring-indigo-500 cursor-pointer">
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    {{ __('#') }}</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    {{ __('main.name') }}</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    {{ __('main.subject-teacher') }}</th>
                                <th scope="col"
                                    class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    {{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @forelse ($classroom_subjects as $classroom_subject)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" value="{{ $classroom_subject->id }}"
                                            class="w-4 h-4 text-indigo-600 bg-slate-100 border-slate-300 rounded focus:ring-indigo-500 cursor-pointer subject-checkbox">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-slate-500">
                                        {{ getIteration($classroom_subjects, $loop) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-md bg-indigo-50 text-indigo-700 text-xs font-bold">
                                            {{ $classroom_subject->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-slate-600">
                                        {{ $classroom_subject->teacher->teacher_name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <livewire:classroom.classroom-subject.classroom-subject-delete :classroom_subject="$classroom_subject"
                                            :wire:key="'delete-classroom-classroom_subject-'.$classroom_subject->id" />
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                        {{ __('main.no-subjects') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $classroom_subjects->render() }}
                </div>

            </div>
        </div>
    </div>

    {{-- ========================================= --}}
    {{-- DELETE ALL MODAL --}}
    {{-- ========================================= --}}
    <div id="modal-deleteAll" wire:ignore tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-[100] hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center bg-slate-900/50 backdrop-blur-sm">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-2xl shadow-xl p-6 text-center">
                <button type="button"
                    class="absolute top-4 right-4 text-slate-400 bg-transparent hover:bg-slate-100 rounded-lg text-sm p-1.5 inline-flex items-center"
                    data-modal-hide="modal-deleteAll">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>

                <div
                    class="w-16 h-16 rounded-full bg-red-50 text-red-500 flex items-center justify-center mx-auto mb-4 mt-2">
                    <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                </div>

                <h3 class="mb-5 text-lg font-bold text-slate-900">
                    {{ trans('main.delete-classroom-subjects-title') }}
                </h3>

                <form action="{{ route('classroom.subjects.remove') }}" method="post">
                    @method('delete')
                    @csrf
                    <input type="hidden" id="selected_ids" name="selected_ids">

                    <div class="flex justify-center gap-3">
                        <button type="submit" id="delete-selected-btn"
                            class="text-white bg-red-600 hover:bg-red-700 font-semibold rounded-xl text-sm px-5 py-2.5 transition-colors w-full">
                            {{ trans('main.confirm') }}
                        </button>
                        <button type="button" data-modal-hide="modal-deleteAll"
                            class="text-slate-600 bg-slate-100 hover:bg-slate-200 font-semibold rounded-xl text-sm px-5 py-2.5 transition-colors w-full">
                            {{ trans('main.cancel') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const headerCheckbox = document.getElementById("checkboxAll");
            const subjectCheckboxes = document.querySelectorAll('.subject-checkbox');
            const deleteAllbtn = document.getElementById("deleteAllbtn");

            // Handle "Select All" click
            if (headerCheckbox && subjectCheckboxes.length > 0) {
                headerCheckbox.addEventListener("click", () => {
                    subjectCheckboxes.forEach((checkbox) => {
                        checkbox.checked = headerCheckbox.checked;
                    });
                    toggleDeleteButton();
                });
            }

            // Handle individual checkbox clicks
            if (subjectCheckboxes.length > 0) {
                subjectCheckboxes.forEach(function(checkbox) {
                    checkbox.addEventListener("change", toggleDeleteButton);
                });
            }

            // Show/Hide the "Delete Selected" button based on selection
            function toggleDeleteButton() {
                let isChecked = false;
                subjectCheckboxes.forEach(function(cb) {
                    if (cb.checked) isChecked = true;
                });
                if (deleteAllbtn) {
                    deleteAllbtn.hidden = !isChecked;
                }
            }

            // Populate the hidden input field before submitting the delete modal
            const deleteSelectedBtn = document.getElementById("delete-selected-btn");
            const selectedIdsInput = document.getElementById("selected_ids");

            if (deleteSelectedBtn && selectedIdsInput) {
                deleteSelectedBtn.addEventListener('click', function(e) {
                    let selected = [];
                    document.querySelectorAll('.subject-checkbox:checked').forEach(function(checkbox) {
                        selected.push(checkbox.value);
                    });

                    if (selected.length > 0) {
                        selectedIdsInput.value = selected.join(',');
                    } else {
                        e.preventDefault(); // Prevent submit if nothing selected
                        alert('Please select at least one subject to delete.');
                    }
                });
            }
        });
    </script>
@endpush
