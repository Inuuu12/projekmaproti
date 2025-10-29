<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Fleur a Tory</title>

    {{-- Load Google Font Great Vibes --}}
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">

    {{-- Tailwind CSS (pakai Vite) --}}
    @vite('resources/css/app.css')

    {{-- Optional: Font atau favicon --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}">
</head>
<body class="min-h-screen bg-background text-foreground antialiased">

    {{-- Navbar sederhana (opsional) --}}
     <header class="bg-white/60 backdrop-blur-md shadow-none border-none" style="border-bottom: none; box-shadow: none;">
      <div class="container mx-auto max-w-7xl px-6 lg:px-8 pt-5 pb-0 flex items-center justify-between">
            <div class="flex items-center">
                <!-- Flower logo -->
                <img src="{{ asset('images/logo.png') }}" alt="Flower logo" class="w-24 h-24 md:w-24 md:h-24 mr-4 object-contain">

                <!-- Brand name with Great Vibes font -->
                <h1 class="text-3xl md:text-4xl" style="font-family: 'Great Vibes', cursive; line-height:1;">
                    La Fleur a Tory
                </h1>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('login') }}">
                <button class="h-12 px-8 bg-gradient-to-r from-gray-400 to-gray-700 text-white rounded-xl font-medium shadow-md hover:scale-105 transition">
                Sign In
                </button>
                </a>
            </div>
        </div>
    </header>

    {{-- Konten halaman --}}
    <main class="pt-8">
        @yield('content')
    </main>

    {{-- Footer sederhana --}}
    <footer class="mt-20 py-6 text-center text-sm text-gray-500">
        © {{ date('Y') }} La Fleur a Tory — All rights reserved.
    </footer>

</body>
</html>
