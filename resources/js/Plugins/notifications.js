import { useToast } from "vue-toastification";
import "vue-toastification/dist/index.css";
import { usePage } from "@inertiajs/vue3";

const toast = useToast();

export const notifications = () => {
  router.on("finish", () => {
    const notification = usePage().props.notification;

    if (notification) {
      toast(notification.body, { type: notification.type });
    }
  });
};
