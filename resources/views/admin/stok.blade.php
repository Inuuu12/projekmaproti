@extends('layouts.sidebar')

@section('content')
<style>
  /* Hide number input spinners globally on this page */
  input[type=number]::-webkit-inner-spin-button, 
  input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none;
      margin: 0; 
  }
  input[type=number] {
      -moz-appearance: textfield;
  }
</style>
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
        <header class="bg-[#151D29] text-gray-100 rounded-2xl p-6 flex items-center justify-between mb-6 shadow-sm border border-gray-800/60 relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-xl font-bold tracking-wide">
                    @if($cabangDipilih)
                        Stok Produk: Cabang {{ $cabangDipilih }}
                    @else
                        Total Stok Semua Cabang
                    @endif
                </h2>
                <p class="text-xs text-gray-400 mt-1">Kelola stok masuk, pantau kadaluarsa, dan retur.</p>
            </div>
        </header>

        {{-- === SECTION TABEL STOK UTAMA === --}}
        <section class="bg-white rounded-2xl shadow-sm border border-gray-200/80 overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-gray-50/50">
                <div class="text-xs text-gray-500 font-bold uppercase tracking-wider">
                    @if($cabangDipilih)
                        Data Stok Cabang: <span class="text-blue-600 normal-case">{{ $cabangDipilih }}</span>
                    @else
                        Akumulasi Stok Semua Cabang
                    @endif
                </div>
                <div>
                    <button id="btn-open-modal" class="flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 active:scale-[0.98] text-white rounded-xl transition shadow-sm font-bold text-xs uppercase tracking-wider w-full sm:w-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        <span>Tambah Stok Masuk</span>
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse">
                    <thead class="bg-gray-50/75 border-b border-gray-100 text-gray-500 uppercase text-[10px] font-bold tracking-wider">
                        <tr>
                            <th class="px-5 py-3.5 text-left font-bold">No</th>
                            <th class="px-5 py-3.5 text-left font-bold">Nama Produk</th>
                            <th class="px-5 py-3.5 text-right font-bold">Harga (Rp)</th>
                            <th class="px-5 py-3.5 text-center font-bold">Cabang</th>
                            <th class="px-5 py-3.5 text-center font-bold">Stok</th>
                            <th class="px-5 py-3.5 text-center font-bold">Tgl Masuk</th>
                            <th class="px-5 py-3.5 text-center font-bold">Tgl Kadaluarsa</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($stoks as $index => $stok)
                            <tr class="hover:bg-gray-50/80 transition-all duration-200 hidden md:table-row">
                                <td class="px-5 py-4 text-gray-400 text-xs font-semibold">{{ $index + 1 }}</td>
                                <td class="px-5 py-4 font-bold text-gray-800 text-sm">
                                    {{ $stok->produk->nama ?? '-' }}
                                </td>
                                <td class="px-5 py-4 text-right text-gray-700 font-semibold text-sm">
                                    Rp{{ number_format($stok->produk->harga ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-4 text-center text-gray-500 text-xs font-bold">{{ $stok->cabang }}</td>
                                <td class="px-5 py-4 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-100">
                                        {{ $stok->stok }} Pcs
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-center text-gray-400 text-xs font-medium">
                                    {{ \Carbon\Carbon::parse($stok->tanggal_masuk)->format('d/m/Y') }}
                                </td>
                                <td class="px-5 py-4 text-center">
                                    @if($stok->tanggal_kadaluarsa)
                                        @if(\Carbon\Carbon::parse($stok->tanggal_kadaluarsa)->isPast())
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-red-600 border border-red-100 uppercase tracking-wider">
                                                Expired ({{ \Carbon\Carbon::parse($stok->tanggal_kadaluarsa)->format('d/m/Y') }})
                                            </span>
                                        @else
                                            <span class="text-gray-600 font-medium text-xs">
                                                {{ \Carbon\Carbon::parse($stok->tanggal_kadaluarsa)->format('d/m/Y') }}
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-gray-400 font-medium text-xs">-</span>
                                    @endif
                                </td>
                            </tr>

                            {{-- Mobile card view for each stok row (visible on small screens) --}}
                            <tr class="md:hidden">
                                <td colspan="7" class="px-4 py-3">
                                    <div class="bg-white p-4 rounded-xl border border-gray-150 shadow-sm space-y-2.5">
                                        <div class="flex items-start justify-between">
                                            <div class="text-sm font-bold text-gray-800">{{ $stok->produk->nama ?? '-' }}</div>
                                            <div class="text-sm font-bold text-blue-600">Rp{{ number_format($stok->produk->harga ?? 0, 0, ',', '.') }}</div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-2 text-xs text-gray-500 font-medium">
                                            <div>Cabang: <span class="font-bold text-gray-700">{{ $stok->cabang }}</span></div>
                                            <div>Stok: <span class="font-bold text-green-700 bg-green-50 px-1.5 py-0.5 rounded border border-green-100">{{ $stok->stok }} Pcs</span></div>
                                            <div>Tgl Masuk: <span class="font-bold text-gray-700">{{ \Carbon\Carbon::parse($stok->tanggal_masuk)->format('d/m/Y') }}</span></div>
                                            <div>Tgl Kadaluarsa: 
                                                @if($stok->tanggal_kadaluarsa)
                                                    @if(\Carbon\Carbon::parse($stok->tanggal_kadaluarsa)->isPast())
                                                        <span class="font-bold text-red-600 bg-red-50 px-1.5 py-0.5 rounded border border-red-100">Expired</span>
                                                    @else
                                                        <span class="font-bold text-gray-700">{{ \Carbon\Carbon::parse($stok->tanggal_kadaluarsa)->format('d/m/Y') }}</span>
                                                    @endif
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-12">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                        <p class="font-semibold text-xs">Belum ada data stok tersedia.</p>
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
    <div class="bg-white rounded-2xl w-full max-w-2xl shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 h-[85vh] md:h-auto flex flex-col border border-gray-100" id="modal-stok-card">
        <form id="form-stok" action="{{ route('stok.store') }}" method="POST" class="flex flex-col flex-1 overflow-auto">
            @csrf

            {{-- Modal Header --}}
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-[#151D29] text-white">
                <div>
                    <h3 class="text-lg font-bold tracking-wide">Tambah Stok Masuk</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Input jumlah stok baru beserta tanggal kadaluarsa produk.</p>
                </div>
                <button type="button" id="modal-close" class="text-gray-400 hover:text-white transition rounded-full p-1 hover:bg-white/10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="p-6 flex-1 overflow-y-auto space-y-5 bg-gray-50/50">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Pilih Cabang <span class="text-red-500">*</span></label>
                        <select name="cabang" id="select-cabang" required
                            class="w-full rounded-xl border border-gray-200 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 text-sm py-2.5 pl-3 pr-14 bg-white transition">
                            <option value="" disabled selected>Pilih Cabang</option>
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
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Tanggal Masuk <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_masuk" value="{{ date('Y-m-d') }}" required
                            class="w-full rounded-xl border border-gray-200 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 text-sm py-2.5 px-3 bg-white transition">
                    </div>
                </div>

                <div class="border border-gray-200/80 rounded-2xl shadow-sm overflow-hidden bg-white">
                    <div class="bg-gray-50 px-4 py-3 border-b border-gray-150 flex items-center justify-between">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-gray-600">Daftar Produk Master</h4>
                        <span class="text-[10px] text-gray-400 font-semibold bg-gray-200/60 px-2 py-0.5 rounded-full">Total: {{ count($rotis) }}</span>
                    </div>

                    <div class="overflow-y-auto max-h-60 custom-scrollbar">
                        <table class="w-full text-sm">
                            <thead class="sticky top-0 bg-gray-50 border-b border-gray-100 shadow-sm z-10 text-gray-500 text-xs">
                                <tr>
                                    <th class="px-4 py-2.5 text-left font-bold w-1/3">Nama Produk</th>
                                    <th class="px-4 py-2.5 text-right font-bold w-1/6">Harga</th>
                                    <th class="px-4 py-2.5 text-center font-bold w-1/4">Tgl Kadaluarsa <span class="text-red-500">*</span></th>
                                    <th class="px-4 py-2.5 text-center font-bold w-1/6">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($rotis as $roti)
                                    <tr class="hover:bg-blue-50/30 transition group">
                                        <td class="px-4 py-3 text-gray-800 font-bold text-xs md:text-sm">
                                            {{ $roti->nama }}
                                            <input type="hidden" name="stok[{{ $roti->id }}][produk_id]" value="{{ $roti->id }}">
                                        </td>
                                        <td class="px-4 py-3 text-right text-gray-500 text-xs font-medium">
                                            Rp{{ number_format($roti->harga, 0, ',', '.') }}
                                        </td>

                                        {{-- INPUT TANGGAL KADALUARSA --}}
                                        <td class="px-4 py-3">
                                            <input type="date"
                                                   name="stok[{{ $roti->id }}][tanggal_kadaluarsa]"
                                                   class="w-full border border-gray-200 rounded-lg text-xs py-1.5 px-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition">
                                        </td>

                                        {{-- INPUT JUMLAH DENGAN BUTTON MINUS/PLUS --}}
                                        <td class="px-4 py-3 text-center align-middle">
                                            <div class="inline-flex items-center bg-gray-50 border border-gray-200 rounded-xl p-0.5 h-8 w-28 justify-between mx-auto">
                                                <button type="button" class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-800 hover:bg-white rounded-lg transition btn-stok-dec font-bold text-xs">-</button>
                                                <input type="number"
                                                       name="stok[{{ $roti->id }}][jumlah]"
                                                       value="0" min="0"
                                                       class="w-10 text-center text-xs font-extrabold text-gray-700 bg-transparent focus:outline-none border-0 p-0 focus:ring-0 input-stok-jumlah">
                                                <button type="button" class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-800 hover:bg-white rounded-lg transition btn-stok-inc font-bold text-xs">+</button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-8 text-center text-gray-500 bg-gray-50">
                                            Belum ada produk master.
                                            <a href="{{ route('tambahproduk.index') }}" class="text-blue-600 font-bold hover:underline">Tambah Produk Dulu</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider text-right">Tanggal kadaluarsa wajib diisi.</p>
            </div>

            {{-- Modal Footer --}}
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3 sticky bottom-0 md:static">
                <button type="button" id="modal-close-footer"
                    class="px-5 py-2.5 bg-white border border-gray-200 text-gray-600 rounded-xl hover:bg-gray-100 transition font-bold text-xs">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-2.5 bg-[#151D29] text-white rounded-xl hover:bg-[#1a2534] transition font-bold text-xs shadow-sm">
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
    const card = document.getElementById('modal-stok-card');
    const btnOpen = document.getElementById('btn-open-modal');
    const btnCloseList = document.querySelectorAll('#modal-close, #modal-close-footer');
    const formStok = document.getElementById('form-stok');

    // Buka Modal dengan Animasi
    if(btnOpen){
        btnOpen.addEventListener('click', () => {
            modal.classList.remove('hidden');
            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 10);
        });
    }

    const closeModal = () => {
        card.classList.remove('scale-100', 'opacity-100');
        card.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    };

    // Tutup Modal (Tombol X dan Batal)
    btnCloseList.forEach(btn => {
        btn.addEventListener('click', closeModal);
    });

    // Tutup Modal (Klik area luar)
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Logic for plus and minus buttons in stok table
    const tableBody = formStok.querySelector('tbody');
    if (tableBody) {
        tableBody.addEventListener('click', function(e) {
            const btnDec = e.target.closest('.btn-stok-dec');
            const btnInc = e.target.closest('.btn-stok-inc');
            if (btnDec) {
                const input = btnDec.parentElement.querySelector('.input-stok-jumlah');
                let val = parseInt(input.value) || 0;
                if (val > 0) {
                    input.value = val - 1;
                }
            }
            if (btnInc) {
                const input = btnInc.parentElement.querySelector('.input-stok-jumlah');
                let val = parseInt(input.value) || 0;
                input.value = val + 1;
            }
        });
    }

    // Validasi Sederhana sebelum Submit
    formStok.addEventListener('submit', async function(e) {
        let isValid = true;
        const inputs = formStok.querySelectorAll('tbody tr');

        inputs.forEach(row => {
            const jumlahInput = row.querySelector('input[type="number"]');
            const tglInput = row.querySelector('input[type="date"]');
            if (jumlahInput && tglInput) {
                const jumlah = jumlahInput.value;
                const tgl = tglInput.value;

                if (Number(jumlah) > 0 && !tgl) {
                    isValid = false;
                    tglInput.classList.add('border-red-500');
                } else {
                    tglInput.classList.remove('border-red-500');
                }
            }
        });

        if (!isValid) {
            e.preventDefault();
            await window.customAlert('Lengkapi Data!', 'Harap isi Tanggal Kadaluarsa untuk produk yang jumlah stoknya ditambahkan!', 'danger');
        }
    });
});
</script>
@endsection
