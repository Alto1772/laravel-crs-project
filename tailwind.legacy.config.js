import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import { addDynamicIconSelectors } from "@iconify/tailwind";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/pages/*.js",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['"Nunito Sans"', ...defaultTheme.fontFamily.sans],
                logo: ['"Bodoni Moda"', ...defaultTheme.fontFamily.serif],
            },
            backgroundImage: {
                banner: "linear-gradient(rgba(245, 229, 210, 0.5), rgba(245, 229, 210, 0.5)), url('../images/crs-logo.png')",
            },
        },
    },

    plugins: [forms, addDynamicIconSelectors()],
};
