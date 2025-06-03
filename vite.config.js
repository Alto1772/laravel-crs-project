import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import { glob } from "glob";
import webfontDownload from "vite-plugin-webfont-dl";

export default defineConfig({
    plugins: [
        webfontDownload([
            "https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap",
            "https://fonts.googleapis.com/css2?family=Bodoni+Moda:opsz,wght@6..96,700&display=swap",
        ]),
        laravel({
            input: [
                "resources/css/app.css",
                "resources/css/app-legacy.css",
                "resources/js/app.js",
                ...glob.sync("resources/js/vendor/*.js"),
                ...glob.sync("resources/css/vendor/*.css"),
                ...glob.sync("resources/js/pages/**/*.js"),
            ],
            refresh: true,
        }),
    ],
    build: {
        // rollupOptions: {
        //     output: {
        //         entryFileNames: "assets/[hash:16].js",
        //         chunkFileNames: "assets/[hash:16].js",
        //         assetFileNames: "assets/[hash:16].[ext]",
        //     },
        // },
    },
});
