import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                revolut: {
                    purple: '#6366F1', // Primary purple
                    'purple-dark': '#4F46E5',
                    'purple-light': '#818CF8',
                    'purple-50': '#EEF2FF',
                    'purple-100': '#E0E7FF',
                    violet: '#8B5CF6',
                    'violet-dark': '#7C3AED',
                    'violet-light': '#A78BFA',
                },
            },
            boxShadow: {
                'revolut': '0 2px 8px rgba(0, 0, 0, 0.08)',
                'revolut-lg': '0 4px 16px rgba(0, 0, 0, 0.12)',
            },
            borderRadius: {
                'revolut': '16px',
                'revolut-sm': '12px',
            },
        },
    },
    plugins: [],
};
