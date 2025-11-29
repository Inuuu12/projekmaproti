@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen p-6 bg-gradient-to-b from-gray-200 to-gray-100">
  <div class="max-w-6xl mx-auto">

    {{-- ALERT PESAN --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- HEADER --}}
    <header class="bg-gray-800/90 text-gray-100 rounded-lg px-4 md:px-6 py-4 mb-6 sticky top-0 z-30 backdrop-blur border border-gray-700/40">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
          <h1 class="text-2xl font-semibold">Daftar Retur Barang</h1>
          <p class="text-sm text-gray-300 mt-1">
            @if($cabangDipilih)
                Data retur untuk cabang: <strong class="text-white">{{ $cabangDipilih }}</strong>
            @else
                Menampilkan semua data retur (Otomatis & Manual).
            @endif
          </p>
        </div>

        <div class="flex items-center gap-3">
          <form action="{{ route('admin.retur.index') }}" method="GET" class="flex items-center">
              <label for="filter-cabang" class="sr-only">Filter Cabang</label>
              <select id="filter-cabang" name="cabang" onchange="this.form.submit()" class="px-3 py-2 bg-white text-gray-800 border border-gray-200 rounded text-sm shadow-sm focus:ring-blue-500 focus:border-blue-500">
                  <option value="">-- Semua Cabang --</option>
                  @foreach($cabangs as $c)
                      <option value="{{ $c->nama_cabang }}" {{ $cabangDipilih == $c->nama_cabang ? 'selected' : '' }}>
                          {{ $c->nama_cabang }}
                      </option>
                  @endforeach
              </select>
          </form>

          <button id="btn-open-create" class="ml-2 inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700 transition text-sm font-medium">
            <span>+ Input Retur Manual</span>
          </button>
        </div>
      </div>
    </header>

    {{-- TABEL DATA --}}
    <section class="bg-white rounded-lg shadow-md overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cabang</th>
              <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Retur</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alasan</th>
              <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
          </thead>

          <tbody class="bg-white divide-y divide-gray-100">
            @forelse($returs as $index => $retur)
            <tr class="hover:bg-gray-50 transition hidden md:table-row">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>

              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                  {{ $retur->produk->nama ?? 'Produk Terhapus' }}
              </td>

              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                  {{ $retur->cabang }}
              </td>

              <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-bold text-red-600">
                  {{ $retur->jumlah }}
              </td>

              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                {{ \Carbon\Carbon::parse($retur->tanggal_retur)->format('d/m/Y') }}
              </td>

              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 max-w-xs truncate">
                  {{ $retur->alasan }}
              </td>

              <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                <div class="inline-flex items-center gap-2">
                  {{-- Tombol Lihat --}}
                  <button
                    class="text-blue-600 hover:text-blue-800 open-view"
                    data-nama="{{ $retur->produk->nama ?? '-' }}"
                    data-cabang="{{ $retur->cabang }}"
                    data-jumlah="{{ $retur->jumlah }}"
                    data-tanggal="{{ \Carbon\Carbon::parse($retur->tanggal_retur)->format('d F Y') }}"
                    data-alasan="{{ $retur->alasan }}"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                  </button>

                  {{-- Tombol Hapus --}}
                  <button
                    type="button"
                    class="text-red-600 hover:text-red-800 open-delete"
                    data-delete-url="{{ route('retur.destroy', $retur->id) }}"
                    data-nama="{{ $retur->produk->nama ?? '-' }}"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                  </button>
                </div>
              </td>
            </tr>

            {{-- Mobile stacked card for small screens --}}
            <tr class="md:hidden">
                <td colspan="7" class="px-4 py-3">
                    <div class="bg-white p-3 rounded-lg shadow-sm">
                        <div class="flex items-center justify-between">
                            <div class="text-sm font-semibold text-gray-800">{{ $retur->produk->nama ?? 'Produk Terhapus' }}</div>
                            <div class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($retur->tanggal_retur)->format('d/m/Y') }}</div>
                        </div>
                        <div class="mt-2 text-sm text-gray-600 grid grid-cols-2 gap-2">
                            <div>Cabang: <span class="font-medium text-gray-800">{{ $retur->cabang }}</span></div>
                            <div>Jumlah: <span class="font-medium text-red-600">{{ $retur->jumlah }}</span></div>
                            <div class="col-span-2">Alasan: <span class="font-medium text-gray-700">{{ $retur->alasan }}</span></div>
                        </div>
                        <div class="mt-3 flex gap-2">
                            <button class="flex-1 px-3 py-2 bg-blue-600 text-white rounded text-sm open-view" data-nama="{{ $retur->produk->nama ?? '-' }}" data-cabang="{{ $retur->cabang }}" data-jumlah="{{ $retur->jumlah }}" data-tanggal="{{ \Carbon\Carbon::parse($retur->tanggal_retur)->format('d F Y') }}" data-alasan="{{ $retur->alasan }}">Lihat</button>
                            <button class="flex-1 px-3 py-2 bg-red-600 text-white rounded text-sm open-delete" data-delete-url="{{ route('retur.destroy', $retur->id) }}" data-nama="{{ $retur->produk->nama ?? '-' }}">Hapus</button>
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-8 text-gray-500">
                    Belum ada data retur.
                </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </section>
  </div>
