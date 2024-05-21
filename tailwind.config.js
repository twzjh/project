// import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue',
  ],

  theme: {
    extend: {
      fontFamily: {
        NotoSerif: ['Noto Serif TC'],
        JhengHei: ['Microsoft JhengHei'],
      },
      colors: {
        'main-white': '#f4f4f4',
        'main-black': '#0B0B0B',
        'front-background': '#f8f8f8',
        'light-light-gary': '#d9d9d9',
        'light-gary': '#b5b5b5',
        'dark-gray': '#6c6c6c',
        'dark-dark-gary': '#363636',
        'lake-green': '#1f9c95',
        'blue-green': '#518c95',
        'main-red': '#e37d73',
        'main-blue': '#687ca6',
        'main-green': '#749b91',
        'main-brown': '#cda07b',
        'main-cream': '#f4f1e9',
        'main-yellow': '#f2eac6',
      },
      boxShadow: {
        'cardShadow': 'rgba(0, 0, 0, 0.25) 0px 0px 5px 0px',
      },
      width: {
        'card3': 'calc(33% - 10px)',
      },
      backgroundImage: {
        'service-img': 'url("/images/holding-acupuncture.jpg")',
        'vedic-img': 'url("/images/astrologicall.jpg")',
        'TCM-img': 'url("/images/prescriptions-table.jpg")',
        'magic-img': 'url("/images/astrology.jpg")',
        'other-img': 'url("/images/symbol-stone.jpg")',
        'class-img': 'url("/images/astrology.png")',
        'class2-img': 'url("/images/Medicine-Prescribed.png")',
        'class3-img': 'url("/images/spells-opening.png")',
      },
      screens: {
        'sm': '600px',
        'xl': '1270px',
        'cart': '685px',
        'sma': '680px',
      },
    },
  },

  plugins: [forms],
};
