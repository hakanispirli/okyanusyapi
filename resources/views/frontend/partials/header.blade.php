<!-- Okyanus Yapı - 2025 Modern Header -->
<div x-data="mobileMenu()">
    <header
        x-data="{ scrolled: false }"
        x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })"
        class="fixed top-0 left-0 right-0 z-40 transition-all duration-300"
        x-bind:class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-lg' : 'bg-white shadow-sm'">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">

                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center group">
                        <div class="relative">
                            @if($siteInformation && $siteInformation->header_logo)
                                <img src="{{ asset($siteInformation->header_logo) }}"
                                     alt="{{ $siteInformation->name }}"
                                     class="h-12 sm:h-14 lg:h-14 w-auto object-contain transition-all duration-300 group-hover:scale-[1.02]">
                            @else
                                <div class="h-12 sm:h-14 lg:h-14 w-32 sm:w-36 lg:w-36 bg-gradient-to-br from-primary-500 via-primary-600 to-primary-700 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300 group-hover:scale-105">
                                    <x-lucide-waves class="w-6 h-6 sm:w-7 sm:h-7 lg:w-7 lg:h-7 text-white" />
                                </div>
                            @endif
                            <div class="absolute -inset-1 bg-gradient-to-br from-primary-400 to-primary-600 rounded-xl opacity-0 group-hover:opacity-20 blur transition-opacity duration-300"></div>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex items-center gap-1">
                    <a href="{{ route('home') }}"
                        class="px-3.5 py-2 text-[15px] font-medium tracking-tight transition-all duration-200 rounded-lg {{ request()->routeIs('home') ? 'text-primary-600 bg-primary-50' : 'text-corporate-700 hover:text-primary-600 hover:bg-primary-50/50' }}">
                        Ana Sayfa
                    </a>

                    <a href="{{ route('about') }}"
                        class="px-3.5 py-2 text-[15px] font-medium tracking-tight {{ request()->routeIs('about') ? 'text-primary-600 bg-primary-50' : 'text-corporate-700 hover:text-primary-600 hover:bg-primary-50/50' }} transition-all duration-200 rounded-lg">
                        Hakkımızda
                    </a>

                    <!-- Hizmetlerimiz Dropdown -->
                    <div class="relative group">
                        <button type="button"
                            class="flex items-center gap-1 px-3.5 py-2 text-[15px] font-medium tracking-tight {{ request()->routeIs('services*') ? 'text-primary-600 bg-primary-50' : 'text-corporate-700 hover:text-primary-600 hover:bg-primary-50/50' }} transition-all duration-200 rounded-lg">
                            <span>Hizmetlerimiz</span>
                            <x-lucide-chevron-down class="w-3.5 h-3.5 transition-transform duration-200 group-hover:rotate-180" />
                        </button>

                        <!-- Dropdown Menu -->
                        <div class="absolute top-full left-0 mt-1 w-64 bg-white/95 backdrop-blur-md rounded-xl shadow-xl border border-corporate-100/50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-1 group-hover:translate-y-0">
                            <div class="p-1.5">
                                <!-- Ana Hizmetler Sayfası -->
                                <a href="{{ route('services') }}"
                                    class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium tracking-tight text-corporate-700 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition-all duration-200 group/item">
                                    <x-lucide-grid-3x3 class="w-4 h-4 text-corporate-400 group-hover/item:text-primary-500" />
                                    <span>Tüm Hizmetler</span>
                                </a>

                                <!-- Divider -->
                                <div class="my-1 h-px bg-corporate-100"></div>

                                <!-- Dinamik Hizmetler -->
                                @if($services && $services->count() > 0)
                                    @foreach($services as $service)
                                        <a href="{{ route('services.show', $service) }}"
                                            class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium tracking-tight text-corporate-700 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition-all duration-200 group/item">
                                            <x-lucide-briefcase class="w-4 h-4 text-corporate-400 group-hover/item:text-primary-500" />
                                            <span>{{ $service->name }}</span>
                                        </a>
                                    @endforeach
                                @else
                                    <div class="px-3 py-2.5 text-sm text-corporate-500 italic">
                                        Henüz hizmet eklenmemiş
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('blogs') }}"
                        class="px-3.5 py-2 text-[15px] font-medium tracking-tight {{ request()->routeIs('blogs*') ? 'text-primary-600 bg-primary-50' : 'text-corporate-700 hover:text-primary-600 hover:bg-primary-50/50' }} transition-all duration-200 rounded-lg">
                        Uygulamalar
                    </a>

                    <a href="{{ route('contact') }}"
                        class="px-3.5 py-2 text-[15px] font-medium tracking-tight {{ request()->routeIs('contact*') ? 'text-primary-600 bg-primary-50' : 'text-corporate-700 hover:text-primary-600 hover:bg-primary-50/50' }} transition-all duration-200 rounded-lg">
                        İletişim
                    </a>
                </nav>

                <!-- Right Actions -->
                <div class="flex items-center gap-2 sm:gap-3">
                    <!-- Contact Info (Desktop) -->
                    @if($siteInformation && $siteInformation->phone)
                        <a href="tel:{{ $siteInformation->phone }}"
                            class="hidden xl:flex items-center gap-2 px-3 py-2 text-sm font-medium tracking-tight text-corporate-700 hover:text-primary-600 rounded-lg transition-colors duration-200">
                            <x-lucide-phone class="w-4 h-4" />
                            <span>{{ $siteInformation->phone }}</span>
                        </a>
                    @endif

                    <!-- CTA Button -->
                    <a href="#"
                        class="hidden lg:inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white text-sm font-semibold tracking-tight rounded-lg hover:from-primary-700 hover:to-primary-800 transition-all duration-200 shadow-sm hover:shadow-md">
                        <x-lucide-send class="w-4 h-4" />
                        Teklif Al
                    </a>

                    <!-- Mobile Menu Button -->
                    <button
                        type="button"
                        @click="toggle()"
                        class="lg:hidden p-2 rounded-lg text-corporate-700 hover:bg-primary-50 hover:text-primary-600 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                        aria-label="Menüyü aç/kapat">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                x-bind:d="open ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Spacer for fixed header -->
    <div class="h-16 sm:h-20"></div>

    <!-- Mobile Menu Component -->
    <x-mobile-menu />
</div>
