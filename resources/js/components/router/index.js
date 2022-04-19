import autorouter from "@/components/router/autorouter";
import paths from "./paths";

import * as VueRouter from "vue-router";

import NProgress from "nprogress";
import "nprogress/nprogress.css";

export default function (app, store) {

    // 3. Create the router instance and pass the `routes` option
    // You can pass in additional options here, but let's
    // keep it simple for now.
    const router = VueRouter.createRouter({
        // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
        history: VueRouter.createWebHashHistory(),
        meta: {
            breadcrumb: true,
            middlewareAuth: true,
        },
        linkActiveClass: "active",
        transitionOnLoad: true,
        routes: paths,
    });

    router.beforeEach((to, from, next) => {
        app.config.globalProperties.$loading = {
            in_progress: true
        }

        NProgress.start();

        if (to.meta.middlewareAuth) {
            if (!store.getters["auth/loggedIn"]) {
                next({
                    path: "/login",
                    query: {
                        redirect: to.fullPath,
                    },
                });

                return;
            }
        }

        if (to.matched.some((record) => record.meta.middlewareAuth)) {
            if (!store.getters["auth/loggedIn"]) {
                next({
                    path: "/login",
                    query: {
                        redirect: to.fullPath,
                    },
                });

                return;
            }
        }

        next();
    });

    router.afterEach((to, from) => {
        // ...
        app.config.globalProperties.$loading = {
            in_progress: false
        }
        NProgress.done();
    });

    autorouter(router);

    return router;
}
