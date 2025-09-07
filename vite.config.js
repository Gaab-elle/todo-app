import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css', 
        'resources/css/custom.css', 
        'resources/css/fab.css', 
        'resources/js/app.js', 
        'resources/js/fab.js',
        'resources/js/vue-app.js'
      ],
      refresh: true,
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
    tailwindcss(),
  ],
  resolve: {
    alias: {
      vue: 'vue/dist/vue.esm-bundler.js',
    },
  },
  build: {
    rollupOptions: {
      external: ['crypto'],
    },
  },
  define: {
    global: 'globalThis',
  },
})