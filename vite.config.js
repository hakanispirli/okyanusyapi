import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        // Enable minification with Terser
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true, // Remove console.logs in production
                drop_debugger: true,
                pure_funcs: ['console.log', 'console.info', 'console.debug'],
            },
            format: {
                comments: false, // Remove comments
            },
        },
        // Optimize chunk splitting
        rollupOptions: {
            output: {
                manualChunks: {
                    // Separate vendor chunks for better caching
                    'alpine': ['alpinejs'],
                },
            },
        },
        // Increase chunk size warning limit
        chunkSizeWarningLimit: 1000,
        // Enable CSS code splitting
        cssCodeSplit: true,
        // Optimize asset inlining threshold (10kb)
        assetsInlineLimit: 10240,
        // Enable source maps for debugging (disable in production if not needed)
        sourcemap: false,
    },
    // Optimize dependencies
    optimizeDeps: {
        include: ['alpinejs'],
    },
});
