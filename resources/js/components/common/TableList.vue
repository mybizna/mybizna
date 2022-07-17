<template>
    <div :class="classes">
        <div :class="'card ' + getCardClassName()">
            <div class="card-head">
                <div v-if="!is_recordpicker" class="form-head d-flex flex-wrap align-items-center py-2">
                    <h3 class="font-medium text-lg text-gray ml-2 mr-5 mb-0">{{ title }}</h3>
                    <a class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm  py-2 px-3  text-center mr-2"
                        @click="addLink()">
                        <i class="fa fa-plus"></i>
                        Add New
                    </a>

                </div>
            </div>
            <div class="card-body p-0">
                <div v-if="is_recordpicker">
                    <search-form></search-form>
                </div>
                <div class="table-responsive table-responsive-sm" v-bind:style="table_style">
                    <table class="table m-0 p-0">
                        <thead>
                            <tr class="bg-slate-100 px-7">
                                <th class="uppercase" scope="col" v-for="(
                                        table_field, index
                                    ) in table.headers" :key="index" :style="table_field.style"
                                    :class="table_field.class">
                                    {{ table_field.label }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="border-none">
                            <template v-if="items.length">
                                <tr v-for="(item, index) in items" :key="index"
                                    class="border-b-sky-200 hover:bg-slate-50">
                                    <td v-if="!hide_action_button">
                                        <menu-dropdown v-if="!is_recordpicker" :field_list="field_list" :pitem="item"
                                            :dropdown_menu_list="dropdown_menu_list"></menu-dropdown>
                                        <a v-else class="btn btn-primary btn-sm text-white"
                                            @click="recordPicker(item.id)">Select</a>
                                    </td>
                                    <th v-if="hide_action_button" scope="row" class="col--check check-column">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input :value="item.id" v-model="checkedItems" class="form-check-input"
                                                    type="checkbox" name="item[]" />
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </th>

                                    <template v-for="(table_field, index) in table_fields">
                                        <slot :name="key" :row="row">
                                            <template v-if="'actions' !== key">
                                                <td-render :key="index" :field_list="field_list" :pitem="item"
                                                    :data_field="table_field" :class_name="
                                                        getClassName(table_field)
                                                    "></td-render>
                                            </template>
                                        </slot>
                                    </template>
                                </tr>
                            </template>
                            <tr class="border-b-sky-200" v-else>
                                <td colspan="20" class="text-center hover:bg-slate-50">
                                    <img class="inline-block w-36 m-6" src="images/no_data_found.svg">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-foot">
                <div class="w-full row">
                    <div class="col-4 col-sm-4">
                        <select class="form-select form-select-sm
                                    mt-2
                                    ml-2
                                    appearance-none
                                    inline-block
                                    w-16
                                    px-2
                                    py-1
                                    text-sm
                                    font-normal
                                    text-gray-700
                                    bg-white bg-clip-padding bg-no-repeat
                                    border border-solid border-gray-300
                                    rounded
                                    transition
                                    ease-in-out
                                    m-0
                                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            aria-label=".form-select-sm example">
                            <option selected value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                        </select>
                    </div>
                    <div class="col-8 col-sm-4 text-center pt-3">

                        <p class="text-center text-sm text-gray-700">
                            Showing
                            <span class="font-medium">1</span>
                            to
                            <span class="font-medium">10</span>
                            of
                            <span class="font-medium">97</span>
                            results
                        </p>
                    </div>
                    <div class="col-sm-4">
                        <nav class="text-right" aria-label="Pagination">
                            <a href="#"
                                class="inline-block bg-gray-50 border-gray-500 text-gray-600 h-9 w-9 leading-8 border text-sm font-medium rounded-full m-1 text-center">
                                <i class="fa-solid fa-caret-left"></i>
                            </a>
                            <!-- Current: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" -->
                            <a href="#" aria-current="page"
                                class="inline-block bg-indigo-200 border-indigo-500 text-indigo-800 h-9 w-9 leading-8 border text-sm font-medium rounded-full m-1 text-center">
                                1 </a>
                            <a href="#"
                                class="inline-block bg-gray-50 border-gray-500 text-gray-600 h-9 w-9 leading-8 border text-sm font-medium rounded-full m-1 text-center">
                                2 </a>

                            <span class="inline-block  text-gray-600  leading-9 text-sm font-medium m-1 text-center">
                                ... </span>
                            <a href="#"
                                class="inline-block bg-gray-50 border-gray-500 text-gray-600 h-9 w-9 leading-8 border text-sm font-medium rounded-full m-1 text-center">
                                4 </a>
                            <a href="#"
                                class="inline-block bg-gray-50 border-gray-500 text-gray-600 h-9 w-9 leading-8 border text-sm font-medium rounded-full m-1 text-center">
                                5 </a>
                            <a href="#"
                                class="inline-block bg-gray-50 border-gray-500 text-gray-600 h-9 w-9 leading-8 border text-sm font-medium rounded-full m-1 text-center">
                                <i class="fa-solid fa-caret-right"></i>
                            </a>
                        </nav>
                    </div>
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
        SearchForm: window.$func.fetchComponent(
            "components/common/SearchForm.vue"
        ),
    },
    props: {
        model: Object,
        table_snippet: Object,
        title: { type: String, default: "Listing", },
        classes: { type: String, default: "", },
        passed_return_url: { type: String, default: "", },
        dropdown_menu: { type: Array, default: () => [] },
        path_param: { type: Array, default: () => [] },
        search: { type: Array, default: () => [] },
        search_fields: { type: Array, default: () => [] },
        table_fields: { type: Array, default: () => [] },
        schema_fields: { type: Array, default: () => [] },
        recordPicker: { type: Object, default: () => { } },
        is_recordpicker: { type: Boolean, default: false },
        has_add_button: { type: Boolean, default: true },
        hide_toolbar: { type: Boolean, default: false },
        hide_delete_button: { type: Boolean, default: false },
        hide_action_button: { type: Boolean, default: false },
        hide_search_form: { type: Boolean, default: false },
        hide_select_checkbox: { type: Boolean, default: false },
    },
    created () {
        this.preparePathParam();
        this.processDropdownMenu();
        this.processFieldList();
        this.presetTableStructure();
        this.fetchRecords();

        window.$store.commit("system/has_search", true);
        window.$store.commit("system/is_list", true);
        window.$store.commit("system/is_edit", false);

        if (this.is_recordpicker) {
            window.$store.commit("system/is_recordpicker", true);
        } else {
            window.$store.commit("system/is_recordpicker", false);
        }
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
    data () {
        return {
            expanded: {},
            table_style: { "padding-bottom": "0px" },
            loading_message: "Fetching Data.",
            show_delete_btn: false,
            show_advance_form: false,
            select_list: {},
            checkedItems: [],
            opeList: [],
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
        pagination () {
            this.fetchRecords();
        },
        model: {
            handler () {
                this.fetchRecords();
            },
            deep: true,
        },
        show_advance_form () {
            const t = this;

            if (t.show_advance_form) {
                t.search = "";
            }
        },
    },

    methods: {

        getCardClassName (prefix = '') {

            return (!this.is_recordpicker) ? prefix + ' shadow-md m-1 mt-3' : ' border-0';

        },
        getClassName (table_field) {
            var full_class_name = "text-xs-left";

            if (Object.prototype.hasOwnProperty.call(table_field, "align")) {
                full_class_name = "text-xs-" + table_field.align;
            }
            return full_class_name;
        },
        changeExpandStatus (id, expanded) {
            this.$set(this.expanded, id, !expanded[id]);
        },
        preparePathParam () {
            this.processed_path_param = window.$func.pathParamHelper(
                this.path_param
            );
        },
        processDropdownMenu () {
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
        processFieldList () {
            var t = this;

            console.log('t.table_fields');
            console.log(t.table_fields);
            t.table_fields.forEach(function (table_field) {
                t.field_list.push(table_field.name);

                if (Object.prototype.hasOwnProperty.call(table_field, "foreign")) {
                    table_field.foreign.forEach(function (table_field_foreign) {
                        t.field_list.push(table_field_foreign);
                    });
                }
            });


        },

        presetTableStructure () {
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

                var table_field_name = '';
                if (
                    Object.prototype.hasOwnProperty.call(table_field, "text")
                ) {
                    table_field_name = table_field.text;
                }
                if (
                    Object.prototype.hasOwnProperty.call(table_field, "name")
                ) {
                    table_field_name = table_field.name;
                }

                var tmp_label = table_field_name
                    .replace("_id", "")
                    .replaceAll("_", " ")
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
        fetchRecords () {
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
                this.table_fields
            );
        },

        deleteRecord () {
            window.$func.deleteRecordHelper(
                this,
                this.processed_path_param,
                this.returnUrl
            );

            this.fetchRecords();
        },

        updatePagination (pagination) {
            this.fetchRecords();
        },

        // a computed getter
        addLink: function () {
            var t = this;

            window.$router.push({
                name: t.processed_path_param.dotted + ".edit",
            });

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

    },
};
</script>
