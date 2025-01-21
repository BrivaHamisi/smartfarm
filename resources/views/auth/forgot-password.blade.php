<x-layout>
    <div class="flex min-h-screen">
        <!-- Enhanced Image Section -->
        <div class="hidden lg:flex w-1/2 relative overflow-hidden">
            <!-- Main background image -->
            <img 
                src="{{ asset('images/smart-farm.jpg') }}"
                alt="Smart Farm Technology"
                class="absolute inset-0 w-full h-full object-cover"
            />
            
            <!-- Gradient overlays -->
            <div class="absolute inset-0 bg-gradient-to-br from-[#FF2D20]/80 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
            
            <!-- Decorative elements -->
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNMjAgMjBMMCAwaDQwTDIwIDIwem0wIDBMMCA0MGg0MEwyMCAyMHoiIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iLjA1Ii8+PC9zdmc+')] opacity-30"></div>
            
            <!-- Futuristic accent lines -->
            <div class="absolute inset-0">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
                <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-transparent via-white/20 to-transparent"></div>
                <div class="absolute top-0 right-0 w-1 h-full bg-gradient-to-b from-transparent via-white/20 to-transparent"></div>
            </div>

            <!-- Content with enhanced styling -->
            <div class="relative z-10 flex flex-col justify-between h-full p-12">
                <div class="space-y-6">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-1 bg-white/60 rounded-full"></div>
                        <div class="text-white/80 text-sm tracking-wider">WELCOME TO THE FUTURE</div>
                    </div>
                    <h1 class="text-5xl font-bold text-white leading-tight">
                        Smart Farm
                        <span class="block text-2xl font-light mt-2">Revolutionizing Agriculture</span>
                    </h1>
                    <p class="text-lg text-white/90 max-w-md">
                        Experience the next generation of farming technology
                    </p>
                </div>

                <!-- Decorative bottom section -->
                <div class="space-y-8">
                    <div class="flex space-x-4">
                        <div class="h-px w-8 bg-white/40 my-auto"></div>
                        <p class="text-white/80 text-sm">INTELLIGENT • SUSTAINABLE • EFFICIENT</p>
                    </div>
                    
                    <!-- Animated dots -->
                    <div class="flex space-x-3">
                        <div class="w-2 h-2 rounded-full bg-white animate-pulse"></div>
                        <div class="w-2 h-2 rounded-full bg-white/60"></div>
                        <div class="w-2 h-2 rounded-full bg-white/30"></div>
                    </div>
                </div>
            </div>

            <!-- Floating geometric shapes -->
            <div class="absolute bottom-0 right-0 w-64 h-64 opacity-10">
                <div class="absolute inset-0 border-2 border-white/20 rounded-full animate-spin-slow"></div>
                <div class="absolute inset-4 border border-white/20 rounded-full rotate-45"></div>
                <div class="absolute inset-8 border border-white/20 rounded-full -rotate-45"></div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="w-full lg:w-1/2 bg-gradient-to-br from-gray-50 to-gray-100 px-8 lg:px-12 flex flex-col justify-center">
            <div class="w-full max-w-md mx-auto space-y-8">
                <!-- Logo and Title -->
                <div class="flex items-center justify-start space-x-3">
                    <x-application-logo class="h-8 w-8 text-[#FF2D20]" />
                    <span class="text-xl font-bold text-gray-800">Smart Farm</span>
                </div>

                <!-- Description -->
                <div class="text-gray-600">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </div>

                <!-- Status Message -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Form -->
                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

                    <div class="space-y-2">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" 
                            type="email" 
                            name="email" 
                            :value="old('email')" 
                            required 
                            autofocus 
                            class="block w-full px-4 py-3 rounded-lg border-gray-200 focus:ring-[#FF2D20] focus:border-[#FF2D20] transition duration-150 ease-in-out" 
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <x-primary-button class="w-full justify-center py-3">
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </form>

                <!-- Back to Login Link -->
                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-sm text-[#FF2D20] hover:text-[#e02717] transition-colors duration-150">
                        {{ __('Back to Login') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    
</x-layout>