</div>

{{-- === MODAL VIEW === --}}
<div id="modal-view" class="hidden fixed inset-0 z-50 flex items-end md:items-center justify-center bg-black/60 backdrop-blur-sm px-4">
  <div class="bg-white rounded-t-lg md:rounded-lg w-full max-w-lg shadow-xl overflow-hidden transform transition-all flex flex-col h-[92vh] md:h-auto">
    <div class="px-6 py-3 md:py-4 border-b bg-gray-50 flex justify-between items-center">
      <h3 class="text-lg font-bold text-gray-800">Detail Retur</h3>
      <button class="text-gray-400 hover:text-gray-600 close-modal" data-target="modal-view">✕</button>
    </div>
    <div class="p-6 space-y-4 overflow-auto flex-1">
      <div class="grid grid-cols-3 gap-4">
          <span class="text-sm font-semibold text-gray-500">Nama Barang</span>
          <span id="view-nama" class="col-span-2 text-sm text-gray-800 font-medium"></span>

          <span class="text-sm font-semibold text-gray-500">Cabang</span>
          <span id="view-cabang" class="col-span-2 text-sm text-gray-800"></span>

          <span class="text-sm font-semibold text-gray-500">Jumlah</span>
          <span id="view-jumlah" class="col-span-2 text-sm text-red-600 font-bold"></span>

          <span class="text-sm font-semibold text-gray-500">Tanggal</span>
          <span id="view-tanggal" class="col-span-2 text-sm text-gray-800"></span>
      </div>
      <div>
        <span class="text-sm font-semibold text-gray-500 block mb-1">Alasan Retur</span>
        <div id="view-alasan" class="p-3 bg-gray-50 rounded border text-sm text-gray-700 italic"></div>
      </div>
    </div>
    <div class="px-6 py-3 border-t bg-gray-50 text-right sticky bottom-0 md:static">
      <button class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition close-modal" data-target="modal-view">Tutup</button>
    </div>
  </div>
</div>

