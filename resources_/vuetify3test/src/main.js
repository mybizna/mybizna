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


import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue-3/dist/bootstrap-vue-3.css';


import {
  loadModule
} from 'vue3-sfc-loader';


loadFonts();

const app = createApp(App)
  .use(vuetify)
  .use(BootstrapVue3);



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
app.mount('#app');

router.addRoute({
  path: '/h2',
  component: defineAsyncComponent(() => loadModule('https://utupress.github.io/blocks/header2/index.vue', options))
});