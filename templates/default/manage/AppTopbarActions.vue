<template>
    <div v-if="$store.state.system.is_list && !$store.state.system.is_edit" class="shadow-sm z-8">
        <div class="flex px-1 py-3">

            <div class="flex-auto">
                <a class="uppercase cursor-point whitespace-nowrap text-white rounded bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium text-sm  py-2 px-3  text-center"
                    @click="addLink()">
                    <i class="fa fa-plus"></i>
                    Create
                </a>
            </div>

            <div v-if="$store.state.system.has_search && !$store.state.system.is_recordpicker"
                class="flex-none w-64 mr-5">
                <search-form :show_filter="false"></search-form>
            </div>

        </div>
    </div>
</template>

<script>

export default {
    components: {
        SearchForm: window.$filters.fetchComponent('templates/default/manage/SearchForm.vue')
    },

    created() {
        this.$store.dispatch("system/getMenu");
        this.$store.dispatch("system/getPositions");

        if (!this.$store.state.system.backendmenu_length) {
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
