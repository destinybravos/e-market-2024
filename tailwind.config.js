/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'selector',
  content: ["./app/**/*.{html,css,php,js}"],
  theme: {
    extend: {
      colors:{
        primary: '#fe624c',
        background: '#f0f2f9',
        secondary: '#6e00ff'
      },
      
    },
  },
  plugins: [],
}

