require('../../bootstrap')

import App from './App.vue'
import router from './router'
import store from '../../vuex/store'
import messages from '../../components/lang/messages'
import VueI18n from 'vue-i18n'

Vue.use(VueI18n)

const i18n = new VueI18n({
    locale: 'pt_br', // set locale
    messages // set locale messages
})

var vm = new Vue({
    store,
    el: '#app',
    router,
    i18n,
    template: '<App/>',
    components: {App}
});
