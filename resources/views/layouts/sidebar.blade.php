<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Fleur a Tory</title>

    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <link rel="icon" href="{{ asset('favicon.ico') }}">
</head>
<body class="flex bg-gray-100">

    {{-- Sidebar --}}
    <aside class="w-64 bg-gray-50 border-r border-gray-200 min-h-screen hidden md:block">
      <div class="px-6 py-8">
        <h2 class="font-serif text-2xl italic">La Fleur a Tory</h2>
      </div>

      <nav class="px-4 space-y-3">
        <a href="{{ route('admin.dashboard') }}"class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-white shadow-sm text-gray-800' : 'text-gray-500 hover:text-gray-800' }}">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h2l.4 2M7 21h10l1-5H6l1 5zM7 7h10l1 5H6l1-5z"/>
            </svg>
            <span>Dashboard</span>
        </a>

         <a href="{{ route('tambahproduk.index') }}"class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('tambahproduk.index') ? 'bg-white shadow-sm text-gray-800' : 'text-gray-500 hover:text-gray-800' }}">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h2l.4 2M7 21h10l1-5H6l1 5zM7 7h10l1 5H6l1-5z"/>
            </svg>
            <span>Tambah Produk</span>
        </a>

        <a href="{{ route('stok.index') }}"class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('stok.index') ? 'bg-white shadow-sm text-gray-800' : 'text-gray-500 hover:text-gray-800' }}">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h2l.4 2M7 21h10l1-5H6l1 5zM7 7h10l1 5H6l1-5z"/>
            </svg>
            <span>Stok</span>
        </a>


        <a href="{{ route('retur') }}"class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('retur') ? 'bg-white shadow-sm text-gray-800' : 'text-gray-500 hover:text-gray-800' }}">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h2l.4 2M7 21h10l1-5H6l1 5zM7 7h10l1 5H6l1-5z"/>
            </svg>
            <span>Retur</span>
        </a>

         <a href="{{ route('laporan') }}"class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('laporan') ? 'bg-white shadow-sm text-gray-800' : 'text-gray-500 hover:text-gray-800' }}">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h2l.4 2M7 21h10l1-5H6l1 5zM7 7h10l1 5H6l1-5z"/>
            </svg>
            <span>Laporan</span>
        </a>
      </nav>

      <div class="mt-auto px-4 py-6">


        <a href="{{ route('awal') }}" class="flex items-center gap-3 text-gray-600">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7"/></svg>
          <span>Log Out</span>
        </a>
      </div>
    </aside>

    {{-- INI BAGIAN PENTING: Tempat isi konten dari @section('content') --}}
    <main class="flex-1">
        @yield('content')
    </main>

</body>
</html>
