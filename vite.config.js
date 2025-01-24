import {defineConfig} from 'vite';
export default defineConfig({
    build: {
        emptyOutDir: false,
        manifest: true,
        rollupOptions: {
            input: ['resources/js/app.js', 'resources/css/main.css'],
            output: {
                entryFileNames: `app.js`,
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
