@component('layouts.guest')
    <div class="flex flex-col items-center justify-center grow h-screen bg-[#f0f4f1] relative">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-[#006025] to-[#004d1e] opacity-90"></div>

        <div class="relative w-full max-w-md px-6 py-8">
            <!-- Logo & Title -->
            <div class="text-center mb-8">
                <div class="mx-auto h-24 w-24 bg-white rounded-full flex items-center justify-center mb-4 shadow-lg border-4 border-[#dcb000]">
                    <img src="{{ asset('img/logo-ppsr.png') }}" alt="Logo PPSR" class="h-16 w-auto">
                </div>
                <h2 class="text-3xl font-extrabold text-white tracking-tight">Sistem Rapor</h2>
                <p class="mt-2 text-[#dcb000] font-semibold text-lg">Pondok Pesantren Syafa'aturrasul</p>
            </div>

            <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-8 border-t-4 border-[#dcb000]">
                <div class="mb-6 text-center">
                    <h3 class="text-2xl font-bold text-[#006025]">Selamat Datang</h3>
                    <p class="text-gray-500 mt-1 text-sm">Masuk untuk mengakses sistem akademik</p>
                </div>
        
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />
        
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf
        
                    <!-- Email / Username -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1 ml-1">Email / Username</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                            </div>
                            <input id="email" type="text" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#006025] focus:border-transparent transition ease-in-out duration-200 bg-gray-50 focus:bg-white placeholder-gray-400"
                                placeholder="Email atau Username">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
        
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1 ml-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                class="w-full pl-10 pr-12 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#006025] focus:border-transparent transition ease-in-out duration-200 bg-gray-50 focus:bg-white placeholder-gray-400"
                                placeholder="••••••••">
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition">
                                <svg id="eye-icon" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg id="eye-slash-icon" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <script>
                        function togglePassword() {
                            const passwordInput = document.getElementById('password');
                            const eyeIcon = document.getElementById('eye-icon');
                            const eyeSlashIcon = document.getElementById('eye-slash-icon');
                            
                            if (passwordInput.type === 'password') {
                                passwordInput.type = 'text';
                                eyeIcon.classList.add('hidden');
                                eyeSlashIcon.classList.remove('hidden');
                            } else {
                                passwordInput.type = 'password';
                                eyeIcon.classList.remove('hidden');
                                eyeSlashIcon.classList.add('hidden');
                            }
                        }
                    </script>
        
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
@endcomponent
