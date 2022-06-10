<template>
    <div :class="classes">
        <div
            v-if="!is_recordpicker"
            class="form-head d-flex flex-wrap align-items-center"
        >
            <h3 class="mr-5 mb-0">{{ title }}</h3>
            <a
                v-if="!hideAddButton"
                @click="addLink()"
                class="btn btn-sm btn-success text-white m-1"
            >
                <i class="fa fa-plus"></i>
                Add New
            </a>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive table-responsive-sm" v-bind:style="table_style">
                    <table class="table table-sm table-striped  table-hover p-0">
                        <thead>
                            <tr>
                                <th
                                    scope="col"
                                    v-for="(
                                        table_field, index
                                    ) in table.headers"
                                    :key="index"
                                    :style="table_field.style"
                                    :class="table_field.class"
                                >
                                    {{ table_field.label }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in items" :key="index">
                                <td v-if="!hide_action_button">
                                    <menu-dropdown
                                        v-if="!is_recordpicker"
                                        :field_list="field_list"
                                        :pitem="item"
                                        :dropdown_menu_list="dropdown_menu_list"
                                    ></menu-dropdown>
                                    <a
                                        v-else
                                        class="btn btn-primary btn-sm text-white"
                                        @click="recordPicker(item.id)"
                                        >Select</a
                                    >
                                </td>
                                <th
                                    v-if="hide_action_button"
                                    scope="row"
                                    class="col--check check-column"
                                >
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input
                                                :value="item.id"
                                                v-model="checkedItems"
                                                class="form-check-input"
                                                type="checkbox"
                                                name="item[]"
                                            />
                                            <span class="form-check-sign">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>
                                </th>

                                <template
                                    v-for="(table_field, index) in table_fields"
                                >
                                    <slot :name="key" :row="row">
                                        <template v-if="'actions' !== key">
                                            <td-render
                                                :key="index"
                                                :field_list="field_list"
                                                :pitem="item"
                                                :data_field="table_field"
                                                :class_name="
                                                    getClassName(table_field)
                                                "
                                            ></td-render>
                                        </template>
                                    </slot>
                                </template>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    components: {
        TdRender: window.$func.fetchComponent(
            "components/common/widgets/list/TdRender.vue"
        ),
        MenuDropdown: window.$func.fetchComponent(
            "components/common/widgets/list/MenuDropdown.vue"
        ),
    },
    props: {
        classes: String,
        title: String,
        model: Object,
        table_snippet: Object,
        passed_return_url: String,
        dropdown_menu: { type: Array, default: () => [] },
        path_param: { type: Array, default: () => [] },
        search: { type: Array, default: () => [] },
        search_fields: { type: Array, default: () => [] },
        table_fields: { type: Array, default: () => [] },
        schema_fields: { type: Array, default: () => [] },
        loop_fields: { type: Array, default: () => [] },
        recordPicker: { type: Object, default: () => {} },
        is_recordpicker: { type: Boolean, default: false },
        has_add_button: { type: Boolean, default: true },
        hide_toolbar: { type: Boolean, default: false },
        hide_delete_button: { type: Boolean, default: false },
        hide_action_button: { type: Boolean, default: false },
        hide_search_form: { type: Boolean, default: false },
        hide_select_checkbox: { type: Boolean, default: false },
    },
    created() {
        this.preparePathParam();
        this.processDropdownMenu();
        this.processFieldList();
        this.presetSearchForm();
        this.presetTableStructure();
        this.fetchRecords();
    },

    emits: {
        // Validate submit event
        "bv::dropdown::show": (bvEvent) => {
            this.table_style = { "padding-bottom": "700px" };
            return true;
        },
        "bv::dropdown::hide": (bvEvent) => {
            this.table_style = { "padding-bottom": "0px" };
            return true;
        },
    },
    data() {
        return {
            expanded: {},
            table_style: { "padding-bottom": "0px" },
            loading_message: "Fetching Data.",
            show_delete_btn: false,
            show_advance_form: false,
            select_list: {},
            checkedItems:[],
            opeList:[],
            items: [],
            field_list: [],
            pages: 1,
            dropdown_menu_list: [],
            processed_path_param: "",
            // search: "",
            pagination: {
                orderby: 'id',
                order: 'DESC',
                limit: 10,
                page: 1,
                totalItems: 0,
                limitItems: [5, 10, 20, 50, 100, 200],
            },
            schema: {
                fields: [],
            },
            formOptions: {
                validateAfterLoad: true,
                validateAfterChanged: true,
                fieldIdPrefix: "user-",
            },
            table: {
                selected: [],
                headers: [],
            },
        };
    },
    watch: {
        pagination() {
            this.fetchRecords();
        },
        model: {
            handler() {
                this.fetchRecords();
            },
            deep: true,
        },
        show_advance_form() {
            const t = this;

            if (t.show_advance_form) {
                t.search = "";
            }
        },
    },

    methods: {
        getClassName(table_field) {
            var full_class_name = "text-xs-left";

            if (Object.prototype.hasOwnProperty.call(table_field, "align")) {
                full_class_name = "text-xs-" + table_field.align;
            }
            return full_class_name;
        },
        changeExpandStatus(id, expanded) {
            this.$set(this.expanded, id, !expanded[id]);
        },
        preparePathParam() {
            this.processed_path_param = window.$func.pathParamHelper(
                this.path_param
            );
        },
        processDropdownMenu() {
            const t = this;

            t.dropdown_menu.forEach(function (dropdown_menu_single) {
                t.dropdown_menu_list.push(dropdown_menu_single);
            });

            t.dropdown_menu_list.push({
                title: "Edit",
                icon: "fa fa-pencil",
                name: this.processed_path_param.dotted + ".edit",
                param: ["pk"],
            });
        },
        processFieldList() {
            var t = this;

            t.schema_fields.forEach(function (schema_field) {
                t.processSingleField(schema_field, "");
            });

            t.loop_fields.forEach(function (loop_field, tmp_index) {
                var name = loop_field.name;
                var start = loop_field.start;
                var end = loop_field.end;
                var fields = loop_field.fields;

                for (let index = 0; index <= end; index++) {
                    var tmp_field_name = name;

                    tmp_field_name = tmp_field_name + "." + index;

                    fields.forEach(function (field) {
                        var new_tmp_field_name = tmp_field_name + "." + field;
                        t.field_list.push(new_tmp_field_name);
                    });
                }
            });
        },
        processSingleField(schema_field, process_str) {
            var t = this;

            if (schema_field.indexOf("{") > 0) {
                var first_brace_index = schema_field.indexOf("{");
                var last_brace_index = schema_field.lastIndexOf("}");

                var first_part = schema_field.substring(0, first_brace_index);
                var main_part = schema_field.substring(
                    first_brace_index + 1,
                    last_brace_index
                );

                process_str = process_str + first_part.trim() + ".";

                var total_braces = main_part.split("{").length - 1;

                if (total_braces) {
                    for (let index = 1; index <= total_braces; index++) {
                        var first_subbrace_start = main_part.indexOf("{");
                        var first_subbrace_end = main_part.indexOf("}");
                        var closest_comma_index = main_part.lastIndexOf(
                            ",",
                            first_subbrace_start
                        );
                        var sub_main_part = main_part.substring(
                            closest_comma_index + 1,
                            first_subbrace_end + 1
                        );

                        main_part = main_part.replace(sub_main_part, "");

                        t.processSingleField(sub_main_part, process_str);
                    }
                }

                t.processCommaField(main_part, process_str);
            } else {
                var schema_field_clean = schema_field.trim();

                if (schema_field_clean.indexOf(",") > 0) {
                    t.processCommaField(schema_field_clean, process_str);
                } else {
                    t.field_list.push(process_str + schema_field_clean);
                }
            }
        },
        processCommaField(schema_field, process_str) {
            var t = this;

            var field_group = schema_field.split(",");

            field_group.forEach(function (single_field) {
                var single_field_clean = single_field.trim();

                if (single_field_clean !== "") {
                    t.field_list.push(process_str + single_field_clean);
                }
            });
        },
        presetSearchForm() {
            var t = this;

            t.search_fields.forEach(function (search_field) {
                if (!search_field.hidden) {
                    var search_field_obj =
                        window.$func.formInputProcessorHelper(search_field, t);
                    t.schema.fields.push(search_field_obj);
                }

                if (
                    search_field.type === "select" ||
                    search_field.type === "selectrecord"
                ) {
                    var select_name = search_field.name;

                    if (
                        !Object.prototype.hasOwnProperty.call(
                            t.select_list,
                            select_name
                        )
                    ) {
                        t.select_list[select_name] = [];
                    }

                    t.getSelectList(t, select_name, search_field.source);
                }
            });

            window.$store.commit('system/has_search', { has_search: true });
            window.$store.commit('system/search', { search: t.search_fields });
        },
        getSelectList(t, select_name, field_source) {
            var path_param_obj = window.$func.pathParamHelper(
                field_source.path_param
            );

            window.$func.fetchOptionsHelper(
                t,
                select_name,
                path_param_obj,
                field_source.fields
            );
        },
        presetTableStructure() {
            var t = this;

            if (window.is_backend) {
                t.table.headers.push({
                    label: "",
                    key: "id",
                    sortable: false,
                    width: "10px",
                });
            }

            t.table_fields.forEach(function (table_field, index) {
                var align = "left";

                if (
                    Object.prototype.hasOwnProperty.call(table_field, "align")
                ) {
                    align = table_field.align;
                }

                t.table_fields[index]["path"] = table_field.prop.split(".");

                var tmp_label = table_field.text
                    .replace("_id", "")
                    .replace("_", " ")
                    .replace(/\w\S*/g, function (word) {
                        return (
                            word.charAt(0).toUpperCase() +
                            word.substr(1).toLowerCase()
                        );
                    });

                t.table.headers.push({
                    label: tmp_label,
                    key: table_field.text.toLowerCase(),
                    sortable: false,
                });
            });
        },
        fetchRecords() {
            var t = this;
            var query_params = t.$route.query;

            for (var key in query_params) {
                if (Object.prototype.hasOwnProperty.call(t.model, key)) {
                    t.model[key] = query_params[key];
                }
            }

            window.$func.fetchRecordsHelper(
                this,
                this.processed_path_param,
                this.search_fields,
                this.schema_fields
            );
        },

        deleteRecord() {
            window.$func.deleteRecordHelper(
                this,
                this.processed_path_param,
                this.returnUrl
            );

            this.fetchRecords();
        },

        updatePagination(pagination) {
            this.fetchRecords();
        },

        postProcessing(t, field_list) {
            var curr_this = this;
            var offset = new Date().getTimezoneOffset();

            t.items.forEach(function (item, item_index) {
                t.table_fields.forEach(function (field, field_index) {
                    if (field.pre_timezone) {
                        var tmp_value = curr_this.getValueByPerPath(
                            t,
                            field.path,
                            item_index
                        );

                        if (offset !== 0 && tmp_value !== null) {
                            tmp_value = curr_this
                                .$moment(tmp_value)
                                .add(offset * -1, "minutes")
                                .format("D MMM YYYY, HH:mm:ss A");
                        }

                        curr_this.setValueByPerPath(
                            t,
                            field.path,
                            item_index,
                            tmp_value
                        );
                    }
                });
            });
        },
        getValueByPerPath(t, field_path, item_index) {
            var item_value = "";

            if (field_path.length == 1) {
                var path_0_1 = field_path[0];
                item_value = t.items[item_index][path_0_1];
            } else if (field_path.length == 2) {
                var path_0_2 = field_path[0];
                var path_1_2 = field_path[1];
                item_value = t.items[item_index][path_0_2][path_1_2];
            } else if (field_path.length == 3) {
                var path_0_3 = field_path[0];
                var path_1_3 = field_path[1];
                var path_2_3 = field_path[2];
                item_value = t.items[item_index][path_0_3][path_1_3][path_2_3];
            } else if (field_path.length == 4) {
                var path_0_4 = field_path[0];
                var path_1_4 = field_path[1];
                var path_2_4 = field_path[2];
                var path_3_4 = field_path[3];
                item_value =
                    t.items[item_index][path_0_4][path_1_4][path_2_4][path_3_4];
            }

            return item_value;
        },
        setValueByPerPath(t, field_path, item_index, tmp_value) {
            var tmp_obj = t.items[item_index];

            if (field_path.length == 1) {
                var path_0_1 = field_path[0];
                tmp_obj[path_0_1] = tmp_value;
            } else if (field_path.length == 2) {
                var path_0_2 = field_path[0];
                var path_1_2 = field_path[1];
                tmp_obj[path_0_2][path_1_2] = tmp_value;
            } else if (field_path.length == 3) {
                var path_0_3 = field_path[0];
                var path_1_3 = field_path[1];
                var path_2_3 = field_path[2];
                tmp_obj[path_0_3][path_1_3][path_2_3] = tmp_value;
            } else if (field_path.length == 4) {
                var path_0_4 = field_path[0];
                var path_1_4 = field_path[1];
                var path_2_4 = field_path[2];
                var path_3_4 = field_path[3];
                tmp_obj[path_0_4][path_1_4][path_2_4][path_3_4] = tmp_value;
            }

            t.$set(t.items, item_index, tmp_obj);
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
        hideAddButton: function () {
            var t = this;

            if (t.hide_add_button) {
                return t.hide_add_button;
            }

            return false;
        },
        // a computed getter
        addLink: function () {
            var t = this;

            a

            var url_obj = window.$router.resolve({
                name: t.processed_path_param.dotted + ".new",
            });

            return url_obj.href;
        },
    },
};
</script>
