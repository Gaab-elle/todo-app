import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css', 
        'resources/css/custom.css', 
        'resources/css/fab.css', 
        'resources/js/app.js', 
        'resources/js/fab.js'
      ],
      refresh: true,
    }),
    tailwindcss(),
  ],
})