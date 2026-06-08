<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Verifikasi OTP Borma Toserba.">
    <title>Verifikasi OTP - Borma Toserba</title>
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
                    <div class="w-16 h-16 bg-primary-50 rounded-2xl flex items-center justify-center mx-auto mb-4 text-primary-700">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <h2 class="font-heading font-bold text-2xl text-neutral-800">Verifikasi OTP</h2>
                    <p class="text-neutral-500 text-sm mt-2">
                        Kami telah mengirimkan 6-digit kode OTP ke email:<br>
                        <strong class="text-neutral-700 font-semibold">{{ session('otp_email') }}</strong>
                    </p>
                </div>

                @if ($errors->any())
                <div class="mb-6 bg-tertiary-50 border border-tertiary-200 rounded-xl p-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-tertiary-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-tertiary-500 text-sm font-medium">{{ $errors->first() }}</p>
                    </div>
                </div>
                @endif

                @if (session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-xl p-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-emerald-700 text-sm font-medium">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ route('auth.otp.verify') }}" class="space-y-6" id="otp-form">
                    @csrf
                    <!-- 6 Digit Input Fields -->
                    <div class="flex justify-between gap-2" id="otp-inputs-container">
                        @for ($i = 0; $i < 6; $i++)
                            <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" required
                                class="w-12 h-14 text-center text-xl font-bold border-2 border-neutral-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all outline-none bg-neutral-50 hover:bg-white focus:bg-white otp-digit-input"
                                data-index="{{ $i }}">
                        @endfor
                    </div>

                    <!-- Hidden Input to store full OTP -->
                    <input type="hidden" name="otp" id="full-otp-input">

                    <button type="submit" class="w-full bg-primary-700 text-white font-bold py-3.5 rounded-xl hover:bg-primary-600 active:bg-primary-800 transition-all duration-200 shadow-lg shadow-primary-700/30 hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <span>Verifikasi & Masuk</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </button>
                </form>

                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-neutral-200"></div></div>
                </div>

                <div class="text-center text-sm">
                    <p class="text-neutral-500">Tidak menerima kode?</p>
                    <form method="POST" action="{{ route('auth.otp.resend') }}" class="mt-2">
                        @csrf
                        <button type="submit" id="btn-resend" class="font-bold text-primary-600 hover:text-primary-700 transition-colors focus:outline-none">
                            Kirim Ulang OTP
                        </button>
                        <span id="countdown-text" class="text-neutral-400 text-xs mt-1 block"></span>
                    </form>
                </div>
            </div>

            <p class="text-center mt-6">
                <a href="{{ route('login') }}" class="text-sm text-primary-300 hover:text-white transition-colors inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Login
                </a>
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.otp-digit-input');
            const form = document.getElementById('otp-form');
            const fullOtpInput = document.getElementById('full-otp-input');
            const btnResend = document.getElementById('btn-resend');
            const countdownText = document.getElementById('countdown-text');

            // Focus first input initially
            if (inputs[0]) inputs[0].focus();

            inputs.forEach(input => {
                input.addEventListener('input', function(e) {
                    const value = e.target.value;
                    const index = parseInt(e.target.dataset.index);

                    // Ensure only numbers
                    e.target.value = value.replace(/[^0-9]/g, '');

                    if (e.target.value && index < 5) {
                        inputs[index + 1].focus();
                    }
                    updateFullOtp();
                });

                input.addEventListener('keydown', function(e) {
                    const index = parseInt(e.target.dataset.index);

                    if (e.key === 'Backspace' && !e.target.value && index > 0) {
                        inputs[index - 1].focus();
                    }
                });

                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const text = (e.clipboardData || window.clipboardData).getData('text');
                    const numbers = text.replace(/[^0-9]/g, '').substring(0, 6);

                    for (let i = 0; i < Math.min(numbers.length, inputs.length); i++) {
                        inputs[i].value = numbers[i];
                    }
                    if (numbers.length > 0) {
                        const nextFocus = Math.min(numbers.length, inputs.length - 1);
                        inputs[nextFocus].focus();
                    }
                    updateFullOtp();
                });
            });

            function updateFullOtp() {
                let otp = '';
                inputs.forEach(input => otp += input.value);
                fullOtpInput.value = otp;
            }

            form.addEventListener('submit', function(e) {
                updateFullOtp();
                if (fullOtpInput.value.length < 6) {
                    e.preventDefault();
                    alert('Mohon masukkan 6 digit kode OTP secara lengkap.');
                }
            });

            // Resend timer countdown logic
            let cooldown = 30; // 30 seconds
            if (sessionStorage.getItem('otp_cooldown')) {
                const elapsed = Math.floor((Date.now() - parseInt(sessionStorage.getItem('otp_cooldown_time'))) / 1000);
                cooldown = Math.max(0, parseInt(sessionStorage.getItem('otp_cooldown')) - elapsed);
            }

            function startTimer() {
                if (cooldown > 0) {
                    btnResend.disabled = true;
                    btnResend.classList.add('opacity-50', 'pointer-events-none');
                    countdownText.textContent = `Silakan tunggu ${cooldown} detik untuk mengirim ulang.`;
                    
                    const interval = setInterval(() => {
                        cooldown--;
                        sessionStorage.setItem('otp_cooldown', cooldown);
                        sessionStorage.setItem('otp_cooldown_time', Date.now());
                        
                        if (cooldown <= 0) {
                            clearInterval(interval);
                            btnResend.disabled = false;
                            btnResend.classList.remove('opacity-50', 'pointer-events-none');
                            countdownText.textContent = '';
                            sessionStorage.removeItem('otp_cooldown');
                            sessionStorage.removeItem('otp_cooldown_time');
                        } else {
                            countdownText.textContent = `Silakan tunggu ${cooldown} detik untuk mengirim ulang.`;
                        }
                    }, 1000);
                }
            }

            if (cooldown > 0) {
                startTimer();
            }

            btnResend.addEventListener('click', function() {
                sessionStorage.setItem('otp_cooldown', 30);
                sessionStorage.setItem('otp_cooldown_time', Date.now());
            });
        });
    </script>
</body>
</html>
