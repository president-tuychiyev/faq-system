import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { NConfigProvider, NDialogProvider, NMessageProvider } from 'naive-ui';
import naive from 'naive-ui';

// Fix Naive UI + Tailwind CSS issue
const meta = document.createElement('meta')
meta.name = 'naive-ui-style'
document.head.appendChild(meta)

const theme = {
    "common": {
        "borderRadius": "6px",
        "borderRadiusSmall": "4px",
        "primaryColor": "#2563ebFF",
        "primaryColorHover": "#3b82f6FF",
        "primaryColorPressed": "#1d4ed8FF",
        "primaryColorSuppl": "#2563ebFF",
        "infoColor": "#0ea5e9FF",
        "infoColorHover": "#38bdf8FF",
        "infoColorPressed": "#0284c7FF",
        "infoColorSuppl": "#0ea5e9FF",
        "successColor": "#10b981FF",
        "successColorHover": "#34d399FF",
        "successColorPressed": "#059669FF",
        "successColorSuppl": "#10b981FF",
        "warningColor": "#f59e0bFF",
        "warningColorHover": "#fbbf24FF",
        "warningColorPressed": "#d97706FF",
        "warningColorSuppl": "#f59e0bFF",
        "errorColor": "#dc2626FF",
        "errorColorHover": "#ef4444FF",
        "errorColorPressed": "#b91c1cFF",
        "errorColorSuppl": "#dc2626FF",
        "textColorBase": "#0f172aFF",
        "textColor3": "#475569FF",
        "textColorDisabled": "#cbd5e1FF",
        "placeholderColor": "#94a3b8FF",
        "placeholderColorDisabled": "#cbd5e1FF",
        "iconColor": "#64748bFF",
        "iconColorHover": "#94a3b8FF",
        "iconColorPressed": "#475569FF",
        "iconColorDisabled": "#cbd5e1FF"
    }
}


const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(NConfigProvider, { themeOverrides: theme }, () => h(NMessageProvider, { placement: "top" }, () => h(NDialogProvider, () => h(App, props)))) })
            .use(plugin)
            .use(naive)
            .use(ZiggyVue, Ziggy)
            .mount(el);
    },
    progress: {
        color: '#2563eb',
    },
});
