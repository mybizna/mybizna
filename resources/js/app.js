import './public-path.js'
import {
    createApp
} from 'vue';
import router from '@/components/router';
/** import {
    loadFonts
 } from './plugins/webfontloader';
*/
import {
    createStore
} from 'vuex';
import moment from 'moment';

import Cookies from "js-cookie";
import createPersistedState from "vuex-persistedstate";
import NProgress from 'nprogress';

import Axios from 'axios';
//import axiosRetry from 'axios-retry';
const rax = require('retry-axios');
import VueSweetalert2 from 'vue-sweetalert2';
import {
    plugin,
    defaultConfig,
} from '@formkit/vue';

import '@popperjs/core';
//import "bootstrap/dist/js/bootstrap.js";
import 'bootstrap/dist/js/bootstrap.bundle.js';
import { Modal } from 'bootstrap/dist/js/bootstrap.bundle.js';

import 'bootstrap/dist/css/bootstrap.css';
import "nprogress/nprogress.css";
import 'sweetalert2/dist/sweetalert2.min.css';

import filters from "@/utils/filters";

window.$Modal = Modal;

window.$filters = window.$func = window.$helper = filters;

import autorouter from "@/components/router/autorouter";
import Calendar from "@/components/common/Calendar";

import App from '@/components/App';
import "../css/app.css";


import config from "@/formkit/config";

const app = createApp(App)
    .use(VueSweetalert2)
    .use(plugin, defaultConfig(config));

//loadFonts();

let base_url = window.base_url + '/api';
let assets_url = window.assets_url;
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxx  App Initializer xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

app.config.globalProperties.$base_url = base_url;
app.config.globalProperties.$assets_url = assets_url;
app.config.globalProperties.$male_default_avatar = 'images/avatar.png';
app.config.globalProperties.$female_default_avatar = 'images/avatar2.png';

app.config.globalProperties.$appName = window.appName = 'My App';

app.config.globalProperties.$is_frontend = window.is_frontend = false;
app.config.globalProperties.$is_stockist = window.is_stockist = false;
app.config.globalProperties.$is_backend = window.is_backend = true;

app.config.globalProperties.$in_progress = window.in_progress = true;
app.config.globalProperties.$loading = window.loading = true;
app.config.globalProperties.$moment = window.$moment = moment;

app.config.devtools = true;

app.config.globalProperties.$loader_template = window.loader_template = '<div class="block-screen"><b>Please wait...</b></div>';

Axios.defaults.baseURL = base_url;

//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxx  Filter xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

app.config.globalProperties.$filters = filters;
app.config.globalProperties.$func = filters;


//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxx  Axios Loader xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

Axios.defaults.baseURL = base_url;
Axios.defaults.withCredentials = true;


Axios.defaults.timeout = 30000;
Axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';

// Add a request interceptor
Axios.interceptors.request.use(function (config) {
    store.commit('system/loading',true);
    NProgress.start();
    return config;
}, function (error) {
    store.commit('system/loading',false);
    return Promise.reject(error);
});

// Add a response interceptor
Axios.interceptors.response.use(function (response) {
    store.commit('system/loading',false);

    if (Object.prototype.hasOwnProperty.call(response.data, 'message') && response.data.message == "Unauthenticated") {
        store.commit('auth/logout');
    }

    // Do something with response data
    NProgress.done();
    return response;
}, function (error) {
    store.commit('system/loading',false);
    return Promise.reject(error);
});


rax.attach();
//axiosRetry(Axios, { retries: 3, shouldResetTimeout: true, retryDelay: axiosRetry.exponentialDelay });
Axios.defaults.raxConfig = {
    retry: 3, // number of retry when facing 4xx or 5xx
    noResponseRetries: 3, // number of retry when facing connection error
    retryDelay: 5000,
    onRetryAttempt: err => {
        const cfg = rax.getConfig(err);
        console.log(`Retry attempt #${cfg.currentRetryAttempt}`); // track current trial
    }
};
app.config.globalProperties.$http = app.config.globalProperties.$axios = window.axios = Axios;


// Create axios instance with base url and credentials support
window.axios.interceptors.request.use(function (config) {


    // If http method is `post | put | delete` and XSRF-TOKEN cookie is
    // not present, call '/sanctum/csrf-cookie' to set CSRF token, then
    // proceed with the initial response

    const tmp_config = async (config) => {

        if ((
            config.method == 'patch' ||
            config.method == 'post' ||
            config.method == 'put' ||
            config.method == 'delete'
            /* other methods you want to add here */
        ) && !Cookies.get('XSRF-TOKEN')) {


            await window.axios.get(window.base_url + '/sanctum/csrf-cookie')
                .then(function (response) {
                });

            return await window.axios.get(window.base_url + '/sanctum/csrf-cookie')
                .then(response => config);
        }

        return config;
    };

    return tmp_config(config);

}, function (error) {
    return Promise.reject(error);
});


//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxx  Vuex Store xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
import modules from '@/store/modules';


const store = createStore({
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


if (store.state.auth.token) {
    window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + store.state.auth.token;
}

app.use(store);



//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx  Ruotes  xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx


router.beforeEach((to, from, next) => {

    store.commit('system/loading',true);
    NProgress.start();

    if (to.meta.middlewareAuth) {
        if (!store.getters["auth/loggedIn"]) {
            next({
                path: "/login",
                query: {
                    redirect: to.fullPath,
                },
            });

            return;
        }
    }


    if (to.matched.some((record) => record.meta.middlewareAuth)) {
        if (!store.getters["auth/loggedIn"]) {
            next({
                path: "/login",
                query: {
                    redirect: to.fullPath,
                },
            });

            return;
        }
    }

    next();
});

router.afterEach((to, from) => {
    // ...
    store.commit('system/loading',false);
    NProgress.done();
});


app.component('calendar', Calendar);


(async () => {

    await autorouter(router);

    app.config.globalProperties.$router = window.$router = router;

    app.use(router);

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx  Mount App  xxxxxxxxxxxxxxxxxxxxxxxxxxxx
    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    app.mount('#app');

})();
