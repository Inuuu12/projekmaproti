@extends('layouts.app')

@section('content')
<div class="min-h-screen">
  <!-- Hero Section -->
  <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
  <div class="relative z-10 container mx-auto px-4 text-center">
  <h1 class="text-5xl md:text-6xl font-serif italic text-gray-900 mb-8">La Fleur a Tory</h1>
  <h2 class="text-4xl md:text-5xl lg:text-6xl font-serif italic text-gray-900 mb-6 max-w-4xl mx-auto leading-tight">
    Where Beauty Blooms and Stories Unfold
  </h2>

  <p class="text-lg md:text-xl text-gray-600 mb-12 max-w-2xl mx-auto leading-relaxed">
    Experience the art of floral expression. Each arrangement is crafted with passion, speaking volumes without words.
  </p>
</div>

<!-- Decorative gradient -->
<div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-gray-100 to-transparent"></div>
  </section>

  <!-- Features Section -->
  <section class="py-20 px-4">
    <div class="container mx-auto">
      <h3 class="text-3xl md:text-4xl font-serif italic text-center text-gray-900 mb-16">
        Our Promise
      </h3>

      <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
        <!-- Feature 1 -->
        <div class="glass-effect rounded-2xl p-8 shadow-md hover:shadow-lg transition text-center">
          <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
            <svg class="w-8 h-8 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
          <h4 class="text-xl font-semibold mb-3 text-gray-900">Premium Quality</h4>
          <p class="text-gray-600">
            Hand-selected flowers from the finest gardens, ensuring every bloom is perfect.
          </p>
        </div>

        <!-- Feature 2 -->
        <div class="glass-effect rounded-2xl p-8 shadow-md hover:shadow-lg transition text-center">
          <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
            <svg class="w-8 h-8 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <h4 class="text-xl font-semibold mb-3 text-gray-900">Timely Delivery</h4>
          <p class="text-gray-600">
            Swift and careful delivery to ensure your flowers arrive fresh and beautiful.
          </p>
        </div>

        <!-- Feature 3 -->
        <div class="glass-effect rounded-2xl p-8 shadow-md hover:shadow-lg transition text-center">
          <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
            <svg class="w-8 h-8 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
          </div>
          <h4 class="text-xl font-semibold mb-3 text-gray-900">Made with Love</h4>
          <p class="text-gray-600">
            Each arrangement is crafted with passion and attention to every detail.
          </p>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
