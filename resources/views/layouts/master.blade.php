<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8" />
    <meta name="locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title>WYZEEK | Paperless Education Platform</title>
    <meta name="title" content="WYZEEK | Paperless Education Platform">
    <meta name="description" content="A complete School Management System developed by WYZEEK...">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>WYZEEK - @yield('Pagetitle', 'Dashboard')</title>

    <style>
        body {
            font-family: 'Inter', 'Hind Siliguri', sans-serif;
        }
        .d-lg-none {
            display: none !important;
        }
        @media (max-width: 768px) {
            .d-lg-none {
                display: block !important;
            }
        }
    </style>

    @include('layouts.links')
</head>

<body class="m-0 font-sans antialiased font-normal text-base leading-default bg-slate-50 text-slate-600 h-[100dvh] overflow-hidden">

    {{-- Alpine State Wrapper for Sidebar --}}
    <div x-data="{ sidebarOpen: false }"
         @toggle-sidebar.window="sidebarOpen = !sidebarOpen"
         class="flex h-full w-full overflow-hidden">

        {{-- Mobile Overlay --}}
        <div x-show="sidebarOpen" x-transition.opacity x-cloak
             class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm lg:hidden"
             @click="sidebarOpen = false"></div>

        {{-- ---------------------- Sidebar -------------------------------- --}}
        @switch(App::getlocale())
            @case('ar')
                @include('layouts.rtl.main-sidebar')
            @break
            @case('en')
                @include('layouts.ltr.main-sidebar')
            @break
            @default
                @include('layouts.ltr.main-sidebar')
        @endswitch
        {{-- ---------------------- End Sidebar ------------------------------ --}}


        {{-- ---------------------- Main Tag -------------------------------- --}}
        <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden relative">

            {{-- ---------------------- Navbar -------------------------------- --}}
            @switch(App::getlocale())
                @case('ar')
                    @include('layouts.rtl.main-header')
                @break
                @case('en')
                    @include('layouts.ltr.main-header')
                @break
                @default
                    @include('layouts.ltr.main-header')
            @endswitch
            {{-- ---------------------- END Navbar -------------------------------- --}}


            {{-- ---------------------- Content -------------------------------- --}}
            <main class="flex-1 overflow-y-auto overflow-x-hidden p-4 sm:p-6 lg:p-8 relative">
                <div class="mx-auto max-w-7xl">
                    @if (Route::currentRouteName() === 'master')
                        @include('layouts.wyzeek-paperless-banner')
                    @endif

                    @yield('Content')
                </div>
            </main>
            {{-- ------------------- End Content -------------------------------- --}}


            {{-- ---------------------- Footer -------------------------------- --}}
            @switch(App::getlocale())
                @case('ar')
                    @include('layouts.rtl.footer')
                @break
                @case('en')
                    @include('layouts.ltr.footer')
                @break
                @default
                    @include('layouts.ltr.footer')
            @endswitch
            {{-- ---------------------- End Footer ------------------------------ --}}

        </div>
    </div>

    @include('layouts.wyzeek-mobile-nav')
    @include('layouts.wyzeek-ai-demo')

    {{-- --------------------------------------------- Footer scripts -------------------------------------------------- --}}
    @include('layouts.footer-scripts')
    {{-- -----------------------------------------  End Footer scripts  -------------------------------------------------- --}}
</body>

</html>
