/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  darkMode: 'class',
  safelist: [
    'dark:bg-slate-900',
    'dark:via-purple-900',
    'dark:from-slate-900',
    'dark:to-slate-900',
    'dark:bg-white/10',
    'dark:text-white',
    'dark:text-gray-300',
    'dark:border-white/10',
    'dark:bg-gray-800',
    'dark:text-gray-400'
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}