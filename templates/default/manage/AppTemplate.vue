<template>
    <template v-if="$store.getters['auth/loggedIn']">

        <app-topbar :windowWidth="windowWidth"></app-topbar>

        <div class="overflow-x-hidden">
            <div class="flex">
                <div class="flex-none">
                    <app-sidebar></app-sidebar>
                </div>
                <div class="flex-auto">

                    <app-topbar-actions></app-topbar-actions>

                    <main class="p-0">
                        <div class="app-content-container boxed-container">
                            <router-view :key="$route.fullPath"></router-view>
                        </div>
                    </main>
                </div>
            </div>
        </div>

    </template>
    <template v-else>
        <div class="overflow-x-hidden">
            <main class="p-0">
                <router-view :key="$route.fullPath"></router-view>
            </main>
        </div>
    </template>

    <footer v-if="$store.getters[' auth/loggedIn']" app inset color="transparent" absolute height="56"
        class="footer mt-auto py-3 bg-light">
        <div class="container">
            <div class="text-muted text-center">
                <span> &copy; 2022 - {{ currentYear }}
                    <a href="https://mybizna.com" class="text-decoration-none" target="_blank">Mybizna</a></span>
            </div>
        </div>
    </footer>
</template>

<script>


export default {
    components: {
        AppSidebar: window.$filters.fetchComponent('templates/default/manage/AppSidebar.vue'),
        AppTopbar: window.$filters.fetchComponent('templates/default/manage/AppTopbar.vue'),
        AppTopbarActions: window.$filters.fetchComponent('templates/default/manage/AppTopbarActions.vue'),
    },
    props: {
        windowWidth: { type: Number, default: window.innerWidth },
        windowHeight: { type: Number, default: window.innerHeight },
    },
    data() {
        return {
            currentYear: new Date().getFullYear(),
        };
    },
};
</script>
