<template>

    <div class="flex bg-violet-50">
        <div class="flex-none w-12"></div>
        <div class="flex-auto">
            <div class="flex justify-start pt-1 pl-1 pb-1 mr-2 space-x-3 cursor-pointer text-blue-600">
                <div class="w-6 h-6">
                    <svg  fill="#0a58ca" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.36 122.88"
                        style="enable-background:new 0 0 122.36 122.88" xml:space="preserve">
                        <g>
                            <path class="st0"
                                d="M5.85,0h20.09c3.22,0,5.85,2.63,5.85,5.85v20.09c0,3.22-2.63,5.85-5.85,5.85H5.85C2.63,31.8,0,29.16,0,25.94 V5.85C0,2.63,2.63,0,5.85,0L5.85,0z M96.42,91.08h20.09c3.22,0,5.86,2.63,5.86,5.86v20.09c0,3.22-2.63,5.86-5.86,5.86H96.42 c-3.22,0-5.86-2.63-5.86-5.86V96.94C90.56,93.72,93.2,91.08,96.42,91.08L96.42,91.08z M51.14,91.08h20.09 c3.22,0,5.86,2.63,5.86,5.86v20.09c0,3.22-2.63,5.86-5.86,5.86H51.14c-3.22,0-5.85-2.63-5.85-5.86V96.94 C45.28,93.72,47.92,91.08,51.14,91.08L51.14,91.08z M5.85,91.08h20.09c3.22,0,5.85,2.63,5.85,5.86v20.09 c0,3.22-2.63,5.86-5.85,5.86H5.85c-3.22,0-5.85-2.63-5.85-5.86V96.94C0,93.72,2.63,91.08,5.85,91.08L5.85,91.08z M96.42,45.54 h20.09c3.22,0,5.86,2.63,5.86,5.86v20.09c0,3.22-2.63,5.86-5.86,5.86H96.42c-3.22,0-5.86-2.63-5.86-5.86V51.4 C90.56,48.18,93.2,45.54,96.42,45.54L96.42,45.54z M51.14,45.54h20.09c3.22,0,5.86,2.63,5.86,5.86v20.09 c0,3.22-2.63,5.86-5.86,5.86H51.14c-3.22,0-5.85-2.63-5.85-5.86V51.4C45.28,48.18,47.92,45.54,51.14,45.54L51.14,45.54z M5.85,45.54h20.09c3.22,0,5.85,2.63,5.85,5.86v20.09c0,3.22-2.63,5.86-5.85,5.86H5.85C2.63,77.34,0,74.7,0,71.48V51.4 C0,48.18,2.63,45.54,5.85,45.54L5.85,45.54z M96.42,0h20.09c3.22,0,5.86,2.63,5.86,5.85v20.09c0,3.22-2.63,5.85-5.86,5.85H96.42 c-3.22,0-5.86-2.63-5.86-5.85V5.85C90.56,2.63,93.2,0,96.42,0L96.42,0z M51.14,0h20.09c3.22,0,5.86,2.63,5.86,5.85v20.09 c0,3.22-2.63,5.85-5.86,5.85H51.14c-3.22,0-5.85-2.63-5.85-5.85V5.85C45.28,2.63,47.92,0,51.14,0L51.14,0z" />
                        </g>
                    </svg>
                </div>
                <h2 class="text-xl leading-7">App Title</h2>
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

export default {
    components: {
        AppTopbarIconAvatar,
        AppTopbarIconOthers
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
