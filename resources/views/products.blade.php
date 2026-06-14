@extends('layouts.profile')

@section('content')
<div class="bg-gray-50 py-24 md:py-32 min-h-screen">
    <div class="container mx-auto max-w-7xl px-6">
        
        {{-- Section Header --}}
        <div class="max-w-3xl mb-16 text-center mx-auto flex flex-col items-center">
            <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-gray-900 mt-2">Daftar Produk</h1>
            <div class="w-12 h-1 bg-gray-900 mt-4"></div>
            <p class="mt-6 text-gray-500 max-w-xl text-sm md:text-base">
                Nikmati persembahan roti manis premium buatan tangan kami dengan cita rasa otentik dan kemasan higienis yang elegan.
            </p>
        </div>

        {{-- Best Sellers Section --}}
        <section class="mb-20">
            <div class="flex items-center gap-4 mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Best Seller</h2>
                <div class="h-[1px] bg-gray-200 flex-1"></div>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                {{-- Pizza Bread --}}
                <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition duration-300 flex flex-col md:flex-row">
                    <div class="md:w-1/2 relative min-h-[200px] bg-gray-100">
                        <img src="{{ asset('images/pizza.jpg') }}" alt="Pizza Bread" class="absolute inset-0 w-full h-full object-cover">
                        <span class="absolute top-4 left-4 bg-gray-900 text-white text-xs font-semibold uppercase tracking-widest px-3 py-1 rounded-full">POPULAR</span>
                    </div>
                    <div class="p-8 md:w-1/2 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Pizza</h3>
                            <p class="text-sm text-gray-500 leading-relaxed mb-4">
                                Roti manis lembut bertabur sosis premium berkualitas, berpadu saus tomat pilihan serta parutan keju gurih yang melimpah.
                            </p>
                        </div>
                        <div class="text-lg font-extrabold text-gray-900">Rp 12.000 <span class="text-xs text-gray-400 font-normal">/ pcs</span></div>
                    </div>
                </div>

                {{-- Almond Bread --}}
                <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition duration-300 flex flex-col md:flex-row">
                    <div class="md:w-1/2 relative min-h-[200px] bg-gray-100">
                        <img src="{{ asset('images/almond.jpeg') }}" alt="Almond Bread" class="absolute inset-0 w-full h-full object-cover">
                        <span class="absolute top-4 left-4 bg-gray-900 text-white text-xs font-semibold uppercase tracking-widest px-3 py-1 rounded-full">POPULAR</span>
                    </div>
                    <div class="p-8 md:w-1/2 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Almond</h3>
                            <p class="text-sm text-gray-500 leading-relaxed mb-4">
                                Roti manis bertekstur krispi di luar dan lembut di dalam, dilapisi Topping kacang almond gurih renyah serta krim mentega pilihan.
                            </p>
                        </div>
                        <div class="text-lg font-extrabold text-gray-900">Rp 15.000 <span class="text-xs text-gray-400 font-normal">/ pcs</span></div>
                    </div>
                </div>
            </div>
        </section>

        {{-- All Products Grid (Dynamic from DB) --}}
        <section>
            <div class="flex items-center gap-4 mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Product List</h2>
                <div class="h-[1px] bg-gray-200 flex-1"></div>
            </div>

            @if($produks->isEmpty())
                <div class="bg-white border border-gray-100 rounded-3xl p-12 text-center text-gray-500 shadow-sm">
                    Belum ada menu produk terdaftar. Pemilik toko dapat menambahkan melalui Dashboard Admin.
                </div>
            @else
                <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    @foreach($produks as $produk)
                        <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition duration-300 flex flex-col justify-between">
                            <div class="relative bg-gray-100 pt-[75%]">
                                @if($produk->foto && file_exists(public_path($produk->foto)))
                                    <img src="{{ asset($produk->foto) }}" alt="{{ $produk->nama }}" class="absolute inset-0 w-full h-full object-cover">
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center text-gray-400 text-sm font-semibold uppercase bg-gray-100">
                                        {{ substr($produk->nama, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="p-6 space-y-3">
                                <h3 class="text-lg font-bold text-gray-900 truncate">{{ $produk->nama }}</h3>
                                <p class="text-xs text-gray-500 line-clamp-2 min-h-[32px] leading-relaxed">
                                    {{ $produk->deskripsi ?? 'Roti manis premium buatan tangan yang diolah secara higienis menggunakan bahan berkualitas.' }}
                                </p>
                                <div class="flex items-center justify-between pt-3 border-t border-gray-50">
                                    <span class="text-base font-bold text-gray-900">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                                    <span class="text-[10px] uppercase font-bold tracking-wider text-gray-400">Tersedia</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

    </div>
</div>
@endsection
