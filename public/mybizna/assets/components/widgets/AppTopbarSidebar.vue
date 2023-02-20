<template>
    <div :class="(($floating_top) ? 'fixed' : '') + 'w-full z-10'">

        <div class="flex bg-indigo-900">
            <div class="flex-auto">
                <div class="flex justify-start pt-1 pl-1 mr-2 space-x-3 cursor-pointer text-blue-600">

                    <a @click="drawer">
                        <i v-if="$store.state.system.sidebar_show && windowWidth < $responsive_point"
                            class="fa-regular fa-circle-xmark  text-2xl text-red-500"></i>
                        <i v-else class="fas fa-bars text-2xl text-white"></i>
                    </a>

                    <h2 class="text-md leading-7 h-8 text-white"
                        :alt="($store.state.system.menu[$store.state.system.active_menu] ? $store.state.system.menu[$store.state.system.active_menu]['title'] : '') + ' - ' + $store.state.system.subtitle">
                        <small v-if="$store.state.system.menu[$store.state.system.active_menu]">
                            {{ $store.state.system.menu[$store.state.system.active_menu]['title'] }}
                        </small>
                        <small class="text-sm" v-if="$store.state.system.subtitle != ''">
                            - {{ $store.state.system.subtitle }}
                        </small>
                    </h2>
                </div>
            </div>

            <div class="flex-auto text-right">
                <div class="flex justify-end pt-1 pr-1 pb-1 mr-2 space-x-2 cursor-pointer">
                    <app-topbar-icon-others></app-topbar-icon-others>
                    <app-topbar-icon-avatar></app-topbar-icon-avatar>
                </div>
            </div>
        </div>

    </div>


    <aside v-if="$store.state.system.sidebar_show"
        class="transform top-10 left-0 w-56 bg-gradient-to-r from-indigo-50 to-indigo-100  border-r-2 border-r border-indigo-200 fixed h-full overflow-auto ease-in-out transition-all duration-300 z-30 translate-x-0 visible md:invisible ">
        <h5 class="p-2 font-semibold text-indigo-700 uppercase dark:text-indigo-400">
            <span class="uppercase">
                {{ $store.state.system.title }}
            </span>
        </h5>

        <app-sidebar></app-sidebar>
    </aside>
</template>

<script>
import AppSidebar from "@/components/widgets/AppSidebar.vue";
import AppTopbarIconAvatar from "@/components/widgets/AppTopbarIconAvatar.vue";
import AppTopbarIconOthers from "@/components/widgets/AppTopbarIconOthers.vue";

export default {
    components: {
        AppTopbarIconAvatar,
        AppTopbarIconOthers,
        AppSidebar
    },
    setup() {
        return {};
    },
    props: {
        windowWidth: { type: String, default: window.innerWidth },
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
