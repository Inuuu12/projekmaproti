@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen p-6 bg-gray-100">
  <div class="max-w-6xl mx-auto">
    <header class="bg-gray-800 text-white rounded-lg px-6 py-4 mb-6">
      <h2 class="text-xl font-semibold">Dashboard Produk</h2>
    </header>

    <div class="bg-white p-6 rounded-lg shadow-md">
      <h3 class="text-lg font-semibold mb-4">Daftar Produk</h3>

      @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
          {{ session('success') }}
        </div>
      @endif

      <table class="min-w-full border border-gray-200 rounded">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2 border">#</th>
            <th class="px-4 py-2 border">Kode</th>
            <th class="px-4 py-2 border">Nama Produk</th>
            <th class="px-4 py-2 border">Kategori</th>
            <th class="px-4 py-2 border">Harga</th>
            <th class="px-4 py-2 border">Stok</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($produks as $index => $produk)
            <tr class="border-t">
              <td class="px-4 py-2 text-center">{{ $index + 1 }}</td>
              <td class="px-4 py-2">{{ $produk->kode }}</td>
              <td class="px-4 py-2">{{ $produk->nama }}</td>
              <td class="px-4 py-2">{{ $produk->kategori }}</td>
              <td class="px-4 py-2">Rp{{ number_format($produk->harga, 0, ',', '.') }}</td>
              <td class="px-4 py-2">{{ $produk->stok }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center py-3 text-gray-500">Belum ada produk</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
