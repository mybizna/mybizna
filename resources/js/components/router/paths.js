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
        path: '/404',
        meta: {
            public: true,
        },
        name: 'NotFound',
        component: () => import(
            /* webpackChunkName: "general-components" */
            /* webpackMode: "lazy" */
            `@/components/pages/NotFound.vue`
        )
    },
    {
        path: '/403',
        meta: {
            public: true,
        },
        name: 'AccessDenied',
        component: () => import(
            /* webpackChunkName: "general-components" */
            /* webpackMode: "lazy" */
            `@/components/pages/Deny.vue`
        )
    },
    {
        path: '/500',
        meta: {
            public: true,
        },
        name: 'ServerError',
        component: () => import(
            /* webpackChunkName: "general-components" */
            /* webpackMode: "lazy" */
            `@/components/pages/Error.vue`
        )
    },
    {
        path: '/login',
        meta: {
            public: true,
        },
        name: 'Login',
        component: () => import(
            /* webpackChunkName: "general-components" */
            /* webpackMode: "lazy" */
            `@/components/pages/Login.vue`
        )
    },

    {
        path: '/autologin',
        meta: {
            public: true,
        },
        name: 'AutoLogin',
        component: () => import(
            /* webpackChunkName: "general-components" */
            /* webpackMode: "lazy" */
            `@/components/pages/AutoLogin.vue`
        )
    },

    {
        path: '/register',
        meta: {
            public: true,
        },
        name: 'Register',
        component: () => import(
            /* webpackChunkName: "general-components" */
            /* webpackMode: "lazy" */
            `@/components/pages/Register.vue`
        )
    },
    {
        path: '/thankyou',
        meta: {
            public: true,
        },
        name: 'ThankYou',
        component: () => import(
            /* webpackChunkName: "general-components" */
            /* webpackMode: "lazy" */
            `@/components/pages/ThankYou.vue`
        )
    },
    {
        path: '/forgotpassword',
        meta: {
            public: true,
        },
        name: 'ForgotPassword',
        component: () => import(
            /* webpackChunkName: "general-components" */
            /* webpackMode: "lazy" */
            `@/components/pages/ForgotPassword.vue`
        )
    },
    {
        path: '/dashboard',
        meta: {
            public: true,
        },
        name: 'dashboard',
        component: () => import(
            /* webpackChunkName: "general-components" */
            /* webpackMode: "lazy" */
            '@/views/dashboard/Dashboard.vue'
        ),
    },
    {
        path: '/typography',
        meta: {
            public: true,
        },
        name: 'typography',
        component: () => import(
            /* webpackChunkName: "general-components" */
            /* webpackMode: "lazy" */
            '@/views/typography/Typography.vue'),
    },
    {
        path: '/icons',
        meta: {
            public: true,
        },
        name: 'icons',
        component: () => import(
            /* webpackChunkName: "general-components" */
            /* webpackMode: "lazy" */
            '@/views/icons/Icons.vue'),
    },
    {
        path: '/cards',
        meta: {
            public: true,
        },
        name: 'cards',
        component: () => import(
            /* webpackChunkName: "general-components" */
            /* webpackMode: "lazy" */
            '@/views/cards/Card.vue'),
    },
    {
        path: '/simple-table',
        meta: {
            public: true,
        },
        name: 'simple-table',
        component: () => import(
            /* webpackChunkName: "general-components" */
            /* webpackMode: "lazy" */
            '@/views/simple-table/SimpleTable.vue'),
    },
    {
        path: '/form-layouts',
        meta: {
            public: true,
        },
        name: 'form-layouts',
        component: () => import(
            /* webpackChunkName: "general-components" */
            /* webpackMode: "lazy" */
            '@/views/form-layouts/FormLayouts.vue'),
    },
    {
        path: '/pages/account-settings',
        meta: {
            public: true,
        },
        name: 'pages-account-settings',
        component: () => import(
            /* webpackChunkName: "general-components" */
            /* webpackMode: "lazy" */
            '@/views/pages/account-settings/AccountSettings.vue'),
    },
    {
        path: '/pages/login',
        meta: {
            public: true,
        },
        name: 'pages-login',
        component: () => import(
            /* webpackChunkName: "general-components" */
            /* webpackMode: "lazy" */
            '@/views/pages/Login.vue'),
        meta: {
            layout: 'blank',
        },
    },
    {
        path: '/pages/register',
        meta: {
            public: true,
        },
        name: 'pages-register',
        component: () => import(

            /* webpackChunkName: "general-components" */
            /* webpackMode: "lazy" */
            '@/views/pages/Register.vue'),
        meta: {
            layout: 'blank',
        },
    },
    {
        path: '/error-404',
        meta: {
            public: true,
        },
        name: 'error-404',
        component: () => import(

            /* webpackChunkName: "general-components" */
            /* webpackMode: "lazy" */
            '@/views/Error.vue'),
        meta: {
            layout: 'blank',
        },
    },

];


//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx



export default paths;
