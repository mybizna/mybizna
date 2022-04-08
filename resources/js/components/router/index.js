import Vue from 'vue';
import Router from 'vue-router';
import paths from './paths';
import 'nprogress/nprogress.css';


Vue.use(Router);

const router = new Router({

    base: '/',
    mode: 'history',
    meta: {
        breadcrumb: true,
        middlewareAuth: true
    },
    linkActiveClass: 'active',
    transitionOnLoad: true,
    routes: paths
});



export default router;
