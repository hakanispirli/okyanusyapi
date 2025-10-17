<!-- Applications Section - 2025 Ultra Modern Design -->
<section id="applications" class="py-16 sm:py-20 lg:py-24 bg-corporate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="max-w-3xl mb-12 sm:mb-16">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-primary-500/20 backdrop-blur-sm border border-primary-400/30 rounded-full text-primary-300 text-xs font-semibold tracking-wide mb-6">
                <x-lucide-layers class="w-4 h-4" />
                UYGULAMALARIMIZ
            </div>
            <h2 class="text-4xl sm:text-5xl lg:text-6xl font-display font-bold text-white mb-6 tracking-tight leading-tight">
                Başarılı Projelerimiz<br class="hidden sm:block"/> ve Uygulamalar
            </h2>
            <p class="text-xl text-gray-300 font-light leading-relaxed">
                Gerçekleştirdiğimiz projeler ve uygulama alanlarımız hakkında detaylı bilgiler.
            </p>
        </div>

        @if($applications && $applications->count() > 0)
            <!-- Applications Horizontal Scroll (Mobile/Tablet) -->
            <div class="lg:hidden relative mb-8">
                <!-- Scroll Container with Snap -->
                <div class="flex gap-4 overflow-x-auto snap-x snap-mandatory scrollbar-hide pb-4 -mx-4 px-4 scroll-smooth">
                    @foreach($applications as $index => $blog)
                        <div class="flex-none w-[85%] sm:w-[45%] snap-center">
                            <div class="group relative h-[420px] bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl overflow-hidden hover:bg-white/10 hover:border-white/20 transition-all duration-300">
                                @if($blog->featured_image)
                                    <img src="{{ asset($blog->featured_image) }}"
                                         alt="{{ $blog->featured_image_alt ?? $blog->title }}"
                                         class="absolute inset-0 w-full h-full object-cover">
                                @else
                                    <div class="absolute inset-0 bg-white/10"></div>
                                @endif
                                <div class="relative h-full p-8 flex flex-col justify-end">
                                    <!-- Category Badge -->
                                    @if($blog->category)
                                        <div class="mb-3">
                                            <span class="inline-block px-3 py-1 bg-primary-500/20 backdrop-blur-sm border border-primary-400/30 rounded-full text-primary-300 text-xs font-medium">
                                                {{ $blog->category->name }}
                                            </span>
                                        </div>
                                    @endif

                                    <a href="{{ route('blogs.show', $blog) }}" class="block group/link">
                                        <h3 class="text-2xl font-display font-bold text-white mb-3 tracking-tight transition-all duration-300 relative
                                                   [text-shadow:_0_2px_8px_rgb(0_0_0_/_60%),_0_4px_16px_rgb(0_0_0_/_40%)]
                                                   group-hover/link:[text-shadow:_0_2px_12px_rgb(0_0_0_/_70%),_0_4px_20px_rgb(0_0_0_/_50%),_0_0_30px_rgb(59_130_246_/_60%)]
                                                   decoration-primary-400 decoration-2 underline underline-offset-4
                                                   group-hover/link:decoration-4 group-hover/link:decoration-primary-300 group-hover/link:text-primary-100">
                                            {{ Str::limit($blog->title, 60) }}
                                        </h3>
                                    </a>

                                    @if($blog->excerpt)
                                        <p class="text-white text-sm font-light leading-relaxed mb-4 drop-shadow-md line-clamp-2">
                                            {{ Str::limit($blog->excerpt, 100) }}
                                        </p>
                                    @endif

                                    <!-- Meta Info -->
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="flex items-center gap-2 bg-black/40 backdrop-blur-md rounded-lg px-3 py-1.5">
                                            <x-lucide-calendar class="w-3 h-3 text-white/80" />
                                            <span class="text-white text-xs font-medium">{{ $blog->published_at->format('d.m.Y') }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 bg-black/40 backdrop-blur-md rounded-lg px-3 py-1.5">
                                            <x-lucide-eye class="w-3 h-3 text-white/80" />
                                            <span class="text-white text-xs font-medium">{{ $blog->views }}</span>
                                        </div>
                                    </div>

                                    <a href="{{ route('blogs.show', $blog) }}" class="inline-flex items-center gap-2 bg-white/90 text-gray-900 font-semibold text-sm px-4 py-2 rounded-lg hover:bg-white transition-colors duration-200 shadow-lg">
                                        <span>Detaylı Bilgi</span>
                                        <x-lucide-arrow-right class="w-4 h-4" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Scroll Hint -->
                <p class="text-center text-sm text-gray-400 font-light">
                    ← Kaydırarak diğer uygulamaları görün →
                </p>
            </div>

            <!-- Desktop Bento Grid -->
            <div class="hidden lg:grid lg:grid-cols-12 gap-6">
                @foreach($applications as $index => $blog)
                    @php
                        // Determine card size based on position
                        $isLargeCard = $index === 0; // First application gets large card
                        $isSmallCard = $index === 1 || $index === 2; // Second and third get small cards
                        $isMediumCard = $index >= 3; // Rest get medium cards

                        // Grid classes based on card type
                        if ($isLargeCard) {
                            $gridClass = 'lg:col-span-8 lg:row-span-2';
                            $minHeight = 'min-h-[500px]';
                            $padding = 'p-10';
                            $titleSize = 'text-4xl';
                            $descSize = 'text-lg';
                            $buttonSize = 'text-base';
                        } elseif ($isSmallCard) {
                            $gridClass = 'lg:col-span-4';
                            $minHeight = 'min-h-[240px]';
                            $padding = 'p-8';
                            $titleSize = 'text-xl';
                            $descSize = 'text-sm';
                            $buttonSize = 'text-sm';
                        } else {
                            $gridClass = 'lg:col-span-6';
                            $minHeight = 'min-h-[300px]';
                            $padding = 'p-8';
                            $titleSize = 'text-2xl';
                            $descSize = 'text-base';
                            $buttonSize = 'text-base';
                        }
                    @endphp

                    <div class="{{ $gridClass }}">
                        <div class="group relative h-full {{ $minHeight }} bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl overflow-hidden hover:bg-white/10 hover:border-white/20 transition-all duration-300">
                            @if($blog->featured_image)
                                <img src="{{ asset($blog->featured_image) }}"
                                     alt="{{ $blog->featured_image_alt ?? $blog->title }}"
                                     class="absolute inset-0 w-full h-full object-cover">
                            @else
                                <div class="absolute inset-0 bg-white/10"></div>
                            @endif
                            <div class="relative h-full {{ $padding }} flex flex-col justify-end">
                                <!-- Category Badge -->
                                @if($blog->category)
                                    <div class="{{ $isLargeCard ? 'mb-4' : 'mb-3' }}">
                                        <span class="inline-block px-3 py-1 bg-primary-500/20 backdrop-blur-sm border border-primary-400/30 rounded-full text-primary-300 text-xs font-medium">
                                            {{ $blog->category->name }}
                                        </span>
                                    </div>
                                @endif

                                <a href="{{ route('blogs.show', $blog) }}" class="block group/link">
                                    <h3 class="{{ $titleSize }} font-display font-bold text-white {{ $isLargeCard ? 'mb-4' : ($isSmallCard ? 'mb-2' : 'mb-3') }} tracking-tight transition-all duration-300 relative
                                               [text-shadow:_0_2px_8px_rgb(0_0_0_/_60%),_0_4px_16px_rgb(0_0_0_/_40%)]
                                               group-hover/link:[text-shadow:_0_2px_12px_rgb(0_0_0_/_70%),_0_4px_20px_rgb(0_0_0_/_50%),_0_0_30px_rgb(59_130_246_/_60%)]
                                               decoration-primary-400 {{ $isLargeCard ? 'decoration-4 underline-offset-8' : ($isSmallCard ? 'decoration-2 underline-offset-2' : 'decoration-2 underline-offset-4') }} underline
                                               group-hover/link:{{ $isLargeCard ? 'decoration-[6px]' : 'decoration-4' }} group-hover/link:decoration-primary-300 group-hover/link:text-primary-100">
                                        @if($isLargeCard)
                                            {{ Str::limit($blog->title, 80) }}
                                        @elseif($isSmallCard)
                                            {{ Str::limit($blog->title, 50) }}
                                        @else
                                            {{ Str::limit($blog->title, 60) }}
                                        @endif
                                    </h3>
                                </a>

                                @if($blog->excerpt)
                                    <p class="text-white {{ $descSize }} font-light {{ $isLargeCard ? 'leading-relaxed mb-6 max-w-lg' : ($isSmallCard ? 'mb-3' : 'leading-relaxed mb-4') }} drop-shadow-md line-clamp-2">
                                        @if($isLargeCard)
                                            {{ Str::limit($blog->excerpt, 150) }}
                                        @else
                                            {{ Str::limit($blog->excerpt, 80) }}
                                        @endif
                                    </p>
                                @endif

                                <!-- Meta Info -->
                                <div class="flex items-center gap-3 {{ $isLargeCard ? 'mb-6' : 'mb-4' }}">
                                    <div class="flex items-center gap-2 bg-black/40 backdrop-blur-md rounded-lg px-3 py-1.5">
                                        <x-lucide-calendar class="{{ $isLargeCard ? 'w-4 h-4' : 'w-3 h-3' }} text-white/80" />
                                        <span class="text-white text-xs font-medium">{{ $blog->published_at->format('d.m.Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 bg-black/40 backdrop-blur-md rounded-lg px-3 py-1.5">
                                        <x-lucide-eye class="{{ $isLargeCard ? 'w-4 h-4' : 'w-3 h-3' }} text-white/80" />
                                        <span class="text-white text-xs font-medium">{{ $blog->views }}</span>
                                    </div>
                                </div>

                                <a href="{{ route('blogs.show', $blog) }}" class="inline-flex items-center gap-2 bg-white/90 text-gray-900 font-semibold {{ $buttonSize }} px-4 py-2 rounded-lg hover:bg-white transition-colors duration-200 shadow-lg">
                                    <span>{{ $isSmallCard ? 'Detay' : 'Detaylı Bilgi' }}</span>
                                    <x-lucide-arrow-right class="{{ $isSmallCard ? 'w-4 h-4' : 'w-5 h-5' }}" />
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- View All Button -->
            <div class="mt-12 text-center">
                <a href="{{ route('blogs') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-white/10 backdrop-blur-sm border border-white/20 text-white rounded-xl font-semibold hover:bg-white/20 hover:border-white/30 transition-all duration-300">
                    <span>Tüm Uygulamaları Gör</span>
                    <x-lucide-arrow-right class="w-5 h-5" />
                </a>
            </div>
        @else
            <!-- No Applications Found -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6">
                    <x-lucide-layers class="w-12 h-12 text-white/40" />
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Henüz uygulama eklenmemiş</h3>
                <p class="text-gray-400">Yakında uygulamalarımızı burada görebileceksiniz.</p>
            </div>
        @endif

    </div>
</section>

