import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
    plugins: [vue()],
    resolve: {
        alias: {
            'vue-i18n': 'vue-i18n/dist/vue-i18n.cjs.js',
            '@': fileURLToPath(new URL('./src', import.meta.url)),
            'api-client': fileURLToPath(
                new URL(`./src/core/services/ApiService.ts`, import.meta.url)
            )
        }
    },
    base: '/',
    build: {
        chunkSizeWarningLimit: 3000
    },
    server: {
        // @ts-ignore
        allowedHosts: [
            'lcr.sabrinaermayanti.com',
            'localhost',
            'oncology.rangminangdev.my.id'
        ]
    }
})
