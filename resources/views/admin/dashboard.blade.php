@extends('layouts.sidebar')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="min-h-screen p-6 bg-gray-50">
    <div class="flex justify-between items-center mb-6 bg-[#151D29] text-white p-6 rounded-2xl shadow-sm border border-gray-800/60 relative overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-xl font-bold tracking-wide">Cabang Pusat</h2>
            <p class="text-xs text-gray-400 mt-1">Toko Utama: Roti Enak</p>
        </div>
        <div class="relative z-10 flex items-center space-x-4">
            <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-sm font-bold border border-white/10">U</div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
 
         <div class="bg-white rounded-2xl border border-gray-150 p-5 shadow-sm">
             <div class="flex justify-between items-start">
                 <div>
                     <p class="text-gray-400 text-xs font-bold tracking-wider uppercase">Penjualan Hari Ini</p>
                     <h3 class="text-2xl font-extrabold text-gray-900 mt-2">Rp {{ number_format($penjualanToday ?? 0, 0, ',', '.') }}</h3>
                 </div>
                 <div class="p-2.5 bg-gray-50 border border-gray-100 rounded-xl text-gray-700">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                     </svg>
                 </div>
             </div>
         </div>
 
         <div class="bg-white rounded-2xl border border-gray-150 p-5 shadow-sm">
             <div class="flex justify-between items-start">
                 <div>
                     <p class="text-gray-400 text-xs font-bold tracking-wider uppercase">Total Stok Roti</p>
                     <h3 class="text-2xl font-extrabold text-gray-900 mt-2">{{ number_format($totalStok ?? 0, 0, ',', '.') }} Pcs</h3>
                 </div>
                 <div class="p-2.5 bg-gray-50 border border-gray-100 rounded-xl text-gray-700">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                     </svg>
                 </div>
             </div>
         </div>
 
         <div class="bg-white rounded-2xl border border-gray-150 p-5 shadow-sm">
             <div class="flex justify-between items-start">
                 <div>
                     <p class="text-gray-400 text-xs font-bold tracking-wider uppercase">Perlu Retur</p>
                     <h3 class="text-2xl font-extrabold text-red-600 mt-2">{{ number_format($perluRetur ?? 0, 0, ',', '.') }} Pcs</h3>
                     <span class="text-[10px] font-bold text-red-400 uppercase tracking-wider block mt-1">Kadaluwarsa Hari Ini</span>
                 </div>
                 <div class="p-2.5 bg-red-50 border border-red-100/50 rounded-xl text-red-650">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                     </svg>
                 </div>
             </div>
         </div>
 
         <div class="bg-white rounded-2xl border border-gray-150 p-5 shadow-sm">
             <div class="flex justify-between items-start">
                 <div>
                     <p class="text-gray-400 text-xs font-bold tracking-wider uppercase">Total Cabang</p>
                     <h3 class="text-2xl font-extrabold text-gray-900 mt-2">{{ $totalCabang ?? 0 }} Outlet</h3>
                 </div>
                 <div class="p-2.5 bg-gray-50 border border-gray-100 rounded-xl text-gray-700">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                     </svg>
                 </div>
             </div>
         </div>
     </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
 
        <div class="bg-white p-6 rounded-2xl border border-gray-150 shadow-sm">
            <h3 class="text-sm font-bold tracking-wider text-gray-400 uppercase mb-4">Tren Penjualan (Mingguan)</h3>
            <div class="relative h-64 w-full">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
 
        <div class="bg-white p-6 rounded-2xl border border-gray-150 shadow-sm">
            <h3 class="text-sm font-bold tracking-wider text-gray-400 uppercase mb-4">Stok Roti per Cabang</h3>
            <div class="relative h-64 w-full">
                <canvas id="stockChart"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Data untuk Chart (PHP Blade terpisah dari JS) --}}
<script>
    const chartLabelsWeek = {!! json_encode($labelsWeek ?? ['Sen','Sel','Rab','Kam','Jum','Sab','Min']) !!};
    const chartDataWeek = {!! json_encode($dataWeek ?? [1200,1900,1500,2200,1800,2800,3100]) !!};
    const chartLabelsCabang = {!! json_encode($labelsCabang ?? ['Cabang Pusat','Cabang A','Cabang B','Cabang C']) !!};
    const chartDataCabang = {!! json_encode($dataCabang ?? [320,210,180,140]) !!};
    const chartCabangCount = {!! json_encode(count($labelsCabang ?? ['a','b','c'])) !!};
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // 1. Konfigurasi Grafik Penjualan (Line Chart)
        const ctxSales = document.getElementById('salesChart').getContext('2d');
        new Chart(ctxSales, {
            type: 'line',
            data: {
                labels: chartLabelsWeek,
                datasets: [{
                    label: 'Penjualan (Ribuan Rp)',
                    data: chartDataWeek,
                    borderColor: '#3b82f6', // Warna Biru
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#3b82f6',
                    pointRadius: 4,
                    tension: 0.4, // Membuat garis melengkung (smooth)
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        grid: { borderDash: [2, 4] }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });

        // 2. Konfigurasi Grafik Stok (Bar Chart)
        const ctxStock = document.getElementById('stockChart').getContext('2d');
        const baseColors = ['#1f2937','#4b5563','#6b7280','#9ca3af','#cbd5e1','#e5e7eb'];
        const barColors = Array.from({length: chartCabangCount}).map((_,i) => baseColors[i] || '#9ca3af');

        new Chart(ctxStock, {
            type: 'bar',
            data: {
                labels: chartLabelsCabang,
                datasets: [{
                    label: 'Jumlah Stok Roti',
                    data: chartDataCabang,
                    backgroundColor: barColors,
                    borderRadius: 4,
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false } // Sembunyikan legenda default karena sudah ada judul
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [2, 4] }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endsection
