<div class="w-full max-w-3xl mx-auto py-6 sm:py-10 px-4 sm:px-6 lg:px-8">
    {{-- Main Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

        {{-- Header --}}
        <div class="p-6 sm:p-8 border-b border-slate-100">
            <h2 class="text-xl sm:text-2xl font-bold text-slate-900">
                {{ trans('main.associate-subject-to-classroom') }}
            </h2>
            <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                {{ trans('main.associate-subject-to-classroom-description-one') }}
                {{ trans('main.associate-subject-to-classroom-description-two') }}
            </p>
        </div>

        {{-- Form Body --}}
        <div class="p-6 sm:p-8 bg-slate-50/50">
            <form wire:submit.prevent="associateSubjectToClassroom()" class="space-y-6">
                @csrf

                {{-- Subject Name (Read-Only) --}}
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">
                        {{ trans('main.subject-name') }}
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                            <i class="fa-solid fa-book text-slate-400"></i>
                        </div>
                        <input type="text" wire:model.defer="name" id="name" disabled
                            class="block w-full pl-10 pr-4 py-3 text-sm text-slate-500 bg-slate-100 border border-slate-200 rounded-xl cursor-not-allowed focus:outline-none"
                            placeholder=" " />
                    </div>
                    @error('name')
                        <span class="text-red-500 text-xs mt-1.5 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Grade & Classroom Selects --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Grade --}}
                    <div>
                        <label for="grade_id" class="block text-sm font-semibold text-slate-700 mb-2">
                            {{ trans('main.select-grade') }}
                        </label>
                        <div class="relative">
                            <select id="grade_id" wire:model.defer="grade_id" name="grade_id" autocomplete="off"
                                onchange="Livewire.emit('updatedGradeId', this.value)"
                                class="block w-full px-4 py-3 text-sm text-slate-900 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none transition-all cursor-pointer">
                                <option value="">{{__('main.select-grade')}}</option>
                                @foreach ($grades as $grade)
                                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                @endforeach
                            </select>
                            {{-- Custom Select Arrow --}}
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                <i class="fa-solid fa-chevron-down text-slate-400 text-xs"></i>
                            </div>
                        </div>
                        @error('grade_id')
                            <span class="text-red-500 text-xs mt-1.5 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Classroom --}}
                    <div>
                        <label for="classroom_id" class="block text-sm font-semibold text-slate-700 mb-2">
                            {{ trans('main.select-classroom') }}
                        </label>
                        <div class="relative">
                            <select id="classroom_id" wire:model.defer="classroom_id" name="classroom_id" autocomplete="off"
                                class="block w-full px-4 py-3 text-sm text-slate-900 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none transition-all cursor-pointer">
                                <option value="">{{__('main.select-classroom')}}</option>
                                @foreach ($classrooms as $classroom)
                                    <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                                @endforeach
                            </select>
                            {{-- Custom Select Arrow --}}
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                <i class="fa-solid fa-chevron-down text-slate-400 text-xs"></i>
                            </div>
                        </div>
                        @error('classroom_id')
                            <span class="text-red-500 text-xs mt-1.5 block">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                {{-- Submit Button --}}
                <div class="pt-2">
                    <button type="submit" wire:submit='associateSubjectToClassroom' wire:loading.attr='disabled'
                        class="w-full flex items-center justify-center gap-2 px-6 py-3.5 bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed text-white text-base font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition-all">

                        {{-- Loading Spinner --}}
                        <svg wire:loading wire:target="associateSubjectToClassroom" class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>

                        <i wire:loading.remove wire:target="associateSubjectToClassroom" class="fa-solid fa-link"></i>
                        {{ __('main.associate') }}
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
