export default () => ({
    isOpen: false,
    currentIndex: 0,
    images: [],
    touchStartX: 0,
    touchEndX: 0,

    init() {
        // Get images from the gallery elements
        this.images = Array.from(document.querySelectorAll('[data-gallery-image]')).map(img => img.src);
    },

    get totalImages() {
        return this.images.length;
    },

    get currentImage() {
        return this.images[this.currentIndex] || '';
    },

    openGallery(index) {
        this.currentIndex = index;
        this.isOpen = true;
        document.body.style.overflow = 'hidden';
    },

    closeGallery() {
        this.isOpen = false;
        document.body.style.overflow = 'auto';
    },

    nextImage() {
        if (this.images.length > 0) {
            this.currentIndex = (this.currentIndex + 1) % this.images.length;
        }
    },

    previousImage() {
        if (this.images.length > 0) {
            this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
        }
    },

    handleKeydown(event) {
        if (!this.isOpen) return;

        if (event.key === 'Escape') {
            this.closeGallery();
        } else if (event.key === 'ArrowRight') {
            this.nextImage();
        } else if (event.key === 'ArrowLeft') {
            this.previousImage();
        }
    },

    handleTouchStart(event) {
        this.touchStartX = event.changedTouches[0].screenX;
    },

    handleTouchEnd(event) {
        this.touchEndX = event.changedTouches[0].screenX;
        this.handleSwipe();
    },

    handleSwipe() {
        const swipeThreshold = 50;
        const diff = this.touchStartX - this.touchEndX;

        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                this.nextImage();
            } else {
                this.previousImage();
            }
        }
    }
});

