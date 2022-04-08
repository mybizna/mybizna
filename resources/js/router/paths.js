export default [

  {
    path: '*',
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


];