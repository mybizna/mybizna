<template>
    <template v-if="$store.state.system.loading">
        <!-- backdrop-blur-sm-->
        <div wire:loading
            class="fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-gray-800/[.08] flex flex-col items-center justify-center">
            <div class="fa-3x text-blue-600">
                <i class="fas fa-spinner fa-spin"></i>
            </div>
            <h2 class="text-center text-blue-700 text-xl font-semibold">Loading...</h2>
            <p class="w-1/3 text-center text-blue-600">This may take a few seconds, please don't close this page.</p>
        </div>

    </template>

    <notifications position="top right" />

    <vue3-confirm-dialog></vue3-confirm-dialog>

    <div class="mybizna-app">

        <template v-if="window.viewside=='frontend'">
            <template v-if="$store.getters['auth/loggedIn']">

                <app-topbar :windowWidth="windowWidth"></app-topbar>

                <div class="overflow-x-hidden">
                    <div class="flex">
                        <div class="flex-none">
                            <app-sidebar></app-sidebar>
                        </div>
                        <div class="flex-auto">

                            <app-topbar-actions></app-topbar-actions>

                            <main class="p-0" :style="'width:' + (windowWidth - 10) + 'px'">
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
        </template>



        <footer v-if="$store.getters[' auth/loggedIn']" app inset color="transparent" absolute height="56"
            class="footer mt-auto py-3 bg-light">
            <div class="container">
                <div class="text-muted text-center">
                    <span> &copy; 2022 - 2023
                        <a href="https://mybizna.com" class="text-decoration-none" target="_blank">Mybizna</a></span>
                </div>
            </div>
        </footer>
    </div>
</template>


<script>
import { computed } from "vue";
import { useStore } from "vuex";
import { useRouter } from "@/utils";
import AppSidebar from "@/components/widgets/AppSidebar.vue";
import AppTopbar from "@/components/widgets/AppTopbar.vue";
import AppTopbarActions from "@/components/widgets/AppTopbarActions.vue";

export default {
    components: {
        AppTopbar,
        AppSidebar,
        AppTopbarActions,
    },
    setup() {
        const { route } = useRouter();

        const store = useStore();

        window.$store = store;

        if (window.innerWidth >= window.responsive_point) {
            store.commit("system/sidebar_show", true);
        }

        store.commit("system/active_menu", 'dashboard');
        store.commit("system/active_subs_1", 0);


        const resolveLayout = computed(() => {
            // Handles initial route
            if (route.value.name === null) return null;

            if (route.value.meta.layout === "blank") return "layout-blank";

            return "layout-content";
        });

        return {
            resolveLayout,
        };
    },
    data() {
        return {
            windowWidth: window.innerWidth,
        }
    },
    mounted() {
        var that = this;
        window.$store.commit("system/window_width", this.windowWidth);

        window.onresize = () => {
            that.windowWidth = window.innerWidth;
            window.$store.commit("system/window_width", this.windowWidth);
        }

        window.onload = () => {
            that.windowWidth = window.innerWidth;
            window.$store.commit("system/window_width", this.windowWidth);
        }
    }


};
</script>

<style lang="scss">
header {
    height: 36px !important;
}

/*
header ::v-deep {
    .v-toolbar__content {
        border-bottom: 1px solid #eee !important;
        background: white !important;
        box-shadow: 0px 2px 4px #eee;
    }
}*/

.list-group-flush {
    overflow: scroll;
    height: 80%;
}

.boxed-container {
    max-width: 1440px;
    margin-left: auto;
    margin-right: auto;
}
</style>