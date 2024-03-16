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
        <app-template :windowWidth="windowWidth"></app-template>
    </div>
</template>


<script>

import { computed } from "vue";
import { useStore } from "vuex";
import { useRouter } from "@/utils";
//import AppBackend from "@/components/widgets/AppBackend.vue";
//import AppFrontend from "@/components/widgets/AppFrontend.vue";

export default {
    components: {
        AppTemplate: window.$filters.fetchComponent('templates/default/' + window.template + '/AppTemplate.vue'),
    },
    setup() {
        const { route } = useRouter();

        const store = useStore();

        window.$store = store;

        if (window.innerWidth >= window.responsive_point) {
            store.commit("system/sidebar_show", true);
        }

        store.commit("system/active_menu", 'dashboard');
        store.commit("system/active_subs_1", 'dashboard');


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
            viewSide: window.viewside ?? 'frontend',
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

.vf-floating-wrapper .vf-floating-label {
    background: white;
    padding: 1px;
    display: block;
    margin-left: 10px;
}

.vf-element-info::before {
    background-image: url('data:image/svg+xml,%3csvg viewBox=\'0 0 512 512\' fill=\'currentColor\' xmlns=\'http://www.w3.org/2000/svg\'%3e%3cpath d=\'M256 8C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm0 110c23.196 0 42 18.804 42 42s-18.804 42-42 42-42-18.804-42-42 18.804-42 42-42zm56 254c0 6.627-5.373 12-12 12h-88c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h12v-64h-12c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h64c6.627 0 12 5.373 12 12v100h12c6.627 0 12 5.373 12 12v24z\'%3e%3c/path%3e%3c/svg%3e');
    background-size: cover;
}

.vf-toggle-container {
    width: 35px;
    height: 15px;
}

.vf-toggle-wrapper .vf-toggle-on {
    background: #517ffd;
    border-color: #cad7fb;
}

.vf-toggle-wrapper .vf-toggle-on .vf-toggle-handle-on,
.vf-toggle-wrapper .vf-toggle-off .vf-toggle-handle-off {
    background: white;
    width: 10px;
    height: 10px;
    margin-top: 1px;
}

.vf-toggle-wrapper .vf-toggle-off {
    background: #999999;
    border-color: #eeeeee;
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