/**
 * Mobile Menu Alpine.js Component
 * Okyanus Yapı - Modern Header Mobile Menu
 */

export default () => ({
    open: false,
    openDropdown: null,

    /**
     * Toggle mobile menu
     */
    toggle() {
        this.open = !this.open;
        if (this.open) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
            this.openDropdown = null;
        }
    },

    /**
     * Close mobile menu
     */
    close() {
        this.open = false;
        document.body.style.overflow = '';
        this.openDropdown = null;
    },

    /**
     * Toggle dropdown in mobile menu
     */
    toggleDropdown(name) {
        this.openDropdown = this.openDropdown === name ? null : name;
    },

    /**
     * Check if dropdown is open
     */
    isDropdownOpen(name) {
        return this.openDropdown === name;
    },

    /**
     * Close on escape key
     */
    init() {
        this.$watch('open', value => {
            if (value) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        });

        // Close on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.open) {
                this.close();
            }
        });

        // Close on route change (if using SPA)
        window.addEventListener('popstate', () => {
            if (this.open) {
                this.close();
            }
        });
    }
});

