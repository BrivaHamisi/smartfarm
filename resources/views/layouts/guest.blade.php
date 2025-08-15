<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- SEO Meta Tags -->
        <meta name="description" content="Smart Farm: Access your account to manage your farm with IoT sensors, AI analytics, and real-time insights for optimized agriculture.">
        <meta name="keywords" content="smart farm, smart agriculture, IoT farming, AI farming, farm management, precision agriculture, crop analytics, weather monitoring, smart irrigation, soil analysis, login, register">
        <meta name="author" content="Smart Farm Team">
        <meta name="robots" content="index, follow">

        <!-- Open Graph / Social Media Meta Tags -->
        <meta property="og:title" content="{{ config('app.name', 'Smart Farm') }} - Farm Management Platform">
        <meta property="og:description" content="Sign in or register to leverage Smart Farm's IoT, AI, and real-time analytics for efficient farm management.">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image" content="{{ asset('/images/smart-farm.jpg') }}">
        <meta property="og:site_name" content="{{ config('app.name', 'Smart Farm') }}">

        <!-- Twitter Card Meta Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ config('app.name', 'Smart Farm') }} - Farm Management Platform">
        <meta name="twitter:description" content="Sign in or register to leverage Smart Farm's IoT, AI, and real-time analytics for efficient farm management.">
        <meta name="twitter:image" content="{{ asset('/images/smart-farm.jpg') }}">

        <!-- Canonical Link -->
        <link rel="canonical" href="{{ url()->current() }}">

        <title>{{ config('app.name', 'Smart Farm') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>