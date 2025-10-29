@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen p-6 bg-gray-100">
  <div class="max-w-6xl mx-auto">
    <!-- Top bar -->
    <header class="bg-gray-800/90 text-gray-100 rounded-lg px-6 py-4 flex items-center justify-between mb-6">
      <div>
        <h2 class="text-xl font-semibold">Stok Produk · Cabang B</h2>
        <p class="text-sm text-gray-300">Kelola stok masuk/keluar dan kadaluarsa</p>
      </div>
    </header>

    <section class="bg-white rounded-lg shadow-md overflow-hidden">
      <div class="p-4 border-b border-gray-200 flex items-center justify-between">
        <div class="text-sm text-gray-600">Daftar stok produk di cabang.</div>
        <div class="flex items-center gap-4">
        <select id="select-cabang" class="bg-gray text-sm rounded border px-4 py-2">
          <option value="b">Cabang B</option>
          <option value="a">Cabang A</option>
        </select>
        <button id="btn-open-modal" class="px-4 py-2 bg-blue-600 text-white rounded">Tambah Stok</button>
      </div>
      </div>

      <div class="p-4">
        @php
          // sample data fallback — controller should pass $stoks (collection) to view
          $stoks = $stoks ?? collect([
            (object)['kode'=>'Rm-010925','nama'=>'Roti Manis','harga'=>5000,'produksi'=>'2025-09-01','expired'=>'2025-09-05','masuk'=>50,'keluar'=>20],
            (object)['kode'=>'Ra-210925','nama'=>'Roti a','harga'=>5000,'produksi'=>'2025-09-21','expired'=>'2025-09-26','masuk'=>50,'keluar'=>20],
            (object)['kode'=>'Rb-210925','nama'=>'Roti b','harga'=>5000,'produksi'=>'2025-09-21','expired'=>'2025-09-26','masuk'=>50,'keluar'=>20],
          ]);
        @endphp

        <div class="overflow-x-auto">
          <table class="min-w-full text-sm">
            <thead class="bg-gray-50">
              <tr class="text-left text-gray-600">
                <th class="px-4 py-3">No</th>
                <th class="px-4 py-3">Nama Barang</th>
                <th class="px-4 py-3 text-right">Harga</th>
                <th class="px-4 py-3">Tanggal Produksi</th>
                <th class="px-4 py-3">Tanggal Expired</th>
                <th class="px-4 py-3 text-right">Masuk</th>
                <th class="px-4 py-3 text-right">Keluar</th>
                <th class="px-4 py-3 text-right">Sisa</th>
                <th class="px-4 py-3 text-center">Aksi</th>
              </tr>
            </thead>

            <tbody class="bg-white divide-y">
              @foreach($stoks as $index => $item)
              @php $sisa = ($item->masuk ?? 0) - ($item->keluar ?? 0); @endphp
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-sm text-gray-700">{{ $index + 1 }}</td>
                <td class="px-4 py-3">{{ $item->nama }}</td>
                <td class="px-4 py-3 text-right">Rp{{ number_format($item->harga ?? 0,0,',','.') }}</td>
                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->produksi ?? $item->tanggal_produksi ?? now())->format('d/m/yy') }}</td>
                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->expired ?? $item->tanggal_kadaluarsa ?? now())->format('d/m/yy') }}</td>
                <td class="px-4 py-3 text-right text-gray-700">{{ $item->masuk ?? 0 }}</td>
                <td class="px-4 py-3 text-right text-gray-700">{{ $item->keluar ?? 0 }}</td>
                <td class="px-4 py-3 text-right font-semibold">{{ $sisa }}</td>
                <td class="px-4 py-3 text-center">
                  <div class="inline-flex gap-2">
                    <button class="px-3 py-1 text-sm bg-white border rounded open-view" data-json='@json($item)'>Lihat</button>
                    <button class="px-3 py-1 text-sm bg-green-500 text-white rounded open-edit" data-json='@json($item)'>Edit</button>
                    <form action="{{ route('stok.destroy', $item->kode ?? '#') }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                      @csrf
                      @method('DELETE')
                      <button class="px-3 py-1 text-sm bg-red-500 text-white rounded">Hapus</button>
                    </form>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</div>

