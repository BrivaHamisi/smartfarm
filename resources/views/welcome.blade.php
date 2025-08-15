<x-layout>
        <div class="min-h-screen relative overflow-hidden bg-gray-50">
            <!-- Subtle background pattern -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNNTkgNTlIMUwxIDFINTlWNTlaIiBzdHJva2U9InJnYmEoMCwwLDAsMC4wMykiIGZpbGw9Im5vbmUiLz48L3N2Zz4=')] opacity-20"></div>
                <div class="absolute -left-20 top-0 max-w-[877px] opacity-50">
                    <img src="/api/placeholder/877/600" alt="Background shape" />
                </div>
            </div>
        
            <!-- Main Content -->
            <div class="relative min-h-screen flex flex-col">
                <!-- Navigation -->
                <nav class="w-full bg-white border-b border-gray-200">
                    <div class="max-w-7xl mx-auto px-6 py-4">
                        <div class="flex justify-between items-center">
                            <!-- Logo -->
                            <div class="flex items-center space-x-3">
                                <svg class="h-8 w-8 text-[#FF2D20]" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 3L4 7.5V16.5L12 21L20 16.5V7.5L12 3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span class="text-xl font-bold text-gray-900">SmartFarm</span>
                            </div>
        
                            <!-- Navigation Links -->
                            @if (Route::has('login'))
                                <div class="flex items-center space-x-4">
                                    @auth
                                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-6 py-2 text-sm font-medium text-white bg-[#FF2D20] rounded-lg hover:bg-[#FF2D20]/90 transition-colors">
                                            Dashboard
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-[#FF2D20] transition-colors">
                                            Log in
                                        </a>
        
                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-2 text-sm font-medium text-white bg-[#FF2D20] rounded-lg hover:bg-[#FF2D20]/90 transition-colors">
                                                Get Started
                                            </a>
                                        @endif
                                    @endauth
                                </div>
                            @endif
                        </div>
                    </div>
                </nav>
        
                <!-- Hero Section -->
                <main class="flex-1 flex items-center">
                    <div class="max-w-7xl mx-auto px-6 py-24">
                        <div class="grid lg:grid-cols-2 gap-12 items-center">
                            <!-- Left Column -->
                            <div class="space-y-8">
                                <div class="inline-flex items-center space-x-2 px-4 py-2 bg-[#FF2D20]/10 rounded-full">
                                    <span class="text-sm font-medium text-gray-900">Smart Agriculture Platform</span>
                                    <svg class="w-4 h-4 text-[#FF2D20]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
        
                                <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 leading-tight">
                                    Transform Your Farm with Smart Technology
                                </h1>
        
                                <p class="text-xl text-gray-600 max-w-xl">
                                    Leverage IoT sensors, real-time analytics, and AI-powered insights to maximize your farm's potential.
                                </p>
        
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-[#FF2D20] rounded-lg hover:bg-[#FF2D20]/90 transition-colors">
                                        Start Free Trial
                                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                    <a href="/demo" class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                        Watch Demo
                                    </a>
                                </div>
                            </div>
        
                            <!-- Right Column - Feature Cards -->
                            <div class="relative lg:h-[600px] hidden lg:block">
                                <div class="grid grid-cols-2 gap-6 h-full">
                                    <div class="space-y-6">
                                        <div class="p-6 bg-white border border-gray-200 rounded-2xl hover:-translate-y-1 transition-transform">
                                            <svg class="w-12 h-12 text-[#FF2D20] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                                            </svg>
                                            <h3 class="text-lg font-semibold mb-2 text-gray-900">Weather Monitoring</h3>
                                            <p class="text-sm text-gray-600">Real-time weather data and predictions</p>
                                        </div>
        
                                        <div class="p-6 bg-white border border-gray-200 rounded-2xl translate-x-4 hover:-translate-y-1 transition-transform">
                                            <svg class="w-12 h-12 text-[#FF2D20] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                                            </svg>
                                            <h3 class="text-lg font-semibold mb-2 text-gray-900">Crop Analytics</h3>
                                            <p class="text-sm text-gray-600">AI-powered yield predictions</p>
                                        </div>
                                    </div>
        
                                    <div class="space-y-6 pt-12">
                                        <div class="p-6 bg-white border border-gray-200 rounded-2xl -translate-x-4 hover:-translate-y-1 transition-transform">
                                            <svg class="w-12 h-12 text-[#FF2D20] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                            <h3 class="text-lg font-semibold mb-2 text-gray-900">Smart Irrigation</h3>
                                            <p class="text-sm text-gray-600">Automated water management</p>
                                        </div>
        
                                        <div class="p-6 bg-white border border-gray-200 rounded-2xl hover:-translate-y-1 transition-transform">
                                            <svg class="w-12 h-12 text-[#FF2D20] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <h3 class="text-lg font-semibold mb-2 text-gray-900">Soil Analysis</h3>
                                            <p class="text-sm text-gray-600">Real-time soil health monitoring</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
</x-layout>