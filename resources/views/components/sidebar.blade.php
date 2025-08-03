<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-50 w-64 h-screen transition-transform -translate-x-full bg-black sm:translate-x-0 p-0"
    aria-label="Sidebar">
    <div class="h-full flex flex-col overflow-hidden">
        <!-- Branding/Header -->
        <div class="flex items-center justify-between px-5 py-4 bg-black border-b border-gray-800">
            <a href="/home" class="flex items-center text-white">
                <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center mr-3">
                    <i class='bx bx-church text-2xl text-white'></i>
                </div>
                <span class="font-bold text-xl tracking-wide">Admin Panel</span>
            </a>
            {{-- <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                type="button"
                class="inline-flex items-center p-2 text-gray-400 rounded-lg sm:hidden hover:text-white focus:outline-none focus:ring-2 focus:ring-orange-500 transition-colors">
                <span class="sr-only">Close sidebar</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button> --}}
        </div>
        <!-- Navigation -->
        <div class="flex-1 overflow-y-auto py-4 px-2 bg-black">
            <ul class="font-medium flex flex-col gap-1">
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors group {{ request()->routeIs('admin.dashboard') ? 'bg-orange-500 text-white font-semibold' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="bx bx-grid-alt text-xl {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.blogs.index') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors group {{ request()->routeIs('admin.blogs.*') ? 'bg-orange-500 text-white font-semibold' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="bx bx-news text-xl {{ request()->routeIs('admin.blogs.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"></i>
                        <span>Blog Posts</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.products.index') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors group {{ request()->routeIs('admin.products.*') ? 'bg-orange-500 text-white font-semibold' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="bx bx-book text-xl {{ request()->routeIs('admin.products.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"></i>
                        <span>Digital Products</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.categories.index') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors group {{ request()->routeIs('admin.categories.*') ? 'bg-orange-500 text-white font-semibold' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="bx bx-category text-xl {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"></i>
                        <span>Categories</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.orders.index') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors group {{ request()->routeIs('admin.orders.*') ? 'bg-orange-500 text-white font-semibold' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="bx bx-cart text-xl {{ request()->routeIs('admin.orders.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"></i>
                        <span>Orders</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors group {{ request()->routeIs('admin.users.*') ? 'bg-orange-500 text-white font-semibold' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="bx bx-user text-xl {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"></i>
                        <span>Users</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.settings.index') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors group {{ request()->routeIs('admin.settings.*') ? 'bg-orange-500 text-white font-semibold' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="bx bx-cog text-xl {{ request()->routeIs('admin.settings.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"></i>
                        <span>Site Settings</span>
                    </a>
                </li>
            </ul>
            <div class="my-4 border-t border-gray-800"></div>
            <ul class="font-medium flex flex-col gap-1">
                <li>
                    <form method="POST" action="{{ route('auth.logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-2 px-4 py-2 rounded-lg transition-colors group text-gray-400 hover:text-white hover:bg-gray-800">
                            <i class='bx bx-log-out text-xl'></i>
                            <span class="text-sm capitalize">Log out</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</aside>