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
    @php
        $user = auth()->user();
        $userRole = $user->role ?? null;
        $isOwner = in_array($userRole, ['owner', 'superadmin']);
    @endphp

    {{-- Topbar Mobile (Hamburger) --}}
    <div class="md:hidden fixed top-0 left-0 right-0 z-40 bg-white/90 border-b border-gray-200 backdrop-blur-sm">
      <div class="px-4 py-3 flex items-center justify-between">
        <button id="mobile-menu-button" class="inline-flex items-center justify-center w-10 h-10 rounded-md border border-gray-300 text-gray-700">
          <span class="sr-only">Buka menu</span>
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <div class="text-sm text-gray-500">Menu</div>
        <div class="w-10" aria-hidden="true"></div>
      </div>
    </div>

    {{-- Sidebar --}}
    <aside id="sidebar" class="flex flex-col w-full sm:w-64 bg-gray-800/90 text-gray-100 border-r border-gray-700 min-h-screen overflow-y-auto overscroll-contain hidden md:block md:translate-x-0 fixed inset-y-0 left-0 z-50 transform -translate-x-full transition-transform duration-200">
      <div class="px-6 py-6">
        <h2 class="font-serif text-2xl italic">La Fleur a Tory</h2>
      </div>

      <nav class="px-4 space-y-3">
        @if($isOwner)
            <a href="{{ route('admin.dashboard') }}"class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-white shadow-sm text-gray-800' : 'text-white-500 hover:text-white-800' }}">
              <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V9m6 8V5" />
              </svg>
              <span>Dashboard</span>
            </a>
        @endif
        {{-- Kasir + dropdown cabang --}}
        <div class="mb-1">
        {{-- Langsung arahkan ke route kasir dengan parameter cabang milik user yang login --}}
        {{-- Asumsi: Di tabel users ada relasi 'cabang' atau kolom 'cabang_id' --}}

        <a href="{{ route('admin.kasir', ['cabang' => auth()->user()->cabang->nama_cabang]) }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg w-full transition-colors {{ request()->routeIs('admin.kasir') ? 'bg-white shadow-sm text-gray-800' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
          <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l1-5H6l1 5z" />
            <circle cx="10" cy="19" r="1" />
            <circle cx="18" cy="19" r="1" />
          </svg>
          <span class="font-medium">Kasir</span>
        </a>
        </a>

