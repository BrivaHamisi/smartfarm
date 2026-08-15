<x-layout>
    <div class="relative min-h-screen overflow-hidden bg-gray-50 dark:bg-zinc-950">
        <!-- Subtle background pattern -->
        <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNNTkgNTlIMUwxIDFINTlWNTlaIiBzdHJva2U9InJnYmEoMCwwLDAsMC4wMykiIGZpbGw9Im5vbmUiLz48L3N2Zz4=')] opacity-20 dark:invert dark:opacity-[0.12]"></div>
        </div>

        <!-- Header -->
        <header class="sticky top-0 z-40 border-b border-gray-200/80 bg-white/80 backdrop-blur-md dark:border-zinc-800/80 dark:bg-zinc-950/70">
            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                <div class="flex h-16 items-center justify-between gap-4">
                    <!-- Logo -->
                    <a href="{{ url('/') }}" class="flex items-center gap-2.5" aria-label="SmartFarm home">
                        <span class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-[#FF2D20] text-white shadow-sm">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M12 3L4 7.5V16.5L12 21L20 16.5V7.5L12 3Z"/>
                            </svg>
                        </span>
                        <span class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">SmartFarm</span>
                    </a>

                    <!-- Header Actions -->
                    <div class="flex items-center gap-2 sm:gap-3">
                        <x-theme-toggle />

                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center rounded-lg bg-[#FF2D20] px-4 py-2 text-sm font-semibold text-white shadow-sm transition-colors duration-150 hover:bg-[#e02717] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#FF2D20] focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:focus-visible:ring-offset-zinc-950">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="hidden items-center rounded-lg px-3 py-2 text-sm font-medium text-gray-600 transition-colors duration-150 hover:text-[#FF2D20] sm:inline-flex dark:text-zinc-300 dark:hover:text-[#FF2D20]">
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-lg bg-[#FF2D20] px-4 py-2 text-sm font-semibold text-white shadow-sm transition-colors duration-150 hover:bg-[#e02717] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#FF2D20] focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:focus-visible:ring-offset-zinc-950">
                                        Get Started
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="relative flex flex-1 items-center">
            <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:py-24">
                <div class="grid items-center gap-12 lg:grid-cols-2">
                    <!-- Left Column -->
                    <div class="space-y-8">
                        <div class="inline-flex items-center gap-2 rounded-full bg-[#FF2D20]/10 px-4 py-1.5">
                            <span class="text-sm font-medium text-gray-900 dark:text-white">Smart Agriculture Platform</span>
                            <svg class="h-4 w-4 text-[#FF2D20]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>

                        <h1 class="text-4xl font-bold leading-tight tracking-tight text-gray-900 lg:text-6xl dark:text-white">
                            Transform Your Farm with Smart Technology
                        </h1>

                        <p class="max-w-xl text-xl text-gray-600 dark:text-zinc-400">
                            Leverage IoT sensors, real-time analytics, and AI-powered insights to maximize your farm's potential.
                        </p>

                        <div class="flex flex-col gap-4 sm:flex-row">
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-lg bg-[#FF2D20] px-6 py-3 text-base font-semibold text-white shadow-sm transition-colors duration-150 hover:bg-[#e02717] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#FF2D20] focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:focus-visible:ring-offset-zinc-950">
                                Start Free Trial
                                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                            <a href="/demo" class="inline-flex items-center justify-center rounded-lg bg-white px-6 py-3 text-base font-medium text-gray-900 ring-1 ring-gray-200 transition-colors duration-150 hover:bg-gray-50 dark:bg-zinc-900 dark:text-white dark:ring-zinc-700/70 dark:hover:bg-zinc-800">
                                Watch Demo
                            </a>
                        </div>
                    </div>

                    <!-- Right Column - Feature Cards -->
                    <div class="relative hidden lg:block lg:h-[600px]">
                        <div class="grid h-full grid-cols-2 gap-6">
                            <div class="space-y-6">
                                <div class="rounded-2xl border border-gray-200 bg-white p-6 transition-transform duration-150 hover:-translate-y-1 dark:border-zinc-800 dark:bg-zinc-900">
                                    <svg class="mb-4 h-12 w-12 text-[#FF2D20]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                                    </svg>
                                    <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Weather Monitoring</h3>
                                    <p class="text-sm text-gray-600 dark:text-zinc-400">Real-time weather data and predictions</p>
                                </div>

                                <div class="translate-x-4 rounded-2xl border border-gray-200 bg-white p-6 transition-transform duration-150 hover:-translate-y-1 dark:border-zinc-800 dark:bg-zinc-900">
                                    <svg class="mb-4 h-12 w-12 text-[#FF2D20]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                                    </svg>
                                    <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Crop Analytics</h3>
                                    <p class="text-sm text-gray-600 dark:text-zinc-400">AI-powered yield predictions</p>
                                </div>
                            </div>

                            <div class="space-y-6 pt-12">
                                <div class="-translate-x-4 rounded-2xl border border-gray-200 bg-white p-6 transition-transform duration-150 hover:-translate-y-1 dark:border-zinc-800 dark:bg-zinc-900">
                                    <svg class="mb-4 h-12 w-12 text-[#FF2D20]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Smart Irrigation</h3>
                                    <p class="text-sm text-gray-600 dark:text-zinc-400">Automated water management</p>
                                </div>

                                <div class="rounded-2xl border border-gray-200 bg-white p-6 transition-transform duration-150 hover:-translate-y-1 dark:border-zinc-800 dark:bg-zinc-900">
                                    <svg class="mb-4 h-12 w-12 text-[#FF2D20]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Soil Analysis</h3>
                                    <p class="text-sm text-gray-600 dark:text-zinc-400">Real-time soil health monitoring</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-layout>
