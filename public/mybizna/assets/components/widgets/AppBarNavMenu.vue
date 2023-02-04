<template>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm z-10">
        <div class="flex">
            <div class="flex-auto">
                <div class="d-block d-md-none mt-1 mx-1">
                    <button class="btn btn-outline-primary" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-list"></i>
                        Menu List
                    </button>
                    <div class="dropdown-menu dropdown-menu-start mobile-dropdown search-dropdown p-2 shadow-lg">

                        <div>
                            <div class="text-sm pb-1 border-b border-b-indigo-100">Main</div>

                            <template
                                v-for="(item, index) in $store.state.system.menu[$store.state.system.active_menu]['menus']"
                                :key="index">

                                <div v-if="!item.list.length"
                                    class="inline-block m-2 px-2 py-2.5 text-sm font-medium text-center text-white bg-blue-500 rounded hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    <a :href="'#' + item.path">
                                        {{ item.title }}
                                    </a>
                                </div>
                            </template>

                        </div>

                        <template
                            v-for="(item, index) in $store.state.system.menu[$store.state.system.active_menu]['menus']"
                            :key="index">

                            <div v-if="item.list.length" class="list-group-item">
                                <div class="text-sm pb-1 border-b border-b-indigo-100">{{ item.title }}</div>

                                <template v-for="(subitem, index) in item.list" :key="index">
                                    <div v-if="subitem.title !== ''"
                                        class="inline-block m-2 px-2 py-2.5 text-sm font-medium text-center text-white bg-blue-500 rounded hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                        <a :href="'#' + subitem.path">
                                            {{ subitem.title }}
                                        </a>
                                    </div>
                                </template>

                            </div>

                        </template>

                        <div class="clear-both" style="margin-bottom:50px;"></div>

                    </div>
                </div>
                <div id="navbarSupportedContent" class="d-none d-md-block">
                    <ul v-if="$store.state.system.active_menu && $store.state.system.menu[$store.state.system.active_menu]"
                        class="navbar-nav me-auto mb-0 mb-lg-0">
                        <li v-for="(item, index) in $store.state.system
                            .menu[$store.state.system.active_menu][
                            'menus'
                        ]" :key="index" class="nav-item dropdown">
                            <a v-if="item.list.length" class="nav-link dropdown-toggle text-black" href="#"
                                id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                {{ item.title }}
                            </a>
                            <a v-else class="nav-link text-black" :href="'#' + item.path" id="navbarDropdown`${index}`"
                                role="button">
                                {{ item.title }}
                            </a>
                            <ul v-if="item.list.length" class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <template v-for="(subitem, index) in item.list" :key="index">
                                    <li v-if="subitem.title !== ''" class="dropdown-item text-black">
                                        <a :href="'#' + subitem.path">{{
                                            subitem.title
                                        }}</a>
                                    </li>
                                    <div v-else class="dropdown-divider"></div>
                                </template>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="flex-auto">
                <search-form></search-form>
            </div>
        </div>
    </nav>
</template>

<script>

import { useStore } from "vuex";

export default {
    components: {
        SearchForm: window.$func.fetchComponent(
            "components/common/SearchForm.vue"
        ),
    },
    setup() {
        const store = useStore();

        if (!store.state.system.has_menu) {
            store.dispatch("system/getMenu");
        }
    },
    mounted() {
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
