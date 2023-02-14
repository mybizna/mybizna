<template>

    <template v-if="$store.state.system.loading">
        <!-- backdrop-blur-sm-->
        <div wire:loading
            class="fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-gray-800/[.05] flex flex-col items-center justify-center">
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

        <template v-if="$store.getters['auth/loggedIn']">

            <template v-if="$store.state.system.menu_type == 'sidebar'">
                <app-topbar-sidebar :windowWidth="windowWidth"></app-topbar-sidebar>

                <div v-if="windowWidth > 640" class="flex">

                    <div v-if="$store.state.system.sidebar_show"
                        class="flex-none invisible md:visible w-56 bg-gradient-to-r from-indigo-50 to-indigo-100 border-r-2 border-r border-indigo-200">
                        <app-sidebar></app-sidebar>
                    </div>
                    <div class="flex-auto">
                        <!--  v-if="$store.state.system.is_list || $store.state.system.is_edit" -->
                        <app-topbar-actions></app-topbar-actions>
                        <main class="p-0">
                            <div class="app-content-container boxed-container">
                                <router-view></router-view>
                            </div>
                        </main>
                    </div>
                </div>
                <div v-else>
                    <app-topbar-actions></app-topbar-actions>
                    <main class="p-0">
                        <div class="app-content-container boxed-container">
                            <router-view></router-view>
                        </div>
                    </main>
                </div>


            </template>
            <template v-else>
                <app-topbar></app-topbar>
                <app-bar-nav-menu></app-bar-nav-menu>
                <main class="p-0">
                    <div class="app-content-container boxed-container">
                        <router-view></router-view>
                    </div>
                </main>

            </template>


        </template>
        <template v-else>
            <main class="p-0">
                <router-view></router-view>
            </main>
        </template>



        <footer v-if="$store.getters['auth/loggedIn']" app inset color="transparent" absolute height="56"
            class="footer mt-auto py-3 bg-light">
            <div class="container">
                <div class="text-muted text-center">
                    <span>
                        &copy; 2022 - 2023
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
import AppBarNavMenu from "@/components/widgets/AppBarNavMenu.vue";
import AppTopbar from "@/components/widgets/AppTopbar.vue";
import AppSidebar from "@/components/widgets/AppSidebar.vue";
import AppTopbarSidebar from "@/components/widgets/AppTopbarSidebar.vue";
import AppTopbarActions from "@/components/widgets/AppTopbarActions.vue";

export default {
    components: {
        AppBarNavMenu,
        AppTopbar,
        AppTopbarSidebar,
        AppSidebar,
        AppTopbarActions,
    },
    setup() {
        const { route } = useRouter();

        const store = useStore();

        window.$store = store;

        if (window.innerWidth > 640) {
            window.$store.commit("system/sidebar_show", true);
        }

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
    create() {
        alert(window.innerWidth);
    },
    data() {
        return {
            windowWidth: window.innerWidth,
        }
    },
    mounted() {
        window.onresize = () => {
            this.windowWidth = window.innerWidth;
            console.log(this.windowWidth);
        }
    }


};
</script>

<style lang="scss">
body .mybizna-app {
    background: #F0F5F8;
}

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