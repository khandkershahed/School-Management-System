<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - @yield('Pagetitle', 'Dashboard')</title>

    <!-- Fonts & CSS -->
    @include('layouts.links')
</head>

<body class="bg-slate-50 text-slate-600 font-sans antialiased h-[100dvh] overflow-hidden">

    <!-- Alpine.js State Wrapper -->
    <div x-data="{ sidebarOpen: false }" class="flex h-full w-full overflow-hidden">

        <!-- Mobile Overlay -->
        <div x-show="sidebarOpen"
             x-transition.opacity
             class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm lg:hidden"
             @click="sidebarOpen = false"></div>

        <!-- Sidebar -->
        @include('layouts.ltr.main-sidebar')
        <!-- NOTE: If you have RTL, pass the state to your RTL sidebar or just use this unified one -->

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden relative">

            <!-- Header -->
            @include('layouts.ltr.main-header')

            <!-- Scrollable Page Content -->
            <main class="flex-1 overflow-y-auto overflow-x-hidden p-4 sm:p-6 lg:p-8">
                <div class="mx-auto max-w-7xl">
                    @yield('Content')
                </div>
            </main>

            <!-- Minimal Footer -->
            <footer class="shrink-0 border-t border-slate-200 bg-white py-4 px-6 text-center text-sm text-slate-400">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                <span class="hidden sm:inline">| Built by Wyzeek</span>
            </footer>
        </div>
    </div>

    @include('layouts.footer-scripts')
</body>
</html>
