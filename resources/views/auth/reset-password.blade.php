<x-layout>
    <div class="flex min-h-screen">
        <!-- Left Image Section -->
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
            
            <!-- Content -->
            <div class="relative z-10 flex flex-col justify-between h-full p-12">
                <div class="space-y-6">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-1 bg-white/60 rounded-full"></div>
                        <div class="text-white/80 text-sm tracking-wider">ACCOUNT RECOVERY</div>
                    </div>
                    <h1 class="text-5xl font-bold text-white leading-tight">
                        Reset Password
                        <span class="block text-2xl font-light mt-2">Secure Account Access</span>
                    </h1>
                    <p class="text-lg text-white/90 max-w-md">
                        Create a new password for your Smart Farm account and get back to innovating
                    </p>
                </div>

                <!-- Decorative bottom section -->
                <div class="space-y-8">
                    <div class="flex space-x-4">
                        <div class="h-px w-8 bg-white/40 my-auto"></div>
                        <p class="text-white/80 text-sm">SECURE • SIMPLE • SWIFT</p>
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
        <div class="w-full lg:w-1/2 bg-gradient-to-br from-gray-50 to-gray-100 px-8 lg:px-12 flex flex-col justify-center">
            <div class="w-full max-w-md mx-auto">
                <!-- Logo and Title -->
                <div class="flex items-center justify-start space-x-3 mb-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#FF2D20]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    <span class="text-xl font-bold text-gray-800">Reset Password</span>
                </div>

                <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Hidden Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email -->
                    <div class="space-y-1">
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            {{ __('Email') }}
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            :value="old('email', $request->email)" 
                            required 
                            autofocus 
                            autocomplete="username"
                            class="block w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-[#FF2D20] focus:ring focus:ring-[#FF2D20]/20 focus:ring-opacity-50 transition duration-150 ease-in-out
                                @error('email') border-red-500 @enderror"
                        >
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div class="space-y-1">
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            {{ __('New Password') }}
                        </label>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="new-password"
                            class="block w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-[#FF2D20] focus:ring focus:ring-[#FF2D20]/20 focus:ring-opacity-50 transition duration-150 ease-in-out
                                @error('password') border-red-500 @enderror"
                        >
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-1">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                            {{ __('Confirm Password') }}
                        </label>
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password"
                            class="block w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-[#FF2D20] focus:ring focus:ring-[#FF2D20]/20 focus:ring-opacity-50 transition duration-150 ease-in-out"
                        >
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Requirements -->
                    <div class="bg-gray-50 rounded-lg p-4 text-sm text-gray-600">
                        <p class="font-medium mb-2">Password requirements:</p>
                        <ul class="space-y-1 list-disc list-inside">
                            <li>Minimum 8 characters</li>
                            <li>At least one uppercase letter</li>
                            <li>At least one number</li>
                            <li>At least one special character</li>
                        </ul>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full flex justify-center py-3 px-6 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-[#FF2D20] hover:bg-[#e02717] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FF2D20] transition-all duration-150 ease-in-out"
                    >
                        {{ __('Reset Password') }}
                    </button>

                    <!-- Back to Login Link -->
                    <p class="mt-6 text-center text-sm text-gray-600">
                        Remember your password?
                        <a href="{{ route('login') }}" class="font-medium text-[#FF2D20] hover:text-[#e02717] transition-colors duration-150 ml-1">
                            Back to login
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</x-layout>