{{-- === MODAL CREATE (INPUT MANUAL) === --}}
<div id="modal-create" class="hidden fixed inset-0 z-50 flex items-end md:items-center justify-center bg-black/60 backdrop-blur-sm px-4">
  <div class="bg-white rounded-t-lg md:rounded-lg w-full max-w-xl shadow-xl overflow-hidden flex flex-col h-[92vh] md:h-auto">
    <form action="{{ route('retur.store') }}" method="POST" class="flex flex-col flex-1 overflow-auto">
      @csrf
      <div class="px-6 py-3 md:py-4 border-b bg-gray-50 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-800">Input Retur Manual</h3>
        <button type="button" class="text-gray-400 hover:text-gray-600 close-modal" data-target="modal-create">✕</button>
      </div>

      <div class="p-6 space-y-4 flex-1 overflow-auto">
        {{-- Pilih Produk --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Barang</label>
            <select name="produk_id" required class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 text-sm">
                <option value="" disabled selected>-- Pilih Produk --</option>
                @foreach($produks as $p)
                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                @endforeach
            </select>
        </div>

        {{-- Pilih Cabang --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Cabang</label>
            <select name="cabang" required class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 text-sm">
                @foreach($cabangs as $c)
                    <option value="{{ $c->nama_cabang }}" {{ $cabangDipilih == $c->nama_cabang ? 'selected' : '' }}>
                        {{ $c->nama_cabang }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                <input type="number" name="jumlah" min="1" required class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 text-sm" placeholder="Contoh: 5">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 text-sm">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Alasan</label>
            <textarea name="alasan" rows="3" required class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 text-sm" placeholder="Contoh: Rusak saat pengiriman / Kemasan sobek"></textarea>
        </div>
      </div>

      <div class="px-6 py-4 border-t bg-gray-50 flex justify-end gap-2 sticky bottom-0 md:static">
        <button type="button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition close-modal" data-target="modal-create">Batal</button>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Simpan</button>
      </div>
    </form>
  </div>
</div>

{{-- === MODAL DELETE === --}}
<div id="modal-delete" class="hidden fixed inset-0 z-50 flex items-end md:items-center justify-center bg-black/60 backdrop-blur-sm px-4">
  <div class="bg-white rounded-t-lg md:rounded-xl w-full max-w-sm shadow-xl overflow-hidden p-6 text-center">
      <h3 class="text-xl font-bold text-gray-800 mb-2">Konfirmasi Hapus</h3>
      <p class="text-gray-600 mb-6">Yakin ingin menghapus data retur <br> <strong id="delete-info" class="text-gray-800"></strong>?</p>

      <div class="flex justify-center gap-4">
        <button class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition close-modal" data-target="modal-delete">Batal</button>
        <form id="form-delete" method="POST" action="#">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">Hapus</button>
        </form>
      </div>
  </div>
</div>

{{-- === JAVASCRIPT === --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

  // Logic Modal Create
  const btnCreate = document.getElementById('btn-open-create');
  const modalCreate = document.getElementById('modal-create');
  if(btnCreate) {
      btnCreate.addEventListener('click', () => {
          modalCreate.classList.remove('hidden');
      });
  }

  // Logic Modal View
  document.querySelectorAll('.open-view').forEach(btn => {
      btn.addEventListener('click', function() {
          document.getElementById('view-nama').textContent = this.dataset.nama;
          document.getElementById('view-cabang').textContent = this.dataset.cabang;
          document.getElementById('view-jumlah').textContent = this.dataset.jumlah + ' Pcs';
          document.getElementById('view-tanggal').textContent = this.dataset.tanggal;
          document.getElementById('view-alasan').textContent = this.dataset.alasan;
          document.getElementById('modal-view').classList.remove('hidden');
      });
  });

  // Logic Modal Delete
  document.querySelectorAll('.open-delete').forEach(btn => {
      btn.addEventListener('click', function() {
          document.getElementById('delete-info').textContent = this.dataset.nama;
          document.getElementById('form-delete').action = this.dataset.deleteUrl;
          document.getElementById('modal-delete').classList.remove('hidden');
      });
  });

  // Global Close Modal Logic
  document.querySelectorAll('.close-modal').forEach(btn => {
      btn.addEventListener('click', function() {
          const targetId = this.dataset.target;
          document.getElementById(targetId).classList.add('hidden');
      });
  });

  // Klik di luar modal menutup modal
  document.querySelectorAll('[id^="modal-"]').forEach(modal => {
      modal.addEventListener('click', function(e) {
          if(e.target === modal) {
              modal.classList.add('hidden');
          }
      });
  });

});
</script>
@endsection
