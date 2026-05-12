<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internal Login - Borma</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        .role-radio:checked + label {
            background-color: #FED50B;
            color: #33116C;
            border-color: #FED50B;
            font-weight: 700;
            box-shadow: 0 4px 14px 0 rgba(254, 213, 11, 0.39);
        }
        
        .role-radio:not(:checked) + label {
            background-color: rgba(255, 255, 255, 0.05);
            color: #e2e8f0;
            border-color: rgba(255, 255, 255, 0.1);
        }
        
        .role-radio:not(:checked) + label:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.3);
        }
        
        .glass-input {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
        }
        
        .glass-input:focus {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: #FED50B;
            outline: none;
            box-shadow: 0 0 0 2px rgba(254, 213, 11, 0.2);
        }
        
        .glass-input::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-[#33116C] via-[#210B46] to-[#110526] flex items-center justify-center p-6 relative overflow-hidden">
    
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-[#FED50B] opacity-10 blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] rounded-full bg-[#6B21A8] opacity-20 blur-[150px] pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 mb-4 shadow-xl">
                <i class="fa-solid fa-cart-shopping text-3xl text-[#FED50B]"></i>
            </div>
            <h1 class="text-3xl font-bold text-white tracking-tight">BORMA</h1>
            <p class="text-white/60 mt-2 font-medium">Internal System Portal</p>
        </div>

        <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl p-8 shadow-[0_8px_32px_0_rgba(0,0,0,0.3)] transform transition-all hover:border-white/20 duration-500">
            <form action="{{ route('internal.login.post') }}" method="POST">
                @csrf
                
                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-red-500/20 border border-red-500/50">
                        <ul class="list-disc list-inside text-sm text-red-200">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="space-y-5">
                    <div>
                        <label for="email" class="block text-sm font-medium text-white/80 mb-2">Email / ID Pengguna</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-regular fa-envelope text-white/40"></i>
                            </div>
                            <input type="text" id="email" name="email" value="{{ old('email') }}" class="glass-input block w-full pl-11 pr-4 py-3.5 rounded-xl text-sm transition-colors" placeholder="Masukkan email atau ID" required>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-sm font-medium text-white/80">Kata Sandi</label>
                            <a href="#" class="text-xs font-medium text-[#FED50B] hover:text-white transition-colors">Lupa sandi?</a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-lock text-white/40"></i>
                            </div>
                            <input type="password" id="password" name="password" class="glass-input block w-full pl-11 pr-11 py-3.5 rounded-xl text-sm transition-colors" placeholder="Masukkan kata sandi" required>
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-white/40 hover:text-white transition-colors">
                                <i class="fa-regular fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <button type="submit" class="w-full bg-[#FED50B] hover:bg-[#F2C900] text-[#33116C] font-bold py-4 px-4 rounded-xl shadow-[0_4px_14px_0_rgba(254,213,11,0.39)] hover:shadow-[0_6px_20px_rgba(254,213,11,0.23)] hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2">
                        Masuk Sistem
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    </button>
                </div>
            </form>
        </div>
        
        <div class="text-center mt-8 text-white/40 text-xs">
            <p>&copy; 2026 Borma Toserba. Internal Use Only.</p>
            <p class="mt-1 flex items-center justify-center gap-2">
                <i class="fa-solid fa-shield-halved"></i>
                Sistem Terenkripsi & Dilindungi
            </p>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const toggleIcon = document.querySelector('#toggleIcon');

        togglePassword.addEventListener('click', function (e) {
            
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            if (type === 'password') {
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            } else {
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            }
        });
    </script>
</body>
</html>
