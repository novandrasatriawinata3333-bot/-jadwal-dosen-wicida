import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',          // ← TAMBAHAN INI (PENTING!)
        './resources/js/**/*.vue',          // ← Jika pakai Vue
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            
            // Custom colors (optional)
            colors: {
                'wicida-primary': '#65c3c8',
                'wicida-secondary': '#ef9fbc',
            },
            
            // Custom animations (optional)
            keyframes: {
                'fade-in': {
                    '0%': { opacity: '0', transform: 'translateY(10px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'slide-in': {
                    '0%': { transform: 'translateX(-100%)' },
                    '100%': { transform: 'translateX(0)' },
                },
            },
            animation: {
                'fade-in': 'fade-in 0.5s ease-out',
                'slide-in': 'slide-in 0.3s ease-out',
            },
        },
    },

    plugins: [
        forms,
        require('daisyui'),
    ],

    // DaisyUI Configuration (ENHANCED)
    daisyui: {
        themes: [
            {
                // Custom theme untuk Lab WICIDA
                wicida: {
                    "primary": "#65c3c8",
                    "primary-focus": "#4fb3b8",
                    "primary-content": "#ffffff",
                    
                    "secondary": "#ef9fbc",
                    "secondary-focus": "#e87fa8",
                    "secondary-content": "#ffffff",
                    
                    "accent": "#eeaf3a",
                    "accent-focus": "#e09f2a",
                    "accent-content": "#ffffff",
                    
                    "neutral": "#291334",
                    "neutral-focus": "#1f0e28",
                    "neutral-content": "#ffffff",
                    
                    "base-100": "#faf7f5",
                    "base-200": "#efeae6",
                    "base-300": "#e7e2df",
                    "base-content": "#291334",
                    
                    "info": "#3abff8",
                    "info-content": "#ffffff",
                    
                    "success": "#36d399",
                    "success-content": "#ffffff",
                    
                    "warning": "#fbbd23",
                    "warning-content": "#ffffff",
                    
                    "error": "#f87272",
                    "error-content": "#ffffff",
                },
            },
            "light",
            "dark",
            "cupcake",
            "bumblebee",
            "emerald",
            "corporate",
            "synthwave",
            "retro",
            "cyberpunk",
            "valentine",
            "halloween",
            "garden",
            "forest",
            "aqua",
            "lofi",
            "pastel",
            "fantasy",
            "wireframe",
            "black",
            "luxury",
            "dracula",
        ],
        
        // Default theme
        darkTheme: "dark",
        
        // Base styles
        base: true,
        
        // Styled components
        styled: true,
        
        // Utility classes
        utils: true,
        
        // Logs
        logs: true,
        
        // RTL support
        rtl: false,
        
        // Theme root
        themeRoot: ":root",
    },
};
