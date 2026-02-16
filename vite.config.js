import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
    
    build: {
        manifest: true,
        outDir: 'public/build',
        emptyOutDir: true,
        sourcemap: false,
        
        rollupOptions: {
            output: {
                manualChunks: undefined,
            },
        },
        
        // Use default esbuild minification (faster & no extra dependency)
        minify: 'esbuild',
        
        chunkSizeWarningLimit: 1000,
    },
    
    server: {
        host: 'localhost',
        port: 5173,
        
        hmr: {
            host: 'localhost',
        },
    },
});
