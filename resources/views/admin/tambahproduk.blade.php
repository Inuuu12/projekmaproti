@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen p-4 md:p-6 bg-gray-100">
  <div class="max-w-6xl mx-auto">
    <header class="bg-[#151D29] text-gray-100 rounded-2xl p-6 flex flex-col gap-3 md:flex-row md:items-center md:justify-between mb-6 shadow-sm border border-gray-800/60 relative overflow-hidden">
      <div class="min-w-0">
        <h2 class="text-lg md:text-xl font-bold truncate">Cabang Pusat</h2>
        <p class="text-xs text-gray-400 mt-1">Halo, <span class="font-medium text-white">[Nama User]</span>!</p>
      </div>
      <div class="flex items-center gap-3 md:gap-4">
        <button class="p-2.5 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition">
          <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5" />
          </svg>
        </button>
        <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center font-bold border border-white/10">U</div>
      </div>
    </header>

    <section class="bg-white rounded-2xl shadow-sm border border-gray-200/80 overflow-hidden">
      <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-gray-50/50">
        <div class="text-xs text-gray-500 font-bold uppercase tracking-wider">
          Daftar Semua Produk Yang Terdaftar
        </div>
        <div>
          <button id="btn-open-modal"
            class="flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 active:scale-[0.98] text-white rounded-xl transition shadow-sm font-bold text-xs uppercase tracking-wider w-full sm:w-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Tambah Produk</span>
          </button>
        </div>
      </div>

      {{-- Tabel Data Produk --}}
      <div class="overflow-x-auto">
        <table class="w-full text-sm border-collapse">
          <thead class="bg-gray-50/75 border-b border-gray-100 text-gray-500 uppercase text-[10px] font-bold tracking-wider">
            <tr>
              <th class="px-5 py-3.5 text-left font-bold">No</th>
              <th class="px-5 py-3.5 text-left font-bold">Foto</th>
              <th class="px-5 py-3.5 text-left font-bold">Nama Produk</th>
              <th class="px-5 py-3.5 text-right font-bold">Harga</th>
              <th class="px-5 py-3.5 text-left font-bold">Deskripsi</th>
              <th class="px-5 py-3.5 text-center font-bold">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100 bg-white">
            @forelse ($produks as $index => $produk)
              <tr class="hover:bg-gray-50/80 transition-all duration-200 hidden md:table-row">
                <td class="px-5 py-4 text-gray-400 text-xs font-semibold">{{ $index + 1 }}</td>
                <td class="px-5 py-4">
                  <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-100 border border-gray-200/60 shadow-sm">
                    @if($produk->foto && file_exists(public_path($produk->foto)))
                      <img src="{{ asset($produk->foto) }}" alt="Foto {{ $produk->nama }}" class="w-full h-full object-cover">
                    @else
                      <div class="w-full h-full flex items-center justify-center text-gray-400 text-[10px] font-bold uppercase">No Pic</div>
                    @endif
                  </div>
                </td>
                <td class="px-5 py-4 font-bold text-gray-800 text-sm">{{ $produk->nama }}</td>
                <td class="px-5 py-4 text-right text-gray-700 font-semibold text-sm">Rp{{ number_format($produk->harga, 0, ',', '.') }}</td>
                <td class="px-5 py-4 text-gray-600 text-sm font-medium max-w-xs truncate">{{ $produk->deskripsi ?? '-' }}</td>
                <td class="px-5 py-4 text-center">
                  <form action="{{ route('tambahproduk.destroy', $produk->id) }}" method="POST" class="delete-form inline" data-confirm="Yakin ingin menghapus produk '{{ $produk->nama }}'?" data-title="Hapus Produk">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-xs font-bold">
                      Hapus
                    </button>
                  </form>
                </td>
              </tr>

              {{-- Mobile stacked card for produk --}}
              <tr class="md:hidden">
                <td colspan="6" class="px-4 py-3">
                  <div class="bg-white p-4 rounded-xl border border-gray-150 shadow-sm space-y-2.5">
                    <div class="flex items-start gap-3">
                      <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0 border border-gray-200/60">
                        @if($produk->foto && file_exists(public_path($produk->foto)))
                          <img src="{{ asset($produk->foto) }}" alt="Foto {{ $produk->nama }}" class="w-full h-full object-cover">
                        @else
                          <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No Image</div>
                        @endif
                      </div>
                      <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2">
                          <div class="font-bold text-gray-800 truncate">{{ $produk->nama }}</div>
                          <div class="text-sm font-bold text-blue-600 flex-shrink-0">Rp{{ number_format($produk->harga, 0, ',', '.') }}</div>
                        </div>
                        <div class="mt-1 text-xs text-gray-500 font-medium truncate">{{ $produk->deskripsi ?? '-' }}</div>
                        <div class="mt-3">
                          <form action="{{ route('tambahproduk.destroy', $produk->id) }}" method="POST" class="delete-form w-full" data-confirm="Yakin ingin menghapus produk '{{ $produk->nama }}'?" data-title="Hapus Produk">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-3 py-2 bg-red-600 text-white rounded-lg font-bold text-xs">Hapus</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center text-gray-500 py-12 bg-white">
                  <div class="flex flex-col items-center justify-center gap-3">
                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <span class="font-semibold text-xs">Belum ada data produk</span>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </section>

          <p class="mt-3 text-sm text-gray-500">Catatan: pastikan field yang wajib diisi sebelum menyimpan.</p>

      </div>
    </section>
  </div>
