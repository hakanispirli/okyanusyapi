<!-- Brands Section - 2025 Modern Infinite Marquee -->
<section class="relative py-16 sm:py-20 lg:py-24 bg-gradient-to-b from-gray-50 to-white overflow-hidden">
    <div class="w-full">

        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16 px-4 sm:px-6 lg:px-8">
            <div
                class="inline-flex items-center gap-2 px-3 py-1.5 bg-primary-500/10 rounded-full text-primary-600 text-xs font-semibold tracking-wide mb-6">
                <x-lucide-handshake class="w-4 h-4" />
                İŞ ORTAKLARIMIZ
            </div>
            <h2
                class="text-4xl sm:text-5xl lg:text-6xl font-display font-bold text-corporate-900 mb-6 tracking-tight leading-tight">
                Bizi Tercih Eden<br class="hidden sm:block" /> Markalar
            </h2>
            <p class="text-xl text-corporate-600 font-light leading-relaxed">
                Türkiye'nin önde gelen kurumları ve markaları bize güveniyor.
            </p>
        </div>

        @if (isset($brands) && $brands->count() > 0)
            @php
                $brand = $brands->first(); // İlk aktif brand kaydını al
            @endphp

            <!-- First Marquee Row -->
            <div class="relative overflow-hidden mb-6">
                <!-- Gradient Overlays -->
                <div
                    class="absolute left-0 top-0 bottom-0 w-24 sm:w-32 bg-gradient-to-r from-gray-50 to-transparent z-10 pointer-events-none">
                </div>
                <div
                    class="absolute right-0 top-0 bottom-0 w-24 sm:w-32 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none">
                </div>

                <!-- Marquee Track -->
                <div class="brands-marquee flex gap-6 sm:gap-8 py-2">
                    <!-- First Set -->
                    <div class="brands-marquee-content flex gap-6 sm:gap-8 items-center">
                        @if ($brand->brands_images && count($brand->brands_images) > 0)
                            @foreach ($brand->brands_images as $image)
                                <div
                                    class="flex-none group relative bg-white rounded-xl p-6 sm:p-8 border border-gray-200 hover:border-primary-200 transition-all duration-300 hover:shadow-lg w-[180px] sm:w-[220px] h-[100px] sm:h-[120px]">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-br from-primary-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl">
                                    </div>
                                    <div class="relative h-full flex items-center justify-center">
                                        <img src="{{ $image['url'] ?? '' }}" alt="{{ $image['alt'] ?? 'Marka' }}"
                                            class="max-w-full max-h-full object-contain group-hover:scale-105 transition-transform duration-300">
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- Second Set (Duplicate for seamless loop) -->
                    <div class="brands-marquee-content flex gap-6 sm:gap-8 items-center" aria-hidden="true">
                        @if ($brand->brands_images && count($brand->brands_images) > 0)
                            @foreach ($brand->brands_images as $image)
                                <div
                                    class="flex-none group relative bg-white rounded-xl p-6 sm:p-8 border border-gray-200 hover:border-primary-200 transition-all duration-300 hover:shadow-lg w-[180px] sm:w-[220px] h-[100px] sm:h-[120px]">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-br from-primary-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl">
                                    </div>
                                    <div class="relative h-full flex items-center justify-center">
                                        <img src="{{ $image['url'] ?? '' }}" alt="{{ $image['alt'] ?? 'Marka' }}"
                                            class="max-w-full max-h-full object-contain group-hover:scale-105 transition-transform duration-300">
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <!-- Second Marquee Row (Reverse Direction) -->
            <div class="relative overflow-hidden">
                <!-- Gradient Overlays -->
                <div
                    class="absolute left-0 top-0 bottom-0 w-24 sm:w-32 bg-gradient-to-r from-gray-50 to-transparent z-10 pointer-events-none">
                </div>
                <div
                    class="absolute right-0 top-0 bottom-0 w-24 sm:w-32 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none">
                </div>

                <!-- Marquee Track (Reverse) -->
                <div class="brands-marquee-reverse flex gap-6 sm:gap-8 py-2">
                    <!-- First Set -->
                    <div class="brands-marquee-content flex gap-6 sm:gap-8 items-center">
                        @if ($brand->brands_images && count($brand->brands_images) > 0)
                            @foreach (array_reverse($brand->brands_images) as $image)
                                <div
                                    class="flex-none group relative bg-white rounded-xl p-6 sm:p-8 border border-gray-200 hover:border-primary-200 transition-all duration-300 hover:shadow-lg w-[180px] sm:w-[220px] h-[100px] sm:h-[120px]">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-br from-primary-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl">
                                    </div>
                                    <div class="relative h-full flex items-center justify-center">
                                        <img src="{{ $image['url'] ?? '' }}" alt="{{ $image['alt'] ?? 'Marka' }}"
                                            class="max-w-full max-h-full object-contain group-hover:scale-105 transition-transform duration-300">
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- Second Set (Duplicate for seamless loop) -->
                    <div class="brands-marquee-content flex gap-6 sm:gap-8 items-center" aria-hidden="true">
                        @if ($brand->brands_images && count($brand->brands_images) > 0)
                            @foreach (array_reverse($brand->brands_images) as $image)
                                <div
                                    class="flex-none group relative bg-white rounded-xl p-6 sm:p-8 border border-gray-200 hover:border-primary-200 transition-all duration-300 hover:shadow-lg w-[180px] sm:w-[220px] h-[100px] sm:h-[120px]">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-br from-primary-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl">
                                    </div>
                                    <div class="relative h-full flex items-center justify-center">
                                        <img src="{{ $image['url'] ?? '' }}" alt="{{ $image['alt'] ?? 'Marka' }}"
                                            class="max-w-full max-h-full object-contain group-hover:scale-105 transition-transform duration-300">
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <x-lucide-building class="w-12 h-12 text-gray-400 mx-auto mb-4" />
                <h3 class="text-lg font-medium text-gray-900 mb-2">Henüz marka bulunmuyor</h3>
                <p class="text-gray-500">Markalar yönetim panelinden eklenebilir.</p>
            </div>
        @endif

    </div>
</section>

<style>
    /* Brands Marquee Animation */
    @keyframes brandsMarquee {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
        }
    }

    @keyframes brandsMarqueeReverse {
        0% {
            transform: translateX(-50%);
        }

        100% {
            transform: translateX(0);
        }
    }

    .brands-marquee {
        animation: brandsMarquee 45s linear infinite;
    }

    .brands-marquee-reverse {
        animation: brandsMarqueeReverse 45s linear infinite;
    }

    /* Pause on hover */
    .brands-marquee:hover,
    .brands-marquee-reverse:hover {
        animation-play-state: paused;
    }

    /* Smooth animation on all browsers */
    @media (prefers-reduced-motion: reduce) {

        .brands-marquee,
        .brands-marquee-reverse {
            animation: none;
        }
    }
</style>
