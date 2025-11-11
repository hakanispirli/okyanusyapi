/**
 * Hero Slider Alpine.js Component
 * Okyanus Yapı - 2025 Modern Hero Slider
 */

export default () => ({
    currentSlide: 0,
    autoplayInterval: null,
    autoplayDelay: 5000,
    isTransitioning: false,
    touchStartX: 0,
    touchEndX: 0,
    imagesLoaded: {},
    isVisible: true,

    slides: [
        {
            id: 1,
            title: 'Su Yalıtımı Hizmetleri',
            subtitle: 'Profesyonel Su Yalıtım Çözümleri',
            description: 'Binalarınızı su ve nem hasarlarından koruyan, uzun ömürlü ve etkili su yalıtım sistemleri ile güvenli yaşam alanları oluşturuyoruz.',
            image: '/images/hero/su-yalitim.jpg',
            cta: { text: 'Hizmetlerimiz', link: '/hizmetlerimiz' },
            ctaSecondary: { text: 'İletişim', link: '/iletisim' }
        },
        {
            id: 2,
            title: 'Isı Yalıtımı Sistemleri',
            subtitle: 'Enerji Tasarrufu ve Konfor',
            description: 'Modern ısı yalıtım teknolojileri ile enerji maliyetlerinizi düşürün, konforunuzu artırın ve çevre dostu yaşam alanları yaratın.',
            image: '/images/hero/isi-yalitim.jpg',
            cta: { text: 'Hizmetlerimiz', link: '/hizmetlerimiz' },
            ctaSecondary: { text: 'Hakkımızda', link: '/hakkimizda' }
        },
        {
            id: 3,
            title: 'Çatı İzolasyon & Revize',
            subtitle: 'Çatı Bakım ve Yenileme Hizmetleri',
            description: 'Çatılarınızın izolasyonunu güçlendirerek, revize işlemleri ile uzun ömürlü ve dayanıklı çatı sistemleri sunuyoruz.',
            image: '/images/hero/cati.jpg',
            cta: { text: 'Hizmetlerimiz', link: '/hizmetlerimiz' },
            ctaSecondary: { text: 'Uygulamalar', link: '/uygulamalar' }
        }
    ],

    /**
     * Initialize slider
     */
    init() {
        // Preload only first and second images for better initial load
        this.preloadImage(0);
        if (this.slides.length > 1) {
            setTimeout(() => this.preloadImage(1), 100);
        }

        // Start autoplay after initial load
        setTimeout(() => {
            this.startAutoplay();
        }, 500);

        // Intersection Observer for visibility
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    this.isVisible = entry.isIntersecting;
                    if (!entry.isIntersecting) {
                        this.stopAutoplay();
                    } else {
                        this.startAutoplay();
                    }
                });
            }, { threshold: 0.5 });
            observer.observe(this.$el);
        }

        // Keyboard navigation with debounce
        let keyDebounce;
        document.addEventListener('keydown', (e) => {
            if (this.isTransitioning) return;
            clearTimeout(keyDebounce);
            keyDebounce = setTimeout(() => {
                if (e.key === 'ArrowLeft') this.prev();
                if (e.key === 'ArrowRight') this.next();
            }, 100);
        });

        // Pause on visibility change
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                this.stopAutoplay();
            } else if (this.isVisible) {
                this.startAutoplay();
            }
        });

        // Touch/Swipe support with passive listeners
        this.$el.addEventListener('touchstart', (e) => {
            this.touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        this.$el.addEventListener('touchend', (e) => {
            this.touchEndX = e.changedTouches[0].screenX;
            this.handleSwipe();
        }, { passive: true });

        // Preload remaining images lazily
        if (this.slides.length > 2) {
            setTimeout(() => {
                for (let i = 2; i < this.slides.length; i++) {
                    this.preloadImage(i);
                }
            }, 2000);
        }
    },

    /**
     * Preload image
     */
    preloadImage(index) {
        if (this.imagesLoaded[index]) return;
        
        const slide = this.slides[index];
        if (!slide) return;

        const img = new Image();
        img.onload = () => {
            this.imagesLoaded[index] = true;
        };
        img.src = slide.image;
    },

    /**
     * Handle swipe gesture
     */
    handleSwipe() {
        const diff = this.touchStartX - this.touchEndX;
        const threshold = 50;

        if (Math.abs(diff) > threshold) {
            if (diff > 0) {
                this.next(); // Swipe left
            } else {
                this.prev(); // Swipe right
            }
        }
    },

    /**
     * Go to specific slide
     */
    goToSlide(index) {
        if (this.isTransitioning || index === this.currentSlide) return;

        // Preload next image if not loaded
        this.preloadImage(index);

        this.isTransitioning = true;
        this.currentSlide = index;
        this.restartAutoplay();

        // Preload adjacent images
        const nextIndex = (index + 1) % this.slides.length;
        const prevIndex = (index - 1 + this.slides.length) % this.slides.length;
        setTimeout(() => {
            this.preloadImage(nextIndex);
            this.preloadImage(prevIndex);
        }, 100);

        setTimeout(() => {
            this.isTransitioning = false;
        }, 600);
    },

    /**
     * Next slide
     */
    next() {
        const nextIndex = (this.currentSlide + 1) % this.slides.length;
        this.goToSlide(nextIndex);
    },

    /**
     * Previous slide
     */
    prev() {
        const prevIndex = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
        this.goToSlide(prevIndex);
    },

    /**
     * Start autoplay
     */
    startAutoplay() {
        if (this.autoplayInterval) return;
        this.autoplayInterval = setInterval(() => {
            if (this.isVisible && !document.hidden) {
                this.next();
            }
        }, this.autoplayDelay);
    },

    /**
     * Stop autoplay
     */
    stopAutoplay() {
        if (this.autoplayInterval) {
            clearInterval(this.autoplayInterval);
            this.autoplayInterval = null;
        }
    },

    /**
     * Restart autoplay
     */
    restartAutoplay() {
        this.stopAutoplay();
        this.startAutoplay();
    },

    /**
     * Check if slide is active
     */
    isActive(index) {
        return this.currentSlide === index;
    },

    /**
     * Get slide by index
     */
    getSlide(index) {
        return this.slides[index] || this.slides[0];
    },

    /**
     * Cleanup on destroy
     */
    destroy() {
        this.stopAutoplay();
    }
});

