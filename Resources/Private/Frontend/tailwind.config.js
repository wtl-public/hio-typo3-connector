/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        '../Partials/**/*.html',
        '../Templates/**/*.html',
    ],
    theme: {
        extend: {
            colors: {
                'primary': {
                    DEFAULT: '#3e566c',
                    50: '#b3c1d0',
                    100: '#a7b6c7',
                    200: '#8e9fb5',
                    300: '#7588a3',
                    400: '#4a657d',
                    500: '#3e566c',
                    600: '#32475b',
                    700: '#253746',
                },
                'wtl-red-dark': {
                    DEFAULT: '#AA0033',
                    50: '#FF6392',
                    100: '#FF4E83',
                    200: '#FF2567',
                    300: '#FC004B',
                    400: '#D3003F',
                    500: '#AA0033',
                    600: '#720022',
                    700: '#3A0011',
                    800: '#020001',
                    900: '#000000',
                },
                'wtl-red': {
                    DEFAULT: '#CC0033',
                    50: '#FF85A3',
                    100: '#FF7094',
                    200: '#FF4775',
                    300: '#FF1F57',
                    400: '#F5003D',
                    500: '#CC0033',
                    600: '#940025',
                    700: '#5C0017',
                    800: '#240009',
                    900: '#000000',
                },
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}

