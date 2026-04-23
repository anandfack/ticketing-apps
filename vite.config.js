import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/js/app.tsx"],
            refresh: true,
        }),
        react(),
    ],
    server: {
        host: "0.0.0.0", // ⬅️ penting (lebih aman dari 0.0.0.0)
        port: 5173,
        strictPort: true,
        hmr: {
            host: "localhost",
            port: 5173,
        },
    },
});
