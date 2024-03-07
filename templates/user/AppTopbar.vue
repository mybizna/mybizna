<template>

</template>

<script>
export default {
    components: {
        AppTopbarIconAvatar: window.$filters.fetchComponent('templates/user/AppTopbarIconAvatar.vue'),
        AppTopbarIconOthers: window.$filters.fetchComponent('templates/user/AppTopbarIconOthers.vue'),
    },
    setup() {
        return {};
    },

    data() {
        return {
            sidebar_show: true,
        }
    },
    methods: {
        logout() {
            this.$store.commit("auth/logout");
        },
        drawer() {
            this.sidebar_show = !this.sidebar_show;
        },
    },

   
};
</script>

<style>
.user-profile-menu-content .v-list-item {
    min-height: 2.5rem !important;
}
</style>
