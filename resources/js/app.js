import './bootstrap';
import { createApp } from 'vue'
import router from './router/route.js'
import App from './layouts/App.vue'

createApp(App)
    .use(router)
    .mount('#app')