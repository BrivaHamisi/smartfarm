<x-layout>
    <div class="flex min-h-screen relative">
        <!-- Theme toggle -->
        <div class="absolute top-4 right-4 z-20">
            <x-theme-toggle />
        </div>

        <!-- Enhanced Image Section -->
        <div class="hidden lg:flex w-1/2 relative overflow-hidden">
            <!-- Main background image -->
            <img 
                src="{{ asset('images/smart-farm.jpg') }}"
                alt="Smart Farm Technology"
                class="absolute inset-0 w-full h-full object-cover"
            />
            {{-- Image Size 1200 by 800 px --}}
            
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
                        <div class="text-white/80 text-sm tracking-wider">JOIN THE REVOLUTION</div>
                    </div>
                    <h1 class="text-5xl font-bold text-white leading-tight">
                        Smart Farm
                        <span class="block text-2xl font-light mt-2">The Future of Agriculture</span>
                    </h1>
                    <p class="text-lg text-white/90 max-w-md">
                        Join our growing community of innovative farmers and agricultural technologists
                    </p>
                </div>

                <!-- Decorative bottom section -->
                <div class="space-y-8">
                    <div class="flex space-x-4">
                        <div class="h-px w-8 bg-white/40 my-auto"></div>
                        <p class="text-white/80 text-sm">INNOVATIVE • SUSTAINABLE • CONNECTED</p>
                    </div>
                    
                    <!-- Floating geometric shapes -->
                    <div class="absolute bottom-12 right-12 w-64 h-64 opacity-10">
                        <div class="absolute inset-0 border-2 border-white/20 rounded-full animate-spin-slow"></div>
                        <div class="absolute inset-4 border border-white/20 rounded-full rotate-45"></div>
                        <div class="absolute inset-8 border border-white/20 rounded-full -rotate-45"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="w-full lg:w-1/2 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-zinc-900 dark:to-zinc-950 px-4 sm:px-8 lg:px-12 flex flex-col justify-center py-12">
            <div class="w-full max-w-md mx-auto">
                <!-- Logo and Title -->
                <div class="flex items-center justify-start space-x-3 mb-8">
                    <div class="flex items-center justify-center h-11 w-11 rounded-xl bg-[#FF2D20]/10 ring-1 ring-[#FF2D20]/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#FF2D20]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Create Account</h2>
                        <p class="text-sm text-gray-500 dark:text-zinc-400">Join Smart Farm and start managing your farm</p>
                    </div>
                </div>

                <form id="auth-form" method="POST" action="{{ route('register') }}" class="space-y-6 bg-white rounded-2xl shadow-sm ring-1 ring-gray-200 p-6 sm:p-8 dark:bg-zinc-900 dark:ring-zinc-700/60" novalidate>
                    @csrf

                    <!-- Name -->
                    <div class="space-y-1.5">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-zinc-300">
                            {{ __('Name') }}
                        </label>
                        <input 
                            id="name" 
                            type="text" 
                            name="name" 
                            value="{{ old('name') }}" 
                            required 
                            autofocus 
                            autocomplete="name"
                            placeholder="e.g. Jane Mwangi"
                            @error('name') aria-invalid="true" aria-describedby="name-error" @enderror
                            class="block w-full px-4 py-3 rounded-lg border shadow-sm text-gray-900 placeholder-gray-400 dark:text-white dark:placeholder-zinc-500 transition duration-150 ease-in-out
                                focus:outline-none focus:ring-2 focus:ring-[#FF2D20]/25 focus:border-[#FF2D20]
                                @error('name') border-red-400 bg-red-50 focus:border-red-500 focus:ring-red-200 dark:border-red-500 dark:bg-red-950/40 @else border-gray-300 dark:border-zinc-600 dark:bg-zinc-800 @enderror"
                        >
                        @error('name')
                            <p id="name-error" role="alert" class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="space-y-1.5">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-zinc-300">
                            {{ __('Email') }}
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autocomplete="username"
                            placeholder="you@example.com"
                            @error('email') aria-invalid="true" aria-describedby="email-error" @enderror
                            class="block w-full px-4 py-3 rounded-lg border shadow-sm text-gray-900 placeholder-gray-400 dark:text-white dark:placeholder-zinc-500 transition duration-150 ease-in-out
                                focus:outline-none focus:ring-2 focus:ring-[#FF2D20]/25 focus:border-[#FF2D20]
                                @error('email') border-red-400 bg-red-50 focus:border-red-500 focus:ring-red-200 dark:border-red-500 dark:bg-red-950/40 @else border-gray-300 dark:border-zinc-600 dark:bg-zinc-800 @enderror"
                        >
                        @error('email')
                            <p id="email-error" role="alert" class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="space-y-1.5">
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-zinc-300">
                            {{ __('Password') }}
                        </label>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="new-password"
                            minlength="8"
                            placeholder="At least 8 characters"
                            @error('password') aria-invalid="true" aria-describedby="password-error" @enderror
                            class="block w-full px-4 py-3 rounded-lg border shadow-sm text-gray-900 placeholder-gray-400 dark:text-white dark:placeholder-zinc-500 transition duration-150 ease-in-out
                                focus:outline-none focus:ring-2 focus:ring-[#FF2D20]/25 focus:border-[#FF2D20]
                                @error('password') border-red-400 bg-red-50 focus:border-red-500 focus:ring-red-200 dark:border-red-500 dark:bg-red-950/40 @else border-gray-300 dark:border-zinc-600 dark:bg-zinc-800 @enderror"
                        >
                        @error('password')
                            <p id="password-error" role="alert" class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-1.5">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-zinc-300">
                            {{ __('Confirm Password') }}
                        </label>
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password"
                            minlength="8"
                            placeholder="Re-enter your password"
                            @error('password_confirmation') aria-invalid="true" aria-describedby="password_confirmation-error" @enderror
                            class="block w-full px-4 py-3 rounded-lg border shadow-sm text-gray-900 placeholder-gray-400 dark:text-white dark:placeholder-zinc-500 transition duration-150 ease-in-out
                                focus:outline-none focus:ring-2 focus:ring-[#FF2D20]/25 focus:border-[#FF2D20]
                                @error('password_confirmation') border-red-400 bg-red-50 focus:border-red-500 focus:ring-red-200 dark:border-red-500 dark:bg-red-950/40 @else border-gray-300 dark:border-zinc-600 dark:bg-zinc-800 @enderror"
                        >
                        @error('password_confirmation')
                            <p id="password_confirmation-error" role="alert" class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-[#FF2D20] hover:text-[#e02717] transition-colors duration-150">
                            {{ __('Already registered?') }}
                        </a>

                        <button 
                            id="submit-button"
                            type="submit" 
                            class="inline-flex items-center justify-center gap-2 py-3 px-6 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-[#FF2D20] hover:bg-[#e02717] active:bg-[#c81f12] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FF2D20] dark:ring-offset-zinc-900 transition-all duration-150 ease-in-out disabled:opacity-70 disabled:cursor-not-allowed"
                        >
                            <span id="submit-label">{{ __('Register') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('auth-form')?.addEventListener('submit', function () {
            const button = document.getElementById('submit-button');
            const label = document.getElementById('submit-label');
            if (!button || button.disabled) return;
            button.disabled = true;
            label.textContent = 'Creating account…';
            const spinner = document.createElement('span');
            spinner.className = 'inline-block h-4 w-4 border-2 border-white border-t-transparent rounded-full animate-spin';
            button.prepend(spinner);
        });
    </script>
</x-layout>
