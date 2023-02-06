<template>
    <div :class="classes">
        <div :class="'card ' + getCardClassName()">
            <div class="card-head">
                <div class="flex">
                    <div class="flex-auto">
                        <div v-if="!is_recordpicker" class="py-2">
                            <h3 class="inline-block font-medium text-lg text-gray ml-2 mr-5 mb-0">{{ title }}</h3>
                        </div>
                    </div>
                    <div class="flex-auto">
                        <div class="text-right  pt-2">
                            <a class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm  py-2 px-3  text-center mr-2"
                                @click="addLink()">
                                <i class="fa fa-plus"></i>
                                Add New
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-body p-0">
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
                                    <img class="inline-block w-36 m-6"
                                        :src='this.$assets_url + "/images/no_data_found.svg"'>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-foot">
                <div class="w-full row">
                    <div class="col-4 col-sm-4">
                        <FormKit id="page_limit" type="select" v-model="pagination.limit" :options="pagination.limits"
                            validation="required" input-class="$reset form-select form-select-sm
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
                                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" />


                    </div>
                    <div class="col-8 col-sm-4 text-center pt-3">

                        <p class="text-center text-sm text-gray-700">
                            Showing Page
                            <span class="font-medium">{{ pagination.page }}</span>
                            of
                            <span class="font-medium">{{ pagination.pages }}</span>
                            results.
                        </p>
                    </div>
                    <div class="col-sm-4">
                        <nav class="text-right" aria-label="Pagination">

                            <!-- Current: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" -->

                            <template v-if="pagination.pages <= 5">
                                <a v-for="index in getNumbers(1, pagination.pages)" :key="index" href="#"
                                    :aria-current="index == pagination.page ? 'page' : ''"
                                    :class="[(index == pagination.page ? 'bg-gray-500 text-gray-50' : '')]"
                                    class="inline-block bg-gray-50 border-gray-500 text-gray-600 h-9 w-9 leading-8 border text-sm font-medium rounded-full m-1 text-center"
                                    @click="loadPage(index)">
                                    {{ index }} </a>
                            </template>

                            <template v-else>
                                <a class="cursor-pointer inline-block bg-gray-50 border-gray-500 text-gray-600 h-9 w-9 leading-8 border text-sm font-medium rounded-full m-1 text-center"
                                    @click="loadPage(1)">
                                    <i class="fa-solid fa-caret-left"></i>
                                </a>
                                <a v-for="index in getNumbers(1, 3)" :key="index"
                                    :aria-current="index == pagination.page ? 'page' : ''"
                                    :class="[(index == pagination.page ? 'bg-gray-500 text-gray-50' : '')]"
                                    class="cursor-pointer inline-block bg-gray-50 border-gray-500 text-gray-600 h-9 w-9 leading-8 border text-sm font-medium rounded-full m-1 text-center"
                                    @click="loadPage(index)">
                                    {{ index }} </a>
                                <span
                                    class="inline-block  text-gray-600  leading-9 text-sm font-medium m-1 text-center">
                                    ... </span>
                                <a v-for="index in getNumbers(pagination.pages - 2, pagination.pages)" :key="index"
                                    :aria-current="index == pagination.page ? 'page' : ''"
                                    :class="[(index == pagination.page ? 'bg-gray-500 text-gray-50' : '')]"
                                    class="cursor-pointer inline-block bg-gray-50 border-gray-500 text-gray-600 h-9 w-9 leading-8 border text-sm font-medium rounded-full m-1 text-center"
                                    @click="loadPage(index)">
                                    {{ index }} </a>
                                <a :class="[(index == pagination.page ? 'bg-gray-500 text-gray-50' : '')]"
                                    class="cursor-pointer inline-block bg-gray-50 border-gray-500 text-gray-600 h-9 w-9 leading-8 border text-sm font-medium rounded-full m-1 text-center"
                                    @click="loadPage(pagination.pages)">
                                    <i class="fa-solid fa-caret-right"></i>
                                </a>
                            </template>
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
            "components/widgets/TdRender.vue"
        ),
        MenuDropdown: window.$func.fetchComponent(
            "components/widgets/MenuDropdown.vue"
        ),
    },
    props: {
        model: Object,
        table_snippet: Object,
        title: { type: String, default: "Listing", },
        classes: { type: String, default: "", },
        module: { type: String, default: "", },
        table: { type: String, default: "", },
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
    created() {
      
        this.preparePathParam();
        this.processDropdownMenu();
        this.processFieldList();
        this.presetTableStructure();
        this.fetchRecords();

        window.$store.commit("system/subtitle", this.title);
        window.$store.commit("system/has_search", true);
        window.$store.commit("system/search_fields", this.search_fields);
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
    data() {
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
                page: 1,
                pages: 1,
                total: 0,
                limit: 10,
                limits: [5, 10, 20, 50, 100, 200],
            },
            schema: {
                fields: [],
            },
            formOptions: {
                validateAfterLoad: true,
                validateAfterChanged: true,
                fieldIdPrefix: "user-",
            },
            table_list: {
                selected: [],
                headers: [],
            },
        };
    },
    watch: {
        // whenever question changes, this function will run
        'pagination.limit'(newQuestion, oldQuestion) {
            this.pagination.page = 1;
            this.fetchRecords();
        },
        /*pagination () {
            this.fetchRecords();
        },*/
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
        loadPage: function (page) {

            if (page < 1) {
                page = 1;
            } else if (page > this.pagination.pages) {
                page = this.pagination.pages;
            }

            this.pagination.page = page;

            this.fetchRecords();
        },
        getNumbers: function (start, stop) {
            var tmp_array = new Array(stop - start).fill(start).map((n, i) => n + i);
            tmp_array.push(stop);
            return tmp_array;
        },
        getCardClassName(prefix = '') {
            return (!this.is_recordpicker) ? prefix + ' shadow-md m-1 mt-3' : ' border-0';
        },
        getClassName(table_field) {
            var full_class_name = "text-left";

            if (Object.prototype.hasOwnProperty.call(table_field, "align")) {
                full_class_name = "text-" + table_field.align;
            }
            return full_class_name;
        },
        changeExpandStatus(id, expanded) {
            this.$set(this.expanded, id, !expanded[id]);
        },
        preparePathParam() {
            var path_param = [];

            if (this.path_param.length !== 0) {
                path_param = this.path_param;
            } else {
                path_param = [this.module, this.table];
            }
            
            this.$emitter.emit("system-set-store", { module: path_param[0], table: path_param[1], search_fields: this.search_fields });
         
            this.processed_path_param = window.$func.pathParamHelper(path_param);
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
                param: ["id"],
            });
        },
        processFieldList() {
            var t = this;

            t.table_fields.forEach(function (table_field) {
                t.field_list.push(table_field.name);

                if (Object.prototype.hasOwnProperty.call(table_field, "foreign")) {
                    table_field.foreign.forEach(function (table_field_foreign) {
                        t.field_list.push(table_field.name + '.' + table_field_foreign);
                    });
                }
            });

        },

        presetTableStructure() {
            var t = this;

            if (window.is_backend) {
                t.table_list.headers.push({
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
                    Object.prototype.hasOwnProperty.call(table_field, "label")
                ) {
                    table_field_name = table_field.label;
                }
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

                t.table_list.headers.push({
                    label: tmp_label,
                    key: table_field.name.toLowerCase(),
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
                this.table_fields
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

        // a computed getter
        addLink: function () {
            var t = this;

            window.$router.push({
                name: t.processed_path_param.dotted + ".create",
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
