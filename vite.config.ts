import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        tailwindcss(),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    build:{
        rollupOptions:{
            output:{
                manualChunks(id){
                    // if(id.includes('node_modules/es-toolkit')){
                    //     return 'est';
                    // }
                    // if(id.includes('node_modules/lucide-vue-next')){
                    //     return 'ico';
                    // }
                    // if(id.includes('node_modules/reka-ui')){
                    //     return 'rui';
                    // }
                    // if (id.includes('node_modules')) {
                    //     //     return 'vendor';
                    //     console.log(id)
                    // }
                    return 'app';
                }
            }
        }
    }
});
