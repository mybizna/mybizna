<template>


    <div class="mybizna-app">
        <app-topbar></app-topbar>
        <app-bar-nav-menu></app-bar-nav-menu>
        
        <main v-if="$store.getters['auth/loggedIn']" class="p-0">
            <div class="app-content-container boxed-container">
                <router-view></router-view>
            </div>
        </main>
        <main v-else class="p-0">
            <router-view></router-view>
        </main>

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

export default {
    components: {
        AppBarNavMenu,
         AppTopbar,
    },
    setup() {
        const { route } = useRouter();

        const store = useStore();

        window.$store = store;

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