</div>

<div id="modal-add-product" class="hidden fixed inset-0 z-50 flex items-end md:items-center justify-center bg-black/60 px-3 md:px-4 backdrop-blur-sm">
  <div class="bg-white rounded-t-2xl md:rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden h-[92vh] md:h-auto flex flex-col border border-gray-100">
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
      <h3 class="text-lg font-bold text-gray-900">Tambah Produk</h3>
      <button id="modal-close" class="text-gray-400 hover:text-gray-600 transition text-lg">✕</button>
    </div>
    <form action="{{ route('tambahproduk.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5 overflow-auto">
      @csrf
      <div class="space-y-4">

        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Nama Produk</label>
          <input name="nama" class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm placeholder-gray-400 focus:outline-none focus:border-gray-400 focus:ring-0 transition" placeholder="Nama Roti" required>
        </div>

        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Harga</label>
          <div class="flex items-center relative">
            <span class="absolute left-4 text-gray-400 text-sm">Rp</span>
            <input name="harga" type="number" min="0" class="w-full rounded-xl border border-gray-200 pl-10 pr-4 py-2.5 text-sm placeholder-gray-400 focus:outline-none focus:border-gray-400 focus:ring-0 transition" placeholder="0" required>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Deskripsi</label>
          <textarea
            name="deskripsi"
            rows="3"
            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm placeholder-gray-400 focus:outline-none focus:border-gray-400 focus:ring-0 transition"
            placeholder="Masukkan deskripsi produk..."
            required></textarea>
        </div>

        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Foto Produk</label>
          <input
            type="file"
            name="foto"
            accept="image/*"
            class="w-full rounded-xl border border-gray-200 px-4 py-2 text-sm text-gray-600 cursor-pointer file:mr-4 file:py-2 file:px-4
                   file:rounded-lg file:border-0 file:text-sm file:font-semibold
                   file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition"
            required
          >
          <p class="mt-1.5 text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Format: JPEG, PNG, JPG, GIF (Max: 2MB)</p>
        </div>

      </div>

      <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 sticky bottom-0 bg-white">
        <button type="button" id="sp-cancel" class="px-5 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-200 transition">Batal</button>
        <button type="submit" id="sp-save" class="px-5 py-2.5 bg-gray-950 text-white text-sm font-semibold rounded-xl hover:bg-gray-900 transition shadow-sm">Tambah</button>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('modal-add-product');
  const btnOpen = document.getElementById('btn-open-modal');
  const btnClose = document.getElementById('modal-close');
  const btnCancel = document.getElementById('sp-cancel');

  // Saat tombol "Tambah Produk (Popup)" diklik → tampilkan modal
  if(btnOpen) {
      btnOpen.addEventListener('click', () => {
        modal.classList.remove('hidden');
      });
  }

  // Saat tombol ✕ atau Batal diklik → sembunyikan modal
  [btnClose, btnCancel].forEach(btn => {
    if(btn) {
        btn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
    }
  });

  // Klik area gelap di luar modal → juga menutup modal
  modal.addEventListener('click', (e) => {
    if (e.target === modal) modal.classList.add('hidden');
  });
});
</script>
@endsection
