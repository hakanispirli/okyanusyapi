<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if($seoData)
        <x-seo :data="$seoData" />
    @else
        <title>{{ $siteInformation->title ?? config('app.name', 'Okyanus Yapı') }}</title>
        <meta name="description" content="Okyanus Yapı olarak kaliteli konut inşaatı hizmetleri, ısı ve su yalıtımı işleri, çelik işleri ve daha fazlası. Doğal ve sağlıklı ürünler için bizi tercih edin.">
    @endif

    <!-- PWA Meta Tags -->
    <meta name="application-name" content="Okyanus Yapı">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Okyanus Yapı">
    <meta name="format-detection" content="telephone=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="msapplication-config" content="/browserconfig.xml">
    <meta name="msapplication-TileColor" content="#000000">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="theme-color" content="#000000">

    <!-- Web App Manifest -->
    <link rel="manifest" href="/manifest.json">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon.png">
    <link rel="shortcut icon" href="/favicon.ico">

    <!-- Apple Touch Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/favicon.png">
    <link rel="apple-touch-icon" sizes="167x167" href="/favicon.png">
    <link rel="apple-touch-icon" href="/favicon.png">

    <!-- Fonts - Inter Font Stack with Turkish Support -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700&family=JetBrains+Mono:ital,wght@0,400;0,500;0,600;1,400&display=swap&subset=latin,latin-ext" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700&family=JetBrains+Mono:ital,wght@0,400;0,500;0,600;1,400&display=swap&subset=latin,latin-ext">
    </noscript>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-17663218192"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'AW-17663218192');
    </script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-KEWSDSCXM4"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-KEWSDSCXM4');
    </script>

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-W3QQNK85');</script>
    <!-- End Google Tag Manager -->

    <!-- Event snippet for Satın alma işlemi conversion page -->
    <script> gtag('event', 'conversion', { 'send_to': 'AW-17663218192/pn5ICP7v7K8bEJCkveZB', 'value': 1.0, 'currency': 'TRY', 'transaction_id': '' }); </script>
</head>

<body class="font-sans antialiased">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W3QQNK85"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div class="min-h-screen">
        @include('frontend.partials.header')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="flex-1">
            {{ $slot }}
        </main>
    </div>
    @include('frontend.partials.footer')

    <!-- Mobile Phone Button -->
    <x-phone-button />

</body>

</html>
