// import {
//     loadModule
// } from 'vue3-sfc-loader';

import * as Vue from 'vue';

import filters from "@/utils/filters";

const { loadModule } = window['vue3-sfc-loader'];

window.$filters = filters;
window.$func = filters;
window.$methods = filters;


const options = {
    moduleCache: {
        vue: Vue
    },
    async getFile(url) {
        const res = await fetch(url)
        if (!res.ok)
            throw Object.assign(new Error(`${res.statusText} ${url}`), { res })
        return await res.text();
    },
    addStyle(textContent) {
        const style = Object.assign(document.createElement("style"), { textContent })
        const ref = document.head.getElementsByTagName("style")[0] || null
        document.head.insertBefore(style, ref)
    },
}

const fetchComponent = (comp_path) => {
    let path_url = window.base_url + '/fetch_vue/' + comp_path;

    try {
        return Vue.defineAsyncComponent(() => loadModule(path_url, options));
    } catch (error) {
        throw new Error(`Error raised on file ${comp_path}`);
    }

}

export default fetchComponent;
