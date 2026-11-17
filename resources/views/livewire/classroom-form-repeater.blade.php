<form class="space-y-6 pb-20 sm:pb-2" wire:submit.prevent="store" method="post">
    @csrf

    {{-- Primary Classroom Entry --}}
    <div class="bg-slate-50/70 p-4 sm:p-5 rounded-2xl border border-slate-200/80">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
            {{-- Left Column: Name & Grade --}}
            <div class="space-y-4">
                <div>
                    <label for="classroom_name" class="block mb-1.5 text-sm font-semibold text-slate-700">
                        {{ trans('main.classroom-name') }}
                    </label>
                    <input type="text" wire:model="name" name="name" id="classroom_name"
                           class="@error('name') border-red-500 focus:ring-red-500 @enderror w-full bg-white border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block p-3 transition-all"
                           placeholder="{{ trans('main.classroom-name') }}">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="small" class="block mb-1.5 text-sm font-semibold text-slate-700">
                        {{ trans('main.add-grade') }}
                    </label>
                    <select id="small" wire:model="grade" name="grade"
                            class="@error('grade') border-red-500 focus:ring-red-500 @enderror w-full bg-white border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block p-3 transition-all">
                        <option value="" selected>{{ trans('main.select-grade') }}</option>
                        @forelse($grades as $gradeItem)
                            <option value="{{ $gradeItem->id }}">{{ trans($gradeItem->name) }}</option>
                        @empty
                            <option disabled>{{ trans('main.no-grade') }}</option>
                        @endforelse
                    </select>
                    @error('grade')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Right Column: Description --}}
            <div class="flex flex-col">
                <label for="message" class="block mb-1.5 text-sm font-semibold text-slate-700">
                    {{ trans('main.classroom-description') }}
                </label>
                <textarea id="message" wire:model="description" name="description" rows="4"
                          class="@error('description') border-red-500 focus:ring-red-500 @enderror w-full flex-1 bg-white border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block p-3 transition-all"></textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    {{-- Repeater Fields --}}
    @if (!empty($fields))
        <div class="space-y-4">
            @foreach ($fields as $index => $field)
                <div wire:key="classroom-field-{{ $index }}" class="bg-slate-50/70 p-4 sm:p-5 rounded-2xl border border-slate-200/80 relative">
                    {{-- Header with Row Number & Remove Button --}}
                    <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-200/80">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                            #{{ $index + 2 }}
                        </span>
                        <button type="button" wire:click.prevent="removeField({{ $index }})"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                            <i class="fa-solid fa-trash-can"></i>
                            <span>{{ trans('main.remove-field-classes') }}</span>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
                        {{-- Left Column: Name & Grade --}}
                        <div class="space-y-4">
                            <div>
                                <label for="field_name_{{ $index }}" class="block mb-1.5 text-sm font-semibold text-slate-700">
                                    {{ trans('main.classroom-name') }}
                                </label>
                                <input type="text" wire:model="fields.{{ $index }}.name"
                                       name="fields[{{ $index }}][name]" id="field_name_{{ $index }}"
                                       class="@error('fields.' . $index . '.name') border-red-500 focus:ring-red-500 @enderror w-full bg-white border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block p-3 transition-all">
                                @error('fields.' . $index . '.name')
                                    <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="field_grade_{{ $index }}" class="block mb-1.5 text-sm font-semibold text-slate-700">
                                    {{ trans('main.add-grade') }}
                                </label>
                                <select wire:model="fields.{{ $index }}.grade"
                                        name="fields[{{ $index }}][grade]" id="field_grade_{{ $index }}"
                                        class="w-full bg-white border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block p-3 transition-all">
                                    <option value="" selected>{{ trans('main.select-grade') }}</option>
                                    @forelse($grades as $gradeItem)
                                        <option value="{{ $gradeItem->id }}">{{ trans($gradeItem->name) }}</option>
                                    @empty
                                        <option disabled>{{ trans('main.no-grade') }}</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        {{-- Right Column: Description --}}
                        <div class="flex flex-col">
                            <label for="field_description_{{ $index }}" class="block mb-1.5 text-sm font-semibold text-slate-700">
                                {{ trans('main.classroom-description') }}
                            </label>
                            <textarea id="field_description_{{ $index }}" wire:model="fields.{{ $index }}.description"
                                      name="fields[{{ $index }}][description]" rows="4"
                                      class="w-full flex-1 bg-white border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block p-3 transition-all"></textarea>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Action Buttons --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
        <button type="button" wire:click.prevent="addField"
                class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 text-sm font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition-colors">
            <i class="fa-solid fa-plus"></i>
            <span>{{ trans('main.add-field-classes') }}</span>
        </button>

        <button type="submit"
                class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 text-sm font-bold text-white bg-slate-900 hover:bg-slate-800 rounded-xl shadow-sm transition-colors">
            <i class="fa-solid fa-check"></i>
            <span>{{ trans('main.add') }}</span>
        </button>
    </div>
</form>
