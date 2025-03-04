import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import requireTransform from 'vite-plugin-require';

export default defineConfig({
  plugins: [
      react(),
      requireTransform(),
    ],
  build: {
    outDir: 'assets/build',
    manifest: true,
    rollupOptions: {
      input: 'assets/src/app.jsx',
    },
  },
});