import router from '@/components/router'

router.addRoutes([{
    path: '/',
    meta: {
        breadcrumb: true,
    },
    name: 'Root',
    redirect: {
        name: 'manage.dashboard'
    }
}, {
    path: '/manage/dashboard',
    meta: {
        breadcrumb: true,
        middlewareAuth: true
    },
    name: 'manage.dashboard',
    component: () => import(
        /* webpackChunkName: "backend-dashboard" */
        /* webpackMode: "lazy" */
        `@/apps/dashboard/pages/Dashboard.vue`
    )

}]);
