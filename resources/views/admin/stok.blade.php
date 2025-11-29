@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen p-6 bg-gray-100">
    <div class="max-w-6xl mx-auto">

        {{-- === BAGIAN ALERT (PESAN SISTEM) === --}}
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('warning'))
            <div class="mb-4 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <span>{{ session('warning') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- === HEADER HALAMAN === --}}
        <header class="bg-gray-800/90 text-gray-100 rounded-lg px-6 py-4 flex items-center justify-between mb-6 shadow-lg">
            <div>
                <h2 class="text-xl font-semibold">
                    @if($cabangDipilih)
                        Stok Produk: Cabang {{ $cabangDipilih }}
                    @else
                        Total Stok Semua Cabang
                    @endif
                </h2>
                <p class="text-sm text-gray-300 mt-1">Kelola stok masuk, pantau kadaluarsa, dan retur.</p>
            </div>

            {{-- Filter Cabang (Opsional - Jika ingin pindah cabang lewat sini) --}}

        </header>

        {{-- === SECTION TABEL STOK UTAMA === --}}
        <section class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between bg-gray-50">
                <div class="text-sm text-gray-600 font-medium">
                    @if($cabangDipilih)
                        Menampilkan data stok untuk <strong>{{ $cabangDipilih }}</strong>.
                    @else
                        Menampilkan akumulasi data dari <strong>semua cabang</strong>.
                    @endif
                </div>
                <div>
                    <button id="btn-open-modal" class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-sm font-medium text-sm">
                        <span>+ Tambah Stok Masuk</span>
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse">
                    <thead class="bg-gray-100 border-b text-gray-600 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">No</th>
                            <th class="px-4 py-3 text-left font-semibold">Nama Produk</th>
                            <th class="px-4 py-3 text-right font-semibold">Harga (Rp)</th>
                            <th class="px-4 py-3 text-center font-semibold">Cabang</th>
                            <th class="px-4 py-3 text-center font-semibold">Stok</th>
                            <th class="px-4 py-3 text-center font-semibold">Tgl Masuk</th>
                            <th class="px-4 py-3 text-center font-semibold">Tgl Kadaluarsa</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($stoks as $index => $stok)
                            <tr class="hover:bg-gray-50 transition hidden md:table-row">
                                <td class="px-4 py-3 text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 font-medium text-gray-800">
                                    {{ $stok->produk->nama ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right text-gray-600">
                                    Rp{{ number_format($stok->produk->harga ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-center text-gray-600">{{ $stok->cabang }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-2 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                        {{ $stok->stok }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center text-gray-500">
                                    {{ \Carbon\Carbon::parse($stok->tanggal_masuk)->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-3 text-center font-medium {{ \Carbon\Carbon::parse($stok->tanggal_kadaluarsa)->isPast() ? 'text-red-600' : 'text-gray-600' }}">
                                    {{ $stok->tanggal_kadaluarsa ? \Carbon\Carbon::parse($stok->tanggal_kadaluarsa)->format('d/m/Y') : '-' }}
                                    @if(\Carbon\Carbon::parse($stok->tanggal_kadaluarsa)->isPast())
                                        <span class="text-xs block text-red-500">(Expired)</span>
                                    @endif
                                </td>
                            </tr>

                            {{-- Mobile card view for each stok row (visible on small screens) --}}
                            <tr class="md:hidden">
                                <td colspan="7" class="px-4 py-3">
                                    <div class="bg-white p-3 rounded-lg shadow-sm">
                                        <div class="flex items-start justify-between">
                                            <div class="text-sm font-semibold text-gray-800">{{ $stok->produk->nama ?? '-' }}</div>
                                            <div class="text-sm text-gray-600">Rp{{ number_format($stok->produk->harga ?? 0, 0, ',', '.') }}</div>
                                        </div>
                                        <div class="mt-2 grid grid-cols-2 gap-2 text-sm text-gray-600">
                                            <div>Cabang: <span class="font-medium text-gray-800">{{ $stok->cabang }}</span></div>
                                            <div>Stok: <span class="font-medium text-gray-800">{{ $stok->stok }}</span></div>
                                            <div>Tgl Masuk: <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($stok->tanggal_masuk)->format('d/m/Y') }}</span></div>
                                            <div>Tgl Kadaluarsa: <span class="font-medium text-gray-800">{{ $stok->tanggal_kadaluarsa ? \Carbon\Carbon::parse($stok->tanggal_kadaluarsa)->format('d/m/Y') : '-' }}</span></div>
                                        </div>
                                        @if(\Carbon\Carbon::parse($stok->tanggal_kadaluarsa)->isPast())
                                            <div class="mt-2 text-xs text-red-600">Expired</div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-8">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                        <p>Belum ada data stok tersedia.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

{{-- === MODAL TAMBAH STOK (POPUP) === --}}
<div id="modal-stok" class="hidden fixed inset-0 z-50 flex items-end md:items-center justify-center bg-black/60 backdrop-blur-sm p-4 transition-opacity duration-300">
    <div class="bg-white rounded-t-lg md:rounded-xl w-full max-w-2xl shadow-2xl overflow-hidden transform scale-100 transition-transform duration-300 h-[92vh] md:h-auto flex flex-col">
        <form id="form-stok" action="{{ route('stok.store') }}" method="POST" class="flex flex-col flex-1 overflow-auto">
            @csrf

            {{-- Modal Header --}}
            <div class="px-6 py-4 border-b bg-gray-50 flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-bold text-gray-800">📦 Tambah Stok Masuk</h3>
                    <p class="text-xs text-gray-500">Stok yang ditambahkan akan tercatat sebagai stok baru.</p>
                </div>
                <button type="button" id="modal-close" class="text-gray-400 hover:text-red-500 transition rounded-full p-1 hover:bg-red-50">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="p-6 flex-1 overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Pilih Cabang <span class="text-red-500">*</span></label>
                        <select name="cabang" id="select-cabang" required
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2">
                            <option value="" disabled selected>-- Pilih Cabang --</option>
                            @forelse($cabangs ?? [] as $cabang)
                                <option value="{{ $cabang->nama_cabang }}" {{ $cabangDipilih == $cabang->nama_cabang ? 'selected' : '' }}>
                                    {{ $cabang->nama_cabang }}
                                </option>
                            @empty
                                <option value="" disabled>Tidak ada data cabang</option>
                            @endforelse
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Masuk <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_masuk" value="{{ date('Y-m-d') }}" required
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2">
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    <div class="bg-gray-100 px-4 py-2 border-b">
                        <h4 class="text-sm font-bold text-gray-700">Daftar Produk</h4>
                    </div>

                    <div class="overflow-y-auto max-h-60">
                        <table class="w-full text-sm">
                            <thead class="sticky top-0 bg-white border-b shadow-sm z-10">
                                <tr>
                                    <th class="px-4 py-2 text-left font-medium text-gray-600 w-1/3">Nama Produk</th>
                                    <th class="px-4 py-2 text-right font-medium text-gray-600 w-1/6">Harga</th>
                                    {{-- KOLOM BARU UNTUK TANGGAL KADALUARSA --}}
                                    <th class="px-4 py-2 text-center font-medium text-gray-600 w-1/4">Tgl Kadaluarsa <span class="text-red-500">*</span></th>
                                    <th class="px-4 py-2 text-center font-medium text-gray-600 w-1/6">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($rotis as $roti)
                                    <tr class="hover:bg-blue-50 transition group">
                                        <td class="px-4 py-2 text-gray-700 font-medium">
                                            {{ $roti->nama }}
                                            <input type="hidden" name="stok[{{ $roti->id }}][produk_id]" value="{{ $roti->id }}">
                                        </td>
                                        <td class="px-4 py-2 text-right text-gray-500 text-xs">
                                            Rp{{ number_format($roti->harga, 0, ',', '.') }}
                                        </td>

                                        {{-- INPUT TANGGAL KADALUARSA (WAJIB DIISI) --}}
                                        <td class="px-4 py-2">
                                            <input type="date"
                                                   name="stok[{{ $roti->id }}][tanggal_kadaluarsa]"
                                                   class="w-full border-gray-300 rounded text-xs py-1 focus:border-blue-500 focus:ring-blue-500"
                                                   placeholder="Pilih tgl">
                                        </td>

                                        {{-- INPUT JUMLAH --}}
                                        <td class="px-4 py-2">
                                            <input type="number"
                                                   name="stok[{{ $roti->id }}][jumlah]"
                                                   value="0" min="0"
                                                   class="w-full border-gray-300 rounded text-center text-sm py-1 focus:border-blue-500 focus:ring-blue-500 font-bold text-gray-700 bg-gray-50 focus:bg-white transition"
                                                   onfocus="if(this.value==0) this.value=''">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-6 text-center text-gray-500 bg-gray-50">
                                            Belum ada produk master.
                                            <a href="{{ route('tambahproduk.index') }}" class="text-blue-600 hover:underline">Tambah Produk Dulu</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <p class="mt-2 text-xs text-gray-400 text-right">Pastikan tanggal kadaluarsa diisi untuk produk yang jumlahnya > 0.</p>
            </div>

            {{-- Modal Footer --}}
            <div class="px-6 py-4 bg-gray-50 border-t flex justify-end gap-3 sticky bottom-0 md:static">
                <button type="button" id="modal-close-footer"
                    class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition font-medium text-sm">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium text-sm shadow-sm">
                    Simpan Stok
                </button>
            </div>
        </form>
    </div>
</div>

{{-- === SCRIPT JAVASCRIPT === --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modal-stok');
    const btnOpen = document.getElementById('btn-open-modal');
    const btnCloseList = document.querySelectorAll('#modal-close, #modal-close-footer');
    const formStok = document.getElementById('form-stok');

    // Buka Modal
    if(btnOpen){
        btnOpen.addEventListener('click', () => {
            modal.classList.remove('hidden');
            // Opsional: Reset form saat dibuka agar bersih
            // formStok.reset();
        });
    }

    // Tutup Modal (Tombol X dan Batal)
    btnCloseList.forEach(btn => {
        btn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
    });

    // Tutup Modal (Klik area luar)
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });

    // Validasi Sederhana sebelum Submit (Opsional)
    // Mencegah submit jika ada jumlah > 0 tapi tanggal kadaluarsa kosong
    formStok.addEventListener('submit', function(e) {
        let isValid = true;
        const inputs = formStok.querySelectorAll('tbody tr');

        inputs.forEach(row => {
            const jumlah = row.querySelector('input[type="number"]').value;
            const tgl = row.querySelector('input[type="date"]').value;

            if (jumlah > 0 && !tgl) {
                isValid = false;
                row.querySelector('input[type="date"]').classList.add('border-red-500');
            } else {
                row.querySelector('input[type="date"]').classList.remove('border-red-500');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Harap isi Tanggal Kadaluarsa untuk produk yang stoknya ditambahkan!');
        }
    });
});
</script>
@endsection
