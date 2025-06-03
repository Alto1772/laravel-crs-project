import defaultTheme from "tailwindcss/defaultTheme";
import flyonui from "flyonui";
import flyonui_plugin from "flyonui/plugin";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/menus/*.json",
        "./resources/js/**/*.js",

        // Flyonui
        "./node_modules/flyonui/dist/js/*.js",
        "./node_modules/apexcharts/**/*.js",
        "./node_modules/notyf/*.js",
        "./node_modules/datatables.net/js/dataTables.min.js",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['"Nunito Sans"', ...defaultTheme.fontFamily.sans],
                logo: ['"Bodoni Moda"', ...defaultTheme.fontFamily.serif],
            },
            backgroundImage: {
                banner: "linear-gradient(rgba(245, 229, 210, 0.3), rgba(245, 229, 210, 0.3)), url('../images/crs-logo.png')",
            },
        },
    },

    plugins: [flyonui, flyonui_plugin],

    flyonui: {
        // themeRoot: ".flyonui-root",
        logs: false,
        vendors: true,
        themes: {},
    },
};
