require('./bootstrap');

Vue.component('server', require('./components/Server.vue'));

const app = new Vue({
    el: 'body'
});
