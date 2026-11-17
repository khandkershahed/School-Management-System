<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Primary Meta Tags -->
    <title>WYZEEK | Paperless Education Platform</title>
    <meta name="title" content="WYZEEK | Paperless Education Platform">
    <meta name="description"
        content="A complete School Management System developed by WYZEEK to manage students, teachers, parents, classes, exams, attendance, fees, and online classes from one powerful platform.">
    <meta name="keywords"
        content="school management system, laravel school management, student management system, education software, school ERP, wyzeek">
    <meta name="author" content="WYZEEK">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Canonical -->
    <link rel="canonical" href="{{ url('/') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="WYZEEK | Paperless Education Platform">
    <meta property="og:description"
        content="Manage students, teachers, parents, exams, attendance, fees, and online classes with a modern paperless education platform by WYZEEK.">
    <meta property="og:image" content="{{ asset('assets/img/wyzeek-logo-dark.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="WYZEEK Paperless Education">
    <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url('/') }}">
    <meta name="twitter:title" content="WYZEEK | Paperless Education Platform">
    <meta name="twitter:description"
        content="A powerful Laravel-based School Management System to streamline academic and administrative operations.">
    <meta name="twitter:image" content="{{ asset('assets/img/wyzeek-logo-dark.png') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/wyzeek-favicon-32.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/wyzeek-apple-touch-icon.png') }}">


    @switch(App::getlocale())
        @case('ar')
            <style>
                html {
                    direction: rtl;
                }

                @font-face {
                    src: url("{{ asset('assets/fonts/changafont/static/Changa-Light.ttf') }}");
                    font-family: 'Changa-Light';
                }

                body {
                    font-family: 'Changa-Light', sans-serif !important;
                }
            </style>
        @break

        @case('en')
            <style>
                html {
                    direction: ltr;
                }
            </style>
        @break

        @default
            <style>
                html {
                    direction: ltr;
                }
            </style>
    @endswitch
    <title>WYZEEK | Paperless Education Platform</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/css/wyzeek-brand.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/wyzeek-responsive.css') }}">
</head>

<body dir="{{ App::getlocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <div class=" text-gray-900 antialiased">
        {{ $slot }}
    </div>
</body>

</html>
