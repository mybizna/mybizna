var paths = [

    {
        path: '/:catchAll(.*)',
        meta: {
            public: true,
        },
        redirect: {
            path: '/404'
        }
    },
    {
        path: '/',
        meta: {
            breadcrumb: true,
        },
        name: 'Root',
        component: () => import('@/views/dashboard/Dashboard.vue'),
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
        component: () => import('@/views/dashboard/Dashboard.vue')

    },
    {
        path: '/dashboard',
        meta: {
            public: true,
        },
        name: 'dashboard',
        component: () => import('@/views/dashboard/Dashboard.vue'),
    },
    {
        path: '/404',
        meta: {
            public: true,
        },
        name: 'NotFound',
        component: () => import(`@/components/pages/NotFound.vue`)
    },
    {
        path: '/403',
        meta: {
            public: true,
        },
        name: 'AccessDenied',
        component: () => import(`@/components/pages/Deny.vue`)
    },
    {
        path: '/500',
        meta: {
            public: true,
        },
        name: 'ServerError',
        component: () => import(`@/components/pages/Error.vue`)
    },
    {
        path: '/login',
        meta: {
            public: true,
        },
        name: 'Login',
        component: () => import(`@/components/pages/Login.vue`)
    },

    {
        path: '/autologin',
        meta: {
            public: true,
        },
        name: 'AutoLogin',
        component: () => import(`@/components/pages/AutoLogin.vue`)
    },

    {
        path: '/register',
        meta: {
            public: true,
        },
        name: 'Register',
        component: () => import(`@/components/pages/Register.vue`)
    },
    {
        path: '/thankyou',
        meta: {
            public: true,
        },
        name: 'ThankYou',
        component: () => import(`@/components/pages/ThankYou.vue`)
    },
    {
        path: '/forgotpassword',
        meta: {
            public: true,
        },
        name: 'ForgotPassword',
        component: () => import(`@/components/pages/ForgotPassword.vue`)
    },

    {
        path: '/typography',
        meta: {
            public: true,
        },
        name: 'typography',
        component: () => import('@/views/typography/Typography.vue'),
    },
    {
        path: '/icons',
        meta: {
            public: true,
        },
        name: 'icons',
        component: () => import('@/views/icons/Icons.vue'),
    },
    {
        path: '/cards',
        meta: {
            public: true,
        },
        name: 'cards',
        component: () => import('@/views/cards/Card.vue'),
    },
    {
        path: '/simple-table',
        meta: {
            public: true,
        },
        name: 'simple-table',
        component: () => import('@/views/simple-table/SimpleTable.vue'),
    },
    {
        path: '/form-layouts',
        meta: {
            public: true,
        },
        name: 'form-layouts',
        component: () => import('@/views/form-layouts/FormLayouts.vue'),
    },
    {
        path: '/pages/account-settings',
        meta: {
            public: true,
        },
        name: 'pages-account-settings',
        component: () => import('@/views/pages/account-settings/AccountSettings.vue'),
    },
    {
        path: '/pages/login',
        meta: {
            public: true,
            layout: 'blank',
        },
        name: 'pages-login',
        component: () => import('@/views/pages/Login.vue'),
    },
    {
        path: '/pages/register',
        meta: {
            public: true,
            layout: 'blank',
        },
        name: 'pages-register',
        component: () => import('@/views/pages/Register.vue'),
    },
    {
        path: '/error-404',
        meta: {
            public: true,
            layout: 'blank',
        },
        name: 'error-404',
        component: () => import('@/views/Error.vue'),
    },

];


//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx



export default paths;
