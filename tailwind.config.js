module.exports = {
  purge: [
    '/resources/views/welcome.blade.php',
    '/resources/views/layouts/app.blade.php',
    '/resources/js/app.js',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}
