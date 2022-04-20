import router from '@/components/router';

router.addRoute([{
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
    component: () => import(`@/apps/dashboard/pages/Dashboard.vue`)

}]);
