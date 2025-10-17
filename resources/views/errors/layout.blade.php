<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'Okyanus Yapı') }}</title>
    <meta name="description" content="Aradığınız sayfa mevcut değil veya taşınmış olabilir.">

    <!-- PWA Meta Tags -->
    <meta name="application-name" content="Okyanus Yapı">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Okyanus Yapı">
    <meta name="format-detection" content="telephone=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="msapplication-TileColor" content="#000000">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="theme-color" content="#000000">

    <!-- Apple Touch Icons -->
    <link rel="apple-touch-icon" href="/favicon.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/favicon.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon.png">
    <link rel="apple-touch-icon" sizes="167x167" href="/favicon.png">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon.png">
    <link rel="shortcut icon" href="/favicon.png">

    <!-- Fonts - Inter Font Stack with Turkish Support -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700&family=JetBrains+Mono:ital,wght@0,400;0,500;0,600;1,400&display=swap&subset=latin,latin-ext" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700&family=JetBrains+Mono:ital,wght@0,400;0,500;0,600;1,400&display=swap&subset=latin,latin-ext">
    </noscript>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        @include('frontend.partials.header')

        <main class="flex-1">
            @yield('content')
        </main>

        @include('frontend.partials.footer')
    </div>
</body>

</html>
