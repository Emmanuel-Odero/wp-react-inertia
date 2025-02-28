import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';

export default defineConfig({
  plugins: [react()],
  build: {
    outDir: 'assets/build',
    manifest: true,
    rollupOptions: {
      input: 'assets/src/app.jsx',
    },
  },
});