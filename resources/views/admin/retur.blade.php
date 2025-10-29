@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen p-6 bg-gradient-to-b from-gray-200 to-gray-100">
  <div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-4">
      <div>
        <h1 class="text-2xl font-semibold text-gray-800">Daftar Retur</h1>
        <p class="text-sm text-gray-500">Kelola data retur produk cabang.</p>
      </div>

      <div class="flex items-center gap-3">
        <div class="flex gap-2">
          <select class="px-3 py-2 bg-white border border-gray-200 rounded text-sm">
            <option>Filter Barang</option>
          </select>
          <select class="px-3 py-2 bg-white border border-gray-200 rounded text-sm">
            <option>Filter Tanggal</option>
          </select>
        </div>

        <button id="btn-open-create" class="ml-2 inline-flex items-center justify-center w-9 h-9 bg-white border border-gray-200 rounded shadow hover:bg-gray-50" title="Tambah Retur">
          <span class="text-xl leading-none text-gray-700">+</span>
        </button>
      </div>
    </div>

    <section class="bg-white rounded-lg shadow-md overflow-hidden">
      <div class="p-4 border-b border-gray-200">
        <p class="text-sm text-gray-500">Daftar retur produk di cabang.</p>
      </div>

      <div class="p-4">
        @php
          $rows = $returs ?? collect([
            (object)['kode'=>'Rm-010925','nama'=>'Roti Manis','jumlah'=>30,'tanggal'=>'2025-09-03','alasan'=>'Lebih dari 3 hari'],
          ]);
        @endphp

        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Kode</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Nama Barang</th>
                <th class="px-6 py-3 text-center text-sm font-medium text-gray-600">Jumlah</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Tanggal</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Alasan</th>
                <th class="px-6 py-3 text-center text-sm font-medium text-gray-600">Aksi</th>
              </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-100">
              @foreach($rows as $retur)
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $retur->kode ?? $retur['kode'] }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $retur->nama ?? $retur['nama'] }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">{{ $retur->jumlah ?? $retur['jumlah'] }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                  {{ \Carbon\Carbon::parse($retur->tanggal ?? ($retur['tanggal'] ?? null))->format('d/m/Y') ?? ($retur['tanggal'] ?? '') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $retur->alasan ?? $retur['alasan'] }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                  <div class="inline-flex items-center gap-2">
                    <button
                      class="inline-flex items-center gap-2 px-3 py-1 bg-white border border-gray-200 rounded text-sm text-gray-700 hover:bg-gray-50 open-view"
                      data-kode="{{ $retur->kode ?? $retur['kode'] }}"
                      data-nama="{{ $retur->nama ?? $retur['nama'] }}"
                      data-jumlah="{{ $retur->jumlah ?? $retur['jumlah'] }}"
                      data-tanggal="{{ \Carbon\Carbon::parse($retur->tanggal ?? ($retur['tanggal'] ?? null))->format('d/m/y') ?? '' }}"
                      data-alasan="{{ $retur->alasan ?? $retur['alasan'] }}"
                    >Lihat</button>

                    <button
                      class="inline-flex items-center gap-2 px-3 py-1 bg-white border border-gray-200 rounded text-sm text-gray-700 hover:bg-gray-50 open-edit"
                      data-kode="{{ $retur->kode ?? $retur['kode'] }}"
                      data-id="{{ $retur->id ?? '' }}"
                      data-nama="{{ $retur->nama ?? $retur['nama'] }}"
                      data-jumlah="{{ $retur->jumlah ?? $retur['jumlah'] }}"
                      data-tanggal="{{ \Carbon\Carbon::parse($retur->tanggal ?? ($retur['tanggal'] ?? null))->format('Y-m-d') ?? '' }}"
                      data-alasan="{{ $retur->alasan ?? $retur['alasan'] }}"
                      data-update-url="{{ route('admin.retur.update', $retur->kode ?? ($retur['kode'] ?? '#')) }}"
                    >Edit</button>

                    <button
                      type="button"
                      class="inline-flex items-center justify-center w-9 h-9 bg-white border border-gray-200 rounded text-gray-600 hover:bg-gray-50 open-delete"
                      data-delete-url="{{ route('admin.retur.destroy', $retur->kode ?? ($retur['kode'] ?? '#')) }}"
                      data-kode="{{ $retur->kode ?? $retur['kode'] }}"
                      data-nama="{{ $retur->nama ?? $retur['nama'] }}"
                    >
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                      </svg>
                    </button>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="mt-4 flex items-center justify-between">
          <div class="text-sm text-gray-500">Menampilkan {{ $rows->count() }} entri</div>
          <div class="flex items-center gap-2">
            <button class="px-3 py-1 border border-gray-200 rounded text-sm text-gray-700 hover:bg-gray-50">Export</button>
            <button class="px-3 py-1 border border-gray-200 rounded text-sm text-gray-700 hover:bg-gray-50" onclick="location.reload()">Refresh</button>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>

