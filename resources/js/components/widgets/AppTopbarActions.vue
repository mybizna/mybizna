<template>
    <div v-if="$store.state.system.is_list" class="shadow-sm z-8">
        <div class="flex h-14 px-1">
            <div class="flex-auto">
                <div class="mx-1">
                    <span class="whitespace-nowrap truncate" v-if="$store.state.system.subtitle != ''">
                        {{ $store.state.system.subtitle }}
                        <small class="text-sm" v-if="$store.state.system.subtitle_action != ''">
                            - {{ $store.state.system.subtitle_action }}
                        </small>
                    </span><br>
                    <a class="uppercase cursor-point whitespace-nowrap text-white rounded bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium text-sm  py-2 px-3  text-center"
                        @click="addLink()">
                        <i class="fa fa-plus"></i>
                        Create
                    </a>
                </div>
            </div>
            <div class="flex-auto">
                <search-form></search-form>
            </div>
        </div>
    </div>
</template>

<script>

import { useStore } from "vuex";
import SearchForm from "@/components/common/SearchForm";

export default {
    components: {
        SearchForm
    },
    setup() {
        const store = useStore();

        if (!store.state.system.menu.length) {
            store.dispatch("system/getMenu");
        }

        if (!store.state.system.positions.length) {
            store.dispatch("system/getPositions");
        }
    },
    mounted() {
    },

    methods: {
        addLink: function () {
            var t = this;

            window.$router.push({
                name: t.$store.state.system.path_params.dotted + ".create",
            });

        },
    },
    data: () => ({}),
};
</script>

<style lang="scss">
.navbar {
    display: block !important;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    background: white !important;
    z-index: 1000;

    @media (min-width: 160px) and (min-width: 768px) {}

    .formkit-wrapper label {
        font-size: 14px;
    }

    .formkit-outer {
        margin-bottom: 0 !important;
    }

    .formkit-messages {
        margin-bottom: 0;
        margin-left: 0;
        list-style-type: none;
        padding: 0;

        .formkit-message {
            font-size: 12px !important;
        }
    }

    .mobile-dropdown {
        overflow: scroll;
        height: 100%;
    }

    .search-dropdown {
        width: 98%;
        position: fixed;
        top: 70px !important;
        margin: 5px;
    }

    ul {
        li.nav-item {
            padding-top: 7px !important;
            padding-bottom: 7px !important;
            border-right: 1px dotted #eee !important;
        }
    }
}
</style>
