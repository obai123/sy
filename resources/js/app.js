import './bootstrap';
import '../css/app.css';
import '../css/vuetify.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

// Vuetify imports
import { createVuetify } from 'vuetify'
import 'vuetify/styles' // Vuetify styles
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import { mdi } from 'vuetify/iconsets/mdi'

// Setup Vuetify instance
const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: 'mdi',
    },
    theme: {
        defaultTheme: 'customTheme',
        themes: {
            customTheme: {
                colors: {
                    background: '#a6a6a6', // Your desired background color
                },
            },
        },
    }
})

const appName = import.meta.env.VITE_APP_NAME || 'Syriatel Portal';

createInertiaApp({
    title: (title) => `${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(vuetify) // Integrating Vuetify here
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
