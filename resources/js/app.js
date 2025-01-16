import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { ZiggyVue } from 'ziggy-js';
import '../css/app.css';
import '@fortawesome/fontawesome-free/css/all.min.css';
import MainLayout from "@/Layouts/MainLayout.vue";

createInertiaApp({
    resolve: async name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
        const page = await pages[`./Pages/${name}.vue`];

        // Apply MainLayout only if `layout` is undefined (not null)
        page.default.layout = page.default.layout === undefined ? MainLayout : page.default.layout;

        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)  // Make sure ZiggyVue is used as a plugin
            .mount(el);
    },
});
