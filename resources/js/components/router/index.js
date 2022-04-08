import Vue from 'vue';
import * as VueRouter from 'vue-router';
import paths from './paths';
import 'nprogress/nprogress.css';


//Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = VueRouter.createRouter({
    // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
    base: '/',
    history: VueRouter.createWebHashHistory(),
    meta: {
        breadcrumb: true,
        middlewareAuth: true
    },
    linkActiveClass: 'active',
    transitionOnLoad: true,
    routes: paths
})


export default router;
