/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        '../Partials/**/*.html',
        '../Templates/**/*.html',
    ],
    theme: {
        extend: {
            colors: {
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

