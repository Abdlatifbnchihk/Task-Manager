<x-guest-layout>

    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-100 via-blue-50 to-indigo-100 px-4">

        <!-- Login Card -->
        <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden ">

            <!-- Top Section -->
            <div class="bg-gradient-to-r from-indigo-600 to-blue-600 px-8 py-10 text-center">

                <!-- Logo -->
                <div
                    class="mx-auto w-20 h-20 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-lg">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">

                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />

                    </svg>

                </div>

                <!-- Heading -->
                <h1 class="mt-6 text-3xl font-bold text-white">
                    Welcome Back
                </h1>

                <p class="mt-2 text-sm text-indigo-100">
                    Login to continue managing your tasks
                </p>

            </div>

            <!-- Form Area -->
            <div class="px-8 py-8">

                <!-- Session Status -->
                <x-auth-session-status class="mb-5" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">

                    @csrf

                    <!-- Email -->
                    <div>

                        <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-semibold" />

                        <x-text-input id="email"
                            class="block mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                            placeholder="Enter your email" />

                        <x-input-error :messages="$errors->get('email')" class="mt-2" />

                    </div>

                    <!-- Password -->
                    <div>

                        <div class="flex items-center justify-between">

                            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold" />

                            @if (Route::has('password.request'))

                                <a href="{{ route('password.request') }}"
                                    class="text-sm text-indigo-600 hover:text-indigo-700 hover:underline">

                                    Forgot password?

                                </a>

                            @endif

                        </div>

                        <x-text-input id="password"
                            class="block mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            type="password" name="password" required autocomplete="current-password"
                            placeholder="Enter your password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />

                    </div>

                    <!-- Remember -->
                    <div class="flex items-center justify-between">

                        <label for="remember_me" class="inline-flex items-center cursor-pointer">

                            <input id="remember_me" type="checkbox"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                name="remember">

                            <span class="ms-2 text-sm text-gray-600">
                                Remember me
                            </span>

                        </label>

                    </div>

                    <!-- Submit Button -->
                    <div>

                        <button type="submit"
                            class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition duration-200">

                            Log In

                        </button>

                    </div>

                </form>

                <!-- Footer -->
                <div class="mt-8 text-center">

                    <p class="text-sm text-gray-500">
                        Don't have an account?

                        <a href="{{ route('register') }}"
                            class="text-indigo-600 hover:text-indigo-700 font-semibold hover:underline">

                            Create Account

                        </a>

                    </p>

                </div>

            </div>

        </div>

    </div>

</x-guest-layout>