const colors = require('tailwindcss/colors')

module.exports = {
  content: [
    './components/**/*.{vue,js,ts}',
    './layouts/**/*.{vue,js,ts}',
    './pages/**/*.{vue,js,ts}',
    './app.vue'
  ],
  theme: {
    extend: {
      colors: {
        primary: colors.blue,
        gray: colors.gray
      }
    }
  },
  plugins: []
}
