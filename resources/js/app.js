/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// import modules
import Swal from 'sweetalert2'
import VueCookies from 'vue-cookies'
import Vue from 'vue'

Vue.use(VueCookies)

window.Swal = Swal
window.Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true
})

window.rootURL = 'http://localhost:8000'
window.baseURL = 'http://localhost:8000/api/v1'

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
