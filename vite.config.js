import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
  plugins: [tailwindcss()],
  build: {
    manifest: true,
    outDir: 'dist',
    rollupOptions: {
      input: 'src/main.js',
    },
  },
  server: {
    cors: true,
    strictPort: true,
    port: 5173,
  },
});
