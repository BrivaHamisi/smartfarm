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

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                {{ __('Email') }}
                            </label>
                            <input 
                                id="email" 
                                type="email" 
                                name="email" 
                                required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#FF2D20] focus:ring focus:ring-[#FF2D20]/20 focus:ring-opacity-50"
                            >
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                {{ __('Password') }}
                            </label>
                            <input 
                                id="password" 
                                type="password" 
                                name="password" 
                                required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#FF2D20] focus:ring focus:ring-[#FF2D20]/20 focus:ring-opacity-50"
                            >
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input 
                                    id="remember_me" 
                                    type="checkbox" 
                                    name="remember" 
                                    class="h-4 w-4 text-[#FF2D20] focus:ring-[#FF2D20] border-gray-300 rounded"
                                >
                                <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                                    {{ __('Remember me') }}
                                </label>
                            </div>

                            @if (Route::has('password.request'))
                                <div class="text-sm">
                                    <a href="{{ route('password.request') }}" class="font-medium text-[#FF2D20] hover:text-[#e02717]">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div>
                            <button 
                                type="submit" 
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#FF2D20] hover:bg-[#e02717] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FF2D20]"
                            >
                                {{ __('Log in') }}
                            </button>
                        </div>
                    </form>

                    @if (Route::has('register'))
                        <div class="mt-6 text-center">
                            <p class="text-sm text-gray-600">
                                Don't have an account? 
                                <a href="{{ route('register') }}" class="font-medium text-[#FF2D20] hover:text-[#e02717]">
                                    Register
                                </a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout>