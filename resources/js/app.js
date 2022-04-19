import {
    createApp
} from 'vue';
import BootstrapVue3 from 'bootstrap-vue-3';
import App from '@/components/App';
import vuetify from './plugins/vuetify';
import {
    loadFonts
} from './plugins/webfontloader';

import {
    createStore
} from 'vuex';

import VueFormGenerator from "vue-form-generator";
import VueMoment from 'vue-moment';
import moment from 'moment-timezone';

import Cookies from "js-cookie";
import createPersistedState from "vuex-persistedstate";
import NProgress from 'nprogress';

import Axios from 'axios';

import 'vue-form-generator/dist/vfg.css';
import 'nprogress/nprogress.css';
import 'material-design-icons-iconfont/dist/material-design-icons.css';

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue-3/dist/bootstrap-vue-3.css';

import "vuetify/dist/vuetify.min.css";

const app = createApp(App)
    .use(vuetify)
    .use(BootstrapVue3);

let base_url = window.base_url + '/api';
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxx  App Initializer xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

app.config.globalProperties.$base_url = base_url;
app.config.globalProperties.$male_default_avatar = 'images/avatar.png';
app.config.globalProperties.$female_default_avatar = 'images/avatar2.png';

app.config.globalProperties.$appName = window.appName = 'My App';

app.config.globalProperties.$is_frontend = window.is_frontend = false;
app.config.globalProperties.$is_stockist = window.is_stockist = false;
app.config.globalProperties.$is_backend = window.is_backend = true;

app.config.globalProperties.$in_progress = window.in_progress = true;
app.config.globalProperties.$loading = window.loading = {
    in_progress: true
};

app.config.globalProperties.$loader_template = window.loader_template = '<div class="block-screen"><b>Please wait...</b></div>';

Axios.defaults.baseURL = base_url;


//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxx  Axios Loader xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

Axios.defaults.baseURL = base_url;


Axios.defaults.timeout = 10000;
Axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';

// Add a request interceptor
Axios.interceptors.request.use(function (config) {

    app.config.globalProperties.$loading = {
        in_progress: true
    }

    // Do something before request is sent
    NProgress.start();
    return config;
}, function (error) {

    app.config.globalProperties.$loading = {
        in_progress: false
    }

    // Do something with request error
    console.error(error);
    return Promise.reject(error);
});

// Add a response interceptor
Axios.interceptors.response.use(function (response) {

    app.config.globalProperties.$loading = {
        in_progress: false
    };

    if (Object.prototype.hasOwnProperty.call(response.data, 'errors') && response.data.errors[0].message == "Signature has expired") {
        store.commit('auth/logout');
    }

    // Do something with response data
    NProgress.done();
    return response;
}, function (error) {

    app.config.globalProperties.$loading = {
        in_progress: false
    };

    // Do something with response error
    console.error(error);
    return Promise.reject(error);
});

app.config.globalProperties.$http = app.config.globalProperties.$axios = window.axios = Axios;



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
})

app.use(store);


import './apps';

//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx  Ruotes  xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

import initrouter from '@/components/router';

let router = initrouter(app);

app.use(router);

//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx  Mount App  xxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

loadFonts();

app.use(VueFormGenerator);
app.use(VueMoment, {
    moment,
});


app.mount('#app');
