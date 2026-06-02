<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('{{ asset('img/bg-pattern.png') }}'); background-color: #f0f4f1;">
        <!-- Overlay for better text readability if background is busy, otherwise just a soft gradient -->
        <div class="absolute inset-0 bg-gradient-to-br from-[#006025] to-[#004d1e] opacity-90"></div>

        <div class="relative max-w-md w-full px-6 py-8">
            <!-- Logo & Title -->
            <div class="text-center mb-8">
                <div class="mx-auto h-24 w-24 bg-white rounded-full flex items-center justify-center mb-4 shadow-lg border-4 border-[#dcb000]">
                    <img src="{{ asset('img/logo-ppsr.png') }}" alt="Logo PPSR" class="h-16 w-auto">
                </div>
                <h2 class="text-3xl font-extrabold text-white tracking-tight">Sistem Rapor</h2>
                <p class="mt-2 text-[#dcb000] font-semibold text-lg">Pondok Pesantren Syafa'aturrasul</p>
            </div>

            <!-- Login Card -->
            <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-8 border-t-4 border-[#dcb000]">
                <div class="mb-6 text-center">
                    <h3 class="text-2xl font-bold text-[#006025]">Selamat Datang</h3>
                    <p class="text-gray-500 mt-1 text-sm">Masuk untuk mengakses sistem akademik</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                        <div class="font-bold mb-1">Terjadi Kesalahan Login:</div>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1 ml-1">Email / Username</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#006025] focus:border-transparent transition ease-in-out duration-200 bg-gray-50 focus:bg-white placeholder-gray-400"
                                placeholder="nama@email.com">
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1 ml-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#006025] focus:border-transparent transition ease-in-out duration-200 bg-gray-50 focus:bg-white placeholder-gray-400"
                            placeholder="••••••••">
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-[#006025] focus:ring-[#006025] shadow-sm">
                            <span class="ml-2 text-gray-600">Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="font-medium text-[#006025] hover:text-[#004d1e] hover:underline transition">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-[#006025] hover:bg-[#004d1e] text-white font-bold py-3.5 px-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 flex items-center justify-center group">
                        <span>Masuk Sekarang</span>
                        <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-white/80 text-xs">
                    © {{ date('Y') }} Pondok Pesantren Syafa'aturrasul.<br>All rights reserved.
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