<!-- Modal: Tambah / Edit Stok -->
<div id="modal-stok" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
  <div class="bg-white rounded-lg w-full max-w-xl shadow-lg overflow-hidden">
    <form id="form-stok" action="{{ route('tambahproduk.store') }}" method="POST" class="p-6 flex flex-col">
      @csrf
      <input type="hidden" name="kode_old" id="kode_old" value="">

      <!-- Scrollable table container -->
      <div class="overflow-y-auto max-h-96 border rounded mb-4">
        <table class="table-auto w-full border-collapse border border-gray-300">
          <thead class="sticky top-0 bg-gray-100">
            <tr>
              <th class="border px-2 py-1">Nama Roti</th>
              <th class="border px-2 py-1">Harga</th>
              <th class="border px-2 py-1">Jumlah</th>
            </tr>
          </thead>
          <tbody>
            @php
                $rotis = [
                    ['nama' => 'Roti A', 'harga' => 5000],
                    ['nama' => 'Roti B', 'harga' => 5500],
                    ['nama' => 'Roti C', 'harga' => 6000],
                    ['nama' => 'Roti D', 'harga' => 5200],
                    ['nama' => 'Roti E', 'harga' => 5800],
                    ['nama' => 'Roti F', 'harga' => 5300],
                    ['nama' => 'Roti G', 'harga' => 5700],
                    ['nama' => 'Roti H', 'harga' => 5600],
                    ['nama' => 'Roti I', 'harga' => 5900],
                    ['nama' => 'Roti J', 'harga' => 6100],
                    ['nama' => 'Roti K', 'harga' => 6200],
                    ['nama' => 'Roti L', 'harga' => 6000],
                    ['nama' => 'Roti M', 'harga' => 6300],
                    ['nama' => 'Roti N', 'harga' => 6400],
                    ['nama' => 'Roti O', 'harga' => 6500],
                    ['nama' => 'Roti P', 'harga' => 6600],
                    ['nama' => 'Roti Q', 'harga' => 6700],
                    ['nama' => 'Roti R', 'harga' => 6800],
                    ['nama' => 'Roti S', 'harga' => 6900],
                    ['nama' => 'Roti T', 'harga' => 7000],
                    ['nama' => 'Roti U', 'harga' => 7100],
                    ['nama' => 'Roti V', 'harga' => 7200],
                    ['nama' => 'Roti W', 'harga' => 7300],
                    ['nama' => 'Roti X', 'harga' => 7400],
                    ['nama' => 'Roti Y', 'harga' => 7500],
                    ['nama' => 'Roti Z', 'harga' => 7600],
                ];
            @endphp

            @foreach($rotis as $index => $roti)
                <tr>
                    <td class="border px-2 py-1">{{ $roti['nama'] }}</td>
                    <td class="border px-2 py-1">{{ number_format($roti['harga'], 0, ',', '.') }}</td>
                    <td class="border px-2 py-1">
                        <input type="number" name="jumlah[{{ $index }}]" value="0" min="0" class="w-20 border px-1 py-0.5">
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Buttons -->
      <div class="mt-4 flex justify-end gap-2">
        <button type="button" id="modal-close" class="px-4 py-2 bg-gray-200 rounded">Batal</button>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
      </div>
    </form>
  </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('modal-stok');
  const btnOpen = document.getElementById('btn-open-modal');
  const btnClose = document.querySelectorAll('#modal-close');

  btnOpen.addEventListener('click', () => {
    // clear form for new stok
    document.getElementById('form-stok').reset();
    document.getElementById('kode_old').value = '';
    modal.classList.remove('hidden');
  });

  btnClose.forEach(b => b.addEventListener('click', () => modal.classList.add('hidden')));

  // open edit modal from row
  document.querySelectorAll('.open-edit').forEach(btn => {
    btn.addEventListener('click', function () {
      const data = JSON.parse(this.dataset.json);
      document.getElementById('kode_old').value = data.kode ?? '';
      document.getElementById('stok-kode').value = data.kode ?? '';
      document.getElementById('stok-nama').value = data.nama ?? '';
      document.getElementById('stok-harga').value = data.harga ?? '';
      document.getElementById('stok-produksi').value = data.produksi ?? data.tanggal_produksi ?? '';
      document.getElementById('stok-expired').value = data.expired ?? data.tanggal_kadaluarsa ?? '';
      document.getElementById('stok-masuk').value = data.masuk ?? 0;
      document.getElementById('stok-keluar').value = data.keluar ?? 0;
      modal.classList.remove('hidden');
    });
  });

  // simple view handler (readonly alert)
  document.querySelectorAll('.open-view').forEach(btn => {
    btn.addEventListener('click', function () {
      const d = JSON.parse(this.dataset.json);
      alert(`Kode: ${d.kode}\nNama: ${d.nama}\nHarga: Rp${d.harga}\nProduksi: ${d.produksi}\nExpired: ${d.expired}\nMasuk: ${d.masuk}\nKeluar: ${d.keluar}`);
    });
  });
});
</script>
@endsection
