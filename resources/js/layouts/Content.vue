<template>

    <template v-if="$store.state.system.loading">
        <div wire:loading
            class="fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-gradient-to-r from-indigo-500/25 via-purple-500/25 to-indigo-500/25 flex flex-col items-center justify-center">
            <div class="fa-3x text-blue-700 ">
                <i class="fas fa-spinner fa-spin"></i>
            </div>
            <h2 class="text-center text-blue-800 text-xl font-semibold">Loading...</h2>
            <p class="w-1/3 text-center text-blue-800">This may take a few seconds, please don't close this page.</p>
        </div>

    </template>

    <div class="mybizna-app">
 

        <app-bar-nav-menu v-if="$store.getters['auth/loggedIn']"></app-bar-nav-menu>

        <main class="p-0">
            <div class="app-content-container boxed-container">
                <slot></slot>
            </div>
        </main>

        <footer app inset color="transparent" absolute height="56" class="footer mt-auto py-3 bg-light">
            <div class="container">
                <div class="text-muted text-center">
                    <span>
                        &copy; 2022 - 2023
                        <a href="https://mybizna.com" class="text-decoration-none" target="_blank">Mybizna</a></span>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
import AppBarNavMenu from "@/components/widgets/AppBarNavMenu.vue";

export default {
    components: {
        AppBarNavMenu,
    },
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
    height: 80%;
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

.boxed-container {
    max-width: 1440px;
    margin-left: auto;
    margin-right: auto;
}
</style>
