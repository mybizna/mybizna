<template>
    <div :class="'table-edit ' + classes">
        <div class="table-edit-wrapper border shadow bg-white mx-auto p-3">

            <div class="form-head mb-1 d-flex flex-wrap align-items-center pb-3">

                <h2 class="capitalize mr-2" :alt="$store.state.system.active_menu + ' - ' + $store.state.system.subtitle">
                    {{ $store.state.system.active_menu }}
                    <small class="text-sm" v-if="$store.state.system.subtitle != ''">
                        - {{ $store.state.system.subtitle }}
                    </small>
                </h2>

                <a class="cursor-pointer text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm  py-2 px-3  text-center mr-2"
                    @click="saveRecord()">
                    <i class="fa fa-save"></i>
                    Save
                </a>


                <a v-if="model.id"
                    class="cursor-pointer rounded-lg text-sm ring ring-2 ring-inset ring-gray-400 text-gray-600 py-2 px-3  text-center mr-2"
                    @click="duplicateRecord()">
                    <i class="fa fa-clone"></i>
                    Duplicate
                </a>

                <a class="cursor-pointer rounded-lg text-sm ring ring-2 ring-inset ring-red-400 text-red-600 py-2 px-3  text-center mr-2"
                    @click="cancelUrl()">
                    <i class="fa fa-plus"></i>
                    Cancel
                </a>

            </div>

            <slot>
                <h2>Error!</h2>
                <p>Editing Field Not set!</p>
            </slot>

        </div>

    </div>
</template>

<script>

export default {
    props: {
        model: Object,
        title: { type: String, default: "Editing", },
        passed_form_url: { type: String, default: "", },
        passed_return_url: { type: String, default: "", },
        main_column_css: { type: String, default: "", },
        no_redirect: { type: Boolean, default: false },
        has_modified: { type: Boolean, default: true },
        has_save: { type: Boolean, default: true },
        has_cancel: { type: Boolean, default: true },
        path_param: { type: Array, default: () => [] },
        form_fields: { type: Array, default: () => [] },
    },
    created() {
        this.preparePathParam();

        this.id = this.$route.params.id;

        if (this.id) {
            this.fetchRecord(this.id);
        }

        window.$store.commit("system/has_search", false);
        window.$store.commit("system/is_list", false);
        window.$store.commit("system/is_recordpicker", false);
        window.$store.commit("system/is_edit", true);
    },
    data() {
        return {
            id: null,
            processed_path_param: {},
            record: {},
            select_list: {},
            schema: {
                groups: [],
            },
            formOptions: {
                validateAfterLoad: true,
                validateAfterChanged: true,
                fieldIdPrefix: "user-",
            },
        };
    },
    methods: {
        preparePathParam() {
            this.processed_path_param = window.$func.pathParamHelper(this.path_param);

            if (this.passed_form_url != '') {
                this.processed_path_param.path = this.passed_form_url;
            }
        },

        fetchRecord(id) {

            window.$func.fetchRecordHelper(
                this,
                this.processed_path_param,
            );
        },
        saveRecord() {
            var t = this;

            window.$func.saveRecordHelper(
                this,
                this.processed_path_param,
                this.returnUrl
            );

            if (!t.no_redirect) {
                if (t.passed_return_url) {
                    window.$router.push(t.passed_return_url)
                }

                window.$router.push('/' + t.path_param[0] + "/admin/" + t.path_param[1])
            }

        },
        duplicateRecord() {
            var confirmation = confirm("Are you sure you want to Duplicate");

            if (confirmation) {
                var t = this;

                window.$func.saveRecordHelper(
                    this,
                    this.processed_path_param,
                    this.returnUrl,
                    true
                );

                if (!t.no_redirect) {
                    if (t.passed_return_url) {
                        window.$router.push(t.passed_return_url)
                    }

                    window.$router.push('/' + t.path_param[0] + "/admin/" + t.path_param[1])
                }
            }

        },
        cancelUrl: function () {
            var t = this;

            window.$router.push('/' + t.path_param[0] + "/admin/" + t.path_param[1])
        },
    },
    computed: {

        returnUrl: function () {
            var t = this;

            if (t.passed_return_url) {
                return t.passed_return_url;
            }

            return false;
        },
        hasCancel: function () {
            var t = this;

            if (t.has_cancel) {
                return t.has_cancel;
            }

            return false;
        },
        hasSave: function () {
            var t = this;

            if (t.has_save) {
                return t.has_save;
            }

            return false;
        },
    },
};
</script>

<style>
.table-edit .table-edit-wrapper {
    width: 90%;
    margin-top: 15px;
}

@media screen and (max-width: 481px) {
    .table-edit .table-edit-wrapper {
        width: 98%;
        margin-top: 5px;

    }
}
</style>
