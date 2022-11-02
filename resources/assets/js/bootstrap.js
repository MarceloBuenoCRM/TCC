window._ = require('lodash');
window.Cookie = require('js-cookie');

try {
    window.$ = window.jQuery = require('jquery');
    window.moment = require('moment');
    require('bootstrap');
} catch (e) {}

import store from './vuex/store';
let count = 0;
let showOrHideLoading = function () {
    if (count > 0) {
        store.commit('SHOW_LOADING');
    } else {
        setTimeout(function(){
            store.commit('HIDE_LOADING');
        }, 200)
    }
}

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.baseURL = 'https://listapresenca.shop/api/';
window.axios.defaults.headers.Authorization = `Bearer ${Cookie.get("token_api")}`;

window.axios.interceptors.request.use((request) => {
    count++;
    showOrHideLoading();

    return request
}, (error) => {
    return Promise.reject(error)
});

window.axios.interceptors.response.use((response) => {
    count--;
    showOrHideLoading();

    return response
}, (error) => {
    count--;
    showOrHideLoading();

    Notification.error({
        title: 'Opsss!',
        message: 'Houve um erro, tente novamente!'
    });

    return Promise.reject(error)
});

window.Vue = require('vue').default;
import ElementUI from 'element-ui';
import {
    Notification
} from 'element-ui';
import '../element-ui/lib/theme-chalk/index.css';
import locale from 'element-ui/lib/locale/lang/pt-br'

Vue.use(ElementUI, {
    locale
})

import VueTheMask from 'vue-the-mask'
Vue.use(VueTheMask)

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
