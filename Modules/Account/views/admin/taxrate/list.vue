<template>
    <div class="app-taxes">
        <div class="content-header-section separator">
            <div class="mybizna-row mybizna-between-xs">
                <div class="mybizna-col">
                    <h2 class="content-header__title">
                        {{ this.$func.__("Tax Rates", "erp") }}
                    </h2>
                    <a
                        class="mybizna-btn btn--primary"
                        @click.prevent="newTaxRate"
                        id="add-tax-rate"
                    >
                        <span>{{ this.$func.__("Add Tax Rate", "erp") }}</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="mybizna-row">
            <div class="table-container mybizna-col-sm-8">
                <list-table
                    tableClass="wp-ListTable table-sm widefat fixed tax-rate-list mybizna-table table-striped table-taxrates"
                    action-column="actions"
                    :columns="columns"
                    :rows="row_data"
                    :total-items="paginationData.totalItems"
                    :total-pages="paginationData.totalPages"
                    :per-page="paginationData.perPage"
                    :current-page="paginationData.currentPage"
                    @pagination="goToPage"
                    :actions="actions"
                    :bulk-actions="bulkActions"
                    @action:click="onActionClick"
                    @bulk:click="onBulkAction"
                >
                    <template slot="tax_rate_name" slot-scope="data">
                        <strong>
                            <a
                                href="#"
                                @click.prevent="
                                    singleTaxRate(
                                        data.row.tax_id,
                                        data.row.tax_rate_name
                                    )
                                "
                            >
                                {{ data.row.tax_rate_name }}</a
                            >
                        </strong>
                    </template>
                </list-table>
            </div>
            <div class="mybizna-col-sm-4">
                <tax-shortcuts></tax-shortcuts>
            </div>
        </div>

        <new-tax-zone v-if="taxrateModal" @close="taxrateModal = false" />
        <new-tax-category v-if="taxcatModal" @close="taxcatModal = false" />
        <new-tax-agency v-if="taxagencyModal" @close="taxagencyModal = false" />
    </div>
</template>

<script>

export default {
    components: {
        ListTable: window.$func.fetchComponent('components/list-table/ListTable.vue'),
        NewTaxZone: window.$func.fetchComponent('components/tax/NewTaxZone.vue'),
        NewTaxCategory: window.$func.fetchComponent('components/tax/NewTaxCategory.vue'),
        NewTaxAgency: window.$func.fetchComponent('components/tax/NewTaxAgency.vue'),
        TaxShortcuts: window.$func.fetchComponent('components/tax/TaxShortcuts.vue'),
    },

    data() {
        return {
            modalParams: null,
            columns: {
                tax_rate_name: {
                    label: this.$func.__("Tax Zone Name", "erp"),
                    isColPrimary: true,
                },
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
            bulkActions: [
                {
                    key: "trash",
                    label: this.$func.__("Move to Trash", "erp"),
                    iconClass: "flaticon-trash",
                },
            ],
            new_entities: [
                { namedRoute: "NewTaxZone", name: this.$func.__("New Tax Zone", "erp") },
                {
                    namedRoute: "NewTaxCategory",
                    name: this.$func.__("New Tax Category", "erp"),
                },
                {
                    namedRoute: "NewTaxAgency",
                    name: this.$func.__("New Tax Agency", "erp"),
                },
            ],
            taxes: [{}],
            buttonTitle: "",
            pageTitle: "",
            url: "",
            singleUrl: "",
            tax_rate: null,
            isActiveOptionDropdown: false,
            tax_rate_id: null,
            taxrateModal: false,
            taxcatModal: false,
            taxagencyModal: false,
        };
    },

    created() {
        this.fetchItems();

        this.$root.$on("comboSelected", (data) => {
            switch (data.namedRoute) {
                case "NewTaxZone":
                    this.taxrateModal = true;
                    break;
                case "NewTaxCategory":
                    this.taxcatModal = true;
                    break;
                case "NewTaxAgency":
                    this.taxagencyModal = true;
                    break;
                default:
                    break;
            }
        });
    },

    computed: {
        row_data() {
            const items = this.rows;

            if (items.length) {
                items.map((item) => {
                    item.tax_id = item.id;
                    if (item.default === 0) {
                        item.default = "-";
                    } else {
                        item.default = this.$func.__("Default", "erp");
                    }
                });

                return items;
            }

            return [];
        },
    },

    methods: {
        fetchItems() {
            this.rows = [];

            window.axios
                .get("/taxes", {
                    params: {
                        per_page: this.paginationData.perPage,
                        page:
                            this.$route.params.page === undefined
                                ? this.paginationData.currentPage
                                : this.$route.params.page,
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
        goToPage(page) {
            const queries = Object.assign({}, this.$route.query);
            this.paginationData.currentPage = page;
            this.$router.push({
                name: "PaginateTaxRates",
                params: { page: page },
                query: queries,
            });

            this.fetchItems();
        },

        newTaxRate() {
            this.$router.push({ name: "NewTaxRate" });
        },

        singleTaxRate(tax_id, tax_rate_name) {
            this.$router.push({
                name: "SingleTaxRate",
                params: { id: tax_id, name: tax_rate_name },
            });
        },

        onActionClick(action, row, index) {
            switch (action) {
                case "trash":
                    if (confirm(this.$func.__("Are you sure to delete?", "erp"))) {
                        window.axios
                            .delete("/taxes/" + row.id)
                            .then((response) => {
                                this.$delete(this.rows, index);
                                this.showAlert(
                                    "success",
                                    this.$func.__("Deleted !", "erp")
                                );
                            })
                            .catch((error) => {
                                throw error;
                            });
                    }
                    break;

                case "edit":
                    this.$router.push({
                        name: "EditSingleTaxRate",
                        params: { id: row.id },
                    });
                    break;

                default:
                    break;
            }
        },

        onBulkAction(action, items) {
            if (action === "trash") {
                if (confirm(this.$func.__("Are you sure to delete?", "erp"))) {

                    window.axios
                        .delete("taxes/delete/" + items.join(","))
                        .then((response) => {
                            const toggleCheckbox =
                                document.getElementsByClassName("column-cb")[0]
                                    .childNodes[0];

                            if (toggleCheckbox.checked) {
                                // simulate click event to remove checked state
                                toggleCheckbox.click();
                            }

                            this.fetchItems();
                        })
                        .catch((error) => {
                            throw error;
                        });
                }
            }
        },
    },
};
</script>
<style>
.app-taxes .table-container {
    width: 600px;
}

.app-taxes .check-column {
    padding: 20px !important;
}

@media (min-width: 783px) {
    .app-taxes .actions {
        text-align: right;
    }

    .app-taxes .col--actions {
        float: right !important;
    }
    .app-taxes .row-actions {
        text-align: right !important;
    }
}
</style>
