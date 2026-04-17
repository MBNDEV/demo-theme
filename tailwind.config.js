/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './*.php',
    './inc/**/*.php',
    './blocks/**/*.php',
    './blocks-render/**/*.php',
    './page-templates/**/*.php',
    './widgets/**/*.php',
    './block-assets/**/*.css',
    './resources/**/*.css',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
};
