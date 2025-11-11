<!-- Hero Section - 2025 Modern Design -->
<section class="relative overflow-hidden bg-corporate-900" x-data="heroSlider()" x-init="init()" style="contain: layout style;">
    <!-- Slider Container -->
    <div class="relative h-[calc(100vh-4rem)] sm:h-[calc(100vh-5rem)] min-h-[600px]" style="will-change: auto;">

        <!-- Slides -->
        <template x-for="(slide, index) in slides" :key="slide.id">
            <div x-show="currentSlide === index" x-transition:enter="transition-opacity ease-out duration-700"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-in duration-700" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="absolute inset-0">

                <!-- Background Image -->
                <div class="absolute inset-0">
                    <img :src="slide.image" 
                         :alt="slide.title" 
                         class="w-full h-full object-cover"
                         :loading="index === 0 ? 'eager' : 'lazy'"
                         :fetchpriority="index === 0 ? 'high' : 'low'"
                         decoding="async"
                         style="will-change: auto;">
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-r from-corporate-900/95 via-corporate-900/80 to-corporate-900/60"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-corporate-900/90 via-transparent to-transparent"></div>
                </div>

                <!-- Content -->
                <div class="relative h-full flex items-center">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                        <div class="max-w-3xl">
                            <!-- Subtitle -->
                            <div x-show="currentSlide === index"
                                x-transition:enter="transition ease-out duration-500 delay-75"
                                x-transition:enter-start="opacity-0 translate-y-4"
                                x-transition:enter-end="opacity-100 translate-y-0" 
                                class="mb-4">
                                <span class="inline-flex items-center gap-2 px-4 py-2 bg-primary-500/20 backdrop-blur-sm border border-primary-400/30 rounded-full text-primary-300 text-sm font-medium tracking-wide">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                        <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z" />
                                    </svg>
                                    <span x-text="slide.subtitle"></span>
                                </span>
                            </div>

                            <!-- Title -->
                            <h1 x-show="currentSlide === index"
                                x-transition:enter="transition ease-out duration-500 delay-150"
                                x-transition:enter-start="opacity-0 translate-y-4"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-display font-bold text-white mb-6 leading-tight tracking-tight"
                                x-text="slide.title">
                            </h1>

                            <!-- Description -->
                            <p x-show="currentSlide === index"
                                x-transition:enter="transition ease-out duration-500 delay-225"
                                x-transition:enter-start="opacity-0 translate-y-4"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="text-lg sm:text-xl text-gray-300 mb-8 max-w-2xl leading-relaxed"
                                x-text="slide.description">
                            </p>

                            <!-- CTA Buttons -->
                            <div x-show="currentSlide === index"
                                x-transition:enter="transition ease-out duration-500 delay-300"
                                x-transition:enter-start="opacity-0 translate-y-4"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="flex flex-col sm:flex-row gap-4">
                                <a :href="slide.cta.link"
                                    class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-semibold tracking-tight hover:from-primary-600 hover:to-primary-700 transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5 group">
                                    <span x-text="slide.cta.text"></span>
                                    <svg class="w-5 h-5 transition-transform duration-200 group-hover:translate-x-1"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </a>
                                <a :href="slide.ctaSecondary.link"
                                    class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white/10 backdrop-blur-sm border border-white/20 text-white rounded-xl font-semibold tracking-tight hover:bg-white/20 hover:border-white/30 transition-all duration-200">
                                    <span x-text="slide.ctaSecondary.text"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- Navigation Arrows (Hidden on Mobile) -->
        <div class="absolute right-4 sm:right-6 lg:right-8 top-1/2 -translate-y-1/2 z-10 hidden md:block">
            <div class="flex flex-col gap-3">
                <!-- Previous Button -->
                <button @click="prev()"
                    class="group w-12 h-12 lg:w-14 lg:h-14 flex items-center justify-center bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-white hover:bg-white/20 hover:border-white/30 transition-all duration-300 hover:scale-110"
                    aria-label="Previous slide">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 transition-transform duration-300 group-hover:-translate-y-0.5"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>
                </button>

                <!-- Next Button -->
                <button @click="next()"
                    class="group w-12 h-12 lg:w-14 lg:h-14 flex items-center justify-center bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-white hover:bg-white/20 hover:border-white/30 transition-all duration-300 hover:scale-110"
                    aria-label="Next slide">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 transition-transform duration-300 group-hover:translate-y-0.5"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Slide Indicators -->
        <div class="absolute bottom-8 left-0 right-0 z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-center gap-3">
                    <template x-for="(slide, index) in slides" :key="slide.id">
                        <button @click="goToSlide(index)" class="group relative"
                            :aria-label="'Go to slide ' + (index + 1)">
                            <!-- Progress bar for active slide -->
                            <div class="h-1 rounded-full bg-white/30 backdrop-blur-sm overflow-hidden transition-all duration-300"
                                :class="currentSlide === index ? 'w-16' : 'w-8 hover:w-12'">
                                <div x-show="currentSlide === index"
                                    class="h-full bg-gradient-to-r from-primary-400 to-primary-500"
                                    :class="currentSlide === index ? 'animate-progress' : ''">
                                </div>
                            </div>
                        </button>
                    </template>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 right-8 hidden lg:block z-10">
            <a href="#features"
                class="flex flex-col items-center gap-2 text-white/60 hover:text-white transition-colors duration-200 group">
                <span class="text-xs font-medium tracking-wider uppercase">Keşfet</span>
                <div class="w-6 h-10 border-2 border-white/30 rounded-full flex items-start justify-center p-1 group-hover:border-white/60 transition-colors duration-200">
                    <div class="w-1.5 h-2 bg-white/60 rounded-full animate-bounce"></div>
                </div>
            </a>
        </div>
    </div>
</section>

<style>
    /* Performance optimizations for hero section */
    #hero img {
        content-visibility: auto;
    }
    
    /* Optimize animations */
    @media (prefers-reduced-motion: reduce) {
        #hero * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
        #hero .animate-bounce {
            animation: none;
        }
    }
    
    /* Progress bar animation */
    @keyframes progress {
        from {
            transform: scaleX(0);
            transform-origin: left;
        }
        to {
            transform: scaleX(1);
            transform-origin: left;
        }
    }
    
    .animate-progress {
        animation: progress 5s linear;
    }
</style>
