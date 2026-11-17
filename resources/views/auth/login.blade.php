@php
    // Safe even if mcamara/laravel-localization is NOT installed
    $llClass = 'Mcamara\\LaravelLocalization\\Facades\\LaravelLocalization';
    $hasLocalization = class_exists($llClass);
    $supportedLocales = $hasLocalization
        ? $llClass::getSupportedLocales()
        : ['en' => ['native' => 'English']];
    $currentLocale = app()->getLocale();
@endphp

<x-guest-layout>

    {{-- App shell: fixed height + internal scroll = native app feel --}}
    <div class="app-shell relative flex w-full flex-col overflow-hidden bg-slate-950 selection:bg-emerald-500 selection:text-white lg:grid lg:grid-cols-12">

        {{-- Ambient glows --}}
        <div class="pointer-events-none absolute -left-24 -top-24 h-72 w-72 rounded-full bg-emerald-500/15 blur-3xl"></div>
        <div class="pointer-events-none absolute -right-20 top-40 h-64 w-64 rounded-full bg-amber-500/10 blur-3xl"></div>

        {{-- ───────── HEADER (safe-area aware) ───────── --}}
        <header class="relative z-30 flex shrink-0 items-center justify-between px-5 pb-2 pt-[max(1rem,env(safe-area-inset-top))] lg:absolute lg:inset-x-0 lg:top-0 lg:px-8 lg:py-6">

            <div class="flex items-center gap-2.5 lg:hidden">
                <img src="{{ asset('images/wyzeek-logo-dark.png') }}" alt="WYZEEK"
                     class="h-9 w-auto rounded object-contain">
            </div>
            <div class="hidden lg:block"></div>

            <div class="flex items-center gap-2">
                @foreach($supportedLocales as $localeCode => $properties)
                    @if($localeCode !== $currentLocale)
                        @php
                            $localeUrl = $hasLocalization
                                ? $llClass::getLocalizedURL($localeCode, null, [], true)
                                : url('/') . '?lang=' . $localeCode;
                        @endphp
                        <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ $localeUrl }}"
                           class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-3 py-1.5 text-xs font-medium text-white shadow-sm backdrop-blur-md transition hover:bg-white/20 active:scale-95">
                            @if($localeCode === 'bn')
                                <svg class="h-4 w-4 shrink-0 rounded-full" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="30" height="30" fill="#006A4E"/>
                                    <circle cx="13.5" cy="15" r="7" fill="#F42A41"/>
                                </svg>
                            @elseif($localeCode === 'ar')
                                <svg class="h-4 w-4 shrink-0 rounded-full" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="30" height="10" fill="#CE1126"/>
                                    <rect y="10" width="30" height="10" fill="#FFFFFF"/>
                                    <rect y="20" width="30" height="10" fill="#000000"/>
                                    <circle cx="15" cy="15" r="2.2" fill="#C09300"/>
                                </svg>
                            @else
                                <svg class="h-4 w-4 shrink-0 rounded-full" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="30" height="30" fill="#012169"/>
                                    <path d="M0,0 L30,30 M30,0 L0,30" stroke="#FFFFFF" stroke-width="5"/>
                                    <path d="M0,0 L30,30 M30,0 L0,30" stroke="#C8102E" stroke-width="3"/>
                                    <path d="M15,0 V30 M0,15 H30" stroke="#FFFFFF" stroke-width="8"/>
                                    <path d="M15,0 V30 M0,15 H30" stroke="#C8102E" stroke-width="5"/>
                                </svg>
                            @endif
                            <span>{{ $properties['native'] ?? strtoupper($localeCode) }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
        </header>

        {{-- ───────── HERO (compact on mobile, full on desktop) ───────── --}}
        <section class="relative z-10 shrink-0 px-6 pb-6 pt-1 text-white lg:col-span-6 lg:flex lg:h-full lg:flex-col lg:justify-center lg:px-16 lg:py-16 xl:col-span-7">
            <div class="mx-auto w-full max-w-xl lg:mx-0">

                <div class="mb-8 hidden lg:block">
                    <img src="{{ asset('images/wyzeek-logo-dark.png') }}" alt="WYZEEK Logo"
                         class="h-16 w-auto object-contain">
                </div>

                <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-emerald-400/30 bg-emerald-500/15 px-3 py-1 text-[11px] font-semibold text-emerald-300 sm:text-xs">
                    <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>{{ __('auth.paperless-badge') }}</span>
                </div>

                <h1 class="text-xl font-extrabold leading-tight tracking-tight sm:text-3xl lg:text-4xl xl:text-5xl">
                    {{ __('auth.system-name') }}
                </h1>

                <p class="mt-2 text-xs leading-relaxed text-slate-300 sm:mt-3 sm:text-base lg:text-lg">
                    {{ __('auth.system-info') }}
                </p>

                {{-- Stats: hidden on phones so the form stays above the fold --}}
                <div class="mt-5 hidden grid-cols-3 gap-3 sm:grid lg:mt-6 lg:gap-4">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-3 backdrop-blur-sm sm:p-4">
                        <div class="text-lg font-extrabold text-emerald-400 sm:text-2xl">75%</div>
                        <div class="mt-0.5 text-[11px] leading-snug text-slate-300 sm:text-xs">{{ __('auth.stat-paper') }}</div>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-3 backdrop-blur-sm sm:p-4">
                        <div class="text-lg font-extrabold text-amber-400 sm:text-2xl">100%</div>
                        <div class="mt-0.5 text-[11px] leading-snug text-slate-300 sm:text-xs">{{ __('auth.stat-cloud') }}</div>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-3 backdrop-blur-sm sm:p-4">
                        <div class="text-lg font-extrabold text-sky-400 sm:text-2xl">0</div>
                        <div class="mt-0.5 text-[11px] leading-snug text-slate-300 sm:text-xs">{{ __('auth.stat-registers') }}</div>
                    </div>
                </div>

                <div class="mt-10 hidden items-center gap-4 border-t border-white/10 pt-6 lg:flex">
                    <a href="mailto:info@wyzeek.com"
                       class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/15 bg-white/10 px-5 py-3 text-sm font-medium text-white transition hover:bg-white/15">
                        <svg class="h-4 w-4 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ __('auth.contact-us') }}</span>
                    </a>
                    <span class="text-xs text-slate-400">www.wyzeek.com</span>
                </div>
            </div>
        </section>

        {{-- ───────── LOGIN CARD (bottom-sheet on mobile) ───────── --}}
        <main class="relative z-20 flex min-h-0 flex-1 flex-col overflow-hidden rounded-t-[2rem] bg-white shadow-[0_-12px_40px_rgba(0,0,0,0.35)] dark:bg-slate-900 lg:col-span-6 lg:h-full lg:rounded-none lg:shadow-none xl:col-span-5">

            {{-- Pull handle (mobile only) --}}
            <div class="flex shrink-0 justify-center pb-1 pt-3 lg:hidden">
                <div class="h-1.5 w-12 rounded-full bg-slate-200 dark:bg-slate-700"></div>
            </div>

            {{-- ★ min-h-0 is what makes this scroll instead of overflow --}}
            <div class="min-h-0 flex-1 overflow-y-auto overscroll-contain">
                <div class="flex min-h-full flex-col justify-center px-6 pb-[max(2rem,env(safe-area-inset-bottom))] pt-4 sm:px-10 lg:px-14 lg:py-16">
                    <div class="mx-auto w-full max-w-md">

                        {{-- Brand header --}}
                        <div class="mb-6 flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-bold text-slate-900 dark:text-white sm:text-2xl">
                                    {{ __('auth.welcome-back') }}
                                </h2>
                                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400 sm:text-sm">
                                    {{ __('auth.login-subtitle') }}
                                </p>
                            </div>
                            <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422A12.083 12.083 0 0112 21.5a12.083 12.083 0 01-6.16-10.922L12 14z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14v7"/>
                                </svg>
                            </div>
                        </div>

                        {{-- Errors (inline, no Jetstream dependency) --}}
                        @if ($errors->any())
                            <div class="mb-4 rounded-xl border border-red-100 bg-red-50 p-3 text-xs text-red-600 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-300">
                                <ul class="list-inside list-disc space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('status'))
                            <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 p-3 text-xs font-medium text-emerald-700 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300 sm:text-sm">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form id="login-form" method="POST" action="{{ route('login') }}" class="space-y-4" novalidate>
                            @csrf

                            {{-- Email --}}
                            <div>
                                <label for="email" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                                    {{ __('main.email') }}
                                </label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}"
                                       required autocomplete="username" inputmode="email" enterkeyhint="next"
                                       placeholder="teacher@school.edu"
                                       class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-base text-slate-900 placeholder-slate-400 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white sm:text-sm" />
                            </div>

                            {{-- Password --}}
                            <div>
                                <div class="mb-1.5 flex items-center justify-between">
                                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                                        {{ __('main.password') }}
                                    </label>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}"
                                           class="text-xs font-medium text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300">
                                            {{ __('auth.forgot-your-password') }}
                                        </a>
                                    @endif
                                </div>
                                <div class="relative">
                                    <input id="password" type="password" name="password"
                                           required autocomplete="current-password" enterkeyhint="go"
                                           placeholder="••••••••"
                                           class="block w-full rounded-xl border border-slate-200 bg-slate-50 py-3.5 ps-4 pe-12 text-base text-slate-900 placeholder-slate-400 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white sm:text-sm" />
                                    <button type="button" id="toggle-password" aria-label="Show password" aria-pressed="false"
                                            class="absolute inset-y-0 end-0 flex w-12 items-center justify-center text-slate-400 transition hover:text-slate-600 focus:outline-none dark:hover:text-slate-200">
                                        <svg id="eye-open" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <svg id="eye-closed" class="hidden h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            {{-- Remember --}}
                            <label for="remember_me" class="inline-flex cursor-pointer select-none items-center pt-1">
                                <input id="remember_me" type="checkbox" name="remember"
                                       class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" />
                                <span class="ms-2 text-sm text-slate-600 dark:text-slate-300">
                                    {{ __('auth.remember-me') }}
                                </span>
                            </label>

                            {{-- Submit with loading state --}}
                            <div class="pt-1">
                                <button type="submit" id="login-submit"
                                        class="group flex w-full items-center justify-center gap-2 rounded-xl bg-slate-900 px-5 py-3.5 text-sm font-bold tracking-wide text-white shadow-lg shadow-slate-900/15 transition hover:bg-slate-800 active:scale-[0.99] disabled:cursor-not-allowed disabled:opacity-70 dark:bg-emerald-600 dark:hover:bg-emerald-500">
                                    <svg id="login-spinner" class="hidden h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"/>
                                    </svg>
                                    <span>{{ __('auth.login') }}</span>
                                    <svg class="rtl-flip h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                    </svg>
                                </button>
                            </div>
                        </form>

                        {{-- Footer --}}
                        <div class="mt-8 space-y-3 border-t border-slate-100 pt-5 text-center dark:border-slate-800">
                            <p class="text-[11px] font-medium text-slate-400">
                                {{ __('auth.paperless-modules') }}
                            </p>
                            <div class="lg:hidden">
                                <a href="mailto:info@wyzeek.com"
                                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-700 hover:text-emerald-600 dark:text-slate-300 dark:hover:text-emerald-400">
                                    <span>{{ __('auth.contact-us') }}</span>
                                    <span class="text-slate-400">•</span>
                                    <span class="text-emerald-600">info@wyzeek.com</span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            /* ---------- Password visibility ---------- */
            const input  = document.getElementById('password');
            const btn    = document.getElementById('toggle-password');
            const eyeOn  = document.getElementById('eye-open');
            const eyeOff = document.getElementById('eye-closed');

            if (input && btn) {
                btn.addEventListener('click', () => {
                    const hidden = input.type === 'password';
                    input.type = hidden ? 'text' : 'password';
                    eyeOn.classList.toggle('hidden', hidden);
                    eyeOff.classList.toggle('hidden', !hidden);
                    btn.setAttribute('aria-pressed', String(hidden));
                    btn.setAttribute('aria-label', hidden ? 'Hide password' : 'Show password');
                });
            }

            /* ---------- Submit loading state (prevents double submit) ---------- */
            const form    = document.getElementById('login-form');
            const submit  = document.getElementById('login-submit');
            const spinner = document.getElementById('login-spinner');

            if (form && submit) {
                form.addEventListener('submit', () => {
                    submit.disabled = true;
                    spinner?.classList.remove('hidden');
                });
            }

            /* ---------- Keep focused input visible above the mobile keyboard ---------- */
            document.querySelectorAll('#login-form input').forEach(el => {
                el.addEventListener('focus', () => {
                    setTimeout(() => el.scrollIntoView({ block: 'center', behavior: 'smooth' }), 300);
                });
            });
        });
    </script>
</x-guest-layout>
