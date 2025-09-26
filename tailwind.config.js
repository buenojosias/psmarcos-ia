import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    presets: [require("./vendor/tallstackui/tallstackui/tailwind.config.js")],
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./vendor/tallstackui/tallstackui/src/**/*.php",
        "./app/Providers/*.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: "#f0f9ff",
                    100: "#dff2fe",
                    200: "#b8e6fe",
                    300: "#74d4ff",
                    400: "#00bcff",
                    500: "#00a6f4",
                    600: "#0084d1",
                    700: "#0069a8",
                    800: "#00598a",
                    900: "#024a70",
                    950: "#052f4a",
                },
            },
        },
    },

    plugins: [forms],
};
