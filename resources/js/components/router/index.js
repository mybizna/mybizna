import Vue from 'vue';
import VueRouter from 'vue-router';
import paths from './paths';
import 'nprogress/nprogress.css';


Vue.use(Router);



const router = new VueRouter({

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
