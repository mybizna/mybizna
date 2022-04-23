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
                                        class="btn btn-success dropdown-toggle"
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
                                        class="dropdown-menu dropdown-menu-end p-2"
                                    >
                                        <div>
                                            <div>
                                                <span
                                                    class="form-check form-check-inline p-0 mr-1"
                                                >
                                                    <input
                                                        class="form-check-input ml-0"
                                                        type="checkbox"
                                                        id="inlineCheckbox1"
                                                        value="option1"
                                                    />
                                                    <label
                                                        class="form-check-label"
                                                        for="inlineCheckbox1"
                                                    >
                                                        <small
                                                            style="
                                                                font-size: 12px;
                                                            "
                                                            >Name</small
                                                        >
                                                    </label>
                                                </span>
                                                <span
                                                    class="form-check form-check-inline p-0 mr-1"
                                                >
                                                    <input
                                                        class="form-check-input ml-0"
                                                        type="checkbox"
                                                        id="inlineCheckbox2"
                                                        value="option2"
                                                    />
                                                    <label
                                                        class="form-check-label"
                                                        for="inlineCheckbox2"
                                                    >
                                                        <small
                                                            style="
                                                                font-size: 12px;
                                                            "
                                                        >
                                                            Title
                                                        </small>
                                                    </label>
                                                </span>
                                                <span
                                                    class="form-check form-check-inline p-0 mr-1"
                                                >
                                                    <input
                                                        class="form-check-input ml-0"
                                                        type="checkbox"
                                                        id="inlineCheckbox2"
                                                        value="option2"
                                                    />
                                                    <label
                                                        class="form-check-label"
                                                        for="inlineCheckbox2"
                                                    >
                                                        <small
                                                            style="
                                                                font-size: 12px;
                                                            "
                                                        >
                                                            Gender
                                                        </small>
                                                    </label>
                                                </span>
                                                <span
                                                    class="form-check form-check-inline p-0 mr-1"
                                                >
                                                    <input
                                                        class="form-check-input ml-0"
                                                        type="checkbox"
                                                        id="inlineCheckbox2"
                                                        value="option2"
                                                    />
                                                    <label
                                                        class="form-check-label"
                                                        for="inlineCheckbox2"
                                                    >
                                                        <small
                                                            style="
                                                                font-size: 12px;
                                                            "
                                                        >
                                                            Gender
                                                        </small>
                                                    </label>
                                                </span>
                                            </div>
                                            <b>Fields</b>
                                            <div class="dropdown-divider"></div>
                                            <div class="form-group">
                                                <b>
                                                    <small
                                                        style="font-size: 12px"
                                                    >
                                                        Email address
                                                    </small>
                                                </b>
                                                <input
                                                    type="email"
                                                    class="form-control form-control-sm"
                                                    id="exampleDropdownFormEmail1"
                                                    placeholder="email@example.com"
                                                />
                                            </div>
                                            <div class="form-group">
                                                <b>
                                                    <small
                                                        style="font-size: 12px"
                                                    >
                                                        Password
                                                    </small>
                                                </b>
                                                <input
                                                    type="password"
                                                    class="form-control form-control-sm"
                                                    id="exampleDropdownFormPassword1"
                                                    placeholder="Password"
                                                />
                                            </div>

                                            <div
                                                class="d-flex justify-content-between"
                                            >
                                                <button
                                                    type="submit"
                                                    class="btn btn-primary btn-sm"
                                                >
                                                    Reset
                                                </button>

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
