<div x-data="{ openLang: false, openProfile: false, openNotif: false }" class="relative z-40">
    <header class="h-16 shrink-0 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6">

        {{-- Left: Mobile Menu Toggle & Page Title --}}
        <div class="flex items-center gap-3 min-w-0">
            {{-- Hamburger Button: Dispatches global event --}}
            <button @click="$dispatch('toggle-sidebar')" type="button"
                class="lg:hidden text-slate-500 hover:text-slate-700 focus:outline-none p-1.5 rounded-lg hover:bg-slate-100 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            {{-- Added min-w-0 and truncate to fix the "ent System" cutoff --}}
            <h1 class="text-lg font-semibold text-slate-800 hidden sm:block truncate">
                {{ trans('main-sidebar.' . Route::currentRouteName()) ?? 'Dashboard' }}
            </h1>
        </div>

        {{-- Right: Actions --}}
        <div class="flex items-center gap-2 sm:gap-4 shrink-0">

            {{-- LANGUAGE SWITCHER --}}
            @if (class_exists(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::class))
                <div class="relative">
                    <button @click="openLang = !openLang" type="button"
                        class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-slate-50 text-sm font-medium text-slate-600 border border-slate-200 transition">
                        @if (App::getLocale() == 'bn')
                            <svg class="w-5 h-5 rounded-sm" viewBox="0 0 30 30">
                                <rect width="30" height="30" fill="#006A4E" />
                                <circle cx="13.5" cy="15" r="7" fill="#F42A41" />
                            </svg>
                        @elseif(App::getLocale() == 'ar')
                            <svg class="w-5 h-5 rounded-sm" viewBox="0 0 30 30">
                                <rect width="30" height="10" fill="#CE1126" />
                                <rect y="10" width="30" height="10" fill="#FFFFFF" />
                                <rect y="20" width="30" height="10" fill="#000000" />
                                <circle cx="15" cy="15" r="2.2" fill="#C09300" />
                            </svg>
                        @else
                            <svg class="w-5 h-5 rounded-sm" viewBox="0 0 30 30">
                                <rect width="30" height="30" fill="#012169" />
                                <path d="M0,0 L30,30 M30,0 L0,30" stroke="#FFFFFF" stroke-width="5" />
                                <path d="M0,0 L30,30 M30,0 L0,30" stroke="#C8102E" stroke-width="3" />
                                <path d="M15,0 V30 M0,15 H30" stroke="#FFFFFF" stroke-width="8" />
                                <path d="M15,0 V30 M0,15 H30" stroke="#C8102E" stroke-width="5" />
                            </svg>
                        @endif
                        <span>{{ strtoupper(App::getLocale()) }}</span>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200"
                            :class="openLang ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="openLang" @click.outside="openLang = false" x-cloak x-transition.opacity
                        class="absolute end-0 mt-2 w-40 bg-white border border-slate-100 rounded-xl shadow-lg z-50 overflow-hidden">
                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            @if ($localeCode !== LaravelLocalization::getCurrentLocale())
                                <a rel="alternate" hreflang="{{ $localeCode }}"
                                    href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 transition">
                                    @if ($localeCode === 'bn')
                                        <svg class="w-5 h-5 rounded-sm shrink-0" viewBox="0 0 30 30">
                                            <rect width="30" height="30" fill="#006A4E" />
                                            <circle cx="13.5" cy="15" r="7" fill="#F42A41" />
                                        </svg>
                                    @elseif($localeCode === 'ar')
                                        <svg class="w-5 h-5 rounded-sm shrink-0" viewBox="0 0 30 30">
                                            <rect width="30" height="10" fill="#CE1126" />
                                            <rect y="10" width="30" height="10" fill="#FFFFFF" />
                                            <rect y="20" width="30" height="10" fill="#000000" />
                                            <circle cx="15" cy="15" r="2.2" fill="#C09300" />
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 rounded-sm shrink-0" viewBox="0 0 30 30">
                                            <rect width="30" height="30" fill="#012169" />
                                            <path d="M0,0 L30,30 M30,0 L0,30" stroke="#FFFFFF" stroke-width="5" />
                                            <path d="M0,0 L30,30 M30,0 L0,30" stroke="#C8102E" stroke-width="3" />
                                            <path d="M15,0 V30 M0,15 H30" stroke="#FFFFFF" stroke-width="8" />
                                            <path d="M15,0 V30 M0,15 H30" stroke="#C8102E" stroke-width="5" />
                                        </svg>
                                    @endif
                                    <span class="font-medium">{{ $properties['native'] }}</span>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- NOTIFICATIONS (Now with proper dropdown) --}}
            <div class="relative">
                <button @click="openNotif = !openNotif" type="button"
                    class="relative p-2 text-slate-400 hover:text-slate-600 transition rounded-full hover:bg-slate-50 border border-transparent hover:border-slate-200">
                    <i class="fa-regular fa-bell text-xl"></i>
                    @if (auth()->user()->unreadNotifications->count() > 0)
                        <span class="absolute top-1 right-1 flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                        </span>
                    @endif
                </button>

                <div x-show="openNotif" @click.outside="openNotif = false" x-cloak x-transition.opacity
                    class="absolute end-0 mt-2 w-80 bg-white border border-slate-100 rounded-xl shadow-lg z-50 overflow-hidden">
                    <div class="px-4 py-3 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                        <p class="text-sm font-bold text-slate-900">Notifications</p>
                        <span
                            class="text-xs font-medium bg-indigo-100 text-indigo-600 px-2 py-0.5 rounded-full">{{ auth()->user()->unreadNotifications->count() }}
                            New</span>
                    </div>
                    <div class="max-h-64 overflow-y-auto">
                        @forelse(auth()->user()->unreadNotifications as $notification)
                            <a href="#"
                                class="flex items-start gap-3 px-4 py-3 hover:bg-slate-50 border-b border-slate-50 last:border-0 transition">
                                <div
                                    class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0 mt-1">
                                    <i class="fa-solid fa-bell text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-800 font-medium">
                                        {{ $notification->data['message'] ?? 'New notification received.' }}</p>
                                    <p class="text-xs text-slate-500 mt-0.5">
                                        {{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                            </a>
                        @empty
                            <div class="px-4 py-6 text-center text-sm text-slate-500">No new notifications</div>
                        @endforelse
                    </div>
                    <div class="px-4 py-2 border-t border-slate-100 text-center">
                        <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">View
                            All</a>
                    </div>
                </div>
            </div>

            {{-- PROFILE DROPDOWN --}}
            <div class="relative">
                <button @click="openProfile = !openProfile"
                    class="flex items-center gap-2 p-1 rounded-full hover:bg-slate-50 transition border border-transparent hover:border-slate-200 focus:outline-none">
                    <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}"
                        class="h-8 w-8 rounded-full object-cover">
                </button>

                <div x-show="openProfile" @click.outside="openProfile = false" x-cloak x-transition.opacity
                    class="absolute end-0 mt-2 w-48 bg-white border border-slate-100 rounded-xl shadow-lg z-50 overflow-hidden">
                    <div class="px-4 py-3 border-b border-slate-100">
                        <p class="text-sm font-bold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="p-2 space-y-1">
                        <a href="{{ route('profile.show') }}"
                            class="block px-3 py-2 text-sm text-slate-600 rounded-lg hover:bg-slate-50">Profile
                            Settings</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-3 py-2 text-sm text-red-600 rounded-lg hover:bg-red-50 font-medium">Sign
                                Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>
</div>
