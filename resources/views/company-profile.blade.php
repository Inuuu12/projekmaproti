@extends('layouts.profile')

@section('content')
<div class="relative bg-gray-50 overflow-hidden">
  
  {{-- Hero Section (matching login/awal background design) --}}
  <section class="relative h-screen min-h-screen flex items-center justify-center bg-black text-white overflow-hidden">
    {{-- Background image layer matching login/awal layout --}}
    <div
      class="absolute inset-0 bg-cover bg-center h-full w-full grayscale contrast-125 brightness-50"
      style="background-image: url('https://images.unsplash.com/photo-1509440159596-0249088772ff?w=1600&q=80&sat=-100');"
    ></div>
    
    {{-- Gradient overlay --}}
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/80"></div>

    {{-- Centered low opacity background logo_bunga.png --}}
    <div class="absolute inset-0 flex items-center justify-center opacity-10 pointer-events-none select-none">
      <img src="{{ asset('images/logo_bunga.png') }}" alt="Background Flower Logo" class="w-[45vh] h-[45vh] object-contain invert">
    </div>
    
    <div class="relative z-10 max-w-5xl mx-auto px-6 text-center py-20 flex flex-col items-center">
      <h2 class="uppercase tracking-[0.4em] text-sm md:text-base font-bold text-white mb-6">
        Company profile
      </h2>
      <h1 class="text-5xl md:text-7xl lg:text-8xl tracking-tight leading-none mb-8" style="font-family: 'Great Vibes', cursive;">
        La Fleur A Tory
      </h1>
      
      <div class="w-32 h-[1px] bg-white/20 mb-8"></div>
      
      <p class="max-w-xl text-lg md:text-xl text-gray-300 leading-relaxed font-light">
        Brand bakery lokal dengan harga yang terjangkau
      </p>
      
      <div class="mt-16 flex items-center justify-between w-full max-w-md text-sm font-semibold tracking-widest uppercase text-gray-400 border-t border-white/10 pt-6">
        <span>From 2024</span>
        <span>Sukabumi</span>
      </div>
    </div>
  </section>

  {{-- About Us (with embedded History Timeline) --}}
  <section id="about-us" class="py-24 bg-white relative scroll-mt-20">
    <div class="container mx-auto max-w-6xl px-6">
      
      {{-- Section Header --}}
      <div class="max-w-2xl mb-16">
        <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-gray-900 mt-2">About our company</h2>
        <div class="w-12 h-1 bg-gray-900 mt-4"></div>
      </div>

      <div class="grid lg:grid-cols-12 gap-12 items-center mb-20">
        <div class="lg:col-span-7 space-y-6 text-gray-600 leading-relaxed text-base">
          <p>
            <strong class="text-gray-950 font-medium">La Fleur a Tory</strong> adalah brand bakery lokal yang menghadirkan roti manis berkualitas tinggi dengan harga terjangkau. Berdiri sejak tahun 2024, bisnis ini mengusung konsep <span class="italic font-medium text-gray-950">"homey luxury"</span> yang memadukan rasa khas, estetika menarik, dan kehangatan dalam setiap produk roti.
          </p>
          <p>
            Tren konsumsi makanan praktis dan lezat terus meningkat, terutama di kalangan muda dan keluarga. Namun, belum banyak brand roti lokal yang menghadirkan kualitas premium dengan harga bersahabat. Kami hadir untuk menjawab kebutuhan tersebut dengan produk roti manis handmade, bahan pilihan, dan desain kemasan estetik.
          </p>
        </div>
        
        {{-- Right Side Logo Box matching Slide 3/13 --}}
        <div class="lg:col-span-5 bg-gray-50 border border-gray-100 rounded-3xl p-12 flex flex-col items-center justify-center shadow-sm relative group overflow-hidden">
          <div class="absolute inset-0 bg-gradient-to-br from-gray-100/30 to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
          <img src="{{ asset('images/logo_bunga.png') }}" alt="Logo" class="w-48 h-48 object-contain mb-6 transform group-hover:scale-105 transition duration-300">
          <span class="text-3xl" style="font-family: 'Great Vibes', cursive;">La Fleur a Tory</span>
        </div>
      </div>

      {{-- History Timeline --}}
      <div class="border-t border-gray-100 pt-20">
        <div class="max-w-2xl mb-12 text-left">
          <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-gray-900 mt-2">Our History</h2>
          <div class="w-12 h-1 bg-gray-900 mt-4"></div>
        </div>
        
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
          @php
            $history = [
              ['year' => '2018', 'title' => 'Buket Bunga', 'text' => 'Memulai usaha buket bunga yang menginspirasi nama La Fleur a Tory di Sukabumi.'],
              ['year' => '2019', 'title' => 'Adaptasi Digital', 'text' => 'Beradaptasi ke bisnis buket digital dan memperluas pemasaran secara daring.'],
              ['year' => '2024', 'title' => 'Eksperimen Roti', 'text' => 'Mulai bereksperimen dengan bakery homemade, fokus pada produk roti manis premium.'],
              ['year' => '2025', 'title' => 'Peluncuran Brand', 'text' => 'Meluncurkan brand bakery La Fleur a Tory dengan platform online & offline.'],
            ];
          @endphp
          @foreach($history as $item)
          <div class="bg-gray-50 border border-gray-100 p-8 rounded-2xl relative hover:shadow-md transition duration-300">
            <div class="text-3xl font-extrabold text-gray-900 mb-2">{{ $item['year'] }}</div>
            <h4 class="text-sm font-semibold text-gray-800 uppercase mb-3">{{ $item['title'] }}</h4>
            <p class="text-sm text-gray-500 leading-relaxed">{{ $item['text'] }}</p>
          </div>
          @endforeach
        </div>
      </div>

    </div>
  </section>

  {{-- Philosophy Section --}}
  <section class="py-24 bg-gray-50 border-y border-gray-100">
    <div class="container mx-auto max-w-6xl px-6">
      
      <div class="max-w-2xl mb-16 text-left">
        <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-gray-900 mt-2">Philosophy</h2>
        <div class="w-12 h-1 bg-gray-900 mt-4"></div>
      </div>

      <div class="grid md:grid-cols-3 gap-8">
        
        {{-- Vision Card --}}
        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
          <div>
            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
              <span class="w-2 h-2 rounded-full bg-gray-900"></span> Vision
            </h3>
            <p class="text-gray-600 text-sm leading-relaxed">
              Menjadi bakery lokal pilihan utama masyarakat Sukabumi dan sekitarnya dalam menyajikan roti manis berkualitas dan penuh cerita.
            </p>
          </div>
          <div class="mt-8 text-xs font-bold text-gray-400 tracking-wider uppercase">Masa Depan</div>
        </div>

        {{-- Mission Card --}}
        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
          <div>
            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
              <span class="w-2 h-2 rounded-full bg-gray-900"></span> Mission
            </h3>
            <ul class="text-gray-600 text-sm leading-relaxed space-y-3 list-disc list-inside">
              <li>Menyediakan roti manis dengan rasa otentik dan tampilan menarik.</li>
              <li>Menjaga kualitas dan higienitas produksi.</li>
              <li>Menghadirkan pengalaman berbelanja yang hangat dan bersahabat.</li>
            </ul>
          </div>
          <div class="mt-8 text-xs font-bold text-gray-400 tracking-wider uppercase">Komitmen</div>
        </div>

        {{-- Background Card --}}
        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
          <div>
            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
              <span class="w-2 h-2 rounded-full bg-gray-900"></span> Background
            </h3>
            <p class="text-gray-600 text-sm leading-relaxed">
              Tren konsumsi makanan praktis dan lezat terus meningkat, terutama di kalangan muda dan keluarga. Kami hadir untuk menjawab kebutuhan tersebut dengan produk handmade premium namun bersahabat.
            </p>
          </div>
          <div class="mt-8 text-xs font-bold text-gray-400 tracking-wider uppercase">Latar Belakang</div>
        </div>

      </div>

    </div>
  </section>

  {{-- Our Team (Circular design matching slide 4/13) --}}
  <section id="teams" class="py-24 bg-white scroll-mt-20">
    <div class="container mx-auto max-w-6xl px-6">
      
      <div class="max-w-2xl mb-16">
        <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-gray-900 mt-2">Our teams</h2>
        <div class="w-12 h-1 bg-gray-900 mt-4"></div>
      </div>

      <div class="grid md:grid-cols-3 gap-12">
        @php
          $team = [
            ['name' => 'Wina Anggraini', 'role' => 'Owner / Head Chef', 'initial' => 'WA'],
            ['name' => 'Chandra Gunawan', 'role' => 'Executive', 'initial' => 'CG'],
            ['name' => 'Aiknye', 'role' => 'Staff', 'initial' => 'A'],
          ];
        @endphp
        @foreach($team as $member)
        <div class="bg-gray-50 border border-gray-100 rounded-3xl p-8 text-center hover:scale-[1.02] transition duration-300 flex flex-col items-center">
          <div class="w-32 h-32 rounded-full bg-gray-900 text-white font-serif text-3xl font-extrabold flex items-center justify-center shadow-md border-4 border-white mb-6">
            {{ $member['initial'] }}
          </div>
          <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $member['name'] }}</h3>
          <p class="text-sm font-semibold tracking-wider text-gray-400 uppercase">{{ $member['role'] }}</p>
        </div>
        @endforeach
      </div>

    </div>
  </section>

  {{-- Certified Section --}}
  <section id="certificate" class="py-24 bg-gray-900 text-white scroll-mt-20">
    <div class="container mx-auto max-w-6xl px-6">
      
      <div class="max-w-2xl mb-16 text-left">
        <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-white mt-2">Certified 2025</h2>
        <div class="w-12 h-1 bg-white mt-4"></div>
      </div>

      <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-6">
        @php
          $certs = [
            'Sertifikat Pelatihan Inkubator Bisnis',
            'Sertifikat Pelatihan Vokasi',
            'Sertifikat Pelatihan Kewirausahaan',
            'Sertifikat Keamanan Pangan',
          ];
        @endphp
        @foreach($certs as $cert)
        <div class="bg-white/5 border border-white/10 rounded-2xl p-8 flex flex-col justify-between items-center text-center backdrop-blur-sm min-h-[160px] hover:border-white/30 transition">
          <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white mb-4">
            ✓
          </div>
          <p class="text-sm font-medium leading-relaxed text-gray-300">{{ $cert }}</p>
        </div>
        @endforeach
      </div>

    </div>
  </section>

</div>
@endsection
