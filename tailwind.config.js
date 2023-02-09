/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme')
module.exports = {
  content: ["./**/*.{html,js}"],
  theme: {
    colors: {
      'white': '#E6F4F7',
      'black': '#17151A',
      'orange': {
        DEFAULT: '#EBA730',
        light: '#F2C77D',
      },
      'teal': {
        DEFAULT: '#33BA9D',
        light: '#7FDCC8',
      },
      'blue': {
        light: '#647A82',
        DEFAULT: '#073642',
        dark: '#002B36',
      },
    },
    extend: {
      fontFamily: {
        serif: ['"Alfa Slab One"', ...defaultTheme.fontFamily.serif],
        sans: ['"Open Sans"', ...defaultTheme.fontFamily.sans],
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('daisyui'),
  ],
}
