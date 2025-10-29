@extends('layouts.app')

@section('content')
<main class="min-h-screen flex items-center justify-center bg-gray-100 py-12">
  <div class="w-full max-w-md mx-auto">
    <div class="bg-white/60 backdrop-blur rounded-2xl shadow-xl overflow-hidden">
      <!-- Top branding -->
      <div class="flex flex-col items-center py-8 px-6">
        <img src="{{ asset('images/logo.png') }}" alt="La Fleur a Tory" class="w-28 h-28 object-contain mb-3">
        <h2 class="text-3xl" style="font-family: 'Great Vibes', cursive; letter-spacing: .5px;">La Fleur a Tory</h2>
        <p class="text-sm text-gray-500 mt-1">Flowers & moments — crafted with love</p>
      </div>

      <!-- Card / Form -->
      <div class="px-6 pb-8">
        <div class="bg-white rounded-xl shadow-md p-6">
          <form method="POST" action="{{ route('login') }}">
            @csrf

            <label class="block text-sm font-medium text-gray-700 mb-2" for="username">Username</label>
            <input id="username" name="email" type="text" autocomplete="username"
              class="w-full px-4 py-3 rounded-full bg-gray-100 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 mb-4"
              placeholder="Username">

            <label class="block text-sm font-medium text-gray-700 mb-2" for="password">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password"
              class="w-full px-4 py-3 rounded-full bg-gray-100 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 mb-4"
              placeholder="Enter Password">

            <div class="flex items-center justify-between mb-4">
              <label class="inline-flex items-center text-sm text-gray-600">
                <input type="checkbox" name="remember" class="form-checkbox h-4 w-4 text-gray-700">
                <span class="ml-2">Remember me</span>
              </label>
              <a href="#" class="text-sm text-gray-500 hover:underline">Forgot?</a>
            </div>

            <button type="submit"
              class="w-full py-3 rounded-full bg-gray-800 text-white font-medium hover:bg-gray-900 transition shadow-sm">
              Log in
            </button>
          </form>

          <p class="text-center text-sm text-gray-500 mt-4">
            don't have an account?
            <a href="{{ route('awal') }}" class="text-gray-800 font-medium hover:underline">Create new account</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
