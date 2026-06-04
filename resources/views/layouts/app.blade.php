<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Rapor PPSR') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex" x-data="{ mobileMenuOpen: false }">
        <!-- Mobile Sidebar Overlay -->
        <div x-show="mobileMenuOpen" 
             @click="mobileMenuOpen = false"
             x-cloak
             class="fixed inset-0 bg-gray-600 bg-opacity-75 z-40 md:hidden"></div>

        <!-- Sidebar (Desktop + Mobile Slide-in) -->
        <aside :class="mobileMenuOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="fixed md:static inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-blue-600 to-blue-800 text-white flex-shrink-0 transform transition-transform duration-300 ease-in-out md:translate-x-0">
            
            <!-- Mobile Close Button -->
            <div class="md:hidden absolute top-4 right-4">
                <button @click="mobileMenuOpen = false" class="text-white hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="p-6">
                <h1 class="text-2xl font-bold">Rapor PPSR</h1>
                <p class="text-blue-200 text-sm mt-1">Pondok Pesantren Syafa'aturrasul</p>
            </div>

            <nav class="mt-6 overflow-y-auto" style="max-height: calc(100vh - 120px);">
                @if(auth()->user()->isAdmin())
                    <!-- Admin Menu -->
                    <div class="px-4 mb-4">
                        <p class="text-xs font-semibold text-blue-300 uppercase tracking-wider">Admin</p>
                    </div>
                    <a href="{{ route('dashboard') }}" wire:navigate @click="mobileMenuOpen = false" class="flex items-center px-6 py-3 text-white hover:bg-blue-700 transition {{ request()->routeIs('dashboard') ? 'bg-blue-700 border-l-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.tahun-ajaran.index') }}" wire:navigate @click="mobileMenuOpen = false" class="flex items-center px-6 py-3 text-white hover:bg-blue-700 transition {{ request()->routeIs('admin.tahun-ajaran.*') ? 'bg-blue-700 border-l-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Tahun Ajaran
                    </a>
                    <a href="{{ route('admin.kelas.index') }}" wire:navigate @click="mobileMenuOpen = false" class="flex items-center px-6 py-3 text-white hover:bg-blue-700 transition {{ request()->routeIs('admin.kelas.*') ? 'bg-blue-700 border-l-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Asrama
                    </a>
                    <a href="{{ route('admin.siswa.index') }}" wire:navigate @click="mobileMenuOpen = false" class="flex items-center px-6 py-3 text-white hover:bg-blue-700 transition {{ request()->routeIs('admin.siswa.*') ? 'bg-blue-700 border-l-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Siswa
                    </a>
                    <a href="{{ route('admin.guru.index') }}" wire:navigate @click="mobileMenuOpen = false" class="flex items-center px-6 py-3 text-white hover:bg-blue-700 transition {{ request()->routeIs('admin.guru.*') ? 'bg-blue-700 border-l-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Pembina Asrama
                    </a>
                    <a href="{{ route('admin.mata-pelajaran.index') }}" wire:navigate @click="mobileMenuOpen = false" class="flex items-center px-6 py-3 text-white hover:bg-blue-700 transition {{ request()->routeIs('admin.mata-pelajaran.*') ? 'bg-blue-700 border-l-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Mata Pelajaran
                    </a>

                    <a href="{{ route('admin.rapor.index') }}" wire:navigate @click="mobileMenuOpen = false" class="flex items-center px-6 py-3 text-white hover:bg-blue-700 transition {{ request()->routeIs('admin.rapor.*') ? 'bg-blue-700 border-l-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        Cetak Rapor
                    </a>
                    
                    <a href="{{ route('admin.leger-kelas.index') }}" wire:navigate @click="mobileMenuOpen = false" class="flex items-center px-6 py-3 text-white hover:bg-blue-700 transition {{ request()->routeIs('admin.leger-kelas.*') ? 'bg-blue-700 border-l-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Leger Asrama
                    </a>
                    
                    <a href="{{ route('admin.rapor-settings.edit') }}" wire:navigate @click="mobileMenuOpen = false" class="flex items-center px-6 py-3 text-white hover:bg-blue-700 transition {{ request()->routeIs('admin.rapor-settings.*') ? 'bg-blue-700 border-l-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Pengaturan Rapor
                    </a>
                @elseif(auth()->user()->isGuru())
                    <!-- Guru Menu -->
                    <div class="px-4 mb-4">
                        <p class="text-xs font-semibold text-blue-300 uppercase tracking-wider">Pembina Asrama</p>
                    </div>
                    <a href="{{ route('dashboard') }}" @click="mobileMenuOpen = false" class="flex items-center px-6 py-3 text-white hover:bg-blue-700 transition {{ request()->routeIs('dashboard') ? 'bg-blue-700 border-l-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('guru.input-nilai.index') }}" wire:navigate @click="mobileMenuOpen = false" class="flex items-center px-6 py-3 text-white hover:bg-blue-700 transition {{ request()->routeIs('guru.input-nilai.*') ? 'bg-blue-700 border-l-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Input Nilai
                    </a>
                @endif

                @if(auth()->user()->isWaliKelas())
                    <!-- Wali Asrama Menu -->
                    <div class="px-4 mb-4 mt-6">
                        <p class="text-xs font-semibold text-blue-300 uppercase tracking-wider">Wali Asrama</p>
                    </div>
                    
                    {{-- Dashboard link only if role is explicitly wali_kelas to avoid duplicates --}}
                    @if(auth()->user()->role === 'wali_kelas')
                    <a href="{{ route('dashboard') }}" @click="mobileMenuOpen = false" class="flex items-center px-6 py-3 text-white hover:bg-blue-700 transition {{ request()->routeIs('dashboard') ? 'bg-blue-700 border-l-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>
                    @endif

                    <a href="{{ route('wali-kelas.rapor.index') }}" wire:navigate @click="mobileMenuOpen = false" class="flex items-center px-6 py-3 text-white hover:bg-blue-700 transition {{ request()->routeIs('wali-kelas.rapor.*') ? 'bg-blue-700 border-l-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        Cetak Rapor
                    </a>
                    
                    <a href="{{ route('wali-kelas.leger-kelas.index') }}" wire:navigate @click="mobileMenuOpen = false" class="flex items-center px-6 py-3 text-white hover:bg-blue-700 transition {{ request()->routeIs('wali-kelas.leger-kelas.*') ? 'bg-blue-700 border-l-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Leger Asrama
                    </a>
                @endif
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Navbar -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-4 sm:px-6 py-4">
                    <!-- Mobile Menu Button + Title -->
                    <div class="flex items-center">
                        <!-- Hamburger Button (Mobile Only) -->
                        <button @click="mobileMenuOpen = true" class="md:hidden mr-3 text-gray-600 hover:text-gray-900 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        
                        <h2 class="text-lg sm:text-xl font-semibold text-gray-800">{{ $title ?? 'Dashboard' }}</h2>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- User Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center space-x-2 sm:space-x-3 focus:outline-none">
                                <div class="text-right hidden sm:block">
                                    <p class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ ucfirst(auth()->user()->role) }}</p>
                                </div>
                                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold text-sm">
                                    {{ auth()->user()->initials() }}
                                </div>
                            </button>

                            <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
    <style>
        [x-cloak] { display: none !important; }
    </style>
</body>
</html>
