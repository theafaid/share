
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

let authorizations = require('./authorizations');

window.Vue = require('vue');

import InstantSearch from 'vue-instantsearch';
import Toaster from 'v-toaster'
import 'v-toaster/dist/v-toaster.css'

Vue.use(Toaster, {timeout: 3000})
Vue.use(InstantSearch);

window.Vue.prototype.authorize = function(...params){
    if(! user.id ) return false;

    if(typeof $params[0] === 'string'){
       return authorizations[params[0]](params[1]);
    }

    return params[0](user);
};

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('thread', require('./pages/Thread.vue'));
Vue.component('UserAvatarForm', require('./components/UserAvatarForm.vue'));
Vue.component('notification', require('./components/Notification.vue'));

const app = new Vue({
    el: '#app'
});
