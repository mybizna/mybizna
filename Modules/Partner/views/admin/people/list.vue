<template>
    <div class="app-customers">
        <div class="people-header">

            <Modal :title="'Title'" :msg="errorMgs" :visible="showModal" :newcomponent="newcomponent" />
           
            <h2 class="add-new-people">
                <span>{{ pageTitle }}</span>
                <a
                    href=""
                    id="erp-customer-new"
                    @click.prevent="showModal = true"
                    >{{ this.$func.__("Add New", "erp") }} {{ buttonTitle }}</a
                >
            </h2>

            <div class="erp-btn-group">
                <button @click.prevent="showImportModal = true">
                    {{ this.$func.__("Import", "erp") }}
                </button>
                <button @click.prevent="showExportModal = true">
                    {{ this.$func.__("Export", "erp") }}
                </button>
            </div>

        </div>

        <people-modal
            v-if="showModal"
            :people.sync="people"
            :title="buttonTitle"
            @close="showModal = false"
        />

        <import-modal
            v-if="showImportModal"
            :title="importTitle"
            :type="url"
            @close="showImportModal = false"
        />

        <export-modal
            v-if="showExportModal"
            :title="exportTitle"
            :type="url"
            @close="showExportModal = false"
        />
        i
        <list-table
            tableClass="table table-sm people-table table table-striped "
            action-column="actions"
            :columns="columns"
            :rows="row_data"
            :bulk-actions="bulkActions"
            :total-items="paginationData.totalItems"
            :total-pages="paginationData.totalPages"
            :per-page="paginationData.perPage"
            :current-page="paginationData.currentPage"
            @pagination="goToPage"
            :actions="actions"
            @action:click="onActionClick"
            @bulk:click="onBulkAction"
        >
            <template slot="title" slot-scope="data">
                <strong
                    ><a href="#">{{ data.row.title }}</a></strong
                >
            </template>
            <template slot="customer" slot-scope="data">
                <strong>
                    <router-link
                        :to="{
                            name: singleUrl,
                            params: { id: data.row.id, route: url },
                        }"
                    >
                        {{ data.row.customer }}
                    </router-link>
                </strong>
            </template>
        </list-table>
    </div>
</template>

<script>

