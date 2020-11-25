
require('./bootstrap');

window.Vue = require('vue');
import router from './routes'
import store from './Store'

import App from './components/app'
Vue.component('pagination', require('laravel-vue-pagination'));


const app = new Vue({
    el: '#app',
    components: {
    	App
    },
    router,
    store
});
