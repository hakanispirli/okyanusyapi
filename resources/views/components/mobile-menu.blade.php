@props(['menuItems' => []])

<!-- Mobile Menu Overlay -->
<div x-show="open"
     x-transition:enter="transition-opacity ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click="close()"
     class="fixed inset-0 bg-corporate-900/60 backdrop-blur-sm z-50 lg:hidden"
     style="display: none;">
</div>

<!-- Mobile Menu Panel -->
<div x-show="open"
     x-transition:enter="transition ease-out duration-300 transform"
     x-transition:enter-start="-translate-x-full"
     x-transition:enter-end="translate-x-0"
     x-transition:leave="transition ease-in duration-200 transform"
     x-transition:leave-start="translate-x-0"
     x-transition:leave-end="-translate-x-full"
     class="fixed inset-y-0 left-0 z-50 w-full max-w-sm bg-white/95 backdrop-blur-xl shadow-2xl lg:hidden overflow-y-auto"
     style="display: none;">

    <!-- Mobile Menu Header -->
    <div class="sticky top-0 bg-white/80 backdrop-blur-md border-b border-corporate-100/50 px-5 py-4 z-10">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group" @click="close()">
                @if($siteInformation && $siteInformation->header_logo)
                    <img src="{{ asset($siteInformation->header_logo) }}"
                         alt="{{ $siteInformation->name }}"
                         class="h-10 w-auto object-contain">
                @else
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 via-primary-600 to-primary-700 rounded-xl flex items-center justify-center shadow-sm">
                        <x-lucide-waves class="w-5 h-5 text-white" />
                    </div>
                @endif
            </a>

            <!-- Close Button -->
            <button type="button"
                    @click="close()"
                    class="p-2 rounded-lg text-corporate-700 hover:bg-primary-50 hover:text-primary-600 transition-all duration-200"
                    aria-label="Menüyü kapat">
                <x-lucide-x class="w-5 h-5" />
            </button>
        </div>
    </div>

    <!-- Mobile Menu Content -->
    <div class="px-5 py-6">
        <!-- Navigation Links -->
        <nav class="space-y-1">
            <!-- Ana Sayfa -->
            <a href="{{ route('home') }}"
               @click="close()"
               class="flex items-center gap-3 px-3 py-3 rounded-lg text-[15px] font-medium tracking-tight {{ request()->routeIs('home') ? 'text-primary-600 bg-primary-50' : 'text-corporate-700 hover:bg-primary-50 hover:text-primary-600' }} transition-all duration-200">
                <x-lucide-house class="w-5 h-5" />
                Ana Sayfa
            </a>

            <!-- Hakkımızda -->
            <a href="{{ route('about') }}"
               @click="close()"
               class="flex items-center gap-3 px-3 py-3 rounded-lg text-[15px] font-medium tracking-tight {{ request()->routeIs('about') ? 'text-primary-600 bg-primary-50' : 'text-corporate-700 hover:bg-primary-50 hover:text-primary-600' }} transition-all duration-200">
                <x-lucide-info class="w-5 h-5" />
                Hakkımızda
            </a>

            <!-- Hizmetlerimiz Dropdown -->
            <div class="space-y-1">
                <button type="button"
                        @click="toggleDropdown('services')"
                        class="w-full flex items-center justify-between px-3 py-3 rounded-lg text-[15px] font-medium tracking-tight {{ request()->routeIs('services*') ? 'text-primary-600 bg-primary-50' : 'text-corporate-700 hover:bg-primary-50 hover:text-primary-600' }} transition-all duration-200">
                    <div class="flex items-center gap-3">
                        <x-lucide-briefcase class="w-5 h-5" />
                        Hizmetlerimiz
                    </div>
                    <x-lucide-chevron-down class="w-4 h-4 transition-transform duration-200"
                                           x-bind:class="isDropdownOpen('services') ? 'rotate-180' : ''" />
                </button>

                <!-- Dropdown Items -->
                <div x-show="isDropdownOpen('services')"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-1"
                     class="ml-8 space-y-0.5 pt-1"
                     style="display: none;">

                    <!-- Ana Hizmetler Sayfası -->
                    <a href="{{ route('services') }}"
                       @click="close()"
                       class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-medium tracking-tight text-corporate-600 hover:bg-primary-50 hover:text-primary-600 transition-all duration-200">
                        <x-lucide-grid-3x3 class="w-4 h-4" />
                        Tüm Hizmetler
                    </a>

                    <!-- Dinamik Hizmetler -->
                    @if($services && $services->count() > 0)
                        @foreach($services as $service)
                            <a href="{{ route('services.show', $service) }}"
                               @click="close()"
                               class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-medium tracking-tight text-corporate-600 hover:bg-primary-50 hover:text-primary-600 transition-all duration-200">
                                <x-lucide-briefcase class="w-4 h-4" />
                                {{ $service->name }}
                            </a>
                        @endforeach
                    @else
                        <div class="px-3 py-2.5 text-sm text-corporate-500 italic">
                            Henüz hizmet eklenmemiş
                        </div>
                    @endif
                </div>
            </div>

            <!-- Uygulamalar -->
            <a href="{{ route('blogs') }}"
               @click="close()"
               class="flex items-center gap-3 px-3 py-3 rounded-lg text-[15px] font-medium tracking-tight {{ request()->routeIs('blogs*') ? 'text-primary-600 bg-primary-50' : 'text-corporate-700 hover:bg-primary-50 hover:text-primary-600' }} transition-all duration-200">
                <x-lucide-newspaper class="w-5 h-5" />
                Uygulamalar
            </a>

            <!-- İletişim -->
            <a href="{{ route('contact') }}"
               @click="close()"
               class="flex items-center gap-3 px-3 py-3 rounded-lg text-[15px] font-medium tracking-tight {{ request()->routeIs('contact*') ? 'text-primary-600 bg-primary-50' : 'text-corporate-700 hover:bg-primary-50 hover:text-primary-600' }} transition-all duration-200">
                <x-lucide-mail class="w-5 h-5" />
                İletişim
            </a>
        </nav>

        <!-- CTA Button -->
        <div class="mt-6 pt-6 border-t border-corporate-100">
            <a href="#"
               @click="close()"
               class="flex items-center justify-center gap-2 w-full px-5 py-3.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl text-sm font-semibold tracking-tight hover:from-primary-700 hover:to-primary-800 transition-all duration-200 shadow-sm hover:shadow-md">
                <x-lucide-send class="w-4 h-4" />
                Teklif Al
            </a>
        </div>

        <!-- Contact Info -->
        <div class="mt-6 pt-6 border-t border-corporate-100 space-y-3">
            @if($siteInformation && $siteInformation->phone)
                <a href="tel:{{ $siteInformation->phone }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-primary-50 transition-colors duration-200 group">
                    <div class="flex items-center justify-center w-10 h-10 bg-primary-50 group-hover:bg-primary-100 rounded-lg flex-shrink-0 transition-colors duration-200">
                        <x-lucide-phone class="w-4 h-4 text-primary-600" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[10px] font-medium tracking-wide text-corporate-500 uppercase">Telefon</p>
                        <p class="text-sm font-semibold tracking-tight text-corporate-900 group-hover:text-primary-600 transition-colors duration-200">
                            {{ $siteInformation->phone }}
                        </p>
                    </div>
                </a>
            @endif

            @if($siteInformation && $siteInformation->email)
                <a href="mailto:{{ $siteInformation->email }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-primary-50 transition-colors duration-200 group">
                    <div class="flex items-center justify-center w-10 h-10 bg-primary-50 group-hover:bg-primary-100 rounded-lg flex-shrink-0 transition-colors duration-200">
                        <x-lucide-mail class="w-4 h-4 text-primary-600" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[10px] font-medium tracking-wide text-corporate-500 uppercase">E-posta</p>
                        <p class="text-sm font-semibold tracking-tight text-corporate-900 group-hover:text-primary-600 transition-colors duration-200 truncate">
                            {{ $siteInformation->email }}
                        </p>
                    </div>
                </a>
            @endif

            @if($siteInformation && $siteInformation->address)
                <div class="flex items-start gap-3 p-3 rounded-lg">
                    <div class="flex items-center justify-center w-10 h-10 bg-primary-50 rounded-lg flex-shrink-0">
                        <x-lucide-map-pin class="w-4 h-4 text-primary-600" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[10px] font-medium tracking-wide text-corporate-500 uppercase">Adres</p>
                        <p class="text-sm font-semibold tracking-tight text-corporate-900">
                            {{ $siteInformation->address }}
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

