<x-guest-layout>

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-100 via-indigo-50 to-blue-100 px-4 py-10">

        <!-- Register Card -->
        <div class="w-full max-w-lg bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">

            <!-- Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-blue-600 px-8 py-10 text-center">

                <!-- Logo -->
                <div class="mx-auto w-20 h-20 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-lg">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-10 h-10 text-white"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 4v16m8-8H4" />

                    </svg>

                </div>

                <h1 class="mt-6 text-3xl font-bold text-white">
                    Create Account
                </h1>

                <p class="mt-2 text-indigo-100 text-sm">
                    Join and start organizing your tasks efficiently
                </p>

            </div>

            <!-- Form Area -->
            <div class="px-8 py-8">

                <form method="POST"
                      action="{{ route('register') }}"
                      class="space-y-5">

                    @csrf

                    <!-- Name -->
                    <div>

                        <x-input-label
                            for="name"
                            :value="__('Full Name')"
                            class="text-gray-700 font-semibold"
                        />

                        <x-text-input
                            id="name"
                            class="block mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            type="text"
                            name="name"
                            :value="old('name')"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="Enter your full name"
                        />

                        <x-input-error
                            :messages="$errors->get('name')"
                            class="mt-2"
                        />

                    </div>

                    <!-- Email -->
                    <div>

                        <x-input-label
                            for="email"
                            :value="__('Email Address')"
                            class="text-gray-700 font-semibold"
                        />

                        <x-text-input
                            id="email"
                            class="block mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autocomplete="username"
                            placeholder="Enter your email"
                        />

                        <x-input-error
                            :messages="$errors->get('email')"
                            class="mt-2"
                        />

                    </div>

                    <!-- Password -->
                    <div>

                        <x-input-label
                            for="password"
                            :value="__('Password')"
                            class="text-gray-700 font-semibold"
                        />

                        <x-text-input
                            id="password"
                            class="block mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            placeholder="Create a password"
                        />

                        <x-input-error
                            :messages="$errors->get('password')"
                            class="mt-2"
                        />

                    </div>

                    <!-- Confirm Password -->
                    <div>

                        <x-input-label
                            for="password_confirmation"
                            :value="__('Confirm Password')"
                            class="text-gray-700 font-semibold"
                        />

                        <x-text-input
                            id="password_confirmation"
                            class="block mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Confirm your password"
                        />

                    </div>

                    <!-- Submit -->
                    <div class="pt-2">

                        <button
                            type="submit"
                            class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition duration-200">

                            Create Account

                        </button>

                    </div>

                </form>

                <!-- Footer -->
                <div class="mt-8 text-center">

                    <p class="text-sm text-gray-500">
                        Already have an account?

                        <a href="{{ route('login') }}"
                           class="text-indigo-600 hover:text-indigo-700 font-semibold hover:underline">

                            Log In

                        </a>

                    </p>

                </div>

            </div>

        </div>

    </div>

</x-guest-layout>