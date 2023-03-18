import { defineConfig } from "vite"
import laravel from "laravel-vite-plugin"
import vue from "@vitejs/plugin-vue"
import DefineOptions from "unplugin-vue-define-options/vite"
import AutoImport from "unplugin-auto-import/vite"
import Components from "unplugin-vue-components/vite"
// import { HeadlessUiResolver } from "unplugin-vue-components/resolvers"

export default defineConfig({
  resolve: {
    alias: {
      "@": "/resources/js",
    },
    extensions: [".mjs", ".js", ".ts", ".jsx", ".tsx", ".json", ".vue"],
    dedupe: ["vue"],
  },
  plugins: [
    laravel({
      input: "resources/js/app.js",
      refresh: true,
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
    DefineOptions(),
    AutoImport({
      dirs: ["resources/js/Composables"],
      imports: ["vue", { "@inertiajs/vue3": ["router", "useForm", "usePage"] }],
      // resolvers: [HeadlessUiResolver()],
    }),
    Components({ dirs: ["resources/js/Components"] }),
  ],
  optimizeDeps: {
    include: ["fast-deep-equal"],
  },
})
