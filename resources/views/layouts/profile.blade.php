<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Fleur a Tory — Premium Bakery</title>
    
    {{-- Load Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    {{-- Tailwind CSS via Vite --}}
    @vite('resources/css/app.css')
    
    <link rel="icon" href="{{ asset('favicon.ico') }}">
</head>
<body class="min-h-screen bg-gray-50 text-gray-800 antialiased font-sans">

    {{-- Sticky Glassmorphic Navbar (Adapting to page background) --}}
    <header class="fixed top-0 left-0 right-0 z-50 bg-black/20 backdrop-blur-md border-b border-white/10 transition-all duration-300 shadow-md {{ request()->routeIs('company.products') ? 'bg-white/80 border-gray-200 text-gray-900' : 'text-white' }}">
        <div class="container mx-auto max-w-7xl px-6 py-4 flex items-center justify-between">
            <a href="{{ route('company.profile') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('images/logo_bunga.png') }}" alt="Logo" class="w-12 h-12 object-contain group-hover:scale-105 transition duration-300 {{ request()->routeIs('company.products') ? '' : 'invert brightness-200' }}">
                <span class="text-2xl md:text-3xl tracking-wide font-semibold {{ request()->routeIs('company.products') ? 'text-gray-900' : 'text-white' }}" style="font-family: 'Great Vibes', cursive;">
                    La Fleur a Tory
                </span>
            </a>
            
            <nav class="hidden md:flex items-center gap-8 text-sm font-bold tracking-wider uppercase">
                @if(request()->routeIs('company.profile'))
                    <a href="#about-us" class="text-white hover:text-gray-200 transition-colors relative py-1">About Us</a>
                    <a href="#teams" class="text-white hover:text-gray-200 transition-colors relative py-1">Teams</a>
                    <a href="#certificate" class="text-white hover:text-gray-200 transition-colors relative py-1">Certificate</a>
                    <a href="{{ route('company.products') }}" class="text-white hover:text-gray-200 transition-colors relative py-1">Products</a>
                @else
                    <a href="{{ route('company.profile') }}#about-us" class="text-gray-700 hover:text-gray-900 transition-colors relative py-1">About Us</a>
                    <a href="{{ route('company.profile') }}#teams" class="text-gray-700 hover:text-gray-900 transition-colors relative py-1">Teams</a>
                    <a href="{{ route('company.profile') }}#certificate" class="text-gray-700 hover:text-gray-900 transition-colors relative py-1">Certificate</a>
                    <a href="{{ route('company.products') }}" class="text-gray-900 hover:text-black font-extrabold transition-colors relative py-1">
                        Products
                        <span class="absolute bottom-0 left-0 right-0 h-[2px] bg-gray-900"></span>
                    </a>
                @endif
            </nav>

            {{-- Mobile Navbar Toggle --}}
            <button id="mobile-profile-toggle" class="md:hidden p-2 rounded-lg {{ request()->routeIs('company.products') ? 'text-gray-900' : 'text-white' }} hover:bg-white/10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-profile-menu" class="hidden md:hidden border-b px-6 py-4 flex flex-col gap-4 text-sm font-bold tracking-wider uppercase {{ request()->routeIs('company.products') ? 'bg-white/95 border-gray-200 text-gray-800' : 'bg-gray-950/95 border-white/5 text-white' }}">
            @if(request()->routeIs('company.profile'))
                <a href="#about-us" class="hover:text-gray-200 py-1 transition-colors">About Us</a>
                <a href="#teams" class="hover:text-gray-200 py-1 transition-colors">Teams</a>
                <a href="#certificate" class="hover:text-gray-200 py-1 transition-colors">Certificate</a>
                <a href="{{ route('company.products') }}" class="hover:text-gray-200 py-1 transition-colors">Products</a>
            @else
                <a href="{{ route('company.profile') }}#about-us" class="hover:text-gray-900 py-1 transition-colors">About Us</a>
                <a href="{{ route('company.profile') }}#teams" class="hover:text-gray-900 py-1 transition-colors">Teams</a>
                <a href="{{ route('company.profile') }}#certificate" class="hover:text-gray-900 py-1 transition-colors">Certificate</a>
                <a href="{{ route('company.products') }}" class="hover:text-gray-900 py-1 transition-colors">Products</a>
            @endif
        </div>
    </header>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Slide 13 Slide-matched Footer --}}
    <footer class="bg-gray-950 text-gray-100 py-12 border-t border-gray-800 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-tr from-gray-900 via-transparent to-transparent opacity-40"></div>
        <div class="container mx-auto max-w-7xl px-6 relative z-10 text-center">
            <p class="text-gray-400 max-w-lg mx-auto mb-10 text-sm">Hubungi kami untuk kolaborasi, pemesanan, atau kemitraan.</p>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-5xl mx-auto text-left border-t border-gray-800/80 pt-6">
                <div>
                    <h4 class="text-xs font-semibold tracking-widest text-gray-500 uppercase mb-3">Telepon</h4>
                    <a href="tel:087820802087" class="text-gray-300 hover:text-white transition text-sm md:text-base font-medium">0878-2080-2087</a>
                </div>
                <div>
                    <h4 class="text-xs font-semibold tracking-widest text-gray-500 uppercase mb-3">Email</h4>
                    <a href="mailto:lafleuratorry@gmail.com" class="text-gray-300 hover:text-white transition text-sm md:text-base font-medium">lafleuratorry@gmail.com</a>
                </div>
                <div>
                    <h4 class="text-xs font-semibold tracking-widest text-gray-500 uppercase mb-3">Platform</h4>
                    <p class="text-gray-300 text-sm md:text-base font-medium">Grabfood • Gofood • Shopeefood</p>
                </div>
                <div>
                    <h4 class="text-xs font-semibold tracking-widest text-gray-500 uppercase mb-3">Alamat</h4>
                    <p class="text-gray-300 text-sm md:text-base font-medium leading-relaxed">Perum. Gading Panggon Mas, Sukabumi</p>
                </div>
            </div>

            <div class="mt-12 border-t border-gray-800/40 pt-6 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-gray-500">
                <p>© {{ date('Y') }} La Fleur a Tory. All rights reserved.</p>
                <div class="flex gap-4">
                    <a href="{{ route('login') }}" class="hover:text-gray-300 transition-colors">Admin Login</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.getElementById('mobile-profile-toggle');
            const menu = document.getElementById('mobile-profile-menu');
            if (toggle && menu) {
                toggle.addEventListener('click', () => {
                    menu.classList.toggle('hidden');
                });
                menu.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        menu.classList.add('hidden');
                    });
                });
            }

            // Scroll section highlighting for profile page
            if ("{{ request()->routeIs('company.profile') ? '1' : '' }}") {
                const navLinks = document.querySelectorAll('header nav a');
                const sections = document.querySelectorAll('section[id]');
                
                // Add relative hover and dynamic underline support classes
                navLinks.forEach(link => {
                    if (link.getAttribute('href').startsWith('#')) {
                        const underline = document.createElement('span');
                        underline.className = 'underline-indicator absolute bottom-0 left-0 right-0 h-[2px] bg-white transition-transform duration-300 scale-x-0';
                        link.appendChild(underline);
                    }
                });

                function highlightNav() {
                    let scrollY = window.pageYOffset;
                    sections.forEach(section => {
                        const sectionHeight = section.offsetHeight;
                        const sectionTop = section.offsetTop - 150;
                        const sectionId = section.getAttribute('id');
                        
                        if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
                            document.querySelectorAll('header nav a[href*=' + sectionId + '] .underline-indicator').forEach(ind => {
                                ind.classList.remove('scale-x-0');
                                ind.classList.add('scale-x-100');
                            });
                        } else {
                            document.querySelectorAll('header nav a[href*=' + sectionId + '] .underline-indicator').forEach(ind => {
                                ind.classList.remove('scale-x-100');
                                ind.classList.add('scale-x-0');
                            });
                        }
                    });
                }
                window.addEventListener('scroll', highlightNav);
                highlightNav();
            }
        });
    </script>
</body>
</html>
