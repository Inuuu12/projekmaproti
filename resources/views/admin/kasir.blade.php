@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen p-4 md:p-6 bg-gray-100">
  <div class="max-w-7xl mx-auto">

    {{-- === HEADER === --}}
    <header class="bg-gray-800/90 text-gray-100 rounded-lg px-4 md:px-6 py-4 mb-4 md:mb-6 sticky top-0 z-30 backdrop-blur border border-gray-700/40">
      <h2 class="text-lg md:text-xl font-semibold">Kasir - Barang Keluar</h2>
      <p class="text-sm text-gray-300">
        Cabang aktif: <span class="font-semibold text-yellow-400">{{ $cabangAktif ?? '-' }}</span>.
        Pakai tombol + untuk menambahkan ke keranjang.
      </p>
    </header>

    {{-- BAGIAN FILTER SUDAH DIHAPUS --}}

    <section class="grid grid-cols-1 lg:grid-cols-12 gap-4 md:gap-6">

      {{-- === KOLOM KIRI: PRODUK GRID === --}}
      <div class="lg:col-span-7 space-y-4">
        {{-- Search Bar --}}
        <div class="bg-white rounded-lg shadow-md p-4 md:p-5">
          <div class="grid grid-cols-1 md:grid-cols-12 gap-3 md:gap-4">
            <div class="md:col-span-8">
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <input id="search" class="w-full rounded border border-gray-300 pl-10 px-3 py-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Cari nama produk...">
              </div>
            </div>
            <div class="md:col-span-4">
              <button id="btn-reset" class="w-full rounded px-3 py-2 border border-gray-300 text-gray-600 hover:bg-gray-50 transition text-sm font-medium">Reset Pencarian</button>
            </div>
          </div>
        </div>

        {{-- Grid Produk --}}
        <div class="bg-white rounded-lg shadow-md p-3 md:p-4 min-h-[400px]">
          <div id="product-grid" class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-3 gap-3 md:gap-4">
            {{-- Produk akan dirender oleh Javascript --}}
            <div class="col-span-full flex justify-center py-10">
                <svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </path>
                </svg>
            </div>
          </div>
          <p class="text-xs text-gray-500 mt-4 italic text-center border-t pt-2">
            Stok otomatis berkurang saat transaksi disimpan.
          </p>
        </div>
      </div>

      {{-- === KOLOM KANAN: KERANJANG === --}}
      <div class="lg:col-span-5 space-y-4 lg:sticky lg:top-24 self-start">
        <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col border border-gray-200">
          <div class="px-4 md:px-5 py-3 border-b bg-gray-50 flex items-center justify-between">
            <h3 class="font-bold text-gray-700 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Keranjang
            </h3>
            <button id="btn-empty" class="text-xs font-medium text-red-600 hover:text-red-800 hover:underline">Kosongkan</button>
          </div>

          <div class="p-0 overflow-y-auto max-h-[50vh]">
            <table class="min-w-full text-sm divide-y divide-gray-100">
              <thead class="bg-gray-50 text-gray-500">
                <tr>
                  <th class="text-left py-2 px-3 font-medium">Produk</th>
                  <th class="text-center py-2 px-1 font-medium">Qty</th>
                  <th class="text-right py-2 px-3 font-medium">Total</th>
                  <th class="w-8"></th>
                </tr>
              </thead>
              <tbody id="cart-body" class="divide-y divide-gray-100">
                {{-- Item keranjang render di sini --}}
              </tbody>
            </table>
          </div>

          {{-- Summary & Pay Button --}}
          <div class="p-4 bg-gray-50 border-t space-y-3">
            <div class="flex items-center justify-between text-sm">
              <span class="text-gray-600">Total Item</span>
              <span id="sum-items" class="font-medium text-gray-900">0</span>
            </div>
            <div class="flex items-center justify-between text-sm">
              <span class="text-gray-600">Subtotal</span>
              <span id="sum-subtotal" class="font-medium text-gray-900">Rp 0</span>
            </div>
            <div class="flex items-center justify-between text-sm">
              <span class="text-gray-600">Diskon (Rp)</span>
              <input id="input-discount" type="number" min="0" value="0" class="w-24 text-right rounded border-gray-300 px-2 py-1 text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex items-center justify-between text-lg border-t border-gray-200 pt-3">
              <span class="font-bold text-gray-800">Total Bayar</span>
              <span id="sum-total" class="font-extrabold text-blue-700">Rp 0</span>
            </div>

            <button id="btn-pay" type="button" class="w-full mt-2 rounded-lg bg-blue-600 text-white py-3 hover:bg-blue-700 font-bold shadow-lg shadow-blue-200 transition transform active:scale-95 flex justify-center items-center gap-2">
                <span>Simpan Transaksi</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </button>
          </div>
        </div>
      </div>
    </section>

    {{-- === BAGIAN BAWAH: RINGKASAN TABEL STOK (PENGAMAN DITAMBAHKAN) === --}}
    @if(isset($stoks) && count($stoks) > 0)
    <section class="mt-10 pt-6 border-t border-gray-200">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">
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
        ? 'bg-gray-300 text-gray-500 cursor-not-allowed'
        : 'bg-blue-600 hover:bg-blue-700 text-white shadow-md hover:shadow-lg transform hover:-translate-y-0.5';

      const card = document.createElement('div');
      card.className = 'bg-white border rounded-xl overflow-hidden flex flex-col justify-between h-full transition hover:shadow-lg relative group';

      card.innerHTML = `
        <div class="p-3 pb-0">
            <div class="aspect-[4/3] rounded-lg overflow-hidden bg-gray-100 relative mb-3">
                <img src="${imgSrc}" alt="${nama}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110" onerror="this.src=window.APP_FALLBACK_IMG">
                ${isHabis ? '<div class="absolute inset-0 bg-black/50 flex items-center justify-center text-white font-bold tracking-wider text-sm">HABIS</div>' : ''}
            </div>
            <h4 class="font-bold text-gray-800 text-sm md:text-base leading-tight mb-1 line-clamp-2" title="${nama}">${nama}</h4>
            <div class="flex items-center justify-between mt-2">
                 <span class="text-xs font-medium px-2 py-0.5 rounded ${stok <= 0 ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'}">
                    Stok: ${stok}
                 </span>
            </div>
            <div class="text-blue-700 font-extrabold text-base md:text-lg mt-1">${rupiah(harga)}</div>
        </div>
        <div class="p-3 pt-2">
            <button class="w-full py-2 rounded-lg text-sm font-semibold transition flex items-center justify-center gap-1 ${btnClass}" ${isHabis ? 'disabled' : ''}>
               ${isHabis ? 'Stok Habis' : `
               <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
               Tambah
               `}
            </button>
        </div>
      `;

      if(!isHabis){
          const btn = card.querySelector('button');
          btn.addEventListener('click', () => addToCart(p));
      }
      grid.appendChild(card);
    });
  }

  // 3. Logic Keranjang
  function addToCart(product) {
    const pId = product.id;
    const currentItem = cart.get(pId);
    const currentQty = currentItem ? currentItem.qty : 0;
    const maxStock = getStok(product);

    if (currentQty + 1 > maxStock) {
        alert(`Stok tidak cukup! Hanya tersedia ${maxStock}`);
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
                <td colspan="4" class="text-center py-8 text-gray-400 text-sm">
                    <div class="flex flex-col items-center">
                        <svg class="w-8 h-8 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        Keranjang Kosong
                    </div>
                </td>
            </tr>`;
        return;
    }

    [...cart.values()].forEach(item => {
      const tr = document.createElement('tr');
      tr.className = "group hover:bg-blue-50 transition";
      tr.innerHTML = `
        <td class="py-3 px-3 align-top">
          <div class="font-semibold text-gray-800 text-sm line-clamp-1" title="${item.name}">${item.name}</div>
          <div class="text-xs text-gray-500">${rupiah(item.price)}</div>
        </td>
        <td class="py-3 px-1 text-center align-top">
          <div class="inline-flex items-center bg-white border rounded-md shadow-sm h-7">
            <button class="px-2 h-full text-gray-600 hover:bg-gray-100 rounded-l-md btn-dec font-bold">-</button>
            <span class="w-8 text-center text-sm font-medium select-none">${item.qty}</span>
            <button class="px-2 h-full text-gray-600 hover:bg-gray-100 rounded-r-md btn-inc font-bold">+</button>
          </div>
        </td>
        <td class="py-3 px-3 text-right align-top text-sm font-bold text-gray-700">
            ${rupiah(item.price * item.qty)}
        </td>
        <td class="py-3 px-1 text-center align-middle">
          <button class="text-gray-400 hover:text-red-600 btn-remove p-1 rounded-full hover:bg-red-50 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
          </button>
        </td>
      `;

      tr.querySelector('.btn-dec').addEventListener('click', () => {
        if(item.qty > 1) { item.qty--; cart.set(item.id, item); }
        else { cart.delete(item.id); }
        renderCart(); compute();
      });

      tr.querySelector('.btn-inc').addEventListener('click', () => {
        if(item.qty < item.max) { item.qty++; cart.set(item.id, item); }
        else { alert('Mentok stok!'); }
        renderCart(); compute();
      });

      tr.querySelector('.btn-remove').addEventListener('click', () => {
        cart.delete(item.id); renderCart(); compute();
      });

      cartBody.appendChild(tr);
    });
  }

  function compute(){
    let items = 0; let subtotal = 0;
    cart.forEach(it => { items += it.qty; subtotal += it.qty * it.price; });
    const discount = Math.max(0, Number(inputDiscount.value || 0));
    const total = Math.max(0, subtotal - discount);

    sumItems.textContent = items;
    sumSubtotal.textContent = rupiah(subtotal);
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
  btnEmpty.addEventListener('click', () => {
      if(confirm('Yakin ingin mengosongkan keranjang?')) {
          cart.clear(); renderCart(); compute();
      }
  });
  inputDiscount.addEventListener('input', compute);

  // 5. Submit Transaksi
  btnPay.addEventListener('click', async () => {
    if (cart.size === 0) { alert('Keranjang kosong!'); return; }
    if (!confirm('Simpan data ini ke laporan? Stok akan berkurang.')) return;

    // UI Loading
    const originalContent = btnPay.innerHTML;
    btnPay.innerHTML = '<svg class="animate-spin h-5 w-5 text-white inline-block mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...';
    btnPay.disabled = true;
    btnPay.classList.add('opacity-75', 'cursor-not-allowed');

    // Data Preparation
    const itemsData = [];
    let subtotalCalc = 0;
    cart.forEach((item) => {
        itemsData.push({ id: item.id, qty: item.qty });
        subtotalCalc += (item.qty * item.price);
    });
    const discountVal = Math.max(0, Number(inputDiscount.value || 0));
    const finalTotal = Math.max(0, subtotalCalc - discountVal);

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
            alert('✅ Transaksi Berhasil Disimpan!');
            window.location.reload(); // Refresh untuk update stok terbaru
        } else {
            alert('❌ Gagal: ' + (result.message || 'Error server'));
            btnPay.innerHTML = originalContent;
            btnPay.disabled = false;
            btnPay.classList.remove('opacity-75', 'cursor-not-allowed');
        }
    } catch (e) {
        console.error(e);
        alert('❌ Gagal koneksi server.');
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
