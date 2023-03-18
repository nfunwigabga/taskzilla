import "./bootstrap";
import "@spartez/vue-atlaskit-next/dist/bundle.css";
import "../css/app.scss";
import { createApp, h } from "vue";
import { createInertiaApp, Head, Link } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import { modal } from "momentum-modal";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import { notifications } from "@/Plugins/notifications";
import Toast from "vue-toastification";
import VueConfirmPlugin from "v3confirm";

const appName =
  window.document.getElementsByTagName("title")[0]?.innerText || "Tickets";

createInertiaApp({
  title: (title) => (title ? `${appName} — ${title}` : `${appName}`),
  progress: {
    color: "#4B5563"
  },
  resolve: async (name) => {
    const page = await resolvePageComponent(
      `./Pages/${name}.vue`,
      import.meta.glob("./Pages/**/*.vue")
    );
    page.default.layout ??= DefaultLayout;
    return page;
  },
  setup({ el, App, props, plugin }) {
    return createApp({ render: () => h(App, props) })
      .use(modal, {
        resolve: (name) =>
          resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
          )
      })
      .use(plugin)
      .use(ZiggyVue, Ziggy)
      .use(Toast, {
        pauseOnFocusLoss: false,
        pauseOnHover: true,
        timeout: 2000,
        transition: "Vue-Toastification__fade"
      })
      .use(notifications)
      .use(VueConfirmPlugin, {
        root: "#confirm",
        yesText: "Yes, continue",
        noText: "No"
      })
      .component("Link", Link)
      .component("Head", Head)
      .mount(el);
  }
});
