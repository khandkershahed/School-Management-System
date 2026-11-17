<div class="w-full max-w-7xl mx-auto space-y-8 pb-12">
    <!-- Video Banner -->
    <div class="relative w-full rounded-3xl overflow-hidden shadow-lg aspect-[21/9] sm:aspect-[3/1]">
        <video class="absolute inset-0 w-full h-full object-cover" autoplay loop muted playsinline>
            <source src="{{ asset('assets/videos/dashboard-1.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="absolute inset-0 bg-gradient-to-r from-slate-900/90 via-slate-900/60 to-transparent"></div>
        <div class="absolute inset-0 flex flex-col justify-center p-8 sm:p-12 max-w-2xl text-white">
            <h1 class="text-2xl sm:text-4xl text-white font-bold mb-3">
                {{ trans('main.welcome-dash', ['name' => auth()->user()->name]) }}
            </h1>
            <p class="text-sm sm:text-base text-slate-200 leading-relaxed">
                {{ trans('main.thank-you-dash') }}
            </p>
        </div>
    </div>
    <!-- 4 Main Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1: Users -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">{{ trans('main.users-numbers') }}</p>
                    <h3 class="text-3xl font-bold text-slate-900 mt-2">
                        {{ $users_number }}
                        <span
                            class="text-sm font-semibold {{ $new_users_percentage < 0 ? 'text-red-500' : 'text-emerald-500' }}">
                            {{ $new_users_percentage > 0 ? '+' : '' }}{{ $new_users_percentage }}%
                        </span>
                    </h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <i class="fa-solid fa-users text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Card 2: Students -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">{{ trans('main.students-numbers') }}</p>
                    <h3 class="text-3xl font-bold text-slate-900 mt-2">
                        {{ $students_number }}
                        <span
                            class="text-sm font-semibold {{ $new_students_percentage < 0 ? 'text-red-500' : 'text-emerald-500' }}">
                            {{ $new_students_percentage > 0 ? '+' : '' }}{{ $new_students_percentage }}%
                        </span>
                    </h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i class="fa-solid fa-chalkboard-user text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Card 3: Teachers -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">{{ trans('main.teachers-numbers') }}</p>
                    <h3 class="text-3xl font-bold text-slate-900 mt-2">
                        {{ $teachers_number }}
                        <span
                            class="text-sm font-semibold {{ $new_teachers_percentage < 0 ? 'text-red-500' : 'text-emerald-500' }}">
                            {{ $new_teachers_percentage > 0 ? '+' : '' }}{{ $new_teachers_percentage }}%
                        </span>
                    </h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <i class="fa-solid fa-person-chalkboard text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Card 4: Classrooms -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">{{ trans('main.classrooms-numbers') }}</p>
                    <h3 class="text-3xl font-bold text-slate-900 mt-2">{{ $classroom_number }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <i class="fa-solid fa-school text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Insights Section (Charts, KPIs, Tables) --}}
    @include('dashboard.wyzeek-admin-insights')



    <!-- Bottom Section: Posts & Calendar -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Posts -->
        <div class="lg:col-span-1 space-y-4">
            <h3 class="text-lg font-bold text-slate-800 mb-4">Recent Discussions</h3>
            @forelse ($last_posts as $last_post)
                <div
                    class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                    <div class="flex items-center gap-2 mb-3">
                        @if ($last_post->grade_id)
                            <span
                                class="bg-indigo-50 text-indigo-700 text-xs font-semibold px-2.5 py-1 rounded-md">{{ $last_post->grade->name }}</span>
                        @endif
                        @if ($last_post->classroom_id)
                            <span
                                class="bg-purple-50 text-purple-700 text-xs font-semibold px-2.5 py-1 rounded-md">{{ $last_post->classroom->name }}</span>
                        @endif
                    </div>
                    <h4 class="font-bold text-slate-900 mb-2 line-clamp-2">
                        {{ $last_post->title }}
                    </h4>
                    <p class="text-sm text-slate-500 line-clamp-3 mb-4">
                        {{ \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($last_post->content)), 150, '...') }}
                    </p>
                    <div class="flex items-center justify-between mt-auto">
                        <span
                            class="text-xs font-medium text-slate-400">{{ $last_post->created_at->diffForHumans() }}</span>
                        <a href="{{ route('post.show', $last_post->id) }}"
                            class="inline-flex items-center gap-1 text-sm font-semibold text-indigo-600 hover:text-indigo-700 group-hover:translate-x-1 transition-transform">
                            Read <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center shadow-sm">
                    <div
                        class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-3 text-slate-400">
                        <i class="fa-regular fa-folder-open text-xl"></i>
                    </div>
                    <p class="text-slate-500">No Posts available right now</p>
                </div>
            @endforelse
        </div>

        <!-- Calendar -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 sm:p-6 h-full">
                <livewire:calendar />
            </div>
        </div>
    </div>
</div>
