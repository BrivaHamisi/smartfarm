<x-layout>
    <div class="bg-gradient-to-br from-gray-50 to-gray-100 text-gray-900 min-h-screen flex flex-col">
        <div class="relative min-h-screen flex flex-col items-center justify-center">
            <div class="relative w-full max-w-md px-6 lg:px-8">
                <div class="bg-white shadow-md rounded-lg p-8">
                    <div class="flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#FF2D20]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                        <span class="ml-2 text-2xl font-bold text-gray-800">Smart Farm</span>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-6">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                {{ __('Name') }}
                            </label>
                            <input 
                                id="name" 
                                type="text" 
                                name="name" 
                                :value="old('name')" 
                                required 
                                autofocus 
                                autocomplete="name"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#FF2D20] focus:ring focus:ring-[#FF2D20]/20 focus:ring-opacity-50 
                                    @error('name') border-red-500 @enderror"
                            >
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                {{ __('Email') }}
                            </label>
                            <input 
                                id="email" 
                                type="email" 
                                name="email" 
                                :value="old('email')" 
                                required 
                                autocomplete="username"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#FF2D20] focus:ring focus:ring-[#FF2D20]/20 focus:ring-opacity-50
                                    @error('email') border-red-500 @enderror"
                            >
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                {{ __('Password') }}
                            </label>
                            <input 
                                id="password" 
                                type="password" 
                                name="password" 
                                required 
                                autocomplete="new-password"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#FF2D20] focus:ring focus:ring-[#FF2D20]/20 focus:ring-opacity-50
                                    @error('password') border-red-500 @enderror"
                            >
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                {{ __('Confirm Password') }}
                            </label>
                            <input 
                                id="password_confirmation" 
                                type="password" 
                                name="password_confirmation" 
                                required 
                                autocomplete="new-password"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#FF2D20] focus:ring focus:ring-[#FF2D20]/20 focus:ring-opacity-50
                                    @error('password_confirmation') border-red-500 @enderror"
                            >
                            @error('password_confirmation')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('login') }}" class="text-sm text-[#FF2D20] hover:text-[#e02717]">
                                {{ __('Already registered?') }}
                            </a>

                            <button 
                                type="submit" 
                                class="flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#FF2D20] hover:bg-[#e02717] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FF2D20]"
                            >
                                {{ __('Register') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>
