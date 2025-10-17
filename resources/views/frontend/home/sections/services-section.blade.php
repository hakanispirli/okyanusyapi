<!-- Services Section - 2025 Ultra Modern Design -->
<section id="services" class="py-16 sm:py-20 lg:py-24 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="max-w-3xl mb-12 sm:mb-16">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-primary-500/10 rounded-full text-primary-600 text-xs font-semibold tracking-wide mb-6">
                HİZMETLERİMİZ
            </div>
            <h2 class="text-4xl sm:text-5xl lg:text-6xl font-display font-bold text-corporate-900 mb-6 tracking-tight leading-tight">
                Profesyonel Yalıtım<br class="hidden sm:block"/> ve İzolasyon Çözümleri
            </h2>
            <p class="text-xl text-corporate-600 font-light leading-relaxed">
                Modern teknoloji ve uzman kadro ile binalarınızı koruyoruz.
            </p>
        </div>

        @if($services && $services->count() > 0)
            <!-- Services Horizontal Scroll (Mobile/Tablet) -->
            <div class="lg:hidden relative mb-8">
                <!-- Scroll Container with Snap -->
                <div class="flex gap-4 overflow-x-auto snap-x snap-mandatory scrollbar-hide pb-4 -mx-4 px-4 scroll-smooth">
                    @foreach($services as $index => $service)
                        <div class="flex-none w-[85%] sm:w-[45%] snap-center">
                            <div class="group relative h-[420px] bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
                                @if($service->hero_image)
                                    <img src="{{ asset($service->hero_image) }}"
                                         alt="{{ $service->name }}"
                                         class="absolute inset-0 w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                                @else
                                    <div class="absolute inset-0 bg-gradient-to-br from-gray-100 to-gray-200"></div>
                                @endif
                                <div class="relative h-full p-8 flex flex-col justify-end">
                                    <a href="{{ route('services.show', $service) }}" class="block group">
                                        <h3 class="text-2xl font-display font-bold text-white mb-3 tracking-tight transition-all duration-300 relative
                                                   [text-shadow:_0_2px_8px_rgb(0_0_0_/_60%),_0_4px_16px_rgb(0_0_0_/_40%)]
                                                   group-hover:[text-shadow:_0_2px_12px_rgb(0_0_0_/_70%),_0_4px_20px_rgb(0_0_0_/_50%),_0_0_30px_rgb(59_130_246_/_60%)]
                                                   decoration-primary-400 decoration-2 underline underline-offset-4
                                                   group-hover:decoration-4 group-hover:decoration-primary-300 group-hover:text-primary-100">
                                            {{ $service->title ?? $service->name }}
                                        </h3>
                                    </a>
                                    <p class="text-white/90 text-sm font-light leading-relaxed mb-4 drop-shadow-md">
                                        {{ Str::limit($service->description, 100) }}
                                    </p>
                                    <a href="{{ route('services.show', $service) }}" class="inline-flex items-center gap-2 bg-white/90 text-gray-900 font-semibold text-sm px-4 py-2 rounded-lg hover:bg-white transition-colors duration-200 shadow-lg">
                                        <span>Detaylı Bilgi</span>
                                        <x-lucide-arrow-right class="w-4 h-4" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Scroll Hint -->
                <p class="text-center text-sm text-corporate-500 font-light">
                    ← Kaydırarak diğer hizmetleri görün →
                </p>
            </div>

            <!-- Desktop Bento Grid -->
            <div class="hidden lg:grid lg:grid-cols-12 gap-6">
                @foreach($services as $index => $service)
                    @php
                        // Determine card size based on position
                        $isLargeCard = $index === 0; // First service gets large card
                        $isSmallCard = $index === 1 || $index === 2; // Second and third get small cards
                        $isMediumCard = $index >= 3; // Rest get medium cards

                        // Grid classes based on card type
                        if ($isLargeCard) {
                            $gridClass = 'lg:col-span-8 lg:row-span-2';
                            $minHeight = 'min-h-[500px]';
                            $padding = 'p-10';
                            $iconSize = 'w-16 h-16';
                            $iconInnerSize = 'w-9 h-9';
                            $titleSize = 'text-4xl';
                            $descSize = 'text-lg';
                            $buttonSize = 'text-base';
                        } elseif ($isSmallCard) {
                            $gridClass = 'lg:col-span-4';
                            $minHeight = 'min-h-[240px]';
                            $padding = 'p-8';
                            $iconSize = 'w-12 h-12';
                            $iconInnerSize = 'w-7 h-7';
                            $titleSize = 'text-xl';
                            $descSize = 'text-sm';
                            $buttonSize = 'text-sm';
                        } else {
                            $gridClass = 'lg:col-span-6';
                            $minHeight = 'min-h-[300px]';
                            $padding = 'p-8';
                            $iconSize = 'w-14 h-14';
                            $iconInnerSize = 'w-8 h-8';
                            $titleSize = 'text-2xl';
                            $descSize = 'text-base';
                            $buttonSize = 'text-base';
                        }
                    @endphp

                    <div class="{{ $gridClass }}">
                        <div class="group relative h-full {{ $minHeight }} bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
                            @if($service->hero_image)
                                <img src="{{ asset($service->hero_image) }}"
                                     alt="{{ $service->name }}"
                                     class="absolute inset-0 w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                            @else
                                <div class="absolute inset-0 bg-gradient-to-br from-gray-100 to-gray-200"></div>
                            @endif
                            <div class="relative h-full {{ $padding }} flex flex-col justify-end">
                                <a href="{{ route('services.show', $service) }}" class="block group">
                                    <h3 class="{{ $titleSize }} font-display font-bold text-white {{ $isLargeCard ? 'mb-4' : ($isSmallCard ? 'mb-2' : 'mb-3') }} tracking-tight transition-all duration-300 relative
                                               [text-shadow:_0_2px_8px_rgb(0_0_0_/_60%),_0_4px_16px_rgb(0_0_0_/_40%)]
                                               group-hover:[text-shadow:_0_2px_12px_rgb(0_0_0_/_70%),_0_4px_20px_rgb(0_0_0_/_50%),_0_0_30px_rgb(59_130_246_/_60%)]
                                               decoration-primary-400 {{ $isLargeCard ? 'decoration-4 underline-offset-8' : ($isSmallCard ? 'decoration-2 underline-offset-2' : 'decoration-2 underline-offset-4') }} underline
                                               group-hover:{{ $isLargeCard ? 'decoration-[6px]' : 'decoration-4' }} group-hover:decoration-primary-300 group-hover:text-primary-100">
                                        {{ $service->title ?? $service->name }}
                                    </h3>
                                </a>
                                <p class="text-white/90 {{ $descSize }} font-light {{ $isLargeCard ? 'leading-relaxed mb-6 max-w-lg' : ($isSmallCard ? 'mb-3' : 'leading-relaxed mb-4') }} drop-shadow-md">
                                    @if($isLargeCard)
                                        {{ Str::limit($service->description, 150) }}
                                    @else
                                        {{ Str::limit($service->description, 80) }}
                                    @endif
                                </p>
                                <a href="{{ route('services.show', $service) }}" class="inline-flex items-center gap-2 bg-white/90 text-gray-900 font-semibold {{ $buttonSize }} px-4 py-2 rounded-lg hover:bg-white transition-colors duration-200 shadow-lg">
                                    <span>{{ $isSmallCard ? 'Detay' : 'Detaylı Bilgi' }}</span>
                                    <x-lucide-arrow-right class="{{ $isSmallCard ? 'w-4 h-4' : 'w-5 h-5' }}" />
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- No Services Found -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <x-lucide-building class="w-12 h-12 text-gray-400" />
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Henüz hizmet eklenmemiş</h3>
                <p class="text-gray-600">Yakında hizmetlerimizi burada görebileceksiniz.</p>
            </div>
        @endif

    </div>
</section>

<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

