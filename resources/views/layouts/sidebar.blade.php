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
    <aside id="sidebar" class="flex flex-col w-full sm:w-64 bg-[#151D29] text-gray-100 border-r border-gray-800/60 h-screen overflow-y-auto custom-scrollbar fixed inset-y-0 left-0 z-50 transform -translate-x-full transition-transform duration-200 md:block md:translate-x-0">
      <div class="px-6 py-6 border-b border-gray-800/80">
        <a href="{{ route('company.profile') }}" class="font-serif text-2xl italic hover:text-white transition-colors flex items-center gap-2 group">
          <img src="{{ asset('images/logo_bunga.png') }}" alt="Logo" class="w-8 h-8 object-contain invert brightness-200">
          <span style="font-family: 'Great Vibes', cursive;">La Fleur a Tory</span>
        </a>
      </div>

      <style>
        .custom-scrollbar::-webkit-scrollbar {
          width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
          background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
          background: rgba(255, 255, 255, 0.1);
          border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
          background: rgba(255, 255, 255, 0.2);
        }
      </style>
      <nav class="px-4 py-6 space-y-2">
        @if($isOwner)
            <a href="{{ route('admin.dashboard') }}"class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-white shadow-sm text-gray-800' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
              <svg class="w-5 h-5 text-gray-405" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <a href="{{ route('tambahproduk.index') }}"class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('tambahproduk.index') ? 'bg-white shadow-sm text-gray-800' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
              <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8M8 12h8" />
              </svg>
              <span>Tambah Produk</span>
            </a>
        @endif
        
        <div class="relative">
            <!-- Link Stok -->
            <a href="{{ route('stok.index') }}" id="stok-toggle" class="flex items-center justify-between w-full gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('stok.index') ? 'bg-white shadow-sm text-gray-800' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                <div class="flex items-center gap-3">
                  <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 16V8a2 2 0 00-1-1.732l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.732l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8v8M17 8v8" />
                  </svg>
                  <span>Stok</span>
                </div>
                <!-- Ikon panah -->
                <svg id="stok-arrow" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        
        <!-- Dropdown Cabang -->
        <div id="stok-dropdown" class="ml-8 mt-1 flex flex-col gap-1 hidden">
            @forelse($cabangs ?? [] as $cabang)
                <a href="{{ route('stok.index', ['cabang' => $cabang->nama_cabang]) }}"
                   class="px-3 py-1.5 rounded-lg text-sm transition-all {{ request('cabang') == $cabang->nama_cabang ? 'bg-white font-semibold text-gray-900 shadow-sm' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                    {{ $cabang->nama_cabang }}
                </a>
            @empty
                <span class="px-2 py-1 text-xs text-gray-400">Belum ada cabang</span>
            @endforelse
        </div>

        <a href="{{ route('admin.retur.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.retur.index') ? 'bg-white shadow-sm text-gray-800' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
          <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h7l-1-2m0 0L9 6m12 8h-7l1 2m0 0l1 2" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-9-9" />
          </svg>
          <span>Retur</span>
        </a>

        <a href="{{ route('admin.laporan') }}"class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.laporan') ? 'bg-white shadow-sm text-gray-800' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
          <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6m6 6V7" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h7" />
          </svg>
          <span>Laporan</span>
        </a>
        
        @if($isOwner)
            <a href="{{ route('tambahcabang.index') }}"class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('tambahcabang.index') ? 'bg-white shadow-sm text-gray-800' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
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
    if (openLogoutBtn) {
      openLogoutBtn.addEventListener('click', async function(e){
        e.preventDefault();
        const confirm = await window.customConfirm('Konfirmasi Logout', 'Apakah Anda yakin ingin keluar dari aplikasi?', 'danger');
        if (confirm) {
          window.location.href = "{{ route('awal') }}";
        }
      });
    }

    // Intercept delete forms globally
    document.addEventListener('submit', async function(e) {
      const form = e.target;
      if (form.classList.contains('delete-form')) {
        e.preventDefault();
        const message = form.getAttribute('data-confirm') || 'Apakah Anda yakin ingin menghapus data ini?';
        const title = form.getAttribute('data-title') || 'Konfirmasi Hapus';
        const confirmed = await window.customConfirm(title, message, 'danger');
        if (confirmed) {
          form.className = form.className.replace('delete-form', '');
          form.submit();
        }
      }
    });
});
</script>

