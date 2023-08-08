<template>
    <div class="w-full z-10 border-b border-dotted border-b-indigo-100 bg-indigo-500">

        <div class="flex">
            <div class="flex-auto">
                <div class="flex justify-start pt-1 pl-1 mr-2 space-x-4 cursor-pointer text-white">

                    <a @click="drawer" class="w-15 mr-2">
                        <i :class="$store.state.system.sidebar_show ? 'text-cyan-200' : ' text-white'"
                            class="fas fa-bars text-2xl"></i>
                    </a>

                    <a @click="applist" class="w-15">
                        <i :class="$store.state.system.applist ? 'text-cyan-200' : ' text-white'"
                            class="fab fa-microsoft text-2xl "></i>

                        <div :class="$store.state.system.applist ? 'text-cyan-200' : 'text-white'"
                            class="inline-block text-sm font-bold  pl-1">
                            APP
                        </div>

                        <span
                            class="absolute inline-flex items-center justify-center w-4 h-4 leading-3 font-bold text-white bg-green-500 border border-white rounded-full top dark:border-gray-900 "
                            style="font-size: 9px !important;">
                            {{ $store.state.system.menu_length }}
                        </span>
                    </a>


                </div>
            </div>
            <div class="flex-auto text-center pt-2">
                <h2 class="text-md text-white"
                    :alt="($store.state.system.menu[$store.state.system.active_menu] ? $store.state.system.menu[$store.state.system.active_menu]['title'] : '') + ' - ' + $store.state.system.subtitle">
                    <small v-if="$store.state.system.menu[$store.state.system.active_menu]">
                        {{ $store.state.system.menu[$store.state.system.active_menu]['title'] }}
                    </small>
                    {{ $store.state.system.subtitle }}
                    <small class="text-sm" v-if="$store.state.system.subtitle != ''">
                        - {{ $store.state.system.subtitle }}
                    </small>
                </h2>
            </div>

            <div class="flex-auto text-right">
                <div class="flex justify-end pt-1 pr-1 pb-1 mr-2 space-x-2 cursor-pointer">
                    <app-topbar-icon-others></app-topbar-icon-others>
                    <app-topbar-icon-avatar></app-topbar-icon-avatar>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import AppTopbarIconAvatar from "@/components/widgets/AppTopbarIconAvatar.vue";
import AppTopbarIconOthers from "@/components/widgets/AppTopbarIconOthers.vue";

export default {
    components: {
        AppTopbarIconAvatar,
        AppTopbarIconOthers,
    },
    setup() {
        return {};
    },
    props: {
        windowWidth: { type: String, default: window.innerWidth },
        windowHeight: { type: String, default: window.innerHeight },
    },
    data() {
        return {
        }
    },
    methods: {
        logout() {
            this.$store.commit("auth/logout");
        },
        drawer() {
            this.$store.commit("system/sidebar_show", !this.$store.state.system.sidebar_show);
        },
        applist() {
            this.$store.commit("system/sidebar_show", false);
            this.$store.commit("system/applist_show", !this.$store.state.system.applist_show);
        }
    },
    mounted() {
    }
};
</script>

<style lang="scss">
.user-profile-menu-content {
    .v-list-item {
        min-height: 2.5rem !important;
    }
}
</style>
