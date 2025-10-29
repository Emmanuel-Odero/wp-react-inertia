import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";

export default defineConfig({
  plugins: [react()],
  build: {
    manifest: true,
    outDir: "assets/build",
    rollupOptions: {
      input: "assets/src/app.jsx",
    },
  },
  server: {
    // allow requests from your WP site origin
    cors: {
      origin: "http://wp-react-inertia.local",
      credentials: true,
    },
    host: true, // listen on all addresses (enables other hostnames)
    port: 5174,
    strictPort: true,
    hmr: {
      protocol: "ws",
      host: "localhost", // where the client should connect for ws
      clientPort: 5174,
    },
  },
});
