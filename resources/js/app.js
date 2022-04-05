
require('./bootstrap');
import VueRouter from 'vue-router'
import { routes } from './routes'
import App from './views/App';
import VueSidebarMenu from 'vue-sidebar-menu'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import  NavBar from './compos/NavBar'
import JwPagination from 'jw-vue-pagination';


window.Vue = require('vue').default;
Vue.use(IconsPlugin)
Vue.use(BootstrapVue)
Vue.use(VueRouter)
Vue.component('NavBar', NavBar)
Vue.use(VueSidebarMenu)
Vue.component('jw-pagination', JwPagination);
const router = new VueRouter({
    mode: 'history',
    routes,
    
})

const app = new Vue({
    el: '#application',
    components: { App },
    router
});
