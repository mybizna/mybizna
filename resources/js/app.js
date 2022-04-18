import * as Vue from 'vue';
import {
    createApp,
    defineAsyncComponent
} from 'vue';
import BootstrapVue3 from 'bootstrap-vue-3';
import * as VueRouter from 'vue-router';
import App from './App.vue';
import vuetify from './plugins/vuetify';
import {
    loadFonts
} from './plugins/webfontloader';

import {
    createStore
} from 'vuex';

import Cookies from "js-cookie";
import createPersistedState from "vuex-persistedstate";

import Axios from 'axios';




import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue-3/dist/bootstrap-vue-3.css';


const app = createApp(App)
    .use(vuetify)
    .use(BootstrapVue3);

    let base_url = window.base_url + '/api';

//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxx  Axios Loader xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

Axios.defaults.baseURL = base_url;


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

//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxx  Components Loader  xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

import {
    loadModule
} from 'vue3-sfc-loader';


loadFonts();



const options = {
    moduleCache: {
        vue: Vue
    },
    async getFile(url) {

        const res = await fetch(url);
        if (!res.ok)
            throw Object.assign(new Error(res.statusText + ' ' + url), {
                res
            });
        return {
            getContentData: asBinary => asBinary ? res.arrayBuffer() : res.text(),
        }
    },
    addStyle(textContent) {

        const style = Object.assign(document.createElement('style'), {
            textContent
        });
        const ref = document.head.getElementsByTagName('style')[0] || null;
        document.head.insertBefore(style, ref);
    },
}


const Home = {
    template: '<div>Home</div>'
};
const About = {
    template: '<div>About</div>'
};

//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx  Ruotes  xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

// 2. Define some routes
// Each route should map to a component.
// We'll talk about nested routes later.
const routes = [{
        path: '/',
        component: Home
    },
    {
        path: '/about',
        component: About
    },
    {
        path: '/h1',
        component: defineAsyncComponent(() => loadModule('https://utupress.github.io/blocks/header1/index.vue', options))
    }
]

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = VueRouter.createRouter({
    // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
    history: VueRouter.createWebHashHistory(),
    routes, // short for `routes: routes`
});

app.use(router);

//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx  Mount App  xxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

app.mount('#app');
