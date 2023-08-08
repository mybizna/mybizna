<template>
    <div :class="classes">
        <div :class="'card ' + getCardClassName()">
            <div v-if="$store.state.system.menu_type != 'sidebar'" class="card-head">
                <div class="flex">
                    <div class="flex-auto">
                        <div v-if="!settings.is_recordpicker" class="py-2">
                            <h3 class="inline-block font-medium text-lg text-gray ml-2 mr-5 mb-0">{{ title }}</h3>
                        </div>
                    </div>

                    <div v-if="!settings.is_recordpicker && !settings.hide_action_button" class="flex-auto">
                        <div class="text-right  pt-2">
                            <a class="whitespace-nowrap text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm  py-2 px-3  text-center mr-2"
                                @click="addLink()">
                                <i class="fa fa-plus"></i>
                                Add New
                            </a>
                        </div>
                    </div>
                    <div v-if="settings.is_recordpicker" class="flex-auto">
                        <search-form></search-form>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="relative">
                    <div class="overflow-x-auto" v-bind:style="table_style">
                        <table class="table m-0 p-0">
                            <thead>
                                <tr class="bg-slate-100 px-7">

                                    <th v-if="!settings.is_recordpicker && !settings.hide_action_button"
                                        class="text-center uppercase w-2.5 whitespace-nowrap">
                                        <input @click="checkedItemsAll" type="checkbox" />
                                        <span class="form-check-sign">
                                            <span class="check"></span>
                                        </span>
                                    </th>

                                    <th v-if="!this.settings.is_recordpicker && !this.settings.hide_action_button"
                                        class="uppercase w-2.5"></th>

                                    <slot name="header">
                                        <th class="uppercase" scope="col" v-for="(
                                                                table_field, index
                                                            ) in table_list.headers" :key="index"
                                            :style="table_field.style"
                                            :class="table_field.class + ' text-center uppercase whitespace-nowrap p-1.5'">
                                            {{ table_field.label }}
                                        </th>
                                    </slot>

                                </tr>
                            </thead>
                            <tbody class="border-none">
                                <template v-if="items.length">
                                    <tr v-for="(item, index) in items" :key="index"
                                        class="border-b-sky-200 hover:bg-slate-50 border-b border-b-sky-100">

                                        <td v-if="!settings.is_recordpicker && !settings.hide_action_button"
                                            class="text-center">
                                            <input :value="item.id" v-model="checkedItems" class="form-check-input"
                                                type="checkbox" name="item[]" />
                                            <span class="form-check-sign">
                                                <span class="check"></span>
                                            </span>
                                        </td>

                                        <td v-if="!settings.hide_action_button">
                                            <menu-dropdown v-if="!settings.is_recordpicker" :field_list="field_list"
                                                :pitem="item" :dropdown_menu_list="dropdown_menu_list"></menu-dropdown>
                                            <a v-else class="btn btn-primary btn-sm text-white"
                                                @click="recordPicker(item.id)">Select</a>
                                        </td>

                                        <slot name="body" :item="item">
                                            <template v-for="(table_field, index) in table_fields">
                                                <slot :name="table_field.name" :item="item">
                                                    <template v-if="'actions' !== table_field.name">
                                                        <td-render :key="index" :field_list="field_list" :pitem="item"
                                                            :data_field="table_field" :class_name="getClassName(table_field)
                                                                "></td-render>
                                                    </template>
                                                </slot>
                                            </template>
                                        </slot>
                                    </tr>
                                </template>
                                <tr class="border-b-sky-200" v-else>
                                    <td colspan="20" class="text-center hover:bg-slate-50">
                                        <img class="inline-block w-36 m-6"
                                            :src="this.$assets_url + '/images/no_data_found.svg'">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-foot">

                <pagination v-if="$store.state.system.window_width < ($responsive_point - 268)" :pagination="pagination"
                    :loadPage="loadPage" @update_page="updatePage">
                </pagination>

                <div class="flex">
                    <div class="flex-auto">
                        <FormKit id="page_limit" type="select" v-model="pagination.limit" :options="pagination.limits"
                            validation="required"
                            input-class="$reset form-select form-select-sm
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
                    <div class="flex-auto">
                        <pagination v-if="$store.state.system.window_width >= ($responsive_point - 268)"
                            :pagination="pagination" :loadPage="loadPage" @update_page="updatePage"></pagination>
                    </div>
                    <div class="flex-auto">
                        <div v-if="!settings.is_recordpicker && !settings.hide_action_button && !(settings.hide_delete_button && !mass_actions.length)"
                            class="text-right pr-2">

                            <button class="mt-2 bg-blue-50 border-blue-200 btn btn-sm dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" dot>
                                Mass Actions
                            </button>

                            <ul class="dropdown-menu py-0" aria-labelledby="dropdownMenuLink">
                                <li v-if="!settings.hide_delete_button">
                                    <a class="dropdown-item cursor-point" @click="deleteCheckedItems()">Delete</a>
                                </li>
                            </ul>
                        </div>
                    </div>


                </div>


            </div>
        </div>
    </div>
</template>

