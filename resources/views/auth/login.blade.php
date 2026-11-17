<x-guest-layout>
    <div class="min-h-screen bg-gray-900 text-gray-900 flex flex-col lg:grid lg:grid-cols-2 relative overflow-x-hidden">

        {{-- Top App Bar: Mobile WYZEEK Logo + Language Switcher --}}
        <header class="w-full z-30 flex items-center justify-between px-5 pt-5 pb-3 lg:fixed lg:top-0 lg:left-0 lg:px-8 lg:py-6">
            {{-- Mobile Inline SVG Logo (Hidden on Desktop) --}}
            <div class="flex items-center lg:hidden">
                <svg class="h-8 w-auto" viewBox="0 0 260 72" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="WYZEEK">
                    <path d="M12 24C8 17 16 9 23 14L31 20L39 10C44 4 54 8 52 16L43 44C41 51 31 52 27 45L12 24Z" fill="#FFFFFF"/>
                    <rect x="58" y="8" width="16" height="44" rx="8" transform="rotate(24 58 8)" fill="#FFFFFF"/>
                    <circle cx="74" cy="43" r="8" fill="#F97316"/>
                    <text x="94" y="48" fill="#FFFFFF" font-family="system-ui, -apple-system, sans-serif" font-weight="800" font-size="34" letter-spacing="-1">wyzeek</text>
                </svg>
            </div>

            <div class="hidden lg:block"></div>

            {{-- Language Switcher Pill --}}
            <div class="flex items-center gap-2">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode =>$properties)
                    @if($localeCode !== LaravelLocalization::getCurrentLocale())
                        <a rel="alternate"
                           hreflang="{{ $localeCode }}"
                           href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                           class="inline-flex items-center gap-2 rounded-full bg-gray-800 hover:bg-gray-700 border border-gray-600 px-3.5 py-1.5 text-xs font-semibold text-white shadow-sm transition">
                            @if($localeCode === 'bn')
                                <svg class="w-4 h-4 rounded-full flex-shrink-0" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="30" height="30" fill="#006A4E"/>
                                    <circle cx="13.5" cy="15" r="7" fill="#F42A41"/>
                                </svg>
                            @elseif($localeCode === 'ar')
                                <svg class="w-4 h-4 rounded-full flex-shrink-0" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="30" height="10" fill="#CE1126"/>
                                    <rect y="10" width="30" height="10" fill="#FFFFFF"/>
                                    <rect y="20" width="30" height="10" fill="#000000"/>
                                    <circle cx="15" cy="15" r="2.2" fill="#C09300"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4 rounded-full flex-shrink-0" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="30" height="30" fill="#012169"/>
                                    <path d="M0,0 L30,30 M30,0 L0,30" stroke="#FFFFFF" stroke-width="5"/>
                                    <path d="M0,0 L30,30 M30,0 L0,30" stroke="#C8102E" stroke-width="3"/>
                                    <path d="M15,0 V30 M0,15 H30" stroke="#FFFFFF" stroke-width="8"/>
                                    <path d="M15,0 V30 M0,15 H30" stroke="#C8102E" stroke-width="5"/>
                                </svg>
                            @endif
                            <span>{{ $properties['native'] }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
        </header>

        {{-- LEFT / TOP HERO SECTION: WYZEEK Paperless Platform --}}
        <section class="flex flex-col justify-center px-6 pt-2 pb-8 lg:px-16 lg:py-16 bg-gray-900 text-white">
            <div class="max-w-xl mx-auto lg:mx-0 w-full">

                {{-- Desktop Inline SVG Logo --}}
                <div class="hidden lg:block mb-8">
                    <svg class="h-14 w-auto" viewBox="0 0 260 72" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="WYZEEK">
                        <path d="M12 24C8 17 16 9 23 14L31 20L39 10C44 4 54 8 52 16L43 44C41 51 31 52 27 45L12 24Z" fill="#FFFFFF"/>
                        <rect x="58" y="8" width="16" height="44" rx="8" transform="rotate(24 58 8)" fill="#FFFFFF"/>
                        <circle cx="74" cy="43" r="8" fill="#F97316"/>
                        <text x="94" y="48" fill="#FFFFFF" font-family="system-ui, -apple-system, sans-serif" font-weight="800" font-size="34" letter-spacing="-1">wyzeek</text>
                    </svg>
                </div>

                {{-- Paperless Badge --}}
                <div class="inline-flex items-center gap-2 rounded-full bg-green-900 border border-green-500 px-3.5 py-1 text-xs font-semibold text-green-300 mb-4">
                    <span class="h-2 w-2 rounded-full bg-green-400"></span>
                    <span>{{ __('auth.paperless-badge') }}</span>
                </div>

                {{-- Main Headline --}}
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-white leading-snug">
                    {{ __('auth.system-name') }}
                </h1>

                {{-- Description --}}
                <p class="mt-3 text-sm sm:text-base lg:text-lg text-gray-300 leading-relaxed">
                    {{ __('auth.system-info') }}
                </p>

                {{-- Paperless Impact Stats --}}
                <div class="mt-6 grid grid-cols-3 gap-3">
                    <div class="rounded-xl bg-gray-800 border border-gray-700 p-3 sm:p-4">
                        <div class="text-lg sm:text-2xl font-extrabold text-green-400">75%</div>
                        <div class="text-xs text-gray-300 mt-1">{{ __('auth.stat-paper') }}</div>
                    </div>
                    <div class="rounded-xl bg-gray-800 border border-gray-700 p-3 sm:p-4">
                        <div class="text-lg sm:text-2xl font-extrabold text-yellow-400">100%</div>
                        <div class="text-xs text-gray-300 mt-1">{{ __('auth.stat-cloud') }}</div>
                    </div>
                    <div class="rounded-xl bg-gray-800 border border-gray-700 p-3 sm:p-4">
                        <div class="text-lg sm:text-2xl font-extrabold text-blue-400">0</div>
                        <div class="text-xs text-gray-300 mt-1">{{ __('auth.stat-registers') }}</div>
                    </div>
                </div>

                {{-- Desktop Contact Button --}}
                <div class="hidden lg:flex items-center gap-4 mt-10 pt-6 border-t border-gray-800">
                    <a href="mailto:info@wyzeek.com"
                       class="inline-flex items-center justify-center gap-2 rounded-lg bg-gray-800 hover:bg-gray-700 border border-gray-600 px-5 py-3 text-sm font-medium text-white transition">
                        <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ __('auth.contact-us') }}</span>
                    </a>
                    <span class="text-xs text-gray-400">www.wyzeek.com</span>
                </div>
            </div>
        </section>

        {{-- RIGHT / BOTTOM SECTION: Mobile App Bottom-Sheet Login Card --}}
        <main class="flex-1 flex flex-col justify-center bg-white rounded-t-3xl lg:rounded-none px-6 py-8 sm:px-10 lg:px-16 shadow-2xl lg:shadow-none">
            <div class="w-full max-w-md mx-auto">

                {{-- Mobile Pull Handle --}}
                <div class="w-12 h-1.5 bg-gray-300 rounded-full mx-auto mb-6 lg:hidden"></div>

                {{-- Form Header + Institution Logo --}}
                <div class="flex items-center justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
                            {{ __('auth.welcome-back') }}
                        </h2>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">
                            {{ __('auth.login-subtitle') }}
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <x-authentication-card-logo />
                    </div>
                </div>

                {{-- Validation Errors & Status --}}
                <x-validation-errors class="mb-4 rounded-lg bg-red-50 p-3 text-xs text-red-600 border border-red-200" />

                @if (session('status'))
                    <div class="mb-4 rounded-lg bg-green-50 border border-green-200 p-3 font-medium text-xs sm:text-sm text-green-700">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Login Form --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                            {{ __('main.email') }}
                        </label>
                        <input id="email"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autofocus
                               autocomplete="username"
                               placeholder="teacher@school.edu"
                               class="block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base sm:text-sm text-gray-900 placeholder-gray-400 focus:border-green-600 focus:bg-white focus:ring-2 focus:ring-green-500 transition" />
                    </div>

                    {{-- Password with Show/Hide Toggler --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-gray-700">
                                {{ __('main.password') }}
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                   class="text-xs font-semibold text-green-700 hover:text-green-800 hover:underline">
                                    {{ __('auth.forgot-your-password') }}
                                </a>
                            @endif
                        </div>

                        <div class="relative flex items-center">
                            <input id="password"
                                   type="password"
                                   name="password"
                                   required
                                   autocomplete="current-password"
                                   placeholder="••••••••"
                                   class="block w-full rounded-xl border border-gray-300 bg-gray-50 {{ App::getLocale() == 'ar' ? 'pl-12 pr-4' : 'pr-12 pl-4' }} py-3 text-base sm:text-sm text-gray-900 placeholder-gray-400 focus:border-green-600 focus:bg-white focus:ring-2 focus:ring-green-500 transition" />

                            <button type="button"
                                    id="toggle-password"
                                    aria-label="Show password"
                                    aria-pressed="false"
                                    style="{{ App::getLocale() == 'ar' ? 'left: 0;' : 'right: 0;' }}"
                                    class="absolute inset-y-0 flex items-center justify-center px-3.5 text-gray-500 hover:text-gray-800 focus:outline-none">
                                {{-- Eye Open --}}
                                <svg id="eye-open" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{-- Eye Closed --}}
                                <svg id="eye-closed" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                            <input id="remember_me"
                                   type="checkbox"
                                   name="remember"
                                   class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500" />
                            <span class="mx-2 text-sm text-gray-600">
                                {{ __('auth.remember-me') }}
                            </span>
                        </label>
                    </div>

                    {{-- Full-Width App Submit Button --}}
                    <div class="pt-1">
                        <button type="submit"
                                class="w-full flex items-center justify-center gap-2 rounded-xl bg-gray-900 hover:bg-gray-80
