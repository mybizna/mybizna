import {
    loadModule
} from 'vue3-sfc-loader';

import * as Vue from 'vue';

const options = {
    moduleCache: {
        vue: Vue
    },
    async getFile(url) {

        console.log(url);

        const res = await fetch(url);
        if (!res.ok)
            console.log(res.statusText + ' ' + url);
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

const fetchComponent = (comp_path) => {

    let path_url = window.base_url + '/assets/' + comp_path;

    return  Vue.defineAsyncComponent( () => loadModule(path_url, options) );
}

//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

function path_updater(route) {
    if (route.component == 'router_view') {
        route.component = {
            render(c) {
                return c('router-view');
            }
        };
    } else {
        console.log(route.component);

        route.component = fetchComponent(route.component);
    }

    if (route.hasOwnProperty('children') && route.children.length > 0) {

        route.children.forEach(child => {
            return path_updater(child);

        });
    }

    return route;
}

export default function (router) {

    // Make a request for a user with a given ID
    window.axios.get(window.base_url + '/api/discover_modules');

    // Make a request for a user with a given ID
    window.axios.get(window.base_url + '/api/fetch_routes')
        .then(function (response) {
            // handle success
            console.log(response);

            response.data.routes.forEach(route => {


                var new_routes = path_updater(route);

                router.addRoute(new_routes);

            });
        })
        .catch(function (error) {
            // handle error
            console.log(error);
        });


}
