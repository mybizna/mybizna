<template>
    <v-app class="custom-class">
        <v-app-bar app flat absolute color="transparent" height="50">
            <div class="boxed-container w-full">
                <div class="d-flex align-center mx-6">
                    <!-- Left Content -->

                    <app-bar-applist-menu></app-bar-applist-menu>

                    <v-spacer></v-spacer>

                    <v-toolbar-title> Accounting </v-toolbar-title>

                    <v-spacer></v-spacer>

                    <!-- Right Content -->
                    <v-btn icon small class="ms-3">
                        <v-icon>
                            {{ icons.mdiBellOutline }}
                        </v-icon>
                    </v-btn>
                    <app-bar-user-menu></app-bar-user-menu>
                </div>
            </div>
        </v-app-bar>

        <div style="margin-top: 50px">
            <b-navbar toggleable="sm" type="light" variant="light">
                <b-navbar-nav>
                    <b-nav-item href="#">Accounting</b-nav-item>

                    <!-- Navbar dropdowns -->
                    <b-nav-item-dropdown text="Invoice" right>
                        <b-dropdown-item to="/transactions">Transactions</b-dropdown-item>
                        <b-dropdown-item to="/transactions/sales">Sales</b-dropdown-item>
                        <b-dropdown-item href="#">Invoice RU</b-dropdown-item>
                        <b-dropdown-item href="#">Invoice FA</b-dropdown-item>
                    </b-nav-item-dropdown>

                    <b-nav-item-dropdown text="Payments" right>
                        <b-dropdown-item href="#">Payments Account</b-dropdown-item>
                        <b-dropdown-item href="#"> Payments Settings</b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-navbar-nav>
            </b-navbar>
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
import { ref } from "@vue/composition-api";
import { mdiMagnify, mdiBellOutline, mdiGithub } from "@mdi/js";
import VerticalNavMenu from "./components/vertical-nav-menu/VerticalNavMenu.vue";
import ThemeSwitcher from "./components/ThemeSwitcher.vue";
import AppBarUserMenu from "./components/AppBarUserMenu.vue";
import AppBarApplistMenu from "./components/AppBarApplistMenu.vue";

export default {
    components: {
        VerticalNavMenu,
        ThemeSwitcher,
        AppBarUserMenu,
        AppBarApplistMenu,
    },
    setup() {
        const isDrawerOpen = ref(null);

        return {
            isDrawerOpen,

            // Icons
            icons: {
                mdiMagnify,
                mdiBellOutline,
                mdiGithub,
            },
        };
    },
};
</script>

<style lang="scss" scoped>
.theme--light.v-application {
    background: #f4f5fa !important;
}

header,
.v-app-bar {
    height: 50px !important;
}

header ::v-deep {
    .v-toolbar__content {
        border-bottom: 1px solid #eee !important;
        background: white !important;
        box-shadow: 0px 2px 4px #eee;
    }
}

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
