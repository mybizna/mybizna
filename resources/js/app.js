import './public-path.js'
import {
    createApp
} from 'vue';
import router from '@/router';

import {
    createStore
} from 'vuex';
import moment from 'moment';
import VueApexCharts from "vue3-apexcharts";

import Cookies from "js-cookie";
import createPersistedState from "vuex-persistedstate";
import localforage from 'localforage';
import NProgress from 'nprogress';

import Axios from 'axios';

const rax = require('retry-axios');
import Notifications from '@kyvg/vue3-notification';
import Vue3ConfirmDialog from 'vue3-confirm-dialog';
import 'vue3-confirm-dialog/style';
import {
    plugin,
    defaultConfig,
} from '@formkit/vue';

import Vueform from '@vueform/vueform'
import vueformConfig from '../../vueform.config'

import '@popperjs/core';

import mitt from 'mitt';

import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

//import "bootstrap/dist/js/bootstrap.js";
import 'bootstrap/dist/js/bootstrap.bundle.js';
import { Modal } from 'bootstrap/dist/js/bootstrap.bundle.js';

import 'bootstrap/dist/css/bootstrap.css';
import "nprogress/nprogress.css";

import filters from "@/utils/filters";

window.$Modal = Modal;

window.$filters = window.$func = window.$helper = filters;

import autorouter from "@/router/autorouter";


import App from '@/components/App';
import "../css/app.css";

// widgets
import Positions from '@/components/widgets/Positions';
import ThRender from '@/components/widgets/ThRender';
import TdRender from '@/components/widgets/TdRender';
import ImageLink from '@/components/widgets/ImageLink';
import Pagination from '@/components/widgets/Pagination';
import MenuDropdown from '@/components/widgets/MenuDropdown';
import BtnStatus from '@/components/widgets/BtnStatus';

import Calendar from "@/components/common/Calendar";
import SearchForm from '@/components/common/SearchForm';
import EditRender from '@/components/common/EditRender';
import TableRender from '@/components/common/TableRender';

import config from "@/formkit/config";

const app = createApp(App)
    .use(Notifications)
    .use(Vue3ConfirmDialog)
    .use(VueApexCharts)
    .use(plugin, defaultConfig(config))
    .use(Vueform, vueformConfig)

//loadFonts();

let base_url = window.base_url + '/api';
let assets_url = window.assets_url;

let default_responsive_point = (window.default_responsive_point) ? window.default_responsive_point : 768;
let responsive_point = (window.responsive_point) ? window.responsive_point : default_responsive_point;
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxx  App Initializer xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

app.config.globalProperties.$floating_top = (window.floating_top) ? window.floating_top : false;
app.config.globalProperties.$margin_top = (window.margin_top) ? window.margin_top : false;
app.config.globalProperties.$responsive_point = responsive_point;
app.config.globalProperties.$default_responsive_point = default_responsive_point;
app.config.globalProperties.$root_url = window.base_url;
app.config.globalProperties.$base_url = base_url;
app.config.globalProperties.$assets_url = assets_url;
app.config.globalProperties.$emitter = mitt();
app.config.globalProperties.$male_default_avatar = 'images/avatar.png';
app.config.globalProperties.$female_default_avatar = 'images/avatar2.png';

app.config.globalProperties.$appName = window.appName = 'My App';
app.config.globalProperties.$viewside = window.viewside ?? 'backend';


app.config.globalProperties.$template = (window.template) ? window.template : 'front';
app.config.globalProperties.$is_frontend = window.is_frontend = false;
app.config.globalProperties.$is_backend = window.is_backend = false;

switch (window.viewside) {
    case 'backend':
        app.config.globalProperties.$is_backend = window.is_backend = true;
        break;
    case 'frontend':
    default:
        app.config.globalProperties.$is_frontend = window.is_frontend = true;
        break;
}

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
    store.commit('system/loading', true);
    NProgress.start();
    return config;
}, function (error) {
    store.commit('system/loading', false);
    return Promise.reject(error);
});

