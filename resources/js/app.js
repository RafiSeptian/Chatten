/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.rootURL = 'https://chattenapp.herokuapp.com'
window.baseURL = 'https://chattenapp.herokuapp.com/api/v1'
window.token = localStorage.getItem('token') ? localStorage.getItem('token') : '';


// Register components
Vue.component('Authentication', require('./views/Authentication.vue').default)
Vue.component('chat-app', require('./views/ChatApp.vue').default)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
