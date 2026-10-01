<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('HPD Logo.png') }}" rel="icon" />
    <meta name="description" content="MyBooking — HPD Booking System.">

    <title>@yield('title', 'MyBooking') — MyBooking</title>

    <!-- Google Fonts — Plus Jakarta Sans (modern, geometric) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="flex flex-col min-h-screen bg-grid">

    <!-- ── Navigation Bar ── -->
    <nav x-data="{ mobileMenuOpen: false, scrolled: false }"
         @scroll.window="scrolled = (window.pageYOffset > 10)"
         :class="scrolled ? 'shadow-lg shadow-purple-500/5' : ''"
         class="sticky top-0 z-50 border-b border-[#eef0f5] backdrop-blur-xl transition-all duration-300"
         style="background-color: rgba(255, 255, 255, 0.85);">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between gap-4">

                <!-- Brand -->
                <a href="{{ auth()->check() ? (auth()->user()->is_admin ? route('admin.bookings.index') : route('dashboard')) : route('login') }}"
                    class="flex items-center gap-3 font-bold text-lg tracking-tight flex-shrink-0 group">
                    <div class="relative">
                        <div class="absolute inset-0 bg-purple-500/30 rounded-xl blur-lg opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <img src="{{ asset('HPD Logo.png') }}" alt="HPD Logo"
                             class="relative w-11 h-9 object-contain transition-transform duration-300 group-hover:scale-110">
                    </div>
                    <span class="text-[#1a1d29]">MyBooking<span class="text-gradient-blue">HPD</span></span>
                </a>

                <!-- Nav Links -->
                @auth
                <div class="hidden md:flex items-center gap-1 p-1 rounded-2xl"
                     style="background-color: #f8f9fc; border: 1px solid #eef0f5;">
                    @if (auth()->user()->isSuper())
                        <a href="{{ route('admin.bookings.index') }}"
                           class="px-3.5 py-2 rounded-xl text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('admin.bookings.*')
                                  ? 'bg-gradient-to-br from-purple-600 to-indigo-500 text-white shadow-lg shadow-purple-600/30'
                                  : 'text-[#718096] hover:text-[#1a1d29] hover:bg-white' }}">
                            Booking Approvals
                        </a>
                        <a href="{{ route('admin.rooms.index') }}"
                            class="px-3.5 py-2 rounded-xl text-sm font-medium transition-all duration-200
                                  {{ request()->routeIs('admin.rooms.*')
                                      ? 'bg-gradient-to-br from-purple-600 to-indigo-500 text-white shadow-lg shadow-purple-600/30'
                                      : 'text-[#718096] hover:text-[#1a1d29] hover:bg-white' }}">
                            Manage Rooms
                        </a>
                        <a href="{{ route('admin.users.index') }}"
                            class="px-3.5 py-2 rounded-xl text-sm font-medium transition-all duration-200
                                  {{ request()->routeIs('admin.users.*')
                                      ? 'bg-gradient-to-br from-purple-600 to-indigo-500 text-white shadow-lg shadow-purple-600/30'
                                      : 'text-[#718096] hover:text-[#1a1d29] hover:bg-white' }}">
                            Manage Users
                        </a>
                        <a href="{{ route('calendar.index') }}"
                            class="px-3.5 py-2 rounded-xl text-sm font-medium transition-all duration-200
                                  {{ request()->routeIs('calendar.*')
                                      ? 'bg-gradient-to-br from-purple-600 to-indigo-500 text-white shadow-lg shadow-purple-600/30'
                                      : 'text-[#718096] hover:text-[#1a1d29] hover:bg-white' }}">
                            Calendar
                        </a>
                    @elseif (auth()->user()->isAdmin())
                        <a href="{{ route('admin.bookings.index') }}"
                           class="px-3.5 py-2 rounded-xl text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('admin.bookings.*')
                                  ? 'bg-gradient-to-br from-purple-600 to-indigo-500 text-white shadow-lg shadow-purple-600/30'
                                  : 'text-[#718096] hover:text-[#1a1d29] hover:bg-white' }}">
                            Manage Bookings
                        </a>
                        <a href="{{ route('admin.rooms.index') }}"
                            class="px-3.5 py-2 rounded-xl text-sm font-medium transition-all duration-200
                                  {{ request()->routeIs('admin.rooms.*')
                                      ? 'bg-gradient-to-br from-purple-600 to-indigo-500 text-white shadow-lg shadow-purple-600/30'
                                      : 'text-[#718096] hover:text-[#1a1d29] hover:bg-white' }}">
                            Manage Rooms
                        </a>
                        <a href="{{ route('calendar.index') }}"
                            class="px-3.5 py-2 rounded-xl text-sm font-medium transition-all duration-200
                                  {{ request()->routeIs('calendar.*')
                                      ? 'bg-gradient-to-br from-purple-600 to-indigo-500 text-white shadow-lg shadow-purple-600/30'
                                      : 'text-[#718096] hover:text-[#1a1d29] hover:bg-white' }}">
                            Calendar
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}"
                            class="px-3.5 py-2 rounded-xl text-sm font-medium transition-all duration-200
                                  {{ request()->routeIs('dashboard')
                                      ? 'bg-gradient-to-br from-purple-600 to-indigo-500 text-white shadow-lg shadow-purple-600/30'
                                      : 'text-[#718096] hover:text-[#1a1d29] hover:bg-white' }}">
                            My Bookings
                        </a>
                        <a href="{{ route('rooms.index') }}"
                            class="px-3.5 py-2 rounded-xl text-sm font-medium transition-all duration-200
                                  {{ request()->routeIs('rooms.*')
                                      ? 'bg-gradient-to-br from-purple-600 to-indigo-500 text-white shadow-lg shadow-purple-600/30'
                                      : 'text-[#718096] hover:text-[#1a1d29] hover:bg-white' }}">
                            Browse Rooms
                        </a>
                        <a href="{{ route('calendar.index') }}"
                            class="px-3.5 py-2 rounded-xl text-sm font-medium transition-all duration-200
                                  {{ request()->routeIs('calendar.*')
                                      ? 'bg-gradient-to-br from-purple-600 to-indigo-500 text-white shadow-lg shadow-purple-600/30'
                                      : 'text-[#718096] hover:text-[#1a1d29] hover:bg-white' }}">
                            Calendar
                        </a>
                    @endif
                </div>
                @endauth

                <!-- Right Side -->
                <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
                    @auth
                        <!-- User Info -->
                        <div class="hidden sm:flex items-center gap-2.5">
                            <a href="{{ route('profile.show') }}"
                               class="flex items-center gap-2.5 px-2 py-1 rounded-xl hover:bg-[#f8f9fc] transition-all group">
                                <div class="relative">
                                    <div class="flex h-9 w-9 items-center justify-center rounded-full
                                                bg-gradient-to-br from-purple-500 via-indigo-500 to-pink-500
                                                text-sm font-bold text-white
                                                shadow-lg shadow-purple-500/30
                                                transition-transform duration-300 group-hover:scale-110">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    <div class="absolute -bottom-0.5 -right-0.5 h-3 w-3 rounded-full bg-emerald-500 ring-2 ring-white"></div>
                                </div>
                                <div class="hidden lg:block">
                                    <p class="text-sm font-semibold text-[#1a1d29] leading-none">{{ auth()->user()->name }}</p>
                                    @if (auth()->user()->isSuper())
                                        <p class="text-xs text-purple-600 mt-1 font-semibold">⚡ Super Admin</p>
                                    @elseif (auth()->user()->isAdmin())
                                        <p class="text-xs text-indigo-600 mt-1 font-semibold">🛡️ Admin</p>
                                    @else
                                        <p class="text-xs text-[#a0aec0] mt-1">User</p>
                                    @endif
                                </div>
                            </a>
                        </div>

                        <!-- Logout -->
                        <form action="{{ route('logout') }}" method="POST" class="hidden md:block" id="logout-form">
                            @csrf
                            <button type="button" onclick="openLogoutModal()"
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold
                                       text-[#4a5568] hover:text-white
                                       bg-white hover:bg-red-500
                                       border border-[#e8eaf0] hover:border-red-500
                                       transition-all duration-200">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span class="hidden sm:inline">Log Out</span>
                            </button>
                        </form>

                        <!-- Hamburger -->
                        <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                                class="md:hidden inline-flex items-center justify-center p-2 rounded-xl
                                       text-[#4a5568] bg-white hover:bg-[#f8f9fc]
                                       border border-[#e8eaf0] transition-all">
                            <svg x-show="!mobileMenuOpen" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg x-show="mobileMenuOpen" style="display:none;" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-3.5 py-2 rounded-xl text-xs font-semibold text-[#4a5568] hover:text-[#1a1d29] hover:bg-white transition-all border border-[#e8eaf0]">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                            class="px-3.5 py-2 rounded-xl text-xs font-semibold text-white
                                   bg-gradient-to-br from-purple-600 to-indigo-500
                                   hover:from-purple-500 hover:to-indigo-400
                                   transition-all shadow-lg shadow-purple-600/30 hover:-translate-y-0.5">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        @auth
        <div x-show="mobileMenuOpen"
             style="display: none;"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="md:hidden border-t border-[#eef0f5]"
             style="background-color: rgba(255, 255, 255, 0.98);">
            <div class="px-4 py-3 space-y-1">
                @if (auth()->user()->isSuper())
                    <a href="{{ route('admin.bookings.index') }}" class="block px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('admin.bookings.*') ? 'bg-gradient-to-br from-purple-600 to-indigo-500 text-white' : 'text-[#4a5568] hover:text-[#1a1d29] hover:bg-[#f8f9fc]' }}">Booking Approvals</a>
                    <a href="{{ route('admin.rooms.index') }}" class="block px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('admin.rooms.*') ? 'bg-gradient-to-br from-purple-600 to-indigo-500 text-white' : 'text-[#4a5568] hover:text-[#1a1d29] hover:bg-[#f8f9fc]' }}">Manage Rooms</a>
                    <a href="{{ route('admin.users.index') }}" class="block px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-br from-purple-600 to-indigo-500 text-white' : 'text-[#4a5568] hover:text-[#1a1d29] hover:bg-[#f8f9fc]' }}">Manage Users</a>
                    <a href="{{ route('calendar.index') }}" class="block px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('calendar.*') ? 'bg-gradient-to-br from-purple-600 to-indigo-500 text-white' : 'text-[#4a5568] hover:text-[#1a1d29] hover:bg-[#f8f9fc]' }}">Calendar</a>
                @elseif (auth()->user()->isAdmin())
                    <a href="{{ route('admin.bookings.index') }}" class="block px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('admin.bookings.*') ? 'bg-gradient-to-br from-purple-600 to-indigo-500 text-white' : 'text-[#4a5568] hover:text-[#1a1d29] hover:bg-[#f8f9fc]' }}">Manage Bookings</a>
                    <a href="{{ route('admin.rooms.index') }}" class="block px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('admin.rooms.*') ? 'bg-gradient-to-br from-purple-600 to-indigo-500 text-white' : 'text-[#4a5568] hover:text-[#1a1d29] hover:bg-[#f8f9fc]' }}">Manage Rooms</a>
                    <a href="{{ route('calendar.index') }}" class="block px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('calendar.*') ? 'bg-gradient-to-br from-purple-600 to-indigo-500 text-white' : 'text-[#4a5568] hover:text-[#1a1d29] hover:bg-[#f8f9fc]' }}">Calendar</a>
                @else
                    <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-gradient-to-br from-purple-600 to-indigo-500 text-white' : 'text-[#4a5568] hover:text-[#1a1d29] hover:bg-[#f8f9fc]' }}">My Bookings</a>
                    <a href="{{ route('rooms.index') }}" class="block px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('rooms.*') ? 'bg-gradient-to-br from-purple-600 to-indigo-500 text-white' : 'text-[#4a5568] hover:text-[#1a1d29] hover:bg-[#f8f9fc]' }}">Browse Rooms</a>
                    <a href="{{ route('calendar.index') }}" class="block px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('calendar.*') ? 'bg-gradient-to-br from-purple-600 to-indigo-500 text-white' : 'text-[#4a5568] hover:text-[#1a1d29] hover:bg-[#f8f9fc]' }}">Calendar</a>
                @endif

                <div class="border-t border-[#eef0f5] pt-2 mt-2">
                    <form action="{{ route('logout') }}" method="POST" id="logout-form-mobile">
                        @csrf
                        <button type="button" onclick="openLogoutModal()"
                            class="w-full flex items-center gap-2.5 px-4 py-3 rounded-xl text-sm font-medium text-red-500 hover:text-white hover:bg-red-500 transition-colors">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endauth
    </nav>

    <!-- Admin Sticky Bar -->
    @auth
        @if(auth()->user()->is_admin)
        <div id="admin-new-booking-bar"
             data-count="0"
             class="hidden sticky top-16 z-40 w-full border-b border-amber-500/40 backdrop-blur-md"
             style="background-color: rgba(254, 243, 199, 0.95);">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between gap-3 py-2.5">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="relative flex h-2.5 w-2.5 flex-shrink-0">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-amber-500"></span>
                        </span>
                        <p class="text-sm font-semibold text-amber-900 truncate">
                            <span id="admin-booking-bar-count" class="font-bold">0</span>
                            new booking request arrived while you were working.
                        </p>
                    </div>
                    <button onclick="window.location.reload()"
                        class="flex-shrink-0 inline-flex items-center gap-1.5 px-4 py-1.5 rounded-lg text-xs font-semibold bg-amber-500 hover:bg-amber-400 text-amber-950 transition-colors cursor-pointer">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Review Now
                    </button>
                </div>
            </div>
        </div>
        @endif
    @endauth

    <!-- Flash Alerts -->
    @if (session('success') || session('error') || session('warning') || $errors->any())
        <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 pt-4 space-y-2">
            @if (session('success'))
                <x-alert type="success" :message="session('success')" />
            @endif
            @if (session('warning'))
                <x-alert type="warning" :message="session('warning')" />
            @endif
            @if (session('error'))
                <x-alert type="error" :message="session('error')" />
            @endif
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <x-alert type="error" :message="$error" />
                @endforeach
            @endif
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-1 mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 py-8 page-animate">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-[#eef0f5] py-6 mt-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex items-center gap-2.5 text-xs text-[#718096]">
                <div class="flex h-6 w-6 items-center justify-center rounded-lg bg-gradient-to-br from-purple-500/15 to-indigo-500/15 border border-purple-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-purple-600" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M2 3h20v4H2V3zm2 5v13h3V8H4zm6 0v13h4V8h-4zm7 0v13h3V8h-3z" />
                    </svg>
                </div>
                <span>&copy; {{ date('Y') }} MyBookingHPD · All rights reserved</span>
            </div>
            <div class="text-xs text-[#a0aec0]">
                Built with <span class="text-pink-500">♥</span> for Hospital Port Dickson
            </div>
        </div>
    </footer>

    <!-- Logout Modal -->
    <div id="logout-modal" class="fixed inset-0 z-[999] hidden items-center justify-center transition-all duration-300"
         style="background-color: rgba(26, 29, 41, 0.5); backdrop-filter: blur(8px);">
        <div class="rounded-3xl p-8 max-w-md w-full mx-4 shadow-2xl transform transition-all duration-300 scale-95 opacity-0"
             id="logout-modal-content"
             style="background-color: #ffffff; border: 1px solid #eef0f5;">

            <div class="flex justify-center mb-4">
                <div class="h-16 w-16 rounded-2xl flex items-center justify-center border border-red-200"
                     style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%);">
                    <svg class="h-8 w-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </div>
            </div>

            <h3 class="text-xl font-bold text-[#1a1d29] text-center mb-2">Log Out?</h3>
            <p class="text-sm text-[#718096] text-center mb-6">Are you sure you want to logout? You'll need to login again.</p>

            <div class="flex gap-3">
                <button type="button" onclick="closeLogoutModal()"
                    class="flex-1 px-4 py-3 rounded-xl border border-[#e8eaf0] hover:border-[#d8dce6]
                           bg-white hover:bg-[#f8f9fc] text-sm font-semibold text-[#4a5568] hover:text-[#1a1d29] transition-all">
                    Cancel
                </button>
                <button type="button" onclick="confirmLogout()"
                    class="flex-1 px-4 py-3 rounded-xl
                           bg-gradient-to-br from-red-600 to-red-500
                           hover:from-red-500 hover:to-red-400
                           text-sm font-semibold text-white transition-all
                           shadow-lg shadow-red-600/30 hover:-translate-y-0.5">
                    Log Out
                </button>
            </div>
        </div>
    </div>

    @stack('scripts')

    <script>
        function openLogoutModal() {
            var modal = document.getElementById('logout-modal');
            var content = document.getElementById('logout-modal-content');
            if (!modal || !content) return;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(function() {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 50);
        }

        function closeLogoutModal() {
            var modal = document.getElementById('logout-modal');
            var content = document.getElementById('logout-modal-content');
            if (!modal || !content) return;
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            setTimeout(function() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        function confirmLogout() {
            var form = document.getElementById('logout-form') || document.getElementById('logout-form-mobile');
            if (form) form.submit();
        }

        document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById('logout-modal');
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) closeLogoutModal();
                });
            }
        });
    </script>
</body>

</html>