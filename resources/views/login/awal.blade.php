<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Fleur a Tory</title>

    {{-- Tailwind CSS (pakai Vite) --}}
    @vite('resources/css/app.css')

    {{-- Optional: Font atau favicon --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}">
</head>
<body class="relative bg-black h-screen">
    <div
        class="absolute inset-0 bg-cover bg-center h-full w-full grayscale contrast-125 brightness-75"
        style="background-image: url('https://images.unsplash.com/photo-1509440159596-0249088772ff?w=1600&q=80&sat=-100');"
    >
    </div>

    <div class="absolute inset-0 bg-gradient-to-l from-black via-black/70 to-black/30"></div>

    <div class="min-h-screen flex flex-col lg:flex-row relative z-10">
        {{-- Text Side --}}
        <section class="flex-1 flex items-center justify-center px-6 py-16 lg:px-16 order-2 lg:order-1">
            <div class="max-w-2xl w-full space-y-8">
                <p class="text-sm tracking-[0.4em] uppercase text-gray-400">La Fleur a Tory</p>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold uppercase leading-tight text-white">
                    Rasakan Setiap Rotinya<br>
                </h1>
                <p class="text-lg text-gray-300 max-w-xl">
                    "Berdayakan dirimu dengan rasa. Setiap roti dibuat untuk menyalakan semangat baru
                    dan menemani langkah besar yang ingin kamu capai"
                </p>
                <div>
                    <a
                        href="{{ route('login') }}"
                        class="inline-flex items-center justify-center px-8 py-4 bg-red-600 text-white font-semibold tracking-wide uppercase rounded shadow-lg hover:bg-red-500 transition-colors"
                    >
                        Mulai Sekarang
                    </a>
                </div>
            </div>
        </section>

        {{-- Image Side (Dibiarkan kosong atau dihapus jika gambar hanya untuk background) --}}
        <section class="flex-1 min-h-[50vh] order-1 lg:order-2"></section>

    </div>
</body>
</html>
