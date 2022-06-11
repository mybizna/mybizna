<template>
    <div :class="'table-edit ' + classes">
        <div class="table-edit-wrapper border shadow bg-white mx-auto p-3">

            <div class="form-head mb-1 d-flex flex-wrap align-items-center pb-3">

                <h3 class="mr-5 mb-0">{{ title }}</h3>

                <a v-if="has_save" class="btn btn-success btn-sm text-white mr-1" @click="saveRecord()">
                    <i class="fa fa-save"></i> Save
                </a>

                <a v-if="has_cancel" class="btn btn-danger btn-sm" @click="cancelUrl()">
                    <i class="fa fa-times"></i> Cancel
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
/*eslint no-undef: 2*/
/* eslint-disable vue/no-unused-components */



export default {
    props: {
        model: Object,
        title: { type: String, default: "Editing", },
        passed_return_url: { type: String, default: "", },
        main_column_css: { type: String, default: "", },
        no_redirect: { type: Boolean, default: false },
        has_modified: { type: Boolean, default: true },
        has_save: { type: Boolean, default: true },
        has_cancel: { type: Boolean, default: true },
        path_param: { type: Array, default: () => [] },
        form_fields: { type: Array, default: () => [] },
        form_groups: { type: Array, default: () => [] },
        schema_fields: { type: Array, default: () => [] },
    },
    created () {
        this.preparePathParam();
        this.addGeneralFields();
        this.processFormFields();

        var path_part = this.path_param[0] + "/" + this.path_param[1];

        if (this.$route.path.indexOf(path_part) !== -1) {
            this.id = this.$route.params.id;
        }

        if (this.id) {
            this.fetchRecord(this.id);
        }

        window.$store.commit("system/has_search", true);
    },
    data () {
        return {
            id: null,
            group_list: [],
            processed_path_param: {},
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
        preparePathParam () {
            this.processed_path_param = window.$func.pathParamHelper(this.path_param);
        },
        addGeneralFields () {
            var t = this;

            if (t.has_modified && t.id) {
                t.form_fields.push(
                    {
                        type: "label",
                        group: "modification",
                        label: "No Modification Details for New Records.",
                        visible: "model.id == ''",
                        styleClasses: "text-xs-left",
                    },
                    {
                        type: "text",
                        name: "id",
                        group: "modification",
                        visible: "model.id != ''",
                        prefix: '"',
                        suffix: '"',
                        readonly: true,
                        disabled: true,
                    },
                    {
                        type: "user",
                        name: "created_by",
                        group: "modification",
                        visible: "model.id != ''",
                        prefix: '"',
                        suffix: '"',
                    },

                    {
                        type: "user",
                        name: "updated_by",
                        group: "modification",
                        visible: "model.id != ''",
                        prefix: '"',
                        suffix: '"',
                    },
                    {
                        type: "text",
                        name: "created_at",
                        group: "modification",
                        visible: "model.id != ''",
                        prefix: '"',
                        suffix: '"',
                        styleClasses: "col-md-6  main-group",
                    },
                    {
                        type: "text",
                        name: "updated_at",
                        group: "modification",
                        visible: "model.id != ''",
                        prefix: '"',
                        suffix: '"',
                        styleClasses: "col-md-6  main-group",
                    }
                );
            }
        },
        processFormFields () {
            var t = this;
            var groups = [];

            groups = this.beforeFormFields(groups);
            groups = this.mainFormFields(groups);

            t.form_groups.forEach(function (form_group) {
                t.group_list.push(form_group.name);
                groups[form_group.name] = {
                    legend: form_group.legend,
                    styleClasses: form_group.styleClasses,
                    fields: [],
                };
            });
            groups = this.afterFormFields(groups);

            t.form_fields.forEach(function (form_field) {
                var group_name = groups[form_field.group]
                    ? form_field.group
                    : "main";

                groups[group_name].fields.push(
                    window.$func.formInputProcessorHelper(form_field, t)
                );

                if (form_field.type === "selectrecord") {
                    var select_name = form_field.name + "_list";

                    t.$set(t.select_list, select_name, []);

                    t.getSelectList(t, select_name, form_field.source);
                }
            });

            t.group_list.forEach(function (group_name) {
                var tmp_group = groups[group_name];
                t.schema.groups.push(tmp_group);
            });
        },
        getSelectList (t, select_name, field_source) {
            var path_param_obj = window.$func.pathParamHelper(field_source.path_param);

            window.$func.fetchOptionsHelper(
                t,
                select_name,
                path_param_obj,
                field_source.fields
            );
        },
        beforeFormFields (groups) {
            var t = this;
            //To be developed if needed
            return groups;
        },
        mainFormFields (groups) {
            var t = this;

            groups["main"] = {
                legend: "Main Details",
                styleClasses: t.main_column_css,
                fields: [],
            };

            t.group_list.push("main");

            return groups;
        },
        afterFormFields (groups) {
            var t = this;

            if (t.has_modified && t.id) {
                groups["modification"] = {
                    legend: "Modification Records",
                    styleClasses: "col-sm-6  modification-group",
                    fields: [],
                };

                t.group_list.push("modification");
            }
            return groups;
        },
        fetchRecord (id) {
            window.$func.fetchRecordHelper(
                this,
                this.processed_path_param,
                this.schema_fields
            );
        },

        saveRecord () {
            window.$func.saveRecordHelper(
                this,
                this.processed_path_param,
                this.form_fields,
                this.returnUrl
            );
        },
        cancelUrl: function () {
            var t = this;

            window.$router.push({ name: t.path_param[0] + ".admin." + t.path_param[1] })
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