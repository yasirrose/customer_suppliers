import _ from 'lodash'
import Vue from 'vue'
import { ToastPlugin, ModalPlugin } from 'bootstrap-vue'
import VueCompositionAPI from '@vue/composition-api'

import router from './router'
import store from './store'
import App from './App.vue'
import '../axios'
// import axios from 'axios'


// to use date format
import moment from 'moment'


// Global Components
import './global-components'

// 3rd party plugins
import '@/libs/portal-vue'
import '@/libs/toastification'

// import casl
import '@/libs/acl'

//use date format
Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('MM/DD/YYYY hh:mm')
    }
});

// BSV Plugin Registration
Vue.use(ToastPlugin)
Vue.use(ModalPlugin)

// Composition API
Vue.use(VueCompositionAPI)

Vue.use(axios)
    // import core styles
require('@core/scss/core.scss')

// import assets styles
require('@/assets/scss/style.scss')

Vue.config.productionTip = false

window._ = _
const getUrl = window.location;
// remove last section for running project as virtual host
const baseUrl =
    getUrl.protocol + '//' + getUrl.host;
window.API_URL = baseUrl + '/api/'

new Vue({
    router,
    store,
    axios,
    render: h => h(App),
}).$mount('#app')