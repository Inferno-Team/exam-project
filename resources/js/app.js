
require('./bootstrap');
import VueRouter from 'vue-router'
import { routes } from './routes'
import App from './views/App';
import VueSidebarMenu from 'vue-sidebar-menu'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

const NarBar = require('./compos/NavBar').default
window.Vue = require('vue').default;
Vue.use(IconsPlugin)
Vue.use(BootstrapVue)
Vue.use(VueRouter)
Vue.component('NavBar', NarBar)
Vue.use(VueSidebarMenu)
const router = new VueRouter({
    mode: 'history',
    routes
})

const app = new Vue({
    el: '#app',
    components: { App },
    router
});
