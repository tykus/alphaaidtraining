require('./bootstrap');

window.Vue = require('vue');

Vue.component('navbar', require('./components/Navbar.vue'));
Vue.component('courses', require('./components/Courses.vue'));

const app = new Vue({
    el: '#app'
});
