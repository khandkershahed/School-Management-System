<x-guest-layout>
    <div class="min-h-screen bg-slate-950 text-slate-900 flex flex-col lg:grid lg:grid-cols-12 relative overflow-x-hidden selection:bg-emerald-500 selection:text-white">

        {{-- Ambient Background Glows (App-like feel) --}}
        <div class="pointer-events-none absolute -top-24 -left-24 h-72 w-72 rounded-full bg-emerald-500/15 blur-3xl"></div>
        <div class="pointer-events-none absolute top-40 -right-20 h-64 w-64 rounded-full bg-amber-500/10 blur-3xl"></div>

        {{-- Top Floating App Bar: Brand Mark (Mobile) + Language Switcher --}}
        <header class="w-full z-30 flex items-center justify-between px-5 pt-5 pb-2 lg:fixed lg:top-0 lg:left-0 lg:px-8 lg:py-6">
            {{-- Mobile Brand Logo (Hidden on Desktop since left panel shows it) --}}
            <div class="flex items-center gap-2.5 lg:hidden">
                <img src="{{ asset('images/wyzeek-logo-dark.png') }}" alt="WYZEEK" class="h-9 w-auto object-contain rounded">
            </div>

            {{-- Spacer for Desktop right alignment --}}
            <div class="hidden lg:block"></div>

            {{-- Clean Locale Switcher Pill --}}
            <div class="relative flex items-center gap-2">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    @if($localeCode !== LaravelLocalization::getCurrentLocale())
                        <a rel="alternate"
                           hreflang="{{ $localeCode }}"
                           href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                           class="inline-flex items-center gap-2 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/15 px-3.5 py-1.5 text-xs font-medium text-white shadow-sm transition active:scale-95">
                            @if($localeCode === 'bn')
                                {{-- Bangladesh Flag --}}
                                <svg class="w-4 h-4 rounded-full shrink-0" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="30" height="30" fill="#006A4E"/>
                                    <circle cx="13.5" cy="15" r="7" fill="#F42A41"/>
                                </svg>
                            @elseif($localeCode === 'ar')
                                {{-- Egypt / Arabic Flag --}}
                                <svg class="w-4 h-4 rounded-full shrink-0" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="30" height="10" fill="#CE1126"/>
                                    <rect y="10" width="30" height="10" fill="#FFFFFF"/>
                                    <rect y="20" width="30" height="10" fill="#000000"/>
                                    <circle cx="15" cy="15" r="2.2" fill="#C09300"/>
                                </svg>
                            @else
                                {{-- UK / English Flag --}}
                                <svg class="w-4 h-4 rounded-full shrink-0" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
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

        {{-- LEFT / TOP SECTION: WYZEEK Paperless Hero --}}
        <section class="lg:col-span-6 xl:col-span-7 flex flex-col justify-between px-6 pt-3 pb-8 lg:px-16 lg:py-16 text-white z-10">
            <div class="my-auto max-w-xl mx-auto lg:mx-0 w-full">

                {{-- Desktop Logo --}}
                <div class="hidden lg:block mb-8">
                    <img src="{{ asset('images/wyzeek-logo-dark.png') }}" alt="WYZEEK Logo" class="h-16 w-auto object-contain">
                </div>

                {{-- Paperless Impact Pill --}}
                <div class="inline-flex items-center gap-2 rounded-full bg-emerald-500/15 border border-emerald-400/30 px-3 py-1 text-xs font-semibold text-emerald-300 mb-4">
                    <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>{{ __('auth.paperless-badge') }}</span>
                </div>

                {{-- Main Headline --}}
                <h1 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-extrabold tracking-tight leading-tight">
                    {{ __('auth.system-name') }}
                </h1>

                {{-- Subtext --}}
                <p class="mt-3 text-sm sm:text-base lg:text-lg text-slate-300 leading-relaxed">
                    {{ __('auth.system-info') }}
                </p>

                {{-- Paperless Impact Stats Cards --}}
                <div class="mt-6 grid grid-cols-3 gap-2.5 sm:gap-4">
                    <div class="rounded-2xl bg-white/5 border border-white/10 p-3 sm:p-4 backdrop-blur-sm">
                        <div class="text-lg sm:text-2xl font-extrabold text-emerald-400">75%</div>
                        <div class="text-[11px] sm:text-xs text-slate-300 mt-0.5 leading-snug">{{ __('auth.stat-paper') }}</div>
                    </div>
                    <div class="rounded-2xl bg-white/5 border border-white/10 p-3 sm:p-4 backdrop-blur-sm">
                        <div class="text-lg sm:text-2xl font-extrabold text-amber-400">100%</div>
                        <div class="text-[11px] sm:text-xs text-slate-300 mt-0.5 leading-snug">{{ __('auth.stat-cloud') }}</div>
                    </div>
                    <div class="rounded-2xl bg-white/5 border border-white/10 p-3 sm:p-4 backdrop-blur-sm">
                        <div class="text-lg sm:text-2xl font-extrabold text-sky-400">0</div>
                        <div class="text-[11px] sm:text-xs text-slate-300 mt-0.5 leading-snug">{{ __('auth.stat-registers') }}</div>
                    </div>
                </div>

                {{-- Desktop Support / Contact CTA --}}
                <div class="hidden lg:flex items-center gap-4 mt-10 pt-6 border-t border-white/10">
                    <a href="mailto:info@wyzeek.com"
                       class="inline-flex items-center justify-center gap-2 rounded-xl bg-white/10 hover:bg-white/15 border border-white/15 px-5 py-3 text-sm font-medium text-white transition">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ __('auth.contact-us') }}</span>
                    </a>
                    <span class="text-xs text-slate-400">www.wyzeek.com</span>
                </div>
            </div>
        </section>

        {{-- RIGHT / BOTTOM SECTION: Mobile App Bottom-Sheet Login Card --}}
        <main class="lg:col-span-6 xl:col-span-5 flex-1 flex flex-col justify-center bg-white dark:bg-slate-900 rounded-t-[2rem] lg:rounded-none px-6 py-8 sm:px-10 lg:px-14 shadow-[0_-12px_40px_rgba(0,0,0,0.35)] lg:shadow-none z-20">
            <div class="w-full max-w-md mx-auto">

                {{-- Native App Pull-Handle Indicator (Mobile Only) --}}
                <div class="w-12 h-1.5 bg-slate-200 dark:bg-slate-700 rounded-full mx-auto mb-6 lg:hidden"></div>

                {{-- Institution / App Brand Header --}}
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white">
                            {{ __('auth.welcome-back') }}
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                            {{ __('auth.login-subtitle') }}
                        </p>
                    </div>
                    <div class="shrink-0">
                        <x-authentication-card-logo class="w-12 h-12" />
                    </div>
                </div>

                {{-- Validation Errors & Status --}}
                <x-validation-errors class="mb-4 rounded-xl bg-red-50 p-3 text-xs text-red-600 border border-red-100" />

                @if (session('status'))
                    <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 p-3 font-medium text-xs sm:text-sm text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Login Form --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    {{-- Email Input --}}
                    <div>
                        <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1.5">
                            {{ __('main.email') }}
                        </label>
                        <div class="relative">
                            <input id="email"
                                   type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autofocus
                                   autocomplete="username"
                                   placeholder="teacher@school.edu"
                                   class="block w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 px-4 py-3.5 text-base sm:text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition" />
                        </div>
                    </div>

                    {{-- Password Input with Show/Hide Toggler --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                                {{ __('main.password') }}
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                   class="text-xs font-medium text-emerald-600 hover:text-emerald-700 dark:text-emerald-400">
                                    {{ __('auth.forgot-your-password') }}
                                </a>
                            @endif
                        </div>

                        <div class="relative">
                            <input id="password"
                                   type="password"
                                   name="password"
                                   required
                                   autocomplete="current-password"
                                   placeholder="••••••••"
                                   class="block w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 ps-4 pe-12 py-3.5 text-base sm:text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition" />

                            <button type="button"
                                    id="toggle-password"
                                    aria-label="Show password"
                                    aria-pressed="false"
                                    class="absolute inset-y-0 end-0 flex items-center justify-center px-3.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 focus:outline-none">
                                {{-- Eye Icon (Shown when password is hidden) --}}
                                <svg id="eye-open" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{-- Eye Off Icon (Shown when password is visible) --}}
                                <svg id="eye-closed" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center justify-between pt-1">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                            <input id="remember_me"
                                   type="checkbox"
                                   name="remember"
                                   class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" />
                            <span class="ms-2 text-sm text-slate-600 dark:text-slate-300">
                                {{ __('auth.remember-me') }}
                            </span>
                        </label>
                    </div>

                    {{-- Full-Width App-Style Submit Button --}}
                    <div class="pt-2">
                        <button type="submit"
                                class="w-full flex items-center justify-center gap-2 rounded-xl bg-slate-900 hover:bg-slate-800 active:scale-[0.99] dark:bg-emerald-600 dark:hover:bg-emerald-500 px-5 py-3.5 text-sm font-bold tracking-wide text-white shadow-lg shadow-slate-900/15 transition">
                            <span>{{ __('auth.login') }}</span>
                            <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                            </svg>
                        </button>
                    </div>
                </form>

                {{-- Mobile Footer: Paperless Modules + Contact --}}
                <div class="mt-8 pt-5 border-t border-slate-100 dark:border-slate-800 text-center space-y-3">
                    <p class="text-[11px] font-medium text-slate-400">
                        {{ __('auth.paperless-modules') }}
                    </p>
                    <div class="lg:hidden">
                        <a href="mailto:info@wyzeek.com"
                           class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-700 dark:text-slate-300 hover:text-emerald-600">
                            <span>{{ __('auth.contact-us') }}</span>
                            <span class="text-slate-400">•</span>
                            <span class="text-emerald-600">info@wyzeek.com</span>
                        </a>
                    </div>
                </div>

            </div>
        </main>
    </div>

    {{-- Password Show/Hide Toggle Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            const toggleButton = document.getElementById('toggle-password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');

            if (passwordInput && toggleButton) {
                toggleButton.addEventListener('click', function () {
                    const isHidden = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isHidden ? 'text' : 'password');
                    eyeOpen.classList.toggle('hidden', isHidden);
                    eyeClosed.classList.toggle('hidden', !isHidden);
                    toggleButton.setAttribute('aria-pressed', String(isHidden));
                    toggleButton.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
                });
            }
        });
    </script>
</x-guest-layout>
