const defaultTheme = require("tailwindcss/defaultTheme");
const colors = require("tailwindcss/colors");
const { tailwindcssOriginSafelist } = require("@headlessui-float/vue");

/** @type {import("tailwindcss").Config} */
module.exports = {
  important: true,
  content: [
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    "./storage/framework/views/*.php",
    "./resources/views/**/*.blade.php",
    "./resources/js/**/*.vue"
  ],

  safelist: [
    {
      pattern:
        /bg-(blue|cyan|gray|green|indigo|orange|pink|purple|red|rose|sky|teal|yellow)-(50|100|200|300|400|500|600|700|800|900)/
    },
    {
      pattern:
        /border-b-(blue|cyan|gray|green|indigo|orange|pink|purple|red|rose|sky|teal|yellow)-(50|100|200|300|400|500|600|700|800|900)/
    },
    {
      pattern:
        /border-(blue|cyan|gray|green|indigo|orange|pink|purple|red|rose|sky|teal|yellow)-(50|100|200|300|400|500|600|700|800|900)/
    },
    {
      pattern:
        /text-(blue|cyan|gray|green|indigo|orange|pink|purple|red|rose|sky|teal|yellow)-(50|100|200|300|400|500|600|700|800|900)/
    },
    ...tailwindcssOriginSafelist
  ],

  theme: {
    container: {
      center: true
    },
    extend: {
      padding: {
        "1/3": "33.33333%",
        "2/3": "66.66667%"
      },

      colors: {
        primary: colors.violet,
        danger: colors.red,
        secondary: "#151b26",
        success: colors.green,
        warning: colors.orange,
        zinc: colors.zinc,
        link: colors.blue,
        rose: colors.rose,
        cyan: colors.cyan,
        dark: colors.slate
      },
      scale: {
        101: "1.01",
        102: "1.02"
      },
      fontFamily: {
        sans: [
          "Figtree",
          "Roboto",
          "Nunito",
          "Helvetica",
          "Proxima Nova",
          ...defaultTheme.fontFamily.sans
        ],
        poppins: ["Poppins", "sans-serif"],
        safira: ["SAFIRA", "Poppins", "Proxima Nova"]
      },
      fontSize: {
        xxs: ["0.65rem", { lineHeight: "1.1rem" }]
      }
    }
  },

  plugins: [
    require("@tailwindcss/forms"),
    require("@tailwindcss/aspect-ratio")
  ]
};
