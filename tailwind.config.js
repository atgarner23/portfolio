/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme')
module.exports = {
  content: ["./**/*.{html,js}"],
  theme: {
    colors: {
      'white': '#E6F4F7',
      'black': '#17151A',
      'orange': '#EBA730',
      'teal': '#33BA9D',
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
  plugins: [],
}