</div>
        </div>
        @if($isOwner)
            <a href="{{ route('tambahproduk.index') }}"class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('tambahproduk.index') ? 'bg-white shadow-sm text-gray-800' : 'text-white-200 hover:text-white-800' }}">
              <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8M8 12h8" />
              </svg>
              <span>Tambah Produk</span>
            </a>

            @endif
            <div class="relative">
            <!-- Link Stok -->
            <a href="{{ route('stok.index') }}" id="stok-toggle" class="flex items-center justify-between w-full gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('stok.index') ? 'bg-white shadow-sm text-gray-800' : 'text-white-200 hover:text-white-800' }}">
            <div class="flex items-center gap-3">
              <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 16V8a2 2 0 00-1-1.732l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.732l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8v8M17 8v8" />
              </svg>
              <span>Stok</span>
            </div>
            <!-- Ikon panah -->
            <svg id="stok-arrow" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5l7 7-7 7"/>
            </svg>
            </a>
            </div>
            <!-- Dropdown Cabang -->
            <div id="stok-dropdown" class="ml-8 mt-1 flex flex-col gap-1 hidden">
                @forelse($cabangs ?? [] as $cabang)
                    <a href="{{ route('stok.index', ['cabang' => $cabang->nama_cabang]) }}"
                       class="px-2 py-1 rounded text-sm {{ request('cabang') == $cabang->nama_cabang ? 'bg-gray-200 font-semibold text-gray-900' : 'text-white-200 hover:text-white-800 hover:bg-white-100' }}">
                        {{ $cabang->nama_cabang }}
                    </a>
                @empty
                    <span class="px-2 py-1 text-xs text-gray-400">Belum ada cabang</span>
                @endforelse
            </div>

            <a href="{{ route('admin.retur.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.retur.index') ? 'bg-white shadow-sm text-gray-800' : 'text-white-200 hover:text-white-800' }}">
              <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h7l-1-2m0 0L9 6m12 8h-7l1 2m0 0l1 2" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-9-9" />
              </svg>
              <span>Retur</span>
            </a>

            <a href="{{ route('admin.laporan') }}"class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.laporan') ? 'bg-white shadow-sm text-gray-800' : 'text-white-200 hover:text-white-800' }}">
              <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6m6 6V7" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h7" />
              </svg>
              <span>Laporan</span>
            </a>
            @if($isOwner)
            <a href="{{ route('tambahcabang.index') }}"class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('tambahcabang.index') ? 'bg-white shadow-sm text-gray-800' : 'text-white-200 hover:text-white-800' }}">
              <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M8 21V10h8v11" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7V3" />
              </svg>

              <span>Tambah Cabang</span>
            </a>
            @endif
      </nav>

      <div class="mt-auto px-4 py-6">
        <button id="open-logout-modal" class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded-md bg-red-600 text-white hover:bg-red-700">
          <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16v1a2 2 0 002 2h6" />
          </svg>
          <span>Logout</span>
        </button>
      </div>
    </aside>
    <div id="sidebar-backdrop" class="hidden fixed inset-0 bg-black/40 z-40 md:hidden"></div>
    <script>
    // Ambil elemen
    const stokToggle = document.getElementById('stok-toggle');
    const stokDropdown = document.getElementById('stok-dropdown');
    const stokArrow = document.getElementById('stok-arrow');
    // Kasir dropdown
    const kasirToggle = document.getElementById('kasir-toggle');
    const kasirDropdown = document.getElementById('kasir-dropdown');
    const kasirArrow = document.getElementById('kasir-arrow');
    // Sidebar mobile toggle
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const sidebar = document.getElementById('sidebar');
    const sidebarBackdrop = document.getElementById('sidebar-backdrop');

    // Toggle dropdown saat klik menu Stok
    if (stokToggle) {
      stokToggle.addEventListener('click', function(e) {
          e.preventDefault();
          stokDropdown?.classList.toggle('hidden');          // show/hide dropdown
          stokArrow?.classList.toggle('rotate-90');          // putar panah
      });
    }
    // Toggle dropdown saat klik menu Kasir
    if (kasirToggle) {
      kasirToggle.addEventListener('click', function(e) {
          e.preventDefault();
          kasirDropdown?.classList.toggle('hidden');
          kasirArrow?.classList.toggle('rotate-90');
      });
    }
    document.addEventListener('DOMContentLoaded', function() {
    const cabangAktif = "{{ request('cabang') }}";
    if (cabangAktif) {
        // Buka dropdown jika ada cabang aktif
        if (stokDropdown && stokArrow && "{{ request()->routeIs('stok.index') ? '1' : '' }}") {
          stokDropdown.classList.remove('hidden');
          stokArrow.classList.add('rotate-90');
        }
        if (kasirDropdown && kasirArrow && "{{ request()->routeIs('admin.kasir') ? '1' : '' }}") {
          kasirDropdown.classList.remove('hidden');
          kasirArrow.classList.add('rotate-90');
        }
    }
    // Toggle sidebar (mobile)
    function openSidebar() {
      if (!sidebar) return;
      sidebar.classList.remove('hidden');
      sidebar.classList.remove('-translate-x-full');
      if (sidebarBackdrop) sidebarBackdrop.classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    }
    function closeSidebar() {
      if (!sidebar) return;
      sidebar.classList.add('-translate-x-full');
      if (sidebarBackdrop) sidebarBackdrop.classList.add('hidden');
      // jangan hidden supaya tetap ada untuk md ke atas
      document.body.style.overflow = '';
    }
    if (mobileMenuButton) {
      mobileMenuButton.addEventListener('click', function(e){ e.preventDefault(); openSidebar(); });
    }
    if (sidebarBackdrop) {
      sidebarBackdrop.addEventListener('click', closeSidebar);
    }
    document.addEventListener('keydown', function(e){ if (e.key === 'Escape') closeSidebar(); });

    // Modal Logout
    const openLogoutBtn = document.getElementById('open-logout-modal');
    const logoutModal = document.getElementById('logout-modal');
    const logoutBackdrop = document.getElementById('logout-modal-backdrop');
    const cancelLogoutBtn = document.getElementById('cancel-logout');
    function openLogoutModal(){ if(!logoutModal||!logoutBackdrop) return; logoutModal.classList.remove('hidden'); logoutBackdrop.classList.remove('hidden'); document.body.style.overflow='hidden'; }
    function closeLogoutModal(){ if(!logoutModal||!logoutBackdrop) return; logoutModal.classList.add('hidden'); logoutBackdrop.classList.add('hidden'); document.body.style.overflow=''; }
    if (openLogoutBtn) openLogoutBtn.addEventListener('click', function(e){ e.preventDefault(); openLogoutModal(); });
    if (cancelLogoutBtn) cancelLogoutBtn.addEventListener('click', function(e){ e.preventDefault(); closeLogoutModal(); });
    if (logoutBackdrop) logoutBackdrop.addEventListener('click', closeLogoutModal);
    document.addEventListener('keydown', function(e){ if (e.key === 'Escape') closeLogoutModal(); });
});
</script>


    {{-- Modal konfirmasi logout --}}
    <div id="logout-modal-backdrop" class="hidden fixed inset-0 bg-black/40 z-40"></div>
    <div id="logout-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
      <div class="w-full max-w-md rounded-lg bg-white shadow-xl border border-gray-200">
        <div class="px-5 py-4 border-b border-gray-100">
          <h3 class="text-lg font-semibold text-gray-800">Konfirmasi Logout</h3>
        </div>
        <div class="px-5 py-4 text-gray-600">Apakah Anda yakin ingin keluar dari aplikasi?</div>
        <div class="px-5 py-4 flex items-center justify-end gap-3 border-t border-gray-100">
          <button id="cancel-logout" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">Batal</button>
          <a href="{{ route('awal') }}" class="px-4 py-2 rounded-md bg-red-600 text-white hover:bg-red-700">Keluar</a>
        </div>
      </div>
    </div>

    {{-- INI BAGIAN PENTING: Tempat isi konten dari @section('content') --}}
    <main class="flex-1 pt-14 md:pt-0 md:ml-64">
        @yield('content')
    </main>

</body>
</html>
