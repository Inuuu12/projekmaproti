<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Fleur a Tory - Login</title>

    {{-- Tailwind CSS (pakai Vite) --}}
    @vite('resources/css/app.css')

    {{-- Optional: Font atau favicon --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}">
</head>
<body class="min-h-screen bg-white text-black">
    <div class="min-h-screen flex flex-col lg:flex-row">
        {{-- Form Side --}}
        <section class="flex-1 flex items-center justify-center px-6 py-16 lg:px-16 order-2 lg:order-1">
            <div class="w-full max-w-md space-y-8">
                <div class="space-y-3">
                    <p class="text-sm tracking-[0.4em] uppercase text-black-400">La Fleur a Tory</p>
                    <h1 class="text-4xl sm:text-5xl font-extrabold uppercase leading-tight">
                        Login<br>Admin
                    </h1>
                    <p class="text-black-300">
                        Masuk untuk melanjutkan perjalanan rasa dan kelola semua kebutuhanmu.
                    </p>
                </div>

                @if ($errors->any())
                    <div class="rounded-xl border border-red-500/40 bg-red-500/10 text-sm text-red-200 px-4 py-3">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.process') }}" class="space-y-6 bg-white border border-black/10 rounded-2xl p-6 backdrop-blur">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-black-800 mb-2">Nama / Email / Username</label>
                        <input
                            class="w-full px-4 py-3 bg-white/30 border  rounded-lg text-black placeholder-gray- focus:outline-none focus:ring-2 focus:ring-white/40"
                            type="text"
                            name="login"
                            placeholder="Masukkan nama, email, atau username"
                            value="{{ old('login') }}"
                        >
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-black-800 mb-2">Password</label>
                        <div class="relative">
                            <input
                                class="w-full px-4 py-3 bg-white/30 border border-black/20 rounded-lg text-black placeholder-White focus:outline-none focus:ring-2 focus:ring-white/40 pr-12"
                                type="password"
                                name="password"
                                id="password"
                                placeholder="••••••••"
                            >
                            <button
                                type="button"
                                id="togglePassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-black
                                    transition-all duration-300 ease-in-out hover:scale-110"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" id="eyeIcon" viewBox="0 0 16 16">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" id="eyeSlashIcon" class="hidden" viewBox="0 0 16 16">
                                    <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/>
                                    <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button
                        class="w-full bg-black text-white py-3 rounded-lg font-semibold uppercase tracking-wide
                            hover:bg-gray-300 hover:text-black transition-colors duration-300 ease-in-out"
                        type="submit">
                        Masuk
                    </button>
                </form>
            </div>
        </section>

        {{-- Image Side --}}
        <section class="relative flex-1 min-h-[50vh] order-1 lg:order-2 overflow-hidden">
            <img
                class="w-full h-full object-cover grayscale contrast-125 brightness-75"
                src="https://images.unsplash.com/photo-1509440159596-0249088772ff?w=1600&q=80&sat=-100"
                alt="Monochrome Bread"
            >
            <div class="absolute inset-0 bg-gradient-to-l from-black via-black/70 to-transparent"></div>
        </section>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeSlashIcon = document.getElementById('eyeSlashIcon');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            if (type === 'text') {
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            } else {
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
