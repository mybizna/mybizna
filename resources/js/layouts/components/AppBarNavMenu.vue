<template>
    <div style="margin-top: 36px">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="row">
                <div class="col-6 col-md-8">
                    <div class="d-block d-md-none mt-1 mx-1">
                        <button class="btn btn-outline-primary" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <v-icon size="12" icon="fas fa-list"></v-icon>
                            Menu List
                        </button>
                        <div class="dropdown-menu dropdown-menu-end mobile-dropdown search-dropdown p-2 shadow-lg">
                            <ul class="list-group list-group-flush">
                                <li v-for="(item, index) in $store.state.system
                                    .menu[$store.state.system.active_menu][
                                    'menus'
                                ]" :key="index" class="list-group-item text-black">
                                    <a :href="'#' + item.path">
                                        {{ item.title }}
                                    </a>
                                    <ul v-if="item.list.length" class="list-group bg-light">
                                        <li v-for="(
                                                subitem, index
                                            ) in item.list" :key="index" class="list-group-item">
                                            <a class="dropdown-item text-black" :href="'#' + subitem.path">{{
                                                    subitem.title
                                            }}</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div id="navbarSupportedContent" class="d-none d-md-block">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li v-for="(item, index) in $store.state.system
                                .menu[$store.state.system.active_menu][
                                'menus'
                            ]" :key="index" class="nav-item dropdown">
                                <a v-if="item.list.length" class="nav-link dropdown-toggle text-black"  href="#"
                                    id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                    {{ item.title }}
                                </a>
                                <a v-else class="nav-link text-black" :href="'#' + item.path"
                                    id="navbarDropdown`${index}`" role="button">
                                    {{ item.title }}
                                </a>
                                <ul v-if="item.list.length" class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <template v-for="(subitem, index) in item.list" :key="index">
                                    <li v-if="subitem.title !== ''" class="dropdown-item text-black">
                                        <a :href="'#' + subitem.path">{{ subitem.title
                                        }}</a>
                                    </li>
                                    <div v-else class="dropdown-divider"></div>
                                    </template>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <search-form></search-form>
                </div>
            </div>
        </nav>
    </div>
</template>

<script>

import { useStore } from "vuex";
import SearchForm from "@/components/common/SearchForm.vue";

export default {
    components: {
        SearchForm,
    },
    setup () {
        const store = useStore();

        if (!store.state.system.has_menu) {
            store.dispatch("system/getMenu");
        }
    },
    mounted () {
        console.log(window.$store.state.system.search);
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
