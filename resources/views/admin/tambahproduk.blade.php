@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen p-6 bg-gray-100">
  <div class="max-w-6xl mx-auto">
    <!-- Top bar -->
    <header class="bg-gray-800/90 text-gray-100 rounded-lg px-6 py-4 flex items-center justify-between mb-6">
      <div>
        <h2 class="text-xl font-semibold">Kasir Cabang B</h2>
        <p class="text-sm text-gray-300">Halo, <span class="font-medium">[Nama User]</span>!</p>
      </div>
      <div class="flex items-center gap-4">
        <button class="p-2 rounded-full bg-gray-700/40 hover:bg-gray-700 transition">
          <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5" />
          </svg>
        </button>
        <div class="w-10 h-10 rounded-full bg-gray-600 flex items-center justify-center font-medium">U</div>
      </div>
    </header>

    <section class="bg-white rounded-lg shadow-md overflow-hidden">
      <div class="p-6">

         <div class="flex justify-end mb-4">
            <button
                type="button"
                id="btn-open-modal"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition duration-200">
                + Tambah Produk
            </button>
         </div>

          <div class="overflow-x-auto bg-white rounded shadow-sm border">
<table class="min-w-full border border-gray-200 rounded-lg">
    <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">No</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Nama Produk</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Harga</th>
            <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Tanggal Kadaluarsa</th>
            <th class="px-4 py-3 text-center text-sm font-medium text-gray-600">Aksi</th>
        </tr>
    </thead>
    <tbody class="bg-white">
        @forelse ($produks as $index => $produk)
        <tr class="border-b hover:bg-gray-50">
            <td class="px-4 py-3 text-sm text-gray-700">{{ $index + 1 }}</td>
            <td class="px-4 py-3 text-sm text-gray-700">{{ $produk->nama }}</td>
            <td class="px-4 py-3 text-sm text-gray-700">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
            <td class="px-4 py-3 text-sm text-gray-700">
                {{ $produk->tanggal_kadaluarsa ? \Carbon\Carbon::parse($produk->tanggal_kadaluarsa)->format('d-m-Y') : '-' }}
            </td>
            <td class="px-4 py-3 text-center">
                <form action="{{ route('tambahproduk.destroy', $produk->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="px-4 py-3 text-center text-gray-500">Belum ada data produk</td>
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

<!-- Modal -->
<div id="modal-add-product" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
  <div class="bg-white rounded-lg w-full max-w-lg shadow-lg overflow-hidden">
    <div class="flex items-center justify-between px-6 py-4 border-b">
      <h3 class="text-lg font-semibold">Tambah Produk</h3>
      <button id="modal-close" class="text-gray-600">✕</button>
    </div>

    <!-- FORM -->
    <form action="{{ route('tambahproduk.store') }}" method="POST" class="p-6 space-y-4">
      @csrf
      <div class="grid grid-cols-12 gap-4">
        <label class="col-span-3 text-sm font-medium text-gray-700">Nama</label>
        <div class="col-span-9">
          <input name="nama" class="w-full rounded border px-2 py-2" placeholder="Nama Produk" required>
        </div>

        <label class="col-span-3 text-sm font-medium text-gray-700">Harga</label>
        <div class="col-span-9 flex items-center">
          <span class="px-2 text-gray-500">Rp</span>
          <input name="harga" type="number" min="0" class="w-full rounded border px-2 py-2" placeholder="0" required>
        </div>

        <label class="col-span-3 text-sm font-medium text-gray-700">Tanggal Kadaluarsa</label>
        <div class="col-span-9">
          <input name="tanggal_kadaluarsa" type="date" class="w-full rounded border px-2 py-2" required>
        </div>
      </div>

      <div class="text-right">
        <button type="button" id="sp-cancel" class="px-4 py-2 bg-gray-200 rounded mr-2">Batal</button>
        <button type="submit" id="sp-save" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Tambah</button>
      </div>
    </form>
  </div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function () {
  const tbody = document.getElementById('tbody-produk');
  const btnAdd = document.getElementById('btn-add-row');

  function reindexRows() {
    Array.from(tbody.querySelectorAll('tr')).forEach((tr, idx) => {
      tr.querySelector('td:first-child').textContent = idx + 1;
      tr.querySelectorAll('input').forEach(input => {
        const name = input.getAttribute('name') || '';
        const newName = name.replace(/produk\[\d+\]/, `produk[${idx}]`);
        input.setAttribute('name', newName);
      });
    });
  }

  function createRowElement(index, data = {}) {
    const { kode = '', nama = '', kategori = '', harga = '', stok = '' } = data;
    const tr = document.createElement('tr');
    tr.className = 'border-t';
    tr.innerHTML = `
      <td class="px-4 py-3 text-sm text-gray-700">${index + 1}</td>
    <td class="px-4 py-3"><input name="produk[${index}][nama]" value="${nama}" class="w-full rounded border px-2 py-1" placeholder="Nama Produk"></td>
    <td class="px-4 py-3"><input name="produk[${index}][harga]" type="number" min="0" value="${harga}" class="w-full rounded border px-2 py-1" placeholder="0"></td>
    <td class="px-4 py-3"><input name="produk[${index}][tanggal_keluar]" type="date" class="w-full rounded border px-2 py-1"></td>
    <td class="px-4 py-3"><input name="produk[${index}][tanggal_kadaluarsa]" type="date" class="w-full rounded border px-2 py-1"></td>
    <td class="px-4 py-3"><input name="produk[${index}][stok]" type="number" min="0" value="${stok}" class="w-full rounded border px-2 py-1" placeholder="0"></td>
    <td class="px-4 py-3"><input name="produk[${index}][tanggal_masuk]" type="date" class="w-full rounded border px-2 py-1"></td>
    <td class="px-4 py-3 text-center">
      <button type="button" class="btn-remove-row w-8 h-8 bg-red-50 text-red-600 border rounded">🗑</button>
    </td>
  `;
    return tr;
  }

  btnAdd.addEventListener('click', () => {
    tbody.appendChild(createRowElement(tbody.querySelectorAll('tr').length));
  });

  tbody.addEventListener('click', e => {
    const btn = e.target.closest('.btn-remove-row');
    if (btn) {
      btn.closest('tr').remove();
      reindexRows();
    }
  });
});
document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('modal-add-product');
  const btnOpen = document.getElementById('btn-open-modal');
  const btnClose = document.getElementById('modal-close');
  const btnCancel = document.getElementById('sp-cancel');

  // Saat tombol "Tambah Produk (Popup)" diklik → tampilkan modal
  btnOpen.addEventListener('click', () => {
    modal.classList.remove('hidden');
  });

  // Saat tombol ✕ atau Batal diklik → sembunyikan modal
  [btnClose, btnCancel].forEach(btn => {
    btn.addEventListener('click', () => {
      modal.classList.add('hidden');
    });
  });

  // Klik area gelap di luar modal → juga menutup modal
  modal.addEventListener('click', (e) => {
    if (e.target === modal) modal.classList.add('hidden');
  });
});
</script>
@endsection
