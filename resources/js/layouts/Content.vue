<template>
    <v-app class="mybizna-app">
        <v-app-bar
            app
            flat
            absolute
            color="indigo darken-4"
            height="36px"
            class="p-0"
        >
            <div class="boxed-container w-100 p-0">
                <div class="d-flex align-center mx-6">
                    <!-- Left Content -->

                    <app-bar-applist-menu></app-bar-applist-menu>

                    <v-spacer></v-spacer>

                    <v-app-bar-title class="text-center">
                        Accounting
                    </v-app-bar-title>

                    <v-spacer></v-spacer>

                    <app-bar-user-menu></app-bar-user-menu>
                </div>
            </div>
        </v-app-bar>

        <div style="margin-top: 36px">
            <nav class="navbar navbar-expand-md navbar-light bg-white">
                <div class="row">
                    <div class="col-6 col-md-8">
                        <div class="d-block d-md-none mt-1 mx-1">
                            <button
                                class="btn btn-outline-primary"
                                type="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                <v-icon size="12" icon="fas fa-list"></v-icon>
                                Menu List
                            </button>
                            <div
                                class="dropdown-menu dropdown-menu-end mobile-dropdown p-2"
                            >
                                <ul class="list-group list-group-flush">
                                    <li
                                        v-for="(item, index) in menus"
                                        :key="index"
                                        class="list-group-item bg-light"
                                    >
                                        <a href="#">
                                            {{ item.title }}
                                        </a>
                                        <ul class="list-group-item">
                                            <li
                                                v-for="(item, index) in menus"
                                                :key="index"
                                            >
                                                <a
                                                    class="dropdown-item"
                                                    href="#"
                                                    >{{ item.title }}</a
                                                >
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div
                            id="navbarSupportedContent"
                            class="d-none d-md-block"
                        >
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li
                                    v-for="(item, index) in menus"
                                    :key="index"
                                    class="nav-item dropdown"
                                >
                                    <a
                                        class="nav-link dropdown-toggle"
                                        href="#"
                                        id="navbarDropdown"
                                        role="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                    >
                                        {{ item.title }}
                                    </a>
                                    <ul
                                        class="dropdown-menu"
                                        aria-labelledby="navbarDropdown"
                                    >
                                        <li
                                            v-for="(item, index) in menus"
                                            :key="index"
                                        >
                                            <a class="dropdown-item" href="#">{{
                                                item.title
                                            }}</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="d-none d-md-block mt-1 mx-1">
                            <div class="input-group input-group-sm">
                                <input
                                    type="text"
                                    class="form-control"
                                    aria-label="Text input with dropdown button"
                                />
                                <button
                                    class="btn btn-outline-primary"
                                    type="button"
                                    aria-expanded="false"
                                >
                                    <v-icon
                                        size="12"
                                        icon="fas fa-search"
                                    ></v-icon>
                                    Search
                                </button>
                                <button
                                    class="btn btn-outline-primary dropdown-toggle"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                ></button>
                                <div
                                    class="dropdown-menu dropdown-menu-end mobile-dropdown p-2"
                                >
                                    <b>Search</b>
                                    <div class="row">
                                        <div
                                            v-for="(item, index) in searchform"
                                            :key="index"
                                            class="col-sm-6 col-md-4 col-lg-2"
                                        >
                                            <div class="form-group">
                                                <b>
                                                    <small
                                                        style="font-size: 12px"
                                                    >
                                                        {{ item.label }}
                                                    </small>
                                                </b>
                                                <input
                                                    :id="item.name"
                                                    :placeholder="
                                                        item.placeholder
                                                    "
                                                    type="text"
                                                    class="form-control form-control-sm"
                                                />
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-2">
                                            <b> &nbsp; </b>
                                            <div class="text-center">
                                                <button
                                                    type="submit"
                                                    class="btn btn-primary btn-sm"
                                                >
                                                    Reset
                                                </button>
                                                &nbsp;&nbsp;
                                                <button
                                                    type="submit"
                                                    class="btn btn-success btn-sm"
                                                >
                                                    Search
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a>
                                <small style="font-size: 12px">
                                    Advanced:Empty
                                </small>
                            </a>
                        </div>
                        <div class="d-block d-md-none mt-1 mx-1 text-right">
                            <button
                                class="btn btn-outline-primary"
                                type="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                <v-icon size="12" icon="fas fa-search"></v-icon>
                                Search
                            </button>
                            <div
                                class="dropdown-menu dropdown-menu-end mobile-dropdown p-2"
                            >
                                <b>Search</b>
                                <div class="row">
                                    <div
                                        v-for="(item, index) in searchform"
                                        :key="index"
                                        class="col-sm-6 col-md-4 col-lg-2"
                                    >
                                        <div class="form-group">
                                            <b>
                                                <small style="font-size: 12px">
                                                    {{ item.label }}
                                                </small>
                                            </b>
                                            <input
                                                :id="item.name"
                                                :placeholder="item.placeholder"
                                                type="text"
                                                class="form-control form-control-sm"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 col-lg-2">
                                        <b> &nbsp; </b>
                                        <div class="text-center">
                                            <button
                                                type="submit"
                                                class="btn btn-primary btn-sm"
                                            >
                                                Reset
                                            </button>
                                            &nbsp;&nbsp;
                                            <button
                                                type="submit"
                                                class="btn btn-success btn-sm"
                                            >
                                                Search
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <a>
                                    <small style="font-size: 12px">
                                        Advanced:Empty
                                    </small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        <v-main>
            <div class="app-content-container boxed-container">
                <slot></slot>
            </div>
        </v-main>

        <v-footer
            app
            inset
            color="transparent"
            absolute
            height="56"
            class="px-0"
        >
            <div class="boxed-container w-full">
                <div class="mx-6 d-flex justify-space-between">
                    <span>
                        &copy; 2021
                        <a
                            href="https://mybizna.com"
                            class="text-decoration-none"
                            target="_blank"
                            >Mybizna</a
                        ></span
                    >
                </div>
            </div>
        </v-footer>
    </v-app>
