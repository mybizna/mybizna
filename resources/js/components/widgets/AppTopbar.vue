<template>

    <div class="flex bg-violet-400">
        <div class="flex-auto">
            <div class="flex justify-start pt-1 pl-1 mr-2 space-x-3 cursor-pointer text-blue-600">

                <app-bar-applist-menu></app-bar-applist-menu>

                <h2 class="text-md leading-7 h-8 text-white"
                    :alt="$store.state.system.title + ': ' + $store.state.system.menu[$store.state.system.active_menu]['title'] + ' - ' + $store.state.system.subtitle">
                    <span class="uppercase">
                        {{ $store.state.system.title }} :
                    </span>
                    <small>
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
</template>

<script>
import AppTopbarIconAvatar from "@/components/widgets/AppTopbarIconAvatar.vue";
import AppTopbarIconOthers from "@/components/widgets/AppTopbarIconOthers.vue";
import AppBarApplistMenu from "@/components/widgets/AppBarApplistMenu.vue";

export default {
    components: {
        AppTopbarIconAvatar,
        AppTopbarIconOthers,
        AppBarApplistMenu
    },
    setup() {
        return {};
    },

    methods: {
        logout() {
            this.$store.commit("auth/logout");
        },
    },
};
</script>

<style lang="scss">
.user-profile-menu-content {
    .v-list-item {
        min-height: 2.5rem !important;
    }
}

</style>
