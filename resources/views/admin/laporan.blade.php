@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen p-6 bg-gray-100">
  <div class="max-w-6xl mx-auto">
    <header class="bg-gray-800/90 text-gray-100 rounded-lg px-6 py-4 flex items-center justify-between mb-6">
      <div>
        <h2 class="text-xl font-semibold">Cabang B</h2>
        <p class="text-sm text-gray-300">Daftar Laporan</p>
      </div>
      <div class="flex items-center gap-4">
  <button id="btn-new-report"
    class="px-4 py-2 rounded-lg bg-gray-600 text-white font-semibold shadow-md
           hover:bg-white hover:text-gray-700 hover:shadow-lg
           active:scale-95 transition-all duration-200 flex items-center gap-2">
    <span class="text-lg">+</span> Tambah Laporan
  </button>
</div>
    </header>

    <section class="bg-white rounded-lg shadow-md overflow-hidden">
      <div class="p-4 border-b border-gray-200">
        <p class="text-sm text-gray-500">Laporan bukti penerimaan barang cabang.</p>
      </div>

      <div class="p-4">
        @php
          $rows = $laporans ?? [
            ['id'=>1,'judul'=>'Laporan Bukti Penerimaan Barang Cabang A oleh (Username) [U001]','user'=>'Username','tanggal'=>'20/09/25','file'=>'/files/lap1.pdf'],
            ['id'=>2,'judul'=>'Laporan Bukti Penerimaan Barang Cabang A oleh (Username) [U002]','user'=>'Other','tanggal'=>'19/09/25','file'=>'/files/lap2.pdf'],
            ['id'=>3,'judul'=>'Laporan Bukti Penerimaan Barang Cabang A oleh (Username) [U003]','user'=>'Someone','tanggal'=>'01/09/25','file'=>'/files/lap3.pdf'],
          ];
        @endphp

        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">#</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Judul</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">User</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Tanggal</th>
                <th class="px-6 py-3 text-center text-sm font-medium text-gray-600">Aksi</th>
              </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-100">
              @foreach($rows as $i => $row)
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $i + 1 }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $row['judul'] }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $row['user'] }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">[{{ $row['tanggal'] }}]</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                  <div class="inline-flex items-center gap-2">
                    <a href="{{ $row['file'] ?? '#' }}" class="px-3 py-1 bg-white border border-gray-200 rounded shadow-sm text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                      Download
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V3"/>
                      </svg>
                    </a>

                    <form method="POST" action="#" onsubmit="return confirm('Hapus laporan ini?')" class="inline-block">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="inline-flex items-center justify-center w-9 h-9 bg-white border border-gray-200 rounded shadow-sm text-gray-600 hover:bg-gray-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="mt-4 flex items-center justify-between">
          <div class="text-sm text-gray-500">Menampilkan {{ count($rows) }} entri</div>
          <div class="flex items-center gap-2">
            <button class="px-3 py-1 border border-gray-200 rounded text-sm text-gray-700 hover:bg-gray-50">Export</button>
            <button class="px-3 py-1 border border-gray-200 rounded text-sm text-gray-700 hover:bg-gray-50" onclick="location.reload()">Refresh</button>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
@endsection