<!-- View Modal -->
<div id="modal-view" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
  <div class="bg-white rounded-lg w-full max-w-2xl shadow-lg overflow-hidden">
    <div class="flex items-center justify-between px-6 py-3 border-b">
      <h3 class="text-lg font-semibold">Lihat Retur</h3>
      <button class="text-gray-600 close-modal" data-target="modal-view">✕</button>
    </div>
    <div class="p-6 space-y-4">
      <div><strong>Kode:</strong> <span id="view-kode" class="text-gray-800"></span></div>
      <div><strong>Nama Barang:</strong> <span id="view-nama" class="text-gray-800"></span></div>
      <div><strong>Jumlah Retur:</strong> <span id="view-jumlah" class="text-gray-800"></span></div>
      <div><strong>Tanggal:</strong> <span id="view-tanggal" class="text-gray-800"></span></div>
      <div><strong>Alasan:</strong>
        <p id="view-alasan" class="mt-2 p-3 bg-gray-50 rounded border text-gray-700"></p>
      </div>
    </div>
    <div class="px-6 py-3 border-t text-right">
      <button class="px-4 py-2 bg-gray-700 text-white rounded close-modal" data-target="modal-view">Tutup</button>
    </div>
  </div>
</div>

<!-- Edit/Create Modal -->
<div id="modal-edit" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4" role="dialog" aria-modal="true" aria-labelledby="modal-edit-title">
  <div class="bg-white rounded-lg w-full max-w-3xl shadow-lg overflow-hidden transform transition-all scale-95">
    <form id="form-edit" method="POST" action="{{ route('admin.retur.store') }}">
      @csrf

      <div class="flex items-center justify-between px-6 py-4 border-b">
        <div class="flex items-center gap-4">
          <img src="{{ asset('images/logo.png') }}" alt="logo" class="w-8 h-8 object-contain">
          <h3 id="modal-edit-title" class="text-xl font-semibold text-gray-800">Form Retur Barang</h3>
        </div>

        <div class="flex items-center gap-3">
          <button type="button" class="text-gray-600 close-modal" data-target="modal-edit" aria-label="Close">✕</button>
          <button type="submit" class="ml-2 px-4 py-2 bg-[#3b2a29] text-white rounded-full shadow">Simpan</button>
        </div>
      </div>

      <div class="p-6 space-y-4">
        <input type="hidden" id="edit-kode" name="kode" value="">
        <input type="hidden" id="edit-id" name="id" value="">

        <div class="grid grid-cols-12 gap-4 items-center">
          <label class="col-span-3 text-sm font-medium text-gray-700">Nama Barang</label>
          <div class="col-span-9">
            <select id="edit-nama" name="nama" class="w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-3 text-gray-700 focus:border-[#3b2a29] focus:ring-[#3b2a29]">
              <option value="" disabled selected>Pilih Barang</option>
              @foreach($produk ?? [] as $p)
                <option value="{{ $p['nama'] }} [{{ $p['kode'] ?? '' }}]">{{ $p['nama'] }} [{{ $p['kode'] ?? '' }}]</option>
              @endforeach
            </select>
          </div>

          <label class="col-span-3 text-sm font-medium text-gray-700">Jumlah Retur</label>
          <div class="col-span-9">
            <input id="edit-jumlah" name="jumlah" type="number" min="1" placeholder="Jumlah Retur" class="w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-3 text-gray-700 focus:border-[#3b2a29] focus:ring-[#3b2a29]" />
          </div>

          <label class="col-span-3 text-sm font-medium text-gray-700">Tanggal Retur</label>
          <div class="col-span-9">
            <input id="edit-tanggal" name="tanggal" type="date" class="w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-3 text-gray-700 focus:border-[#3b2a29] focus:ring-[#3b2a29]" />
          </div>

          <label class="col-span-3 text-sm font-medium text-gray-700">Alasan</label>
          <div class="col-span-9">
            <textarea id="edit-alasan" name="alasan" rows="5" placeholder="Tuliskan alasan retur" class="w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-3 text-gray-700 focus:border-[#3b2a29] focus:ring-[#3b2a29]"></textarea>
          </div>
        </div>
      </div>

      <div class="px-6 py-3 border-t text-right">
        <button type="button" class="px-4 py-2 bg-gray-200 rounded close-modal" data-target="modal-edit">Batal</button>
      </div>
    </form>
  </div>
