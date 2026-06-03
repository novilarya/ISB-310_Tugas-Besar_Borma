<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Masuk ke akun Borma Toserba Anda.">
    <title>Masuk - Borma Toserba</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-primary-800 font-sans antialiased">
    <div class="fixed inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-br from-primary-900 via-primary-800 to-primary-700"></div>
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-secondary-400/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-tertiary-400/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 flex min-h-screen items-center justify-center px-4 py-12">
        <div class="w-full max-w-md animate-fade-in-up">
            <a href="{{ route('pelanggan.dashboard') }}" class="flex items-center justify-center gap-3 mb-10 group">
                <div class="w-12 h-12 bg-secondary-400 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <span class="text-primary-700 font-heading font-extrabold text-xl">B</span>
                </div>
                <div>
                    <h1 class="font-heading font-bold text-2xl tracking-tight text-white leading-none">BORMA</h1>
                    <p class="text-primary-300 text-xs font-medium mt-0.5">Toserba Digital</p>
                </div>
            </a>

            <div class="bg-white rounded-2xl shadow-2xl p-8 sm:p-10">
                <div class="text-center mb-8">
                    <h2 class="font-heading font-bold text-2xl text-neutral-800">Selamat Datang!</h2>
                    <p class="text-neutral-500 text-sm mt-2">Masuk ke akun Anda untuk melanjutkan</p>
                </div>

                @if ($errors->any())
                <div class="mb-6 bg-tertiary-50 border border-tertiary-200 rounded-xl p-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-tertiary-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-tertiary-500 text-sm font-medium">{{ $errors->first() }}</p>
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ route('login.submit') }}" class="space-y-5" id="login-form">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-semibold text-neutral-700 mb-1.5">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="contoh@email.com" class="w-full pl-12 pr-4 py-3 border-2 border-neutral-200 rounded-xl text-sm text-neutral-800 placeholder-neutral-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all outline-none bg-neutral-50 hover:bg-white focus:bg-white">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-neutral-700 mb-1.5">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <input type="password" name="password" id="password" required placeholder="Masukkan password" class="w-full pl-12 pr-12 py-3 border-2 border-neutral-200 rounded-xl text-sm text-neutral-800 placeholder-neutral-400 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all outline-none bg-neutral-50 hover:bg-white focus:bg-white">
                            <button type="button" onclick="togglePassword('password', this)" class="absolute inset-y-0 right-0 pr-4 flex items-center text-neutral-400 hover:text-neutral-600 transition-colors">
                                <svg class="w-5 h-5 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg class="w-5 h-5 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M3 3l18 18"/></svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" id="login-submit-btn" class="w-full bg-primary-700 text-white font-bold py-3.5 rounded-xl hover:bg-primary-600 active:bg-primary-800 transition-all duration-200 shadow-lg shadow-primary-700/30 hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <span>Masuk</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </form>

                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-neutral-200"></div></div>
                    <div class="relative flex justify-center"><span class="px-4 bg-white text-sm text-neutral-400">atau</span></div>
                </div>

                <p class="text-center text-sm text-neutral-500">
                    Belum memiliki akun?
                    <a href="{{ route('register') }}" class="font-bold text-primary-600 hover:text-primary-700 transition-colors ml-1" id="register-link">Daftar Sekarang</a>
                </p>
            </div>

            <p class="text-center mt-6">
                <a href="{{ route('pelanggan.dashboard') }}" class="text-sm text-primary-300 hover:text-white transition-colors inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Beranda
                </a>
            </p>
        </div>
    </div>

    <script>
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const eyeOpen = button.querySelector('.eye-open');
            const eyeClosed = button.querySelector('.eye-closed');
            if (input.type === 'password') { input.type = 'text'; eyeOpen.classList.add('hidden'); eyeClosed.classList.remove('hidden'); }
            else { input.type = 'password'; eyeOpen.classList.remove('hidden'); eyeClosed.classList.add('hidden'); }
        }
    </script>
</body>
</html>
