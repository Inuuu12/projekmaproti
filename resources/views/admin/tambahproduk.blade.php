@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen p-4 md:p-6 bg-gray-100">
  <div class="max-w-6xl mx-auto">
    <header class="bg-gray-800/90 text-gray-100 rounded-lg px-4 md:px-6 py-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between mb-4 md:mb-6">
      <div class="min-w-0">
        <h2 class="text-lg md:text-xl font-semibold truncate">Cabang Pusat</h2>
        <p class="text-xs md:text-sm text-gray-300">Halo, <span class="font-medium">[Nama User]</span>!</p>
      </div>
      <div class="flex items-center gap-3 md:gap-4">
        <button class="p-2 md:p-2.5 rounded-full bg-gray-700/40 hover:bg-gray-700 transition">
          <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5" />
          </svg>
        </button>
        <div class="w-10 h-10 rounded-full bg-gray-600 flex items-center justify-center font-medium">U</div>
      </div>
    </header>

    <section class="bg-white rounded-lg shadow-md overflow-hidden">
      <div class="p-4 md:p-6">

         <div class="flex justify-end mb-4">
            <button
                type="button"
                id="btn-open-modal"
              class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition duration-200">
                + Tambah Produk
            </button>
         </div>

         <div class="overflow-x-auto bg-white rounded shadow-sm border">
        <table class="min-w-full border border-gray-200 rounded-lg text-sm md:text-base">
            <thead class="bg-gray-100 text-xs md:text-sm">
                <tr>
                    <th class="px-3 md:px-4 py-3 text-left font-medium text-gray-600">No</th>
                    <th class="px-3 md:px-4 py-3 text-left font-medium text-gray-600">Foto</th>
                    <th class="px-3 md:px-4 py-3 text-left font-medium text-gray-600">Nama Produk</th>
                    <th class="px-3 md:px-4 py-3 text-left font-medium text-gray-600">Harga</th>
                    <th class="px-3 md:px-4 py-3 text-left font-medium text-gray-600">Deskripsi</th>
                    <th class="px-3 md:px-4 py-3 text-center font-medium text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @forelse ($produks as $index => $produk)
                <tr class="border-b hover:bg-gray-50 hidden md:table-row">
                  <td class="px-3 md:px-4 py-3 text-gray-700">{{ $index + 1 }}</td>
                  <td class="px-3 md:px-4 py-3">
                    <div class="w-14 h-14 rounded-lg overflow-hidden bg-gray-100">
                      @if($produk->foto && file_exists(public_path($produk->foto)))
                        <img src="{{ asset($produk->foto) }}" alt="Foto {{ $produk->nama }}" class="w-full h-full object-cover">
                      @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No Image</div>
                      @endif
                    </div>
                  </td>
                  <td class="px-3 md:px-4 py-3 text-gray-700">{{ $produk->nama }}</td>
                  <td class="px-3 md:px-4 py-3 text-gray-700">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>

                  <td class="px-3 md:px-4 py-3 text-gray-700 max-w-xs truncate">
                    {{ $produk->deskripsi ?? '-' }}
                  </td>

                  <td class="px-3 md:px-4 py-3 text-center">
                    <form action="{{ route('tambahproduk.destroy', $produk->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="bg-red-500 text-white px-3 py-1.5 rounded hover:bg-red-600">
                        Hapus
                      </button>
                    </form>
                  </td>
                </tr>

                {{-- Mobile stacked card for produk --}}
                <tr class="md:hidden">
                  <td colspan="6" class="px-3 py-3">
                    <div class="bg-white p-3 rounded-lg shadow-sm">
                      <div class="flex items-start gap-3">
                        <div class="w-16 h-16 rounded overflow-hidden bg-gray-100 flex-shrink-0">
                          @if($produk->foto && file_exists(public_path($produk->foto)))
                            <img src="{{ asset($produk->foto) }}" alt="Foto {{ $produk->nama }}" class="w-full h-full object-cover">
                          @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No Image</div>
                          @endif
                        </div>
                        <div class="flex-1">
                          <div class="flex items-center justify-between">
                            <div class="font-semibold text-gray-800">{{ $produk->nama }}</div>
                            <div class="text-gray-600">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
                          </div>
                          <div class="mt-2 text-sm text-gray-600">{{ $produk->deskripsi ?? '-' }}</div>
                          <div class="mt-3 flex gap-2">
                            <form action="{{ route('tambahproduk.destroy', $produk->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="w-full px-3 py-2 bg-red-500 text-white rounded">Hapus</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-3 md:px-4 py-3 text-center text-gray-500">Belum ada data produk</td>
                </tr>
                @endforelse
            </tbody>
        </table>
          </div>

          <p class="mt-3 text-sm text-gray-500">Catatan: pastikan field yang wajib diisi sebelum menyimpan.</p>

      </div>
    </section>
  </div>
</div>

<div id="modal-add-product" class="hidden fixed inset-0 z-50 flex items-end md:items-center justify-center bg-black/50 px-3 md:px-4">
  <div class="bg-white rounded-t-lg md:rounded-lg w-full max-w-lg shadow-lg overflow-hidden h-[92vh] md:h-auto flex flex-col">
    <div class="flex items-center justify-between px-4 md:px-6 py-3 md:py-4 border-b">
      <h3 class="text-lg font-semibold">Tambah Produk</h3>
      <button id="modal-close" class="text-gray-600">✕</button>
    </div>
    <form action="{{ route('tambahproduk.store') }}" method="POST" enctype="multipart/form-data" class="p-4 md:p-6 space-y-4 overflow-auto">
      @csrf
      <div class="grid grid-cols-1 md:grid-cols-12 gap-3 md:gap-4">

        <label class="md:col-span-3 text-sm font-medium text-gray-700">Nama</label>
        <div class="md:col-span-9">
          <input name="nama" class="w-full rounded border px-2 py-2" placeholder="Nama Produk" required>
        </div>

        <label class="md:col-span-3 text-sm font-medium text-gray-700">Harga</label>
        <div class="md:col-span-9 flex items-center">
          <span class="px-2 text-gray-500">Rp</span>
          <input name="harga" type="number" min="0" class="w-full rounded border px-2 py-2" placeholder="0" required>
        </div>

        <label class="md:col-span-3 text-sm font-medium text-gray-700">Deskripsi</label>
        <div class="md:col-span-9">
          <textarea
            name="deskripsi"
            rows="3"
            class="w-full rounded border px-2 py-2"
            placeholder="Masukkan deskripsi produk..."
            required></textarea>
        </div>

        <label class="md:col-span-3 text-sm font-medium text-gray-700">Foto Produk</label>
        <div class="md:col-span-9">
          <input
            type="file"
            name="foto"
            accept="image/*"
            class="w-full rounded border px-2 py-2 text-sm text-gray-700 cursor-pointer file:mr-4 file:py-2 file:px-4
                   file:rounded-lg file:border-0 file:text-sm file:font-semibold
                   file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
            required
          >
          <p class="mt-1 text-xs text-gray-500">Format: JPEG, PNG, JPG, GIF (Max: 2MB)</p>
        </div>

      </div>

      <div class="text-right sticky bottom-0 bg-white/60 backdrop-blur-md py-3 md:py-0 md:bg-transparent md:backdrop-blur-0">
        <button type="button" id="sp-cancel" class="px-4 py-2 bg-gray-200 rounded mr-2">Batal</button>
        <button type="submit" id="sp-save" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Tambah</button>
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
