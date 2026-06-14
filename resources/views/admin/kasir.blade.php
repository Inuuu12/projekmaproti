@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen p-4 md:p-6 bg-gray-50">
  <div class="max-w-7xl mx-auto">

    {{-- === HEADER === --}}
    <header class="bg-[#151D29] text-gray-100 rounded-2xl p-6 mb-6 relative overflow-hidden border border-gray-800/60 shadow-sm">
      <div class="relative z-10">
        <h2 class="text-xl font-bold tracking-wide">Kasir - Barang Keluar</h2>
        <p class="text-xs text-gray-400 mt-1">
          Cabang aktif: <span class="font-semibold text-yellow-400">{{ $cabangAktif ?? '-' }}</span>.
          Pakai tombol + untuk menambahkan ke keranjang.
        </p>
      </div>
    </header>

    {{-- BAGIAN FILTER SUDAH DIHAPUS --}}

    <section class="grid grid-cols-1 lg:grid-cols-12 gap-6">
 
      {{-- === KOLOM KIRI: PRODUK GRID === --}}
      <div class="lg:col-span-7 space-y-6">
        {{-- Search Bar --}}
        <div class="bg-white rounded-2xl border border-gray-200/80 p-4 shadow-sm">
          <div class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
              <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
              </div>
              <input id="search" class="w-full rounded-xl border border-gray-200 pl-11 pr-4 py-2.5 text-sm placeholder-gray-405 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition-all" placeholder="Cari nama produk...">
            </div>
            <button id="btn-reset" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-650 bg-gray-50 hover:bg-gray-100 hover:text-gray-800 transition text-sm font-bold flex items-center justify-center gap-1.5">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.27 15M21 12h-7"></path></svg>
              Reset
            </button>
          </div>
        </div>
 
        {{-- Grid Produk --}}
        <div class="bg-white rounded-2xl border border-gray-200/80 p-6 shadow-sm min-h-[450px]">
          <div id="product-grid" class="grid grid-cols-2 sm:grid-cols-3 gap-5">
            {{-- Produk akan dirender oleh Javascript --}}
            <div class="col-span-full flex justify-center py-20">
                <svg class="animate-spin h-8 w-8 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
          </div>
          <div class="mt-8 pt-4 border-t border-gray-100 flex items-center justify-center gap-2 text-gray-400">
            <svg class="w-4 h-4 text-gray-450" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-xs font-semibold tracking-wide text-gray-400">
              Stok otomatis berkurang saat transaksi disimpan.
            </p>
          </div>
        </div>
      </div>
 
      {{-- === KOLOM KANAN: KERANJANG === --}}
      <div class="lg:col-span-5 space-y-6 lg:sticky lg:top-24 self-start">
        <div class="bg-white rounded-2xl border border-gray-200/80 overflow-hidden flex flex-col shadow-sm">
          <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
            <h3 class="font-bold text-gray-800 flex items-center gap-2 text-sm uppercase tracking-wider">
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Keranjang Belanja
            </h3>
            <button id="btn-empty" class="text-xs font-bold text-red-500 hover:text-red-705 transition-colors flex items-center gap-1">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
              Kosongkan
            </button>
          </div>
 
          <div class="p-0 overflow-y-auto max-h-[40vh] custom-scrollbar">
            <table class="min-w-full text-sm divide-y divide-gray-150">
              <thead class="bg-gray-50/40 text-gray-400">
                <tr>
                  <th class="text-left py-3.5 px-5 text-xs font-bold tracking-wider uppercase">Produk</th>
                  <th class="text-center py-3.5 px-2 text-xs font-bold tracking-wider uppercase">Qty</th>
                  <th class="text-right py-3.5 px-5 text-xs font-bold tracking-wider uppercase">Total</th>
                  <th class="w-12"></th>
                </tr>
              </thead>
              <tbody id="cart-body" class="divide-y divide-gray-100 bg-white">
                {{-- Item keranjang render di sini --}}
              </tbody>
            </table>
          </div>
 
          {{-- Summary & Pay Button --}}
          <div class="p-5 bg-gray-50/50 border-t border-gray-100 space-y-4">
            <div class="flex items-center justify-between text-sm">
              <span class="text-gray-500 font-medium">Total Item</span>
              <span id="sum-items" class="font-extrabold text-gray-800 bg-gray-200/80 px-2.5 py-0.5 rounded-full text-xs">0</span>
            </div>
            <div class="flex items-center justify-between text-sm">
              <span class="text-gray-500 font-medium">Subtotal</span>
              <span id="sum-subtotal" class="font-bold text-gray-855">Rp 0</span>
            </div>
            <div id="promo-row" class="flex items-center justify-between text-sm text-green-600 hidden">
              <span class="font-semibold">Promo Roti (Setiap kelipatan 3)</span>
              <span id="sum-promo" class="font-bold">-Rp 0</span>
            </div>
            <div class="flex items-center justify-between text-sm">
              <span class="text-gray-500 font-medium">Diskon Tambahan</span>
              <div class="flex items-center relative w-32">
                <span class="absolute left-2.5 text-xs font-bold text-gray-400">Rp</span>
                <input id="input-discount" type="number" min="0" value="0" class="w-full text-right rounded-xl border border-gray-200 pl-8 pr-3 py-2 text-sm font-bold text-gray-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition">
              </div>
            </div>
            <div class="flex items-center justify-between text-base border-t border-gray-200 pt-4">
              <span class="font-bold text-gray-850">Total Bayar</span>
              <span id="sum-total" class="font-extrabold text-blue-600 text-xl">Rp 0</span>
            </div>
 
            <button id="btn-pay" type="button" class="w-full mt-2 rounded-xl bg-[#151D29] text-white py-3.5 hover:bg-[#1a2534] active:scale-[0.98] font-bold transition flex justify-center items-center gap-2 shadow-md hover:shadow-lg text-sm uppercase tracking-wider">
                <span>Simpan Transaksi</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </button>
          </div>
        </div>
      </div>
    </section>

    {{-- === BAGIAN BAWAH: RINGKASAN TABEL STOK (PENGAMAN DITAMBAHKAN) === --}}
    @if(isset($stoks) && count($stoks) > 0)
    <section class="mt-10 pt-6 border-t border-gray-200">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-gray-800">
            Detail Stok Cabang: <span class="text-blue-600">{{ $cabangAktif ?? 'Semua' }}</span>
        </h3>
      </div>
      @include('admin.partials.stok_table', [
        'stoks' => $stoks,
        'cabangDipilih' => $cabangAktif ?? null,
        'showAddButton' => false
      ])
    </section>
    @endif
  </div>
