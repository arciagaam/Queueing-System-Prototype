/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      backgroundImage: {
        'window' : 'url(/images/window-image.png)'
      },
      colors: {
        'primary' : '#082144',
        'secondary' : '#01C386'
      }

    },
  },
  plugins: [],
}