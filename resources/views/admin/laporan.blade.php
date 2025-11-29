@extends('layouts.sidebar')

@section('content')

<div class="min-h-screen p-6 bg-gray-100">
  <div class="max-w-6xl mx-auto">

    <header class="bg-gray-800/90 text-gray-100 rounded-lg px-6 py-4 flex items-center justify-between mb-6">
      <div>
        <h2 class="text-xl font-semibold">Cabang Pusat</h2>
        <p class="text-sm text-gray-300">Daftar Laporan</p>
      </div>
    </header>

    <section class="bg-white rounded-lg shadow-md overflow-hidden">

      <div class="p-4 border-b border-gray-200">
        <p class="text-sm text-gray-500">Laporan bukti penerimaan barang cabang.</p>
      </div>

      <div class="p-4">

        {{-- DATA LAPORAN --}}
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">#</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Judul</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">User</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Tanggal</th>
                <th class="px-6 py-3 text-center text-sm font-medium text-gray-600">Aksi</th>
              </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-100">
            @forelse($laporans ?? [] as $i => $lap)
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-sm">{{ $i + 1 }}</td>
                <td class="px-6 py-4 text-sm">{{ $lap->judul }}</td>
                <td class="px-6 py-4 text-sm">{{ $lap->user->username ?? '-' }}</td>
                <td class="px-6 py-4 text-sm">{{ $lap->tanggal }}</td>
                  <td class="px-6 py-4 text-center">

                <td class="px-6 py-4 text-center">
                  <div class="inline-flex flex-col sm:flex-row items-center gap-2 w-full sm:w-auto">

                    {{-- DOWNLOAD PDF --}}
                    <a href="{{ route('laporan.download', $lap->id) }}"
                      class="w-full sm:w-auto px-3 py-2 bg-white border border-gray-200 rounded shadow-sm text-sm text-gray-700 hover:bg-gray-50 text-center">
                      Download
                    </a>

                    {{-- DELETE --}}
                    <form method="POST" action="{{ route('laporan.destroy', $lap->id) }}"
                          onsubmit="return confirm('Hapus laporan ini?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                        class="w-full sm:w-9 h-9 bg-white border border-gray-200 rounded shadow-sm text-gray-600 hover:bg-gray-50">
                        ✕
                      </button>
                    </form>

                  </div>
                </td>
              </tr>
                <tr class="md:hidden">
                  <td colspan="5" class="px-4 py-3">
                    <div class="bg-white p-3 rounded-lg shadow-sm">
                      <div class="flex items-center justify-between">
                        <div class="font-medium text-gray-800">{{ $lap->judul }}</div>
                        <div class="text-sm text-gray-500">{{ $lap->tanggal }}</div>
                      </div>
                      <div class="mt-2 text-sm text-gray-600">User: <span class="font-medium text-gray-800">{{ $lap->user->username ?? '-' }}</span></div>
                      <div class="mt-3 flex gap-2">
                        <a href="{{ route('laporan.download', $lap->id) }}" class="flex-1 px-3 py-2 bg-white border border-gray-200 rounded text-sm text-gray-700 text-center">Download</a>
                        <form method="POST" action="{{ route('laporan.destroy', $lap->id) }}" class="flex-1" onsubmit="return confirm('Hapus laporan ini?')">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="w-full px-3 py-2 bg-red-600 text-white rounded text-sm">Hapus</button>
                        </form>
                      </div>
                    </div>
                  </td>
                </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center py-4 text-gray-500">Belum ada laporan</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="mt-4 flex items-center justify-between">
        <div class="text-sm text-gray-500">Menampilkan {{ isset($laporans) ? $laporans->count() : 0 }} entri</div>
          <div class="flex items-center gap-2">

            {{-- EXPORT PDF --}}
            <a href="{{ route('laporan.export.pdf') }}"
              class="px-3 py-1 border border-gray-200 rounded text-sm text-gray-700 hover:bg-gray-50">
              Export PDF
            </a>

            <button class="px-3 py-1 border border-gray-200 rounded text-sm text-gray-700 hover:bg-gray-50"
                    onclick="location.reload()">
              Refresh
            </button>

          </div>
        </div>

      </div>
    </section>
  </div>
</div>

@endsection
