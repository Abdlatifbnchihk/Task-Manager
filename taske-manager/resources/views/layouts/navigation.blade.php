<nav x-data="{ open: false }" class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
    
    <!-- Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between items-center h-16">

            <!-- LEFT SIDE -->
            <div class="flex items-center gap-10">

                <!-- Logo -->
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 group">

                    <div class="flex items-center justify-center w-10 h-10 rounded-xl border border-indigo-600 bg-white text-indigo-600 shadow-md">
                        <x-application-logo class="h-6 w-6 fill-current" />
                    </div>

                    <div>
                        <h1 class="text-lg font-bold text-gray-800 leading-none">
                            Task Manager
                        </h1>

                        <span class="text-xs text-gray-500">
                            Productivity Workspace
                        </span>
                    </div>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden sm:flex items-center gap-2">

                    <a href="{{ route('dashboard') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition
                       {{ request()->routeIs('dashboard')
                            ? 'bg-indigo-100 text-indigo-700'
                            : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('tasks.index') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition
                       {{ request()->routeIs('tasks.*')
                            ? 'bg-indigo-100 text-indigo-700'
                            : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        My Tasks
                    </a>

                    <a href="{{ route('tasks.create') }}"
                       class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 transition shadow-sm">
                        + New Task
                    </a>

                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="hidden sm:flex items-center gap-4">

                <!-- User Dropdown -->
                <div class="relative">
                    <x-dropdown align="right" width="56">

                        <!-- Trigger -->
                        <x-slot name="trigger">

                            <button class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-gray-100 transition">

                                <!-- Avatar -->
                                <div class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center font-semibold shadow-sm">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>

                                <!-- User Info -->
                                <div class="text-left">
                                    <div class="text-sm font-semibold text-gray-800">
                                        {{ Auth::user()->name }}
                                    </div>

                                    <div class="text-xs text-gray-500">
                                        {{ Auth::user()->email }}
                                    </div>
                                </div>

                                <!-- Arrow -->
                                <svg class="w-4 h-4 text-gray-400"
                                     xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="2"
                                     stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>

                            </button>

                        </x-slot>

                        <!-- Dropdown Content -->
                        <x-slot name="content">

                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ Auth::user()->name }}
                                </p>

                                <p class="text-xs text-gray-500 truncate">
                                    {{ Auth::user()->email }}
                                </p>
                            </div>

                            <x-dropdown-link :href="route('profile.edit')">
                                Profile Settings
                            </x-dropdown-link>

                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                    this.closest('form').submit();">

                                    Log Out

                                </x-dropdown-link>
                            </form>

                        </x-slot>

                    </x-dropdown>
                </div>

            </div>

            <!-- MOBILE MENU BUTTON -->
            <div class="flex sm:hidden">

                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition">

                    <svg class="h-6 w-6"
                         stroke="currentColor"
                         fill="none"
                         viewBox="0 0 24 24">

                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                              class="inline-flex"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />

                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                              class="hidden"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>

                </button>

            </div>

        </div>
    </div>

    <!-- MOBILE MENU -->
    <div x-show="open"
         x-transition
         class="sm:hidden border-t border-gray-200 bg-white">

        <div class="px-4 py-4 space-y-2">

            <a href="{{ route('dashboard') }}"
               class="block px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100">
                Dashboard
            </a>

            <a href="{{ route('tasks.index') }}"
               class="block px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100">
                My Tasks
            </a>

            <a href="{{ route('tasks.create') }}"
               class="block px-4 py-3 rounded-lg bg-indigo-600 text-white text-sm font-medium text-center">
                + New Task
            </a>

        </div>

        <!-- Mobile User -->
        <div class="border-t border-gray-100 px-4 py-4">

            <div class="flex items-center gap-3 mb-4">

                <div class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center font-semibold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>

                <div>
                    <div class="text-sm font-semibold text-gray-800">
                        {{ Auth::user()->name }}
                    </div>

                    <div class="text-xs text-gray-500">
                        {{ Auth::user()->email }}
                    </div>
                </div>

            </div>

            <div class="space-y-2">

                <a href="{{ route('profile.edit') }}"
                   class="block px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100">
                    Profile Settings
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                            class="w-full text-left px-4 py-3 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50">
                        Log Out
                    </button>
                </form>

            </div>

        </div>
    </div>
</nav>