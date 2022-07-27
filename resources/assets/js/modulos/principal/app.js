require('../../bootstrap');

import App from './App.vue';
import router from './router'
import store from '../../vuex/store'

var vm = new Vue({
    store,
    el: '#app',
    router: router,
    template: '<App/>',
    components: {App}
});
