/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vuetify from 'vuetify';
import router from './router';
import store from './store/store';

require('./bootstrap');

window.Vue = require('vue').default;
window.Vue.use(Vuetify);


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const {
    loadModule
} = window['vue3-sfc-loader'];


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


    log(type, ...args) {

        console[type](...args);
    },

    compiledCache: {
        set(key, str) {

            // naive storage space management
            for (;;) {

                try {

                    // doc: https://developer.mozilla.org/en-US/docs/Web/API/Storage
                    window.localStorage.setItem(key, str);
                    break;
                } catch (ex) {

                    // handle: Uncaught DOMException: Failed to execute 'setItem' on 'Storage': Setting the value of 'XXX' exceeded the quota

                    window.localStorage.removeItem(window.localStorage.key(0));
                }
            }
        },
        get(key) {

            return window.localStorage.getItem(key);
        },
    },

    handleModule(type, source, path, options) {

        if (type === '.json')
            return JSON.parse(source);
    }

}

const fetchComponent = (tag_name) => {
    return Vue.defineAsyncComponent(() => loadModule('https://utupress.github.io/blocks/' + tag_name + '/index.vue', options));
}

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    store
});
