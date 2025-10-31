import './bootstrap';

import Alpine from 'alpinejs';
import mobileMenu from './mobile-menu';
import heroSlider from './hero-slider';
import photoGallery from './photo-gallery';
import quillEditor from './quill-editor';

window.Alpine = Alpine;

// Register Alpine.js components
Alpine.data('mobileMenu', mobileMenu);
Alpine.data('heroSlider', heroSlider);
Alpine.data('photoGallery', photoGallery);
Alpine.data('quillEditor', quillEditor);

Alpine.start();

/**
 * Google Ads Conversion Tracking for Phone Calls
 * Tracks conversions when user clicks on phone links
 */
document.addEventListener('DOMContentLoaded', function() {
    // Generate unique transaction ID for phone call conversion
    function generateTransactionId() {
        const timestamp = Date.now();
        const random = Math.floor(Math.random() * 1000000);
        return `phone_call_${timestamp}_${random}`;
    }

    // Track phone link clicks - Push to dataLayer for GTM to handle
    function trackPhoneClick(event) {
        // Initialize dataLayer if not exists
        window.dataLayer = window.dataLayer || [];

        const transactionId = generateTransactionId();

        // Push event to dataLayer - GTM will handle the conversion
        window.dataLayer.push({
            'event': 'phone_call_conversion',
            'phone_number': event.currentTarget.getAttribute('href')?.replace('tel:', '') || '',
            'conversion_data': {
                'send_to': 'AW-17663218192/pn5ICP7v7K8bEJCkveZB',
                'value': 1.0,
                'currency': 'TRY',
                'transaction_id': transactionId
            }
        });
    }

    // Attach click listener to all tel: links
    function attachPhoneTracking() {
        const phoneLinks = document.querySelectorAll('a[href^="tel:"]');
        phoneLinks.forEach(link => {
            // Remove existing listener if any to avoid duplicates
            link.removeEventListener('click', trackPhoneClick);
            // Add click listener
            link.addEventListener('click', trackPhoneClick);
        });
    }

    // Initial attachment
    attachPhoneTracking();

    // Re-attach after dynamic content changes (for Alpine.js components)
    // Use MutationObserver to watch for new phone links
    const observer = new MutationObserver(function(mutations) {
        attachPhoneTracking();
    });

    // Observe changes to the document body
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});
