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
            ctaSecondary: { text: 'Blog', link: '/blog' }
        }
    ],

    /**
     * Initialize slider
     */
    init() {
        this.startAutoplay();

        // Preload images
        this.slides.forEach(slide => {
            const img = new Image();
            img.src = slide.image;
        });

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') this.prev();
            if (e.key === 'ArrowRight') this.next();
        });

        // Pause on visibility change
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                this.stopAutoplay();
            } else {
                this.startAutoplay();
            }
        });

        // Touch/Swipe support
        this.$el.addEventListener('touchstart', (e) => {
            this.touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        this.$el.addEventListener('touchend', (e) => {
            this.touchEndX = e.changedTouches[0].screenX;
            this.handleSwipe();
        }, { passive: true });
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
        if (this.isTransitioning) return;

        this.isTransitioning = true;
        this.currentSlide = index;
        this.restartAutoplay();

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
        this.autoplayInterval = setInterval(() => {
            this.next();
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