</template>

<script>
import { ref } from "vue";
import AppBarUserMenu from "@/layouts/components/AppBarUserMenu.vue";
import AppBarApplistMenu from "@/layouts/components/AppBarApplistMenu.vue";

export default {
    components: {
        AppBarUserMenu,
        AppBarApplistMenu,
    },
    setup() {
        const isDrawerOpen = ref(null);

        return {
            isDrawerOpen,
        };
    },
    data: () => ({
        searchform: [
            {
                name: "title",
                label: "Title",
                value: "Title",
                placeholder: "Title",
            },
            {
                name: "name",
                label: "Name",
                value: "Name",
                placeholder: "Title",
            },
            {
                name: "gender",
                label: "Gender",
                value: "Gender",
                placeholder: "Title",
            },
            {
                name: "country",
                label: "Country",
                value: "Country",
                placeholder: "Title",
            },
        ],
        menus: [
            {
                title: "Payment",
                children: [
                    { title: "Action" },
                    { title: "Action" },
                    { title: "Action" },
                    { title: "Action" },
                ],
            },
            {
                title: "Invoice",
                children: [
                    { title: "Action" },
                    { title: "Action" },
                    { title: "Action" },
                    { title: "Action" },
                ],
            },
            {
                title: "Transaction",
                children: [
                    { title: "Action" },
                    { title: "Action" },
                    { title: "Action" },
                    { title: "Action" },
                ],
            },
        ],
        ex4: [
            "red",
            "indigo",
            "orange",
            "primary",
            "secondary",
            "success",
            "info",
            "warning",
            "error",
            "red darken-3",
            "indigo darken-3",
            "orange darken-3",
        ],

        fav: true,
        menu: false,
        message: false,
        hints: true,
    }),
};
</script>

<style lang="scss">
.mybizna-app {
    background: #f5f7fb;
}

.theme--light.v-application {
    background: #f4f5fa !important;
}

.v-toolbar--density-default {
    .v-toolbar__content {
        padding-top: 0 !important;
        padding-bottom: 0 !important;
    }
}

header,
.v-app-bar {
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
    height: 100%;
}

.v-toolbar {
    overflow: visible;
    .dropdown-toggle:after {
        content: none;
    }
}

.v-app-bar {
    .dropdown-toggle:after {
        content: none;
    }
    .v-toolbar__content {
        padding: 0;
        .app-bar-search {
            .v-input__slot {
                padding-left: 18px;
            }
        }
    }
}

.v-main {
    padding: 15px 10px !important;
}

.navbar {
    display: block !important;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    background: white !important;
    @media (min-width: 160px) and (min-width: 768px) {
    }

    .mobile-dropdown {
        overflow: scroll;
        height: 100%;
    }
    .dropdown-menu {
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

.boxed-container {
    max-width: 1440px;
    margin-left: auto;
    margin-right: auto;
}
</style>
