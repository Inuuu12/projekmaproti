@extends('layouts.app')

@php
  use Illuminate\Support\Str;
@endphp

@section('content')
<div class="bg-gray-50 text-gray-800">
  {{-- Hero Section --}}
  <section class="relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-700 opacity-90"></div>
    <div class="relative z-10 max-w-6xl mx-auto px-6 py-24 text-center text-white">
      <p class="uppercase tracking-[0.4em] text-sm md:text-base text-gray-300">Company Profile</p>
      <h1 class="mt-6 text-4xl md:text-6xl font-bold">La Fleur a Tory</h1>
      <p class="mt-4 text-lg md:text-xl text-gray-200 max-w-3xl mx-auto">
        Brand bakery lokal dengan sentuhan "homey luxury" yang memadukan rasa khas, estetika menarik, dan kehangatan dalam setiap produk roti.
      </p>
      <div class="mt-10 flex flex-wrap justify-center gap-4 text-sm uppercase tracking-wider text-gray-200">
        <span class="px-4 py-2 border border-white/20 rounded-full">Est. 2024</span>
        <span class="px-4 py-2 border border-white/20 rounded-full">Homey Luxury</span>
        <span class="px-4 py-2 border border-white/20 rounded-full">Sukabumi</span>
      </div>
    </div>
  </section>

  {{-- Table of Content --}}
  <section class="py-16">
    <div class="max-w-5xl mx-auto px-6 grid md:grid-cols-[2fr,1.2fr] gap-10 items-center">
      <div>
        <h2 class="text-3xl font-semibold mb-6">Table of Content</h2>
        <div class="grid grid-cols-2 gap-y-4 text-sm md:text-base">
          <div class="flex gap-3"><span class="font-semibold text-gray-500">02</span><span>Table of Content</span></div>
          <div class="flex gap-3"><span class="font-semibold text-gray-500">08</span><span>Best Seller</span></div>
          <div class="flex gap-3"><span class="font-semibold text-gray-500">03</span><span>About Us</span></div>
          <div class="flex gap-3"><span class="font-semibold text-gray-500">09</span><span>Customer Profile</span></div>
          <div class="flex gap-3"><span class="font-semibold text-gray-500">04</span><span>Our Team</span></div>
          <div class="flex gap-3"><span class="font-semibold text-gray-500">10</span><span>Our Growth</span></div>
          <div class="flex gap-3"><span class="font-semibold text-gray-500">05</span><span>Our Philosophy</span></div>
          <div class="flex gap-3"><span class="font-semibold text-gray-500">11</span><span>Awards & Certificates</span></div>
          <div class="flex gap-3"><span class="font-semibold text-gray-500">06</span><span>Our History</span></div>
          <div class="flex gap-3"><span class="font-semibold text-gray-500">12</span><span>Future Projects</span></div>
          <div class="flex gap-3"><span class="font-semibold text-gray-500">07</span><span>Our Menu</span></div>
          <div class="flex gap-3"><span class="font-semibold text-gray-500">13</span><span>Contact</span></div>
        </div>
      </div>
      <div class="rounded-3xl overflow-hidden shadow-xl">
        <img src="{{ asset('images/company/profile-hero.jpg') }}" alt="Roti La Fleur a Tory" class="w-full h-full object-cover">
      </div>
    </div>
  </section>

  {{-- About Company --}}
  <section class="py-20 bg-white">
    <div class="max-w-5xl mx-auto px-6 grid md:grid-cols-[1.4fr,1fr] gap-12 items-center">
      <div>
        <h2 class="text-3xl font-semibold">About Company</h2>
        <p class="mt-6 text-lg leading-relaxed text-gray-600">
          La Fleur a Tory adalah brand bakery lokal yang menghadirkan roti manis berkualitas tinggi dengan harga terjangkau. Berdiri sejak tahun 2024, kami mengusung konsep "homey luxury" yang menggabungkan rasa otentik, estetika memikat, dan pelayanan hangat dalam setiap gigitan.
        </p>
        <p class="mt-4 text-lg leading-relaxed text-gray-600">
          Dengan produksi handmade dan pemilihan bahan pilihan, La Fleur a Tory tumbuh sebagai pilihan utama masyarakat Sukabumi yang mendambakan produk roti premium namun tetap ramah di kantong.
        </p>
      </div>
      <div class="bg-gray-100 rounded-[2.5rem] p-6 flex items-center justify-center">
        <img src="{{ asset('images/logo.png') }}" alt="Logo La Fleur a Tory" class="w-48 h-48 object-contain">
      </div>
    </div>
  </section>

  {{-- Our Team --}}
  <section class="py-20">
    <div class="max-w-6xl mx-auto px-6 text-center">
      <h2 class="text-3xl font-semibold">Our Team</h2>
      <p class="mt-4 text-gray-500 max-w-3xl mx-auto">Tim inti yang menjaga kualitas rasa, visual, dan pengalaman pelanggan La Fleur a Tory.</p>
      <div class="mt-12 grid md:grid-cols-3 gap-8">
        @php
          $team = [
            ['name' => 'Wina Anggraini', 'role' => 'Owner & Head Chef', 'image' => 'images/team/wina.jpg'],
            ['name' => 'Chandra Gunawan', 'role' => 'Executive', 'image' => 'images/team/chandra.jpg'],
            ['name' => 'Aiknye', 'role' => 'Staff', 'image' => 'images/team/aiknye.jpg'],
          ];
        @endphp
        @foreach($team as $member)
        <div class="bg-white shadow-lg rounded-3xl px-8 py-10">
          <div class="w-28 h-28 mx-auto rounded-full overflow-hidden">
            <img src="{{ asset($member['image']) }}" alt="{{ $member['name'] }}" class="w-full h-full object-cover">
          </div>
          <h3 class="mt-6 text-xl font-semibold">{{ $member['name'] }}</h3>
          <p class="mt-2 text-sm text-gray-500">{{ $member['role'] }}</p>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- Philosophy --}}
  <section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-6">
      <h2 class="text-3xl font-semibold text-center">Our Philosophy</h2>
      <div class="mt-12 grid md:grid-cols-3 gap-8">
        <div class="p-8 bg-gray-50 rounded-2xl shadow-sm">
          <h3 class="text-xl font-semibold">Vision</h3>
          <p class="mt-4 text-gray-600 leading-relaxed">Menjadi bakery lokal pilihan utama masyarakat Sukabumi dan sekitarnya dalam menyajikan roti manis berkualitas dan penuh cerita.</p>
        </div>
        <div class="p-8 bg-gray-50 rounded-2xl shadow-sm">
          <h3 class="text-xl font-semibold">Mission</h3>
          <ul class="mt-4 space-y-3 text-gray-600 leading-relaxed list-disc list-inside">
            <li>Menyediakan roti manis dengan rasa otentik dan tampilan menarik.</li>
            <li>Menjaga kualitas dan higienitas produksi.</li>
            <li>Menghadirkan pengalaman berbelanja yang hangat dan bersahabat.</li>
          </ul>
        </div>
        <div class="p-8 bg-gray-50 rounded-2xl shadow-sm">
          <h3 class="text-xl font-semibold">Background</h3>
          <p class="mt-4 text-gray-600 leading-relaxed">Tren makanan praktis dan lezat terus meningkat, terutama di kalangan muda dan keluarga. La Fleur a Tory hadir untuk menjawab kebutuhan tersebut dengan produk handmade, pilihan bahan premium, dan desain kemasan estetik.</p>
        </div>
      </div>
    </div>
  </section>

  {{-- History Timeline --}}
  <section class="py-20">
    <div class="max-w-6xl mx-auto px-6">
      <h2 class="text-3xl font-semibold text-center">Our History</h2>
      <div class="mt-12 grid md:grid-cols-4 gap-8">
        @php
          $history = [
            ['year' => '2018', 'text' => 'Memulai usaha buket bunga yang menginspirasi nama La Fleur a Tory di Sukabumi.'],
            ['year' => '2019', 'text' => 'Beradaptasi ke bisnis buket digital dan memperluas pemasaran secara daring.'],
            ['year' => '2024', 'text' => 'Mulai bereksperimen dengan bakery homemade, fokus pada produk roti manis premium.'],
            ['year' => '2025', 'text' => 'Meluncurkan brand bakery La Fleur a Tory dengan platform online & offline.'],
          ];
        @endphp
        @foreach($history as $item)
        <div class="bg-white rounded-3xl shadow-lg p-8">
          <div class="text-3xl font-bold text-gray-900">{{ $item['year'] }}</div>
          <p class="mt-4 text-gray-600 leading-relaxed">{{ $item['text'] }}</p>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- Menu --}}
  <section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-6 text-center">
      <h2 class="text-3xl font-semibold">Our Menu</h2>
      <p class="mt-4 text-gray-500">Varian roti manis unggulan yang disukai pelanggan La Fleur a Tory.</p>
      @php
        $menus = [
          'Garlic Cheese', 'Triple Choco', 'Choco Mede', 'Choco Caramel', 'Keju', 'Pepperoni', 'Kombinasi', 'Vanilla', 'Srikaya', 'Taro',
          'Durian', 'Tiramisu', 'Choco Peanut Butter', 'Almond', 'Blueberry', 'Cokelat Keju', 'Ham and Cheese', 'Strawberry Cheese', 'Abon', 'Abon Roll',
          'Cinnamon Roll', 'Cookies and Cream', 'Cokelat', 'Milk Cheese', 'Pizza', 'Pisang Coklat Keju', 'Kopi', 'Cream Cheese', 'Kacang Merah', 'Kacang Ijo',
          'Red Velvet Roll', 'Choco Vanilla', 'Choco Milk', 'Ubi', 'Sosis', 'Creamy Egg', 'Krim Ayam', 'Jamur'
        ];
      @endphp
      <div class="mt-12 grid sm:grid-cols-3 lg:grid-cols-5 gap-6">
        @foreach($menus as $menu)
        <div class="flex flex-col items-center bg-gray-50 rounded-2xl px-4 py-6 shadow-sm">
          <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center text-gray-500 text-3xl font-semibold">
            {{ Str::of($menu)->substr(0,1) }}
          </div>
          <p class="mt-4 font-medium">{{ $menu }}</p>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- Best Seller --}}
  <section class="py-20">
    <div class="max-w-5xl mx-auto px-6">
      <h2 class="text-3xl font-semibold text-center">Best Seller</h2>
      <div class="mt-12 grid md:grid-cols-2 gap-10 items-stretch">
        <div class="bg-white rounded-3xl shadow-lg p-8 flex flex-col">
          <div class="rounded-2xl overflow-hidden">
            <img src="{{ asset('images/company/best-seller-pizza.jpg') }}" alt="Pizza Bread" class="w-full h-48 object-cover">
          </div>
          <h3 class="mt-6 text-xl font-semibold">Pizza</h3>
          <p class="mt-3 text-gray-600 leading-relaxed">Sosis yang dibalut roti dan diberi saus pizza serta keju—favorit banyak kalangan karena perpaduan gurih dan manis yang seimbang.</p>
        </div>
        <div class="bg-white rounded-3xl shadow-lg p-8 flex flex-col">
          <div class="rounded-2xl overflow-hidden">
            <img src="{{ asset('images/company/best-seller-almond.jpg') }}" alt="Almond Bread" class="w-full h-48 object-cover">
          </div>
          <h3 class="mt-6 text-xl font-semibold">Almond</h3>
          <p class="mt-3 text-gray-600 leading-relaxed">Roti almond dengan campuran kacang almond gurih dan topping krim lembut, menghadirkan sensasi megah di setiap gigitan.</p>
        </div>
      </div>
    </div>
  </section>

  {{-- Customer Profile --}}
  <section class="py-20 bg-white">
    <div class="max-w-5xl mx-auto px-6">
      <h2 class="text-3xl font-semibold text-center">Customer Profile</h2>
      <div class="mt-12 grid md:grid-cols-2 gap-12 items-center">
        <div class="space-y-6">
          <div>
            <p class="text-sm tracking-widest text-gray-500 uppercase">Gender</p>
            <div class="mt-4 flex items-center gap-6">
              <div class="relative w-24 h-24">
                <svg viewBox="0 0 36 36" class="w-24 h-24">
                  <path class="text-gray-200" stroke-width="3" stroke="currentColor" fill="none" d="M18 2.0845
                    a 15.9155 15.9155 0 0 1 0 31.831
                    a 15.9155 15.9155 0 0 1 0 -31.831"/>
                  <path class="text-emerald-500" stroke-width="3" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845
                    a 15.9155 15.9155 0 0 1 0 31.831"/>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-sm font-semibold">
                  <span class="text-xl">60%</span>
                  <span class="text-gray-500">Female</span>
                </div>
              </div>
              <div class="relative w-24 h-24">
                <svg viewBox="0 0 36 36" class="w-24 h-24">
                  <path class="text-gray-200" stroke-width="3" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                  <path class="text-emerald-500" stroke-width="3" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 0 0 31.831"/>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-sm font-semibold">
                  <span class="text-xl">40%</span>
                  <span class="text-gray-500">Male</span>
                </div>
              </div>
            </div>
          </div>

          <div>
            <p class="text-sm tracking-widest text-gray-500 uppercase">Age Group</p>
            @php
              $ages = [
                ['label' => '4 - 11', 'value' => 70],
                ['label' => '12 - 50', 'value' => 85],
                ['label' => '50 - 75', 'value' => 45],
              ];
            @endphp
            <div class="mt-5 space-y-4">
              @foreach($ages as $age)
              <div>
                <div class="flex justify-between text-sm font-semibold text-gray-600">
                  <span>{{ $age['label'] }}</span>
                  <span>{{ $age['value'] }}%</span>
                </div>
                <div class="mt-2 h-3 rounded-full bg-gray-200 overflow-hidden">
                  <div class="h-full bg-emerald-500 progress-bar" data-progress="{{ (int) $age['value'] }}"></div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
        <div class="bg-gray-50 rounded-3xl shadow-inner p-10 space-y-6 text-gray-600">
          <p>Mayoritas pelanggan kami adalah keluarga muda dan profesional yang mencari camilan premium untuk acara keluarga, rapat, maupun hampers.</p>
          <p>Pelanggan perempuan mendominasi 60% pembelian, sementara pria 40% terutama untuk kebutuhan oleh-oleh.</p>
          <p>Kelompok usia 12−50 tahun merupakan basis terbesar karena aktivitas sosial dan kebutuhan konsumsi praktis.</p>
        </div>
      </div>
    </div>
  </section>

  {{-- Growth --}}
  <section class="py-20">
    <div class="max-w-6xl mx-auto px-6">
      <h2 class="text-3xl font-semibold text-center">Our Growth</h2>
      <div class="mt-12 grid md:grid-cols-[1.2fr,1fr] gap-12 items-center">
        <div class="bg-white rounded-3xl shadow-lg p-8">
          <canvas id="growthChart" class="w-full h-64"></canvas>
        </div>
        <div class="space-y-6 text-gray-600">
          <div>
            <h3 class="font-semibold text-gray-900">2018</h3>
            <p>Penjualan offline buket mencapai puluhan orderan per bulan.</p>
          </div>
          <div>
            <h3 class="font-semibold text-gray-900">2019</h3>
            <p>Buket cokelat viral secara online, mendongkrak ribuan pesanan.</p>
          </div>
          <div>
            <h3 class="font-semibold text-gray-900">2024</h3>
            <p>Omzet bulanan menembus Rp6.000.000 dari penjualan makanan berat secara online.</p>
          </div>
          <div>
            <h3 class="font-semibold text-gray-900">2025</h3>
            <p>Distribusi roti manis premium secara online & offline untuk pasar Sukabumi dan sekitarnya.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Awards / Certificates --}}
  <section class="py-20 bg-white">
    <div class="max-w-5xl mx-auto px-6 text-center">
      <h2 class="text-3xl font-semibold">Certified 2025</h2>
      <p class="mt-4 text-gray-500">Pengakuan terhadap komitmen kami dalam kualitas produk dan pengembangan usaha.</p>
      <div class="mt-12 grid sm:grid-cols-2 md:grid-cols-4 gap-8">
        @php
          $certs = [
            'Sertifikat Pelatihan Inkubator Bisnis',
            'Sertifikat Pelatihan Vokasi',
            'Sertifikat Pelatihan Kewirausahaan',
            'Sertifikat Keamanan Pangan',
          ];
        @endphp
        @foreach($certs as $cert)
        <div class="bg-gray-50 border border-gray-200 rounded-2xl py-8 px-4 flex items-center justify-center text-sm font-medium text-gray-600">
          {{ $cert }}
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- Future Projects --}}
  <section class="py-20">
    <div class="max-w-5xl mx-auto px-6">
      <h2 class="text-3xl font-semibold text-center">Future Projects</h2>
      <div class="mt-12 overflow-x-auto">
        <table class="w-full text-left text-sm md:text-base bg-white rounded-3xl shadow-lg overflow-hidden">
          <thead class="bg-gray-900 text-white">
            <tr>
              <th class="px-6 py-4">Project</th>
              <th class="px-6 py-4">2025</th>
              <th class="px-6 py-4">2026</th>
              <th class="px-6 py-4">2027</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <tr>
              <td class="px-6 py-4 font-semibold text-gray-900">Project 1</td>
              <td class="px-6 py-4">Menambah menu</td>
              <td class="px-6 py-4">Meningkatkan omzet</td>
              <td class="px-6 py-4">Menambah cabang</td>
            </tr>
            <tr>
              <td class="px-6 py-4 font-semibold text-gray-900">Project 2</td>
              <td class="px-6 py-4">Membangun tempat produksi</td>
              <td class="px-6 py-4">Membuka bakery shop</td>
              <td class="px-6 py-4">Mendirikan yayasan sosial</td>
            </tr>
            <tr>
              <td class="px-6 py-4 font-semibold text-gray-900">Project 3</td>
              <td class="px-6 py-4">Rekrutmen pegawai</td>
              <td class="px-6 py-4">Menambah aset</td>
              <td class="px-6 py-4">Membuka store baru</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  {{-- Contact --}}
  <section class="py-20 bg-gray-900 text-gray-100">
    <div class="max-w-5xl mx-auto px-6 text-center">
      <h2 class="text-3xl font-semibold">Thank You</h2>
      <p class="mt-3 text-gray-300">Hubungi kami untuk kolaborasi, pemesanan, atau kemitraan.</p>
      <div class="mt-10 grid sm:grid-cols-2 md:grid-cols-4 gap-8 text-sm">
        <div>
          <p class="font-semibold">Telepon</p>
          <a href="tel:087820802087" class="mt-2 block text-gray-300 hover:text-white">0878-2080-2087</a>
        </div>
        <div>
          <p class="font-semibold">Email</p>
          <a href="mailto:lafleuratorry@gmail.com" class="mt-2 block text-gray-300 hover:text-white">lafleuratorry@gmail.com</a>
        </div>
        <div>
          <p class="font-semibold">Platform</p>
          <p class="mt-2 text-gray-300">Grabfood • Gofood • Shopeefood</p>
        </div>
        <div>
          <p class="font-semibold">Alamat</p>
          <p class="mt-2 text-gray-300">Perum. Gading Panggon Mas, Sukabumi</p>
        </div>
      </div>
    </div>
  </section>
</div>

{{-- Chart.js untuk Growth --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.progress-bar[data-progress]').forEach(el => {
      const value = parseInt(el.dataset.progress || '0', 10);
      const clamped = Math.max(0, Math.min(100, value));
      el.style.width = `${clamped}%`;
    });

    const ctx = document.getElementById('growthChart');
    if (!ctx) return;

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['2018', '2019', '2024', '2025'],
        datasets: [{
          label: 'Order (index)',
          data: [60, 100, 130, 150],
          backgroundColor: ['#f87171', '#facc15', '#4ade80', '#60a5fa'],
          borderRadius: 12,
        }]
      },
      options: {
        plugins: {
          legend: { display: false }
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: { color: 'rgba(148,163,184,0.2)' },
            ticks: { color: '#475569' }
          },
          x: {
            grid: { display: false },
            ticks: { color: '#475569' }
          }
        }
      }
    });
  });
</script>
@endpush
@endsection

