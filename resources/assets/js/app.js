
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('share-list', require('./components/ShareListComponent.vue'));
// Vue.component('share-show', require('./components/ShareShowComponent.vue'));

import App from './components/ExampleComponent.vue'
import ShareList from './components/ShareListComponent.vue'
import ShareShow from './components/ShareShowComponent.vue'
import Toasted from 'vue-toasted';
import BootstrapVue from 'bootstrap-vue'

export const eventBus = new Vue();

import VueRouter from 'vue-router'

window.Vue.use(VueRouter)
window.Vue.use(BootstrapVue)
window.Vue.use(Toasted, {iconPack:'fontawesome'})

// you can also pass options, check options reference below
// Vue.use(Toasted, Options)

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/vuejs/list',
            name: 'list',
            component: ShareList
        },
        {
            path: '/vuejs/show/:id',
            name: 'show',
            component: ShareShow,
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
