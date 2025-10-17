{{-- Photo Gallery Section --}}
@if($blog->gallery_images && count($blog->gallery_images) > 0)
    <section class="py-12 md:py-16 bg-gray-50" x-data="photoGallery" @keydown.window="handleKeydown($event)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 md:mb-12">
                <h2 class="text-2xl sm:text-3xl font-display font-bold text-corporate-900 mb-3">
                    Uygulama Galerisi
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    {{ $blog->title }} uygulamasından görüntüler
                </p>
            </div>

            {{-- Mobile Gallery --}}
            <div class="block sm:hidden">
                <div class="relative -mx-4 px-4 overflow-x-auto scrollbar-hide">
                    <div class="flex gap-3 pb-4 snap-x snap-mandatory touch-pan-x">
                        @foreach($blog->gallery_images as $index => $image)
                            <div class="flex-shrink-0 w-72 snap-center">
                                <div class="relative aspect-[4/3] rounded-2xl overflow-hidden cursor-pointer group" @click="openGallery({{ $index }})">
                                    <img
                                        src="{{ $image['url'] ?? $image }}"
                                        alt="{{ $image['alt'] ?? $blog->title . ' - Galeri Resmi ' . ($index + 1) }}"
                                        class="w-full h-full object-cover transition-transform duration-500 group-active:scale-95"
                                        data-gallery-image>
                                    <div class="absolute inset-0 bg-black/20 group-active:bg-black/40 transition-colors duration-300"></div>
                                    <div class="absolute top-3 right-3 w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center">
                                        <x-lucide-expand class="w-5 h-5 text-corporate-900" />
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Tablet Gallery --}}
            <div class="hidden sm:block lg:hidden">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($blog->gallery_images as $index => $image)
                        <div class="relative aspect-[4/3] rounded-2xl overflow-hidden cursor-pointer group" @click="openGallery({{ $index }})">
                            <img
                                src="{{ $image['url'] ?? $image }}"
                                alt="{{ $image['alt'] ?? $blog->title . ' - Galeri Resmi ' . ($index + 1) }}"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                data-gallery-image>
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300"></div>
                            <div class="absolute top-3 right-3 w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <x-lucide-expand class="w-5 h-5 text-corporate-900" />
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Desktop Gallery --}}
            <div class="hidden lg:block">
                <div class="grid grid-cols-3 gap-6">
                    @foreach($blog->gallery_images as $index => $image)
                        <div class="relative aspect-[4/3] rounded-2xl overflow-hidden cursor-pointer group" @click="openGallery({{ $index }})">
                            <img
                                src="{{ $image['url'] ?? $image }}"
                                alt="{{ $image['alt'] ?? $blog->title . ' - Galeri Resmi ' . ($index + 1) }}"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                data-gallery-image>
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300"></div>
                            <div class="absolute top-4 right-4 w-12 h-12 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <x-lucide-expand class="w-6 h-6 text-corporate-900" />
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Gallery Modal --}}
        <div
            x-show="isOpen"
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black z-50"
            @touchstart="handleTouchStart($event)"
            @touchend="handleTouchEnd($event)">

            <div class="relative w-full h-full flex items-center justify-center">
                {{-- Close Button --}}
                <button
                    @click="closeGallery()"
                    class="absolute top-4 right-4 sm:top-6 sm:right-6 z-30 w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-white/30 active:scale-95 transition-all duration-200">
                    <x-lucide-x class="w-6 h-6" />
                </button>

                {{-- Previous Button --}}
                <button
                    @click="previousImage()"
                    class="absolute left-4 sm:left-6 top-1/2 -translate-y-1/2 z-30 w-12 h-12 sm:w-14 sm:h-14 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-white/30 hover:scale-105 active:scale-95 transition-all duration-200">
                    <x-lucide-chevron-left class="w-6 h-6 sm:w-7 sm:h-7" />
                </button>

                {{-- Next Button --}}
                <button
                    @click="nextImage()"
                    class="absolute right-4 sm:right-6 top-1/2 -translate-y-1/2 z-30 w-12 h-12 sm:w-14 sm:h-14 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-white/30 hover:scale-105 active:scale-95 transition-all duration-200">
                    <x-lucide-chevron-right class="w-6 h-6 sm:w-7 sm:h-7" />
                </button>

                {{-- Main Image --}}
                <div class="relative w-full h-full flex items-center justify-center p-4 sm:p-6 md:p-12">
                    <img
                        :src="currentImage"
                        alt="Gallery Image"
                        class="max-w-full max-h-full w-auto h-auto object-contain select-none transition-opacity duration-300"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        draggable="false">
                </div>

                {{-- Image Counter --}}
                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-30 px-5 py-2.5 bg-white/20 backdrop-blur-md rounded-full text-white text-sm font-medium">
                    <span x-text="currentIndex + 1"></span> / <span x-text="totalImages"></span>
                </div>
            </div>
        </div>
    </section>
@endif