<script>
/* eslint-disable vue/no-mutating-props */
import TdRender from "@/components/widgets/TdRender";
import MenuDropdown from "@/components/widgets/MenuDropdown";
import Pagination from "@/components/widgets/Pagination";
import SearchForm from "@/components/common/SearchForm";

export default {
    components: {
        TdRender,
        MenuDropdown,
        Pagination,
        SearchForm
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
        table_fields: { type: Array, default: () => [] },
        mass_actions: { type: Array, default: () => [] },
        recordPicker: { type: Object, default: () => { } },
        setting: { type: Object, default: () => { } },
    },
    data() {
        return {
            expanded: {},
            table_style: { "padding-bottom": "0px" },
            loading_message: "Fetching Data.",
            show_delete_btn: false,
            has_checked_items: false,
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
            settings: {
                is_recordpicker: false,
                has_add_button: true,
                hide_toolbar: false,
                hide_delete_button: false,
                hide_action_button: false,
                hide_search_form: false,
                hide_select_checkbox: false,
            }
        };
    },
    watch: {
        // whenever question changes, this function will run
        'pagination.limit'(newer, older) {
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
    },
    created() {
        this.settings = { ...this.settings, ...this.setting };

        this.preparePathParam();
        this.processDropdownMenu();
        this.fetchRecords();

        window.$store.commit("system/subtitle", this.title);
        window.$store.commit("system/has_search", true);
        window.$store.commit("system/is_list", true);
        window.$store.commit("system/is_edit", false);

        if (this.is_recordpicker) {
            window.$store.commit("system/is_recordpicker", true);
        } else {
            window.$store.commit("system/is_recordpicker", false);
        }
    },

    mounted() {
        this.$emitter.on('search-records', async (status) => {
            if (status) {
                this.fetchRecords();
            }
        });

        this.$emitter.on('delete-record', async (setting) => {

            await this.deleteRecords(setting.ids);

            this.fetchRecords();

            if (Object.prototype.hasOwnProperty.call(setting, "path")) {
                if (setting.path.type == 'link') {
                    this.$router.push(setting.path.link);
                } else {
                    this.$router.push({ name: setting.path.link });
                }
            }
        });
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

    methods: {
        updatePage(page = 0) {
            console.log(page);
            this.pagination.page = page;
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
        deleteCheckedItems() {

            var that = this;

            if (!that.checkedItems.length) {
                this.$confirm({ message: ' There are no Selected Items.', button: { yes: 'OK' }, });
            } else {
                var message = `Are you sure you want to <b class="whitespace-nowrap text-red-500">Delete All ${that.checkedItems.length} </b> selected Records?`;
                this.$confirm(
                    {
                        message: message, button: { no: 'No', yes: 'Yes' },
                        callback: confirm => {
                            if (confirm) {
                                that.deleteRecords(that.checkedItems);
                                that.checkedItems = [];
                                that.has_checked_items = false;

                            }
                        }
                    }
                )
            }
        },
        checkedItemsAll() {

            if (!this.has_checked_items) {

                this.items.forEach(item => {
                    this.checkedItems.push(item.id);
                });

                this.has_checked_items = true;
            } else {
                this.checkedItems = [];
                this.has_checked_items = false;

            }

        },
        preparePathParam() {

            this.$store.commit('system/search_path_params', this.path_param);

            this.processed_path_param = window.$func.pathParamHelper(this.path_param);

            this.$store.commit('system/path_params', this.processed_path_param);
        },
        processDropdownMenu() {
            const t = this;

            t.dropdown_menu_list.push({
                title: "Edit",
                icon: "fa fa-pencil",
                type: "router",
                name: this.processed_path_param.dotted + ".edit",
                param: ["id"],
            });

            t.dropdown_menu.forEach(function (dropdown_menu_single) {
                if (Object.prototype.hasOwnProperty.call(dropdown_menu_single, "type")) {
                    dropdown_menu_single['type'] = "event";
                }
                t.dropdown_menu_list.push(dropdown_menu_single);
            });

            if (!this.settings.hide_delete_button) {
                t.dropdown_menu_list.push({
                    title: "Delete",
                    icon: "fa fa-trash",
                    type: "event",
                    name: this.processed_path_param.dotted + ".delete",
                    event: "delete-record",
                    return: this.processed_path_param.dotted + ".list",
                });

            }


        },
        loadPage: function (page = '') {

            if (page == '') {
                page = this.pagination.page;
            }

            if (page < 1) {
                page = 1;
            } else if (page > this.pagination.pages) {
                page = this.pagination.pages;
            }

            this.pagination.page = page;

            this.fetchRecords();
        },
        fetchRecords() {
            var t = this;
            var query_params = t.$route.query;

            for (var key in query_params) {
                if (Object.prototype.hasOwnProperty.call(t.model, key)) {
                    t.model[key] = query_params[key];
                }
            }

            window.$func.fetchRecordsHelper(this, this.processed_path_param, this.table_fields);
        },

        async deleteRecords(ids) {
            var results = await window.$func.deleteRecordHelper(this, this.processed_path_param, ids);

            this.fetchRecords();

            return results;
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
