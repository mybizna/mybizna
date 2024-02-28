<template></template>

<script>

export default {
    components: {
        SearchForm: window.$filters.fetchComponent('templates/admin/SearchForm.vue')
    },
    setup() {


        if (!this.$store.state.system.backendmenu.length) {
            this.$store.dispatch("system/getMenu");
        }

        if (!this.$store.state.system.positions.length) {
            this.$store.dispatch("system/getPositions");
        }
    },

    methods: {
        addLink: function () {
            var t = this;

            window.$router.push({
                name: t.$store.state.system.path_params.dotted + ".create",
            });

        },
    },
    data: () => ({}),
};
</script>

<style>
.navbar {
    display: block !important;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    background: white !important;
    z-index: 1000;
}

.navbar .formkit-wrapper label {
    font-size: 14px;
}

.navbar .formkit-outer {
    margin-bottom: 0 !important;
}

.navbar .formkit-messages {
    margin-bottom: 0;
    margin-left: 0;
    list-style-type: none;
    padding: 0;
}

.navbar .formkit-messages .formkit-message {
    font-size: 12px !important;
}

.navbar .mobile-dropdown {
    overflow: scroll;
    height: 100%;
}

.navbar .search-dropdown {
    width: 98%;
    position: fixed;
    top: 70px !important;
    margin: 5px;
}

.navbar ul li.nav-item {
    padding-top: 7px !important;
    padding-bottom: 7px !important;
    border-right: 1px dotted #eee !important;
}
</style>
