
import paths from "./paths";

import * as VueRouter from "vue-router";

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

export default router;

