<header class="h-16 shrink-0 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 z-30 relative">

    <!-- Left: Mobile Menu Toggle & Page Title -->
    <div class="flex items-center gap-3">
        <button @click="sidebarOpen = true" class="lg:hidden text-slate-500 hover:text-slate-700 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>

        <h1 class="text-lg font-semibold text-slate-800 hidden sm:block">
            {{ trans('main-sidebar.' . Route::currentRouteName()) ?? 'Dashboard' }}
        </h1>
    </div>

    <!-- Right: Actions -->
    <div class="flex items-center gap-2 sm:gap-4">

        <!-- Language Switcher (Simplified) -->
        @if(class_exists(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::class))
        <div class="relative group">
            <button class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-slate-50 text-sm font-medium text-slate-600 border border-slate-200 transition">
                <span>{{ strtoupper(LaravelLocalization::getCurrentLocale()) }}</span>
                <i class="fa-solid fa-chevron-down text-xs"></i>
            </button>
            <div class="absolute right-0 mt-1 w-32 bg-white border border-slate-100 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    @if($localeCode !== LaravelLocalization::getCurrentLocale())
                    <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-slate-50">
                        {{ $properties['native'] }}
                    </a>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        <!-- Notifications -->
        <a href="#" class="relative p-2 text-slate-400 hover:text-slate-600 transition">
            <i class="fa-regular fa-bell text-xl"></i>
            @if(auth()->user()->unreadNotifications->count() > 0)
                <span class="absolute top-1 right-1 flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                </span>
            @endif
        </a>

        <!-- Profile Dropdown -->
        <div class="relative group">
            <button class="flex items-center gap-2 p-1 rounded-full hover:bg-slate-50 transition border border-transparent hover:border-slate-200">
                <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="h-8 w-8 rounded-full object-cover">
            </button>

            <div class="absolute right-0 mt-2 w-48 bg-white border border-slate-100 rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                <div class="px-4 py-3 border-b border-slate-100">
                    <p class="text-sm font-medium text-slate-900 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
                </div>
                <div class="p-2 space-y-1">
                    <a href="{{ route('profile.show') }}" class="block px-3 py-2 text-sm text-slate-600 rounded-lg hover:bg-slate-50">Profile Settings</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 text-sm text-red-600 rounded-lg hover:bg-red-50 font-medium">Sign Out</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</header>