{{-- === CUSTOM CONFIRMATION / ALERT MODAL (GLOBAL) === --}}
<div id="custom-modal" class="fixed inset-0 z-[9999] flex items-center justify-center hidden">
  <!-- Backdrop -->
  <div class="absolute inset-0 bg-[#151D29]/60 backdrop-blur-sm transition-opacity"></div>
  
  <!-- Modal Card -->
  <div class="relative bg-white rounded-2xl max-w-sm w-full mx-4 overflow-hidden border border-gray-100 shadow-2xl transform scale-95 opacity-0 transition-all duration-200 z-10" id="custom-modal-card">
    <div class="p-6">
      <div class="flex items-center justify-center w-12 h-12 rounded-full mb-4 mx-auto" id="custom-modal-icon-container">
        <!-- Icon injected dynamically -->
      </div>
      <h3 class="text-base font-bold text-gray-900 text-center mb-2" id="custom-modal-title">Konfirmasi</h3>
      <p class="text-xs text-gray-500 text-center leading-relaxed" id="custom-modal-message">Apakah Anda yakin?</p>
    </div>
    <div class="bg-gray-50/50 px-6 py-4 flex items-center justify-end gap-3 border-t border-gray-150/50" id="custom-modal-actions">
      <button id="custom-modal-cancel" class="px-4 py-2 rounded-xl border border-gray-200 text-gray-650 hover:bg-gray-100 transition text-xs font-bold">Batal</button>
      <button id="custom-modal-confirm" class="px-4 py-2 rounded-xl bg-[#151D29] text-white hover:bg-[#1a2534] transition text-xs font-bold">Lanjutkan</button>
    </div>
  </div>
</div>

<script>
window.showCustomConfirm = function(options) {
  return new Promise((resolve) => {
    const modal = document.getElementById('custom-modal');
    const card = document.getElementById('custom-modal-card');
    const iconContainer = document.getElementById('custom-modal-icon-container');
    const titleEl = document.getElementById('custom-modal-title');
    const msgEl = document.getElementById('custom-modal-message');
    const cancelBtn = document.getElementById('custom-modal-cancel');
    const confirmBtn = document.getElementById('custom-modal-confirm');
    
    titleEl.textContent = options.title || 'Konfirmasi';
    msgEl.textContent = options.message || '';
    
    iconContainer.className = "flex items-center justify-center w-12 h-12 rounded-full mb-4 mx-auto";
    
    if (options.type === 'danger') {
      iconContainer.className += " bg-red-50 text-red-500";
      iconContainer.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>';
      confirmBtn.className = "px-4 py-2 rounded-xl bg-red-600 text-white hover:bg-red-700 transition text-xs font-bold";
    } else if (options.type === 'success') {
      iconContainer.className += " bg-green-50 text-green-500";
      iconContainer.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
      confirmBtn.className = "px-4 py-2 rounded-xl bg-green-650 text-white hover:bg-green-700 transition text-xs font-bold";
    } else {
      iconContainer.className += " bg-blue-50 text-blue-500";
      iconContainer.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
      confirmBtn.className = "px-4 py-2 rounded-xl bg-[#151D29] text-white hover:bg-[#1a2534] transition text-xs font-bold";
    }
    
    if (options.isAlert) {
      cancelBtn.classList.add('hidden');
      confirmBtn.textContent = options.confirmText || 'OK';
    } else {
      cancelBtn.classList.remove('hidden');
      cancelBtn.textContent = options.cancelText || 'Batal';
      confirmBtn.textContent = options.confirmText || 'Ya, Lanjutkan';
    }
    
    modal.classList.remove('hidden');
    setTimeout(() => {
      card.classList.remove('scale-95', 'opacity-0');
      card.classList.add('scale-100', 'opacity-100');
    }, 10);
    
    function close() {
      card.classList.remove('scale-100', 'opacity-100');
      card.classList.add('scale-95', 'opacity-0');
      setTimeout(() => {
        modal.classList.add('hidden');
      }, 200);
    }
    
    const onConfirm = () => {
      close();
      confirmBtn.removeEventListener('click', onConfirm);
      cancelBtn.removeEventListener('click', onCancel);
      resolve(true);
    };
    
    const onCancel = () => {
      close();
      confirmBtn.removeEventListener('click', onConfirm);
      cancelBtn.removeEventListener('click', onCancel);
      resolve(false);
    };
    
    confirmBtn.addEventListener('click', onConfirm);
    cancelBtn.addEventListener('click', onCancel);
  });
};

window.customAlert = (title, message, type = 'info') => {
  return window.showCustomConfirm({ title, message, type, isAlert: true });
};

window.customConfirm = (title, message, type = 'info') => {
  return window.showCustomConfirm({ title, message, type, isAlert: false });
};
</script>

    {{-- INI BAGIAN PENTING: Tempat isi konten dari @section('content') --}}
    <main class="flex-1 pt-14 md:pt-0 md:ml-64">
        @yield('content')
    </main>

</body>
</html>