export default {
    components: {
        ListTable: window.$func.fetchComponent('components/list-table/ListTable.vue'),
        PeopleModal: window.$func.fetchComponent('partner/widgets/PeopleModal.vue'),
        ImportModal: window.$func.fetchComponent('partner/widgets/PeopleModal.vue'),
        ExportModal: window.$func.fetchComponent('partner/widgets/PeopleModal.vue'),
        Modal: window.$func.fetchComponent('components/modal/Modal.vue'),
    },

    data() {
        return {
            newcomponent:window.$func.fetchComponent('partner/widgets/PeopleModal.vue'),
            errorMgs: "sdfdsfds",
            people: null,
            bulkActions: [
                {
                    key: "trash",
                    label: this.$func.__("Move to Trash", "erp"),
                    iconClass: "flaticon-trash",
                },
            ],
            columns: {
                customer: { label: this.$func.__("Name", "erp"), isColPrimary: true },
                company: { label: this.$func.__("Company", "erp") },
                email: { label: this.$func.__("Email", "erp") },
                phone: { label: this.$func.__("Phone", "erp") },
                actions: { label: this.$func.__("Actions", "erp") },
            },
            rows: [],
            paginationData: {
                totalItems: 0,
                totalPages: 0,
                perPage: 20,
                currentPage:
                    this.$route.params.page === undefined
                        ? 1
                        : parseInt(this.$route.params.page),
            },
            actions: [
                {
                    key: "edit",
                    label: this.$func.__("Edit", "erp"),
                    iconClass: "flaticon-edit",
                },
                {
                    key: "trash",
                    label: this.$func.__("Delete", "erp"),
                    iconClass: "flaticon-trash",
                },
            ],
            search: "",
            showModal: false,
            showImportModal: false,
            showExportModal: false,
            buttonTitle: "",
            importTitle: "",
            exportTitle: "",
            pageTitle: "",
            url: "",
            singleUrl: "",
            isActiveOptionDropdown: false,
        };
    },
    emits: {
        // Validate submit event
        "imported-people": () => {
            this.showImportModal = false;
            this.fetchItems();
            return true;
        },
        "modal-close": () => {
          this.showModal = false;
            this.showImportModal = false;
            this.showExportModal = false;
            this.people = null;
            return true;
        },
        peopleUpdate: () => {
            this.showModal = false;
        this.fetchItems();
            return true;
        },
    },
    created() {



        this.buttonTitle =
            this.$route.name.toLowerCase() === "customers"
                ? this.$func.__("Customer", "erp")
                : this.$func.__("Vendor", "erp");
        this.importTitle =
            this.$route.name.toLowerCase() === "customers"
                ? this.$func.__("Import Customers", "erp")
                : this.$func.__("Import Vendors", "erp");
        this.exportTitle =
            this.$route.name.toLowerCase() === "customers"
                ? this.$func.__("Export Customers", "erp")
                : this.$func.__("Export Vendors", "erp");
        this.pageTitle =
            this.$route.name.toLowerCase() === "customers"
                ? this.$func.__("Customers", "erp")
                : this.$func.__("Vendors", "erp");
        this.url = this.$route.name.toLowerCase();
        this.singleUrl =
            this.url === "customers" ? "CustomerDetails" : "VendorDetails";

        this.fetchItems();
    },

    computed: {
        row_data() {
            const items = this.rows;
            items.map((item) => {
                item.customer = item.first_name + " " + item.last_name;
            });
            return items;
        },
    },

    watch: {
        search(newVal, oldVal) {
            this.fetchItems();
        },
    },

    methods: {
        fetchItems() {
            this.rows = [];
            window.axios
                .get(this.url, {
                    params: {
                        per_page: this.paginationData.perPage,
                        page:
                            this.$route.params.page === undefined
                                ? this.paginationData.currentPage
                                : this.$route.params.page,
                        search: this.search,
                    },
                })
                .then((response) => {
                    this.rows = response.data;
                    this.paginationData.totalItems = parseInt(
                        response.headers["x-wp-total"]
                    );
                    this.paginationData.totalPages = parseInt(
                        response.headers["x-wp-totalpages"]
                    );
                })
                .catch((error) => {
                    throw error;
                });
        },

        onActionClick(action, row, index) {
            switch (action) {
                case "trash":
                    if (confirm( this.$func.__("Are you sure to delete?", "erp"))) {
                        window.axios
                            .delete(this.url + "/" + row.id)
                            .then((response) => {
                                if (response.status !== 204) {
                                    this.showAlert(
                                        "error",
                                        response.data.data[0].message
                                    );
                                    // or loop through the erros and show a list
                                    return;
                                }

                                this.$delete(this.rows, index);
                                this.showAlert("success", "Deleted !");

                                this.fetchItems();
                            })
                            .catch((error) => {
                                throw error;
                            });
                    }
                    break;

                case "edit":
                    this.showModal = true;
                    this.people = row;
                    break;

                default:
                    break;
            }
        },

        onBulkAction(action, items) {
            if (action === "trash") {
                if (confirm( this.$func.__("Are you sure to delete?", "erp"))) {
                    window.axios
                        .delete(this.url + "/delete/" + items.join(","))
                        .then((response) => {
                            if (response.status !== 204) {
                                this.showAlert(
                                    "error",
                                    response.data.data[0].message
                                );

                                return;
                            }

                            const toggleCheckbox =
                                document.getElementsByClassName("column-cb")[0]
                                    .childNodes[0];

                            if (toggleCheckbox.checked) {
                                // simulate click event to remove checked state
                                toggleCheckbox.click();
                            }

                            this.fetchItems();
                            this.showAlert("success", this.$func.__("Deleted !", "erp"));
                        })
                        .catch((error) => {
                            throw error;
                        });
                }
            }
        },

        goToPage(page) {
            const queries = Object.assign({}, this.$route.query);
            this.paginationData.currentPage = page;

            this.$router.push({
                name:
                    this.url === "customers"
                        ? "PaginateCustomers"
                        : "PaginateVendors",
                params: { page: page },
                query: queries,
            });

            this.fetchItems();
        },
    },
};
</script>
<style>
.app-customers .people-header {
    display: flex;
    align-items: center;
}
.app-customers .people-header .add-new-people {
    align-items: center;
    display: flex;
    width: 65%;
    margin: 0;
    padding: 0;
}

