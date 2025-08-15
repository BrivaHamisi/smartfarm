<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- SEO Meta Tags -->
        <meta name="description" content="Smart Farm: Revolutionize your farming with IoT sensors, AI analytics, and real-time insights for optimized farm management.">
        <meta name="keywords" content="smart farm, smart agriculture, IoT farming, AI farming, farm management, precision agriculture, crop analytics, weather monitoring, smart irrigation, soil analysis">
        <meta name="author" content="Smart Farm Team">
        <meta name="robots" content="index, follow">

        <!-- Open Graph / Social Media Meta Tags -->
        <meta property="og:title" content="{{ config('app.name', 'Smart Farm') }} - Smart Agriculture Platform">
        <meta property="og:description" content="Transform your farm with Smart Farm's IoT, AI, and real-time analytics for efficient crop and resource management.">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url('/') }}">
        <meta property="og:image" content="{{ asset('/images/smart-farm.jpg') }}">
        <meta property="og:site_name" content="{{ config('app.name', 'Smart Farm') }}">

        <!-- Twitter Card Meta Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ config('app.name', 'Smart Farm') }} - Smart Agriculture Platform">
        <meta name="twitter:description" content="Transform your farm with Smart Farm's IoT, AI, and real-time analytics for efficient crop and resource management.">
        <meta name="twitter:image" content="{{ asset('/images/smart-farm.jpg') }}">

        <!-- Canonical Link -->
        <link rel="canonical" href="{{ url('/') }}">

        <title>{{ config('app.name', 'Smart Farm') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            {{-- @include('layouts.navigation') --}}

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>