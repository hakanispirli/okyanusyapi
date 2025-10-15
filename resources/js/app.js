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