.app-customers .people-header .add-new-people a {
    background: #1a9ed4;
    border-radius: 3px;
    color: #fff;
    font-size: 12px;
    height: 29px;
    line-height: 29px;
    margin-left: 13px;
    text-align: center;
    text-decoration: none;
    width: 150px;
}
@media (max-width: 782px) and (min-width: 768px) {
    .app-customers .people-header .add-new-people a {
        margin-right: 18rem;
        margin-bottom: 3px;
        max-width: 120px;
    }
}

@media (max-width: 767px) and (min-width: 707px) {
    .app-customers .people-header .add-new-people a {
        margin-right: 16rem;
        margin-bottom: 3px;
    }
}

@media (max-width: 706px) and (min-width: 651px) {
    .app-customers .people-header .add-new-people a {
        margin-right: 14rem;
        margin-bottom: 3px;
    }
}

@media (max-width: 650px) {
    .app-customers .people-header .add-new-people a {
        margin-right: 12rem;
        margin-bottom: 3px;
    }
}

.app-customers .people-header .widefat tfoot td,
.app-customers .people-header .widefat tbody th {
    line-height: 2.5em;
}
.app-customers .people-header .widefat tbody td {
    line-height: 3em;
}

.app-customers .people-header .people-table {
    border-radius: 3px;
}
.app-customers .people-header .people-table tbody {
    background: #fafafa;
}
.app-customers .people-header .people-table th ul,
.app-customers .people-header .people-table th li {
    margin: 0;
}
.app-customers .people-header .people-table th li {
    display: flex;
    align-items: center;
}
.app-customers .people-header .people-table th li img {
    width: 14px;
    padding-right: 5px;
}

.app-customers .people-header .people-table .check-column input {
    border-color: #e7e7e7;
    box-shadow: none;
    border-radius: 3px;
}
.app-customers .people-header .people-table .check-column input:checked {
    background: #1abc9c;
    border-color: #1abc9c;
    border-radius: 3px;
}
.app-customers .people-header .people-table .check-column input:before {
    color: #fff;
}
@media (min-width: 783px) {
    .app-customers .people-header .col--actions {
        float: left !important;
    }
}
.row-actions {
    padding-left: 20px !important;
    text-align: left !important;
}
.app-customers .people-header .check-column {
    padding: 20px !important;
}

@media (max-width: 650px) {
    .app-customers .search-btn {
        display: none;
    }
}

@media (max-width: 479px) {
    .app-customers .people-search {
        margin-top: 20px;
    }
}

.erp-btn-group {
    display: inline-flex;
    position: absolute;
    right: 17.5rem;
}
.erp-btn-group :after {
    content: "";
    clear: both;
    display: table;
}

@media (max-width: 782px) {
    .erp-btn-group {
        right: 17rem;
        margin-top: 23px;
    }
}

@media (max-width: 650px) {
    .erp-btn-group {
        right: 8.5rem;
    }
}

.erp-btn-group button {
    padding: 5px 15px;
    border: 0.3px solid rgb(226, 226, 226);
    background-color: #fff;
    color: rgba(0, 0, 0, 0.6);
    font-size: 12px;
    font-weight: 400;
    text-decoration: none;
    line-height: inherit;
    cursor: pointer;
}
@media (max-width: 479px) {
    .erp-btn-group button {
        padding: 5px;
    }
}

.erp-btn-group button:last-child {
    border-top-right-radius: 3.5px;
    border-bottom-right-radius: 3.5px;
}

.erp-btn-group button:first-child {
    border-top-left-radius: 3.5px;
    border-bottom-left-radius: 3.5px;
}

.erp-btn-group button:not(:last-child) {
    border-right: none;
}

.erp-btn-group button:hover {
    background-color: #1a9ed4;
    color: #fff;
}
</style>
