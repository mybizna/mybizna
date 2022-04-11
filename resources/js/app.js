// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import '@/plugins/vue-composition-api';
import '@/styles/styles.scss';

import Vue from 'vue';
import Vuetify from 'vuetify';
import Vuex from 'vuex';
import App from '@/components/App';
import Axios from 'axios';
import router from '@/components/router';
import createPersistedState from "vuex-persistedstate";
import VueRouter from 'vue-router';
import Truncate from 'lodash.truncate';
import VueFormGenerator from "vue-form-generator";
import VueMoment from 'vue-moment';
import moment from 'moment-timezone';
import NProgress from 'nprogress';
import Cookies from "js-cookie";

import VueCommonFilters from 'vue-common-filters';

import 'vue-form-generator/dist/vfg.css';
import 'nprogress/nprogress.css';


let base_url = window.base_url + '/api';

Vue.prototype.$base_url = base_url;
Vue.prototype.$male_default_avatar = '/assets/images/avatar.png';
Vue.prototype.$female_default_avatar = '/assets/images/avatar2.png';
Axios.defaults.baseURL = base_url;
var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

moment.tz.setDefault(timezone);
Vue.config.productionTip = false;

Vue.use(VueRouter);
Vue.use(VueFormGenerator);
Vue.use(Vuetify);
Vue.use(Vuex);
Vue.use(VueMoment, {
    moment,
});

window.router = router;

Vue.prototype.$appName = window.appName = 'My App';

Vue.prototype.$is_frontend = window.is_frontend = false;
Vue.prototype.$is_stockist = window.is_stockist = false;
Vue.prototype.$is_backend = window.is_backend = true;

Vue.prototype.$in_progress = window.in_progress = true;
Vue.prototype.$loading = window.loading = {
    in_progress: true
};

Vue.prototype.$loader_template = window.loader_template = '<div class="block-screen"><b>Please wait...</b></div>';

import './apps';

import modules from '@/store/modules';

let store = new Vuex.Store({
    modules: modules,
    plugins: [createPersistedState({
        storage: {
            getItem: (key) => Cookies.get(key),
            // Please see https://github.com/js-cookie/js-cookie#json, on how to handle JSON.
            setItem: (key, value) =>
                Cookies.set(key, value, {
                    expires: 3,
                    secure: true
                }),
            removeItem: (key) => Cookies.remove(key),
        },
    })],
});

Axios.defaults.timeout = 10000;
Axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';

// Add a request interceptor
Axios.interceptors.request.use(function (config) {

    Vue.prototype.$loading.in_progress = true;

    // Do something before request is sent
    NProgress.start();
    return config;
}, function (error) {

    Vue.prototype.$loading.in_progress = false;

    // Do something with request error
    console.error(error);
    return Promise.reject(error);
});

// Add a response interceptor
Axios.interceptors.response.use(function (response) {

    Vue.prototype.$loading.in_progress = false;

    if (Object.prototype.hasOwnProperty.call(response.data, 'errors') && response.data.errors[0].message == "Signature has expired") {
        store.commit('auth/logout');
    }

    // Do something with response data
    NProgress.done();
    return response;
}, function (error) {

    Vue.prototype.$loading.in_progress = false;

    // Do something with response error
    console.error(error);
    return Promise.reject(error);
});


/*xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx */
// Register my awesome field
import fieldautocomplete from "@/components/custom_fields/autocomplete-field.vue";
Vue.component("field-autocomplete", fieldautocomplete);

//import fieldeditor from "@/components/custom_fields/editor-field.vue";
//Vue.component("field-editor", fieldeditor);

import fieldmedia from "@/components/custom_fields/media-field.vue";
Vue.component("field-media", fieldmedia);

import fieldvuedatetime from "@/components/custom_fields/vuedatetime-field.vue";
Vue.component("field-vuedatetime", fieldvuedatetime);

import fieldvuedatetimepicker from "@/components/custom_fields/vuedatetimepicker-field.vue";
Vue.component("field-vuedatetimepicker", fieldvuedatetimepicker);

import fieldrecordpicker from "@/components/custom_fields/recordpicker-field.vue";
Vue.component("field-recordpicker", fieldrecordpicker);


/*xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx */
// Helpers
// Global filters

Vue.filter('toCurrency', function (value) {
    if (typeof value !== "number") {
        return value;
    }
    var formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 4
    });
    return formatter.format(value);
});

let config = {
    "currency": {
        "symbol": "$",
        "decimalDigits": 2,
        "symbolOnLeft": true,
        "spaceBetweenAmountAndSymbol": false
    },

    "text": {
        "truncateClamp": "..."
    },

    "numbers": {
        "decimalDigits": 2
    },

    "array": {
        "implodeDelimiter": ", "
    },

    "dates": {
        "defaultFormat": "YYYY-MM-DD HH:mm:ss",
        "filterConvertFormat": "DD MMMM YYYY"
    }
};

Vue.use(VueCommonFilters, config);


Vue.prototype.$http = Vue.prototype.$axios = window.axios = Axios;

/*xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx */
// router gards
router.beforeEach((to, from, next) => {

    Vue.prototype.$loading.in_progress = true;

    NProgress.start();

    if (to.meta.middlewareAuth) {

        if (!store.getters["auth/loggedIn"]) {
            next({
                path: '/login',
                query: {
                    redirect: to.fullPath
                }
            });

            return;
        }
    }


    if (to.matched.some(record => record.meta.middlewareAuth)) {
        if (!store.getters["auth/loggedIn"]) {
            next({
                path: '/login',
                query: {
                    redirect: to.fullPath
                }
            });

            return;
        }
    }

    next();
});

router.afterEach((to, from) => {
    // ...
    Vue.prototype.$loading.in_progress = false;
    NProgress.done();
});

new Vue({
    router,
    store,
    render: (h) => h(App),
}).$mount("#app");