</div>

{{-- === DATA TRANSFER OBJECT (JSON) === --}}
{{-- PENGAMAN: Jika $produkKasir null, ganti dengan collect() agar tidak error --}}
<script type="application/json" id="stok-json">{!! ($produkKasir ?? collect())->toJson(JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>

{{-- === SCRIPT UTAMA === --}}
<script>
window.APP_FALLBACK_IMG = "{{ asset('images/no-image.jpg') }}";

document.addEventListener('DOMContentLoaded', function () {
  // Use global customAlert and customConfirm from sidebar layout
  const customAlert = window.customAlert;
  const customConfirm = window.customConfirm;

  // 1. Ambil & Parse Data
  const stokEl = document.getElementById('stok-json');
  let products = [];
  try {
    products = stokEl ? JSON.parse(stokEl.textContent) : [];
  } catch (e) {
    console.error("Gagal parse JSON produk", e);
    products = [];
  }

  const cart = new Map();

  // Elements DOM
  const grid = document.getElementById('product-grid');
  const search = document.getElementById('search');
  const btnReset = document.getElementById('btn-reset');
  const cartBody = document.getElementById('cart-body');
  const sumItems = document.getElementById('sum-items');
  const sumSubtotal = document.getElementById('sum-subtotal');
  const sumTotal = document.getElementById('sum-total');
  const inputDiscount = document.getElementById('input-discount');
  const btnEmpty = document.getElementById('btn-empty');
  const btnPay = document.getElementById('btn-pay');

  // Helper Functions
  const rupiah = (n) => 'Rp ' + (Number(n)||0).toLocaleString('id-ID');

  // SUPPORT DUAL FORMAT: Mengecek 'nama' (lama) atau 'name' (baru)
  const getNama = (p) => p.name || p.nama || 'Produk Tanpa Nama';
  const getStok = (p) => Number(p.stock ?? p.stok ?? 0);
  const getHarga = (p) => Number(p.price ?? p.harga ?? 0);

  const getImage = (p) => {
    if(p.image) return p.image;
    if(p.foto) return p.foto.startsWith('http') ? p.foto : `/${p.foto.replace(/^\/+/, '')}`;
    return window.APP_FALLBACK_IMG;
  };

  // 2. Render Grid Produk
  function renderProducts(list){
    grid.innerHTML = '';

    if(list.length === 0) {
        grid.innerHTML = `
            <div class="col-span-full flex flex-col items-center justify-center py-10 text-gray-400">
                <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p>Produk tidak ditemukan / Data Kosong</p>
            </div>`;
        return;
    }

    list.forEach(p => {
      const nama = getNama(p);
      const stok = getStok(p);
      const harga = getHarga(p);
      const imgSrc = getImage(p);
      const isHabis = stok <= 0;

      const btnClass = isHabis
        ? 'bg-gray-100 text-gray-450 cursor-not-allowed border border-gray-200'
        : 'bg-[#151D29] hover:bg-[#1a2534] active:scale-[0.98] text-white shadow-sm hover:shadow-md';

      const card = document.createElement('div');
      card.className = 'bg-white border border-gray-200/80 rounded-2xl overflow-hidden flex flex-col justify-between h-full transition-all duration-300 hover:shadow-md hover:border-gray-300 hover:-translate-y-1 relative group';

      card.innerHTML = `
        <div class="p-4 pb-0">
            <div class="aspect-[4/3] rounded-xl overflow-hidden bg-gray-50 relative mb-3 border border-gray-100">
                <img src="${imgSrc}" alt="${nama}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105" onerror="this.src=window.APP_FALLBACK_IMG">
                ${isHabis ? '<div class="absolute inset-0 bg-black/60 backdrop-blur-[1px] flex items-center justify-center text-white font-extrabold tracking-wider text-xs rounded-xl">HABIS</div>' : ''}
            </div>
            <h4 class="font-bold text-gray-800 text-sm leading-snug mb-1 line-clamp-2 min-h-[2.5rem]" title="${nama}">${nama}</h4>
            <div class="flex items-center justify-between mt-2">
                 <span class="text-[10px] font-bold px-2 py-0.5 rounded-full ${stok <= 0 ? 'bg-red-50 text-red-650 border border-red-100' : 'bg-green-50 text-green-650 border border-green-100'}">
                    Stok: ${stok}
                 </span>
            </div>
            <div class="text-blue-600 font-extrabold text-base mt-1.5">${rupiah(harga)}</div>
        </div>
        <div class="p-4 pt-2">
            <button class="w-full py-2.5 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 ${btnClass}" ${isHabis ? 'disabled' : ''}>
               ${isHabis ? 'Stok Habis' : `
               <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
               Tambah
               `}
            </button>
        </div>
      `;

      if(!isHabis){
          const btn = card.querySelector('button');
          btn.addEventListener('click', async () => await addToCart(p));
      }
      grid.appendChild(card);
    });
  }

  // 3. Logic Keranjang
  async function addToCart(product) {
    const pId = product.id;
    const currentItem = cart.get(pId);
    const currentQty = currentItem ? currentItem.qty : 0;
    const maxStock = getStok(product);

    if (currentQty + 1 > maxStock) {
        await customAlert('Stok Tidak Cukup!', `Hanya tersedia ${maxStock} pcs untuk produk ini.`, 'danger');
        return;
    }

    const nextQty = currentQty + 1;
    cart.set(pId, {
        id: pId,
        name: getNama(product),
        price: getHarga(product),
        qty: nextQty,
        max: maxStock
    });
    renderCart();
    compute();
  }

  function renderCart(){
    cartBody.innerHTML = '';
    if(cart.size === 0){
        cartBody.innerHTML = `
            <tr>
                <td colspan="4" class="text-center py-12 text-gray-400 text-sm bg-white">
                    <div class="flex flex-col items-center justify-center">
                        <svg class="w-10 h-10 mb-2.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        <p class="font-medium text-xs">Keranjang Belanja Kosong</p>
                    </div>
                </td>
            </tr>`;
        return;
    }

    [...cart.values()].forEach(item => {
      const tr = document.createElement('tr');
      tr.className = "group hover:bg-gray-50/80 transition-all duration-200";
      tr.innerHTML = `
        <td class="py-3.5 px-5 align-middle bg-white">
          <div class="font-bold text-gray-800 text-sm line-clamp-1" title="${item.name}">${item.name}</div>
          <div class="text-xs font-semibold text-gray-400 mt-0.5">${rupiah(item.price)}</div>
        </td>
        <td class="py-3.5 px-1 text-center align-middle bg-white">
          <div class="inline-flex items-center bg-gray-50 border border-gray-200 rounded-xl p-0.5 h-8">
            <button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-800 hover:bg-white rounded-lg transition btn-dec font-bold text-xs">-</button>
            <span class="w-8 text-center text-xs font-extrabold text-gray-700 select-none">${item.qty}</span>
            <button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-800 hover:bg-white rounded-lg transition btn-inc font-bold text-xs">+</button>
          </div>
        </td>
        <td class="py-3.5 px-5 text-right align-middle text-sm font-bold text-gray-800 bg-white">
            ${rupiah(item.price * item.qty)}
        </td>
        <td class="py-3.5 px-2 text-center align-middle bg-white">
          <button class="text-gray-450 hover:text-red-500 btn-remove p-1.5 rounded-xl hover:bg-red-50 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
          </button>
        </td>
      `;

      tr.querySelector('.btn-dec').addEventListener('click', () => {
        if(item.qty > 1) { item.qty--; cart.set(item.id, item); }
        else { cart.delete(item.id); }
        renderCart(); compute();
      });

      tr.querySelector('.btn-inc').addEventListener('click', async () => {
        if(item.qty < item.max) { item.qty++; cart.set(item.id, item); renderCart(); compute(); }
        else { await customAlert('Stok Tidak Cukup!', 'Kuantitas pesanan sudah mencapai batas stok yang tersedia.', 'danger'); }
      });

      tr.querySelector('.btn-remove').addEventListener('click', () => {
        cart.delete(item.id); renderCart(); compute();
      });

      cartBody.appendChild(tr);
    });
  }

  function compute(){
    let items = 0; let subtotal = 0; let totalQty3500 = 0;
    cart.forEach(it => { 
      items += it.qty; 
      subtotal += it.qty * it.price; 
      
      // Hitung total qty semua item berharga 3500
      if (Number(it.price) === 3500) {
        totalQty3500 += it.qty;
      }
    });

    const promoDiscount = Math.floor(totalQty3500 / 3) * 500;
    const discount = Math.max(0, Number(inputDiscount.value || 0));
    const total = Math.max(0, subtotal - promoDiscount - discount);

    sumItems.textContent = items;
    sumSubtotal.textContent = rupiah(subtotal);

    const promoRow = document.getElementById('promo-row');
    const sumPromo = document.getElementById('sum-promo');
    if (promoDiscount > 0) {
      promoRow.classList.remove('hidden');
      sumPromo.textContent = '-' + rupiah(promoDiscount);
    } else {
      promoRow.classList.add('hidden');
    }

    sumTotal.textContent = rupiah(total);
  }

  // 4. Filter & Search Logic
  function applyFilter() {
    const q = (search.value || '').toLowerCase();
    const list = products.filter(p => getNama(p).toLowerCase().includes(q));
    renderProducts(list);
  }

  search.addEventListener('input', applyFilter);
  btnReset.addEventListener('click', ()=>{ search.value=''; applyFilter(); });
  btnEmpty.addEventListener('click', async () => {
      if(await customConfirm('Kosongkan Keranjang?', 'Apakah Anda yakin ingin menghapus semua item di keranjang belanja?', 'danger')) {
          cart.clear(); renderCart(); compute();
      }
  });
  inputDiscount.addEventListener('input', compute);

  // 5. Submit Transaksi
  btnPay.addEventListener('click', async () => {
    if (cart.size === 0) { await customAlert('Keranjang Kosong!', 'Silakan pilih produk terlebih dahulu.', 'danger'); return; }
    if (!await customConfirm('Simpan Transaksi?', 'Apakah Anda yakin ingin menyimpan transaksi ini? Stok produk akan otomatis berkurang.', 'info')) return;

    // UI Loading
    const originalContent = btnPay.innerHTML;
    btnPay.innerHTML = '<svg class="animate-spin h-5 w-5 text-white inline-block mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...';
    btnPay.disabled = true;
    btnPay.classList.add('opacity-75', 'cursor-not-allowed');

    // Data Preparation
    const itemsData = [];
    let subtotalCalc = 0;
    let totalQty3500 = 0;
    cart.forEach((item) => {
        itemsData.push({ id: item.id, qty: item.qty });
        subtotalCalc += (item.qty * item.price);
        
        if (Number(item.price) === 3500) {
            totalQty3500 += item.qty;
        }
    });

    const promoDiscount = Math.floor(totalQty3500 / 3) * 500;
    const discountVal = Math.max(0, Number(inputDiscount.value || 0));
    const finalTotal = Math.max(0, subtotalCalc - promoDiscount - discountVal);

    try {
      const cabangAktifForPost = "{{ $cabangAktif ?? '' }}";
      const response = await fetch("{{ route('admin.laporan') }}", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        body: JSON.stringify({ items: itemsData, total: finalTotal, cabang: cabangAktifForPost })
      });

        const result = await response.json();

        if(response.ok) {
            await customAlert('Berhasil!', '✅ Transaksi Berhasil Disimpan!', 'success');
            window.location.reload(); // Refresh untuk update stok terbaru
        } else {
            await customAlert('Gagal!', '❌ Gagal: ' + (result.message || 'Error server'), 'danger');
            btnPay.innerHTML = originalContent;
            btnPay.disabled = false;
            btnPay.classList.remove('opacity-75', 'cursor-not-allowed');
        }
    } catch (e) {
        console.error(e);
        await customAlert('Gagal Koneksi!', '❌ Gagal koneksi server.', 'danger');
        btnPay.innerHTML = originalContent;
        btnPay.disabled = false;
        btnPay.classList.remove('opacity-75', 'cursor-not-allowed');
    }
  });

  // Init Awal
  renderProducts(products);
  renderCart();
});
</script>
@endsection
