<nav class="fixed top-0 w-full backdrop-blur-md z-50" x-data="{ mobileOpen: false }">
    <div class="w-full mx-auto px-6 sm:px-10 lg:px-16 h-20 md:h-24 flex items-center justify-between">
        <a href="/" class="flex items-center gap-2">
            <span class="text-xl font-bold text-indigo-600 tracking-tight">Kelas Online</span>
        </a>
        <div class="hidden md:flex items-center gap-3">
            <a href="{{ route('catalog') }}"
                class="px-5 py-2 rounded-full text-lg font-semibold bg-indigo-100 text-indigo-700 transition">
                See Catalog
            </a>
            @auth
                @if (Auth::user()->role === 'admin')
                    <a href="{{ url('/dashboard') }}"
                        class="px-5 py-2 rounded-full text-md font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition">
                        Dashboard
                    </a>
                @else
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false"
                            class="flex items-center gap-2 px-5 py-2 rounded-full text-md font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition cursor-pointer">
                            <i class="bi bi-person-circle"></i>
                            {{ Auth::user()->name }}
                            <i class="bi bi-chevron-down text-xs"></i>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-1"
                            class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden z-50">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-400">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('my-videos.pending') }}"
                                    class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition">
                                    <i class="bi bi-hourglass-split"></i> Menunggu Akses
                                </a>
                                <a href="{{ route('my-videos.approved') }}"
                                    class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition">
                                    <i class="bi bi-check-circle"></i> Video Saya
                                </a>
                            </div>
                            <div class="border-t border-gray-100 py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center gap-2 w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition cursor-pointer">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <a href="{{ route('login') }}"
                    class="px-5 py-2 rounded-full text-md font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition">
                    Login
                </a>
            @endauth
        </div>

        <button @click="mobileOpen = !mobileOpen"
            class="md:hidden flex items-center justify-center p-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
            <i x-show="!mobileOpen" class="bi bi-list text-2xl text-gray-700"></i>
            <i x-show="mobileOpen" class="bi bi-x-lg text-2xl text-gray-700"></i>
        </button>
    </div>

    <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2" @click.outside="mobileOpen = false"
        class="md:hidden bg-white/95 backdrop-blur-md border-t border-gray-200 shadow-lg">
        <div class="flex flex-col px-6 py-4 gap-3">
            <a href="{{ route('catalog') }}"
                class="px-4 py-2.5 rounded-xl text-base font-semibold bg-indigo-100 text-indigo-700 text-center transition">
                See Catalog
            </a>
            @auth
                @if (Auth::user()->role === 'admin')
                    <a href="{{ url('/dashboard') }}"
                        class="px-4 py-2.5 rounded-xl text-base font-semibold text-white bg-indigo-600 hover:bg-indigo-700 text-center transition">
                        Dashboard
                    </a>
                @else
                    <div class="border-t border-gray-100 pt-3 mt-1">
                        <p class="text-sm font-semibold text-gray-800 px-2">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400 px-2 mb-3">{{ Auth::user()->email }}</p>
                        <a href="{{ route('my-videos.pending') }}"
                            class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition">
                            <i class="bi bi-hourglass-split"></i> Menunggu Akses
                        </a>
                        <a href="{{ route('my-videos.approved') }}"
                            class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition">
                            <i class="bi bi-check-circle"></i> Video Saya
                        </a>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl text-sm text-red-600 bg-red-50 hover:bg-red-100 transition cursor-pointer">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                @endif
            @else
                <a href="{{ route('login') }}"
                    class="px-4 py-2.5 rounded-xl text-base font-semibold text-white bg-indigo-600 hover:bg-indigo-700 text-center transition">
                    Login
                </a>
            @endauth
        </div>
    </div>
</nav>
