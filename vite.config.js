import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        tailwindcss(),
    ],
    build: {
        emptyOutDir: false,
        manifest: 'manifest.json',
        rollupOptions: {
            input: ['resources/js/app.js', 'resources/css/main.css'],
            output: {
                entryFileNames: `js/app.js`,
                assetFileNames: file => {
                    let ext = file.name.split('.').pop()
                    if (ext === 'css') {
                        return 'css/main.css'
                    }
                }
            }
        },
        outDir: 'public',
    },
});