// Add a response interceptor
Axios.interceptors.response.use(function (response) {
    store.commit('system/loading', false);

    if (Object.prototype.hasOwnProperty.call(response.data, 'message') && response.data.message == "Unauthenticated") {
        store.commit('auth/logout');
    }

    // Do something with response data
    NProgress.done();
    return response;
}, function (error) {
    store.commit('system/loading', false);
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

let db = null;

const store = createStore({
    modules: modules,
    plugins: [createPersistedState({
        key: `vuex_${window.mybizna_uniqid}`, // Optional key to store state under
        //storage: localforage, // Use localForage for storage
        storage: {
            getItem: async (key) => {

                console.log('xxxxxxxxxxxxxxxxxxxxxxxx');
                console.log('');
                console.log('');
                console.log('getItem');
                console.log('');
                console.log('key');
                console.log(key);
                console.log('------------------------');

                try {
                    const data = {};
                    const vuexData = await localforage.getItem(`${key}_${window.mybizna_uniqid}_data`);

                    // check if vuexData is a valid JSON string
                    let is_json = filters.isJson(vuexData);

                    let vuexObj = (is_json) ? JSON.parse(vuexData) : vuexData;

                    for (const mkey in vuexObj) {
                        data[mkey] = {};
                        const keys = vuexObj[mkey];
                        keys.forEach(async skey => {
                            const subData = await localforage.getItem(`vuex_${window.mybizna_uniqid}_${mkey}_${skey}`);
                            data[mkey][skey] = subData;
                        });
                    }

                    const vuex = await localforage.getItem(key);
                    vuexObj = (filters.isJson(vuex)) ? JSON.parse(vuex) : vuexData;

                    console.log('vuexObj');
                    console.log(vuexObj);
                    console.log('data');
                    console.log(data);
                    console.log('data.auth.token');
                    console.log(data.auth.token);
                    console.log('vuexObj');
                    console.log(vuexObj);
                    console.log('{ ...vuexObj, ...data }');
                    console.log({ ...vuexObj, ...data });
                    
                    let result = (data.auth.token == null) ? vuexObj : { ...vuexObj, ...data };
                   
                    console.log('result');
                    console.log(result);

                    return result;

                } catch (error) {
                    // is not a valid JSON string
                    console.error("Error retrieving data:", error);
                }
            },
            setItem: async (key, value) => {

                try {
                    const keys = {};
                    const modules = JSON.parse(value);

                    for (const mkey in modules) {
                        const module = modules[mkey];

                        keys[mkey] = [];

                        for (const skey in module) {
                            await localforage.setItem(`vuex_${window.mybizna_uniqid}_${mkey}_${skey}`, module[skey]);
                            keys[mkey].push(skey);
                        }
                    }

                    await localforage.setItem(`${key}_${window.mybizna_uniqid}_data`, keys);
                } catch (error) {
                    console.error("Error setting data:", error);
                }
            },
            removeItem: async (key) => {
                try {
                    const modules = await localforage.getItem(`${key}_${window.mybizna_uniqid}_data`);

                    for (const mkey in modules) {
                        const module = modules[mkey];
                        for (const skey in module) {
                            await localforage.removeItem(`vuex_${window.mybizna_uniqid}_${mkey}_${skey}`);
                        }
                    }
                } catch (error) {
                    console.error("Error removing data:", error);
                }
            }
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

    if (to.path.includes('/admin/')) {
        var path_parts = to.path.split('/admin/');
        var subpath_parts = path_parts[1].split('/');

        store.commit("system/subtitle", subpath_parts[0].replace('_', ' '));
    }

    if (from.path != to.path) {
        store.commit('system/loading', true);
        store.commit('system/is_list', false);
        store.commit('system/is_edit', false);
        store.commit('system/has_search', false);
        store.commit('system/search_fields', []);
        store.commit('system/search_path_params', []);
    }

    if (window.innerWidth < window.responsive_point) {
        store.commit("system/sidebar_show", false);
    }

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
    store.commit('system/loading', false);
    NProgress.done();
});



app.component('Datepicker', Datepicker);
app.component('calendar', Calendar);
app.component('th-render', ThRender);
app.component('positions', Positions);
app.component('td-render', TdRender);
app.component('image-link', ImageLink);
app.component('pagination', Pagination);
app.component('menu-dropdown', MenuDropdown);
app.component('search-form', SearchForm);
app.component('edit-render', EditRender);
app.component('table-render', TableRender);
app.component('btn-status', BtnStatus);
app.component('apexchart', VueApexCharts);

(async () => {

    await autorouter(router);

    app.config.globalProperties.$router = window.$router = router;

    app.use(router);

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx  Mount App  xxxxxxxxxxxxxxxxxxxxxxxxxxxx
    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    app.mount('#app');

})();
