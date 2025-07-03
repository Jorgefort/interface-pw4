module.exports = {
  content: [
    "./index.html",
    "./js/**/*.js",
    "./src/**/*.{html,js}"
  ],
  theme: {
    extend: {
      fontFamily: {
        'mono': ['JetBrains Mono', 'monospace'],
      },
      colors: {
        'luxury-black': '#000000',
        'luxury-gray': '#1a1a1a',
        'luxury-light': '#2a2a2a',
      }
    },
  },
  plugins: [],
}
