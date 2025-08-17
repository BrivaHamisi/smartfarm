<x-app-layout>
    <div class="flex h-screen bg-gray-100" x-data="{ open: false, cattleOpen: false }" x-init="() => { if (window.innerWidth < 1024) open = false; console.log('Alpine initialized, open:', open); }">
        <!-- Sidebar Navigation -->
        <div class="fixed inset-y-0 left-0 z-30 w-64 bg-white shadow-lg flex flex-col transform transition-transform duration-300 ease-in-out lg:static lg:transform-none" :class="{ '-translate-x-full': !open, 'translate-x-0': open }">
            <!-- Logo Section -->
            <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200">
                <span class="text-2xl font-bold text-emerald-700 tracking-tight">Smart Farm</span>
                <button @click="open = false; console.log('Close button clicked, open:', open)" class="lg:hidden p-2 text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <!-- User Profile Section -->
            <div class="p-4 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <img src="/api/placeholder/40/40" alt="User Avatar" class="w-10 h-10 rounded-full border-2 border-white shadow-sm">
                        <span class="absolute bottom-0 right-0 h-4 w-4 bg-emerald-500 border-2 border-white rounded-full"></span>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</h3>
                        <p class="text-xs text-gray-500">Farm Manager</p>
                    </div>
                </div>
            </div>
            <!-- Navigation Links -->
            <nav class="mt-4 flex-1 flex flex-col overflow-y-auto">
                <div class="px-2 space-y-1 flex-1">
                    <a href="{{ route('dashboard') }}" @click="open = false; console.log('Dashboard clicked, open:', open)" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('dashboard') ? 'text-emerald-700 bg-emerald-50' : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-emerald-500' : 'text-gray-500' }} transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"></path>
                        </svg>
                        <span class="ml-3 font-medium">Dashboard</span>
                    </a>
                    <a href="{{ route('cattle.index') }}" @click="open = false; console.log('Cattle clicked, open:', open)" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('cattle.index') ? 'text-emerald-700 bg-emerald-50' : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('cattle.index') ? 'text-emerald-500' : 'text-gray-500' }} transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                        <span class="ml-3 font-medium">Cattle</span>
                    </a>
                    <a href="{{ route('cattle.milk-records.index') }}" @click="open = false; console.log('Milk Records clicked, open:', open)" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('cattle.milk-records.*') ? 'text-emerald-700 bg-emerald-50' : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('cattle.milk-records.*') ? 'text-emerald-500' : 'text-gray-500' }} transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="ml-3 font-medium">Milk Records</span>
                    </a>
                    <a href="{{ route('poultry.index') }}" @click="open = false; console.log('Poultry clicked, open:', open)" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('poultry.index') ? 'text-emerald-700 bg-emerald-50' : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('poultry.index') ? 'text-emerald-500' : 'text-gray-500' }} transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                        </svg>
                        <span class="ml-3 font-medium">Poultry</span>
                    </a>
                    <a href="{{ route('calves.index') }}" @click="open = false; console.log('Calves clicked, open:', open)" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('calves.*') ? 'text-emerald-700 bg-emerald-50' : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('calves.*') ? 'text-emerald-500' : 'text-gray-500' }} transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15h14a2 2 0 002-2v-2a2 2 0 00-2-2H5a2 2 0 00-2 2v2a2 2 0 002 2z M7 9v2m10-2v2m-5-6v3m-2-6h4m-2 12v3m-3-3h6"></path>
                        </svg>
                        <span class="ml-3 font-medium">Calves</span>
                    </a>
                    <a href="{{ route('finances.index') }}" @click="open = false; console.log('Finances clicked, open:', open)" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('finances.*') ? 'text-emerald-700 bg-emerald-50' : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('finances.*') ? 'text-emerald-500' : 'text-gray-500' }} transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="ml-3 font-medium">Finances</span>
                    </a>
                    <a href="{{ route('workers.index') }}" @click="open = false; console.log('Workers clicked, open:', open)" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('workers.*') ? 'text-emerald-700 bg-emerald-50' : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('workers.*') ? 'text-emerald-500' : 'text-gray-500' }} transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="ml-3 font-medium">Workers</span>
                    </a>
                </div>
                <!-- Profile and Logout at the Bottom -->
                <div class="px-2 space-y-1 border-t border-gray-200 pt-4">
                    <a href="{{ route('profile.edit') }}" @click="open = false; console.log('Profile clicked, open:', open)" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('profile.*') ? 'text-emerald-700 bg-emerald-50' : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('profile.*') ? 'text-emerald-500' : 'text-gray-500' }} transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="ml-3 font-medium">Profile</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" @click="open = false; console.log('Logout clicked, open:', open)" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 text-gray-600 hover:bg-emerald-50 hover:text-emerald-700">
                            <svg class="w-5 h-5 text-gray-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="ml-3 font-medium">Log Out</span>
                        </a>
                    </form>
                </div>
            </nav>
        </div>
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-auto">
            <!-- Top Header -->
            <div class="bg-white shadow-sm border-b border-gray-200 relative z-40">
                <div class="flex justify-between items-center px-6 py-4">
                    <div class="flex items-center space-x-4">
                        <!-- Hamburger Menu for Mobile -->
                        <button @click="open = !open; console.log('Hamburger clicked, open:', open)" class="lg:hidden p-2 text-gray-600 hover:text-gray-900 z-50 relative">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <h2 class="text-lg font-semibold text-gray-800">
                            @if (request()->routeIs('dashboard'))
                                Dashboard
                            @elseif (request()->routeIs('cattle.index'))
                                Cattle
                            @elseif (request()->routeIs('cattle.milk-records.*'))
                                Milk Records
                            @elseif (request()->routeIs('poultry.index'))
                                Poultry
                            @elseif (request()->routeIs('calves.*'))
                                Calves
                            @elseif (request()->routeIs('finances.*'))
                                Finances
                            @elseif (request()->routeIs('workers.*'))
                                Workers
                            @elseif (request()->routeIs('profile.*'))
                                Profile
                            @else
                                Smart Farm
                            @endif
                        </h2>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button class="text-gray-600 hover:text-gray-900 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                        <div class="relative">
                            <button class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-full transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span class="absolute top-0 right-0 h-3 w-3 bg-red-500 rounded-full border-2 border-white"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main Content Area -->
            <div class="flex-1 overflow-auto p-6 bg-gray-50">
                {{ $slot }}
            </div>
        </div>
        <!-- Overlay for Mobile -->
        <div x-show="open" @click="open = false; console.log('Overlay clicked, open:', open)" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden" x-cloak></div>
    </div>

    <!-- Ensure Alpine.js is included -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- Fallback JavaScript for sidebar closing -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Alpine === 'undefined') {
                console.error('Alpine.js not loaded!');
                // Fallback for closing sidebar
                const sidebar = document.querySelector('.fixed.inset-y-0.left-0');
                const overlay = document.querySelector('.fixed.inset-0.bg-black');
                const closeButtons = document.querySelectorAll('[href], [onclick]');
                closeButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        sidebar.classList.add('-translate-x-full');
                        sidebar.classList.remove('translate-x-0');
                        overlay.classList.add('hidden');
                        console.log('Fallback: Sidebar closed');
                    });
                });
                overlay.addEventListener('click', () => {
                    sidebar.classList.add('-translate-x-full');
                    sidebar.classList.remove('translate-x-0');
                    overlay.classList.add('hidden');
                    console.log('Fallback: Overlay clicked, sidebar closed');
                });
            }
        });
    </script>
</x-app-layout>