</div>

<!-- Delete Modal -->
<div id="modal-delete" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm px-4">
  <div class="bg-white rounded-2xl w-full max-w-md shadow-xl overflow-hidden transform transition-all scale-95 hover:scale-100 duration-300">
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
      <h3 class="text-xl font-semibold text-gray-800">Konfirmasi Hapus</h3>
      <button class="text-gray-500 hover:text-gray-700 text-2xl close-modal" data-target="modal-delete">×</button>
    </div>

    <div class="p-6 text-center">
      <p class="text-gray-600">Apakah Anda yakin ingin menghapus retur berikut?</p>
      <p class="mt-4 text-lg font-semibold text-gray-900" id="delete-info">Data Retur</p>
    </div>

    <div class="px-6 py-4 border-t border-gray-200 flex justify-center gap-4">
      <button class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-xl text-lg font-medium transition-all close-modal" data-target="modal-delete">Batal</button>

      <form id="form-delete" method="POST" action="#" class="inline-block">
        @csrf
        @method('DELETE')
        <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl text-lg font-medium transition-all">Hapus</button>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // Open create
  document.getElementById('btn-open-create')?.addEventListener('click', function () {
    const form = document.getElementById('form-edit');
    form.reset();
    form.action = "{{ route('admin.retur.store') }}";
    const methodInput = form.querySelector('input[name=\"_method\"]');
    if (methodInput) methodInput.remove();
    document.getElementById('edit-kode').value = '';
    document.getElementById('modal-edit').classList.remove('hidden');
  });

  // View
  document.querySelectorAll('.open-view').forEach(btn => btn.addEventListener('click', function () {
    document.getElementById('view-kode').textContent = this.dataset.kode || '';
    document.getElementById('view-nama').textContent = this.dataset.nama || '';
    document.getElementById('view-jumlah').textContent = this.dataset.jumlah || '';
    document.getElementById('view-tanggal').textContent = this.dataset.tanggal || '';
    document.getElementById('view-alasan').textContent = this.dataset.alasan || '';
    document.getElementById('modal-view').classList.remove('hidden');
  }));

  // Edit
  document.querySelectorAll('.open-edit').forEach(btn => btn.addEventListener('click', function () {
    const kode = this.dataset.kode || '';
    const nama = this.dataset.nama || '';
    const jumlah = this.dataset.jumlah || '';
    const tanggal = this.dataset.tanggal || '';
    const alasan = this.dataset.alasan || '';
    const updateUrl = this.dataset.updateUrl || '#';

    const form = document.getElementById('form-edit');
    form.action = updateUrl;

    let methodInput = form.querySelector('input[name=\"_method\"]');
    if (!methodInput) {
      methodInput = document.createElement('input');
      methodInput.type = 'hidden';
      methodInput.name = '_method';
      form.appendChild(methodInput);
    }
    methodInput.value = 'PUT';

    document.getElementById('edit-kode').value = kode;

    const selectNama = document.getElementById('edit-nama');
    if (selectNama.querySelector('option[value=\"'+nama+'\"]')) {
      selectNama.value = nama;
    } else {
      const opt = document.createElement('option');
      opt.value = nama;
      opt.text = nama;
      opt.selected = true;
      selectNama.appendChild(opt);
    }

    document.getElementById('edit-tanggal').value = tanggal || '';
    document.getElementById('edit-jumlah').value = jumlah;
    document.getElementById('edit-alasan').value = alasan;

    document.getElementById('modal-edit').classList.remove('hidden');
  }));

  // Delete
  document.querySelectorAll('.open-delete').forEach(btn => btn.addEventListener('click', function () {
    const delUrl = this.dataset.deleteUrl || '#';
    const kode = this.dataset.kode || '';
    const nama = this.dataset.nama || '';
    document.getElementById('delete-info').textContent = kode + ' — ' + nama;
    const formDelete = document.getElementById('form-delete');
    formDelete.action = delUrl;
    document.getElementById('modal-delete').classList.remove('hidden');
  }));

  // Close handlers
  document.querySelectorAll('.close-modal').forEach(btn => btn.addEventListener('click', function () {
    const target = this.dataset.target;
    if (target) document.getElementById(target).classList.add('hidden');
    else this.closest('[id^=\"modal-\"]')?.classList.add('hidden');
  }));

  // overlay click & Esc
  document.querySelectorAll('[id^=\"modal-\"]').forEach(modal => {
    modal.addEventListener('click', function (e) {
      if (e.target === modal) modal.classList.add('hidden');
    });
  });
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape') document.querySelectorAll('[id^=\"modal-\"]').forEach(m=>m.classList.add('hidden')); });
});
</script>
@endsection
