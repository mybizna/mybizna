<template>
    <v-app class="custom-class">
        <v-app-bar app flat absolute color="transparent">
            <div class="boxed-container w-full">
                <div class="d-flex align-center mx-6">
                    <!-- Left Content -->

                    <app-bar-applist-menu></app-bar-applist-menu>

                    <v-spacer></v-spacer>

                    <v-toolbar-title> Accounting </v-toolbar-title>

                    <v-spacer></v-spacer>

                    <!-- Right Content -->
                    <theme-switcher></theme-switcher>
                    <v-btn icon small class="ms-3">
                        <v-icon>
                            {{ icons.mdiBellOutline }}
                        </v-icon>
                    </v-btn>
                    <app-bar-user-menu></app-bar-user-menu>
                </div>
            </div>
        </v-app-bar>

        <div>
            <b-navbar type="dark" variant="dark">
                <b-navbar-nav>
                    <b-nav-item href="#">Home</b-nav-item>

                    <!-- Navbar dropdowns -->
                    <b-nav-item-dropdown text="Lang" right>
                        <b-dropdown-item href="#">EN</b-dropdown-item>
                        <b-dropdown-item href="#">ES</b-dropdown-item>
                        <b-dropdown-item href="#">RU</b-dropdown-item>
                        <b-dropdown-item href="#">FA</b-dropdown-item>
                    </b-nav-item-dropdown>

                    <b-nav-item-dropdown text="User" right>
                        <b-dropdown-item href="#">Account</b-dropdown-item>
                        <b-dropdown-item href="#">Settings</b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-navbar-nav>
            </b-navbar>
        </div>

        <v-main>
            <div class="app-content-container boxed-container pa-6">
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
    height: 54px !important;
}

header ::v-deep {
    .v-toolbar__content {
        background: white !important;
        height: 54px !important;
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

.boxed-container {
    max-width: 1440px;
    margin-left: auto;
    margin-right: auto;
}
</style>
