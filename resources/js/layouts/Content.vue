<template>
    <v-app class="mybizna-app">
        <v-app-bar
            app
            flat
            absolute
            color="indigo darken-4"
            height="44"
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
                    <div class="text-center">
                        <v-menu
                            v-model="menu"
                            :close-on-content-click="false"
                            anchor="start"
                        >
                            <template v-slot:activator="{ props }">
                                <v-btn color="indigo" v-bind="props">
                                    Menu as Popover
                                </v-btn>
                            </template>

                            <v-card min-width="300">
                                <v-list>
                                    <v-list-item
                                        prepend-avatar="https://cdn.vuetifyjs.com/images/john.jpg"
                                        title="John Leider"
                                        subtitle="Founder of Vuetify"
                                    >
                                        <template v-slot:append>
                                            <v-btn
                                                variant="text"
                                                :class="fav ? 'text-red' : ''"
                                                icon="mdi-heart"
                                                @click="fav = !fav"
                                            ></v-btn>
                                        </template>
                                    </v-list-item>
                                </v-list>

                                <v-divider></v-divider>

                                <v-list>
                                    <v-list-item>
                                        <v-switch
                                            v-model="message"
                                            color="purple"
                                            label="Enable messages"
                                            hide-details
                                        ></v-switch>
                                    </v-list-item>

                                    <v-list-item>
                                        <v-switch
                                            v-model="hints"
                                            color="purple"
                                            label="Enable hints"
                                            hide-details
                                        ></v-switch>
                                    </v-list-item>
                                </v-list>

                                <v-card-actions>
                                    <v-spacer></v-spacer>

                                    <v-btn text @click="menu = false">
                                        Cancel
                                    </v-btn>
                                    <v-btn
                                        color="primary"
                                        text
                                        @click="menu = false"
                                    >
                                        Save
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-menu>
                    </div>
                </div>
            </div>
        </v-app-bar>

        <div style="margin-top: 50px">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button
                        class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent"
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                    >
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div
                        class="collapse navbar-collapse"
                        id="navbarSupportedContent"
                    >
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown">
                                <a
                                    class="nav-link dropdown-toggle"
                                    href="#"
                                    id="navbarDropdown"
                                    role="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                >
                                    Payments
                                </a>
                                <ul
                                    class="dropdown-menu"
                                    aria-labelledby="navbarDropdown"
                                >
                                    <li>
                                        <a class="dropdown-item" href="#"
                                            >Action</a
                                        >
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#"
                                            >Another action</a
                                        >
                                    </li>
                                    <li><hr class="dropdown-divider" /></li>
                                    <li>
                                        <a class="dropdown-item" href="#"
                                            >Something else here</a
                                        >
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a
                                    class="nav-link dropdown-toggle"
                                    href="#"
                                    id="navbarDropdown"
                                    role="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                >
                                    Transactions
                                </a>
                                <ul
                                    class="dropdown-menu"
                                    aria-labelledby="navbarDropdown"
                                >
                                    <li>
                                        <a class="dropdown-item" href="#"
                                            >Action</a
                                        >
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#"
                                            >Another action</a
                                        >
                                    </li>
                                    <li><hr class="dropdown-divider" /></li>
                                    <li>
                                        <a class="dropdown-item" href="#"
                                            >Something else here</a
                                        >
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <form class="d-flex">
                            <input
                                class="form-control me-2"
                                type="search"
                                placeholder="Search"
                                aria-label="Search"
                            />
                            <button
                                class="btn btn-outline-success"
                                type="submit"
                            >
                                Search
                            </button>
                        </form>
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
        fav: true,
        menu: false,
        message: false,
        hints: true,
    }),
};
</script>

<style lang="scss" scoped>
.mybizna-app {
    background: #f5f7fb;
}

.theme--light.v-application {
    background: #f4f5fa !important;
}

header,
.v-app-bar {
    height: 50px !important;
}

/*
header ::v-deep {
    .v-toolbar__content {
        border-bottom: 1px solid #eee !important;
        background: white !important;
        box-shadow: 0px 2px 4px #eee;
    }
}*/

.v-app-bar ::v-deep {
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
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    background: white !important;
    ul {
    }
}

.navbar {
    ul {
        li {
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
