@php
    $locale = app()->getLocale();
    $isRtl  = in_array($locale, ['ar', 'fa', 'he', 'ur'], true);
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $locale) }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    {{-- ★ charset was missing — this alone breaks Arabic/Bengali --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#020617">
    <meta name="color-scheme" content="light dark">

    <title>School Management System | CodersHat</title>

    <meta name="title" content="School Management System | CodersHat">
    <meta name="description" content="A complete School Management System developed by CodersHat to manage students, teachers, parents, classes, exams, attendance, fees, and online classes from one powerful platform.">
    <meta name="keywords" content="school management system, laravel school management, student management system, education software, school ERP, codershat">
    <meta name="author" content="CodersHat">
    <meta name="robots" content="index, follow">

    <link rel="canonical" href="https://sms.codershat.org">

    <meta property="og:type" content="website">
    <meta property="og:url" content="https://sms.codershat.org">
    <meta property="og:title" content="School Management System | CodersHat">
    <meta property="og:description" content="Manage students, teachers, parents, exams, attendance, fees, and online classes with a modern School Management System by CodersHat.">
    <meta property="og:image" content="{{ asset('assets/img/logo-ct.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="School Management System">
    <meta property="og:locale" content="{{ str_replace('_', '-', $locale) }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="https://sms.codershat.org">
    <meta name="twitter:title" content="School Management System | CodersHat">
    <meta name="twitter:description" content="A powerful Laravel-based School Management System to streamline academic and administrative operations.">
    <meta name="twitter:image" content="{{ asset('assets/img/logo-ct.png') }}">

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/apple-icon.png') }}">

    @if ($locale === 'ar')
        <style>
            @font-face {
                font-family: 'Changa-Light';
                src: url("{{ asset('assets/fonts/changafont/static/Changa-Light.ttf') }}");
                font-display: swap;
            }
            body { font-family: 'Changa-Light', sans-serif; }
        </style>
    @endif

    {{-- App-shell + RTL helpers (browser-safe fallbacks, no Tailwind-version dependency) --}}
    <style>
        html, body { -webkit-tap-highlight-color: transparent; }
        .app-shell { height: 100vh; height: 100dvh; overscroll-behavior: none; }
        [dir="rtl"] .rtl-flip { transform: scaleX(-1); }
    </style>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="bg-slate-950 font-sans antialiased">
    {{ $slot }}
    @stack('scripts')
</body>
</html>
