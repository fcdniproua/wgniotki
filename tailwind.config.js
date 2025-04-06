/** @type {import('tailwindcss').Config} */
module.exports = {
  important: true,
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    // Додайте всі шляхи, де використовуються Tailwind-класи
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}