/**
 * Vite build for the standalone alert.css bundle (Tailwind v4).
 * Outputs to public/css/alert.css for publishing with the package.
 */
import tailwindcss from '@tailwindcss/vite';
import { dirname, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';
import { defineConfig } from 'vite';

const __dirname = dirname(fileURLToPath(import.meta.url));

export default defineConfig({
    publicDir: false,
    plugins: [tailwindcss()],
    build: {
        outDir: resolve(__dirname, 'public/css'),
        emptyOutDir: true,
        rollupOptions: {
            input: resolve(__dirname, 'resources/css/alert.css'),
            output: {
                assetFileNames: 'alert.css',
            },
        },
    },
});
