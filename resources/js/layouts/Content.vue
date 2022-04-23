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
                            <div>
                                <div class="input-group input-group-sm mt-1">
                                    <input
                                        type="text"
                                        class="form-control"
                                        aria-label="Text input with dropdown button"
                                    />
                                    <button
                                        class="btn btn-outline-secondary dropdown-toggle"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                    >
                                        <v-icon
                                            size="12"
                                            icon="fas fa-search"
                                        ></v-icon>
                                        Search
                                    </button>
                                    <div
                                        class="dropdown-menu dropdown-menu-end"
                                    >
                                        <div class="px-4 py-3">
                                            <div class="form-group">
                                                <label
                                                    for="exampleDropdownFormEmail1"
                                                    >Email address</label
                                                >
                                                <input
                                                    type="email"
                                                    class="form-control"
                                                    id="exampleDropdownFormEmail1"
                                                    placeholder="email@example.com"
                                                />
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    for="exampleDropdownFormPassword1"
                                                    >Password</label
                                                >
                                                <input
                                                    type="password"
                                                    class="form-control"
                                                    id="exampleDropdownFormPassword1"
                                                    placeholder="Password"
                                                />
                                            </div>
                                            <div class="form-check">
                                                <input
                                                    type="checkbox"
                                                    class="form-check-input"
                                                    id="dropdownCheck"
                                                />
                                                <label
                                                    class="form-check-label"
                                                    for="dropdownCheck"
                                                >
                                                    Remember me
                                                </label>
                                            </div>
                                            <button
                                                type="submit"
                                                class="btn btn-primary"
                                            >
                                                Sign in
                                            </button>
                                        </div>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#"
                                            >New around here? Sign up</a
                                        >
                                        <a class="dropdown-item" href="#"
                                            >Forgot password?</a
                                        >
                                    </div>
                                </div>

                                <a>
                                    <small style="font-size: 12px">
                                        Advanced:Empty
                                    </small>
                                </a>
                            </div>
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
