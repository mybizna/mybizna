var paths = [
    {
        path: "/:catchAll(.*)",
        meta: {
            public: true,
        },
        redirect: {
            path: "/404",
        },
    },
    {
        path: "/",
        meta: {
            breadcrumb: true,
            middlewareAuth: true,
        },
        name: "Root",
        redirect: {
            name: "manage.dashboard",
        },
    },
    {
        path: "/manage/dashboard",
        meta: {
            breadcrumb: true,
            middlewareAuth: true,
        },
        name: "manage.dashboard",
      
        component: () => import(`@/components/pages/Dashboard.vue`),
    },
    {
        path: "/404",
        meta: {
            public: true,
        },
        name: "NotFound",
        component: () => import(`@/components/pages/NotFound.vue`),
    },
    {
        path: "/403",
        meta: {
            public: true,
        },
        name: "AccessDenied",
        component: () => import(`@/components/pages/Deny.vue`),
    },
    {
        path: "/500",
        meta: {
            public: true,
        },
        name: "ServerError",
        component: () => import(`@/components/pages/Error.vue`),
    },
    {
        path: "/login",
        meta: {
            public: true,
        },
        name: "Login",
        component: () => import(`@/components/pages/Login.vue`),
    },

    {
        path: "/autologin",
        meta: {
            public: true,
        },
        name: "AutoLogin",
        component: () => import(`@/components/pages/AutoLogin.vue`),
    },

    {
        path: "/register",
        meta: {
            public: true,
        },
        name: "Register",
        component: () => import(`@/components/pages/Register.vue`),
    },
    {
        path: "/thankyou",
        meta: {
            public: true,
        },
        name: "ThankYou",
        component: () => import(`@/components/pages/ThankYou.vue`),
    },
    {
        path: "/forgotpassword",
        meta: {
            public: true,
        },
        name: "ForgotPassword",
        component: () => import(`@/components/pages/ForgotPassword.vue`),
    },
];

//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

export default paths;
