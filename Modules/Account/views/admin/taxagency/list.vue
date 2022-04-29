<template>
    <div class="app-tax-agencies">
        <div class="content-header-section separator">
            <div class="mybizna-row mybizna-between-xs">
                <div class="mybizna-col">
                    <h2 class="content-header__title">
                        {{ this.$func.__("Tax Agencies", "erp") }}
                    </h2>
                    <a
                        class="mybizna-btn btn--primary"
                        @click.prevent="showModal = true"
                    >
                        <span>{{
                            this.$func.__("Add Tax Agency", "erp")
                        }}</span>
                    </a>
                </div>
            </div>
        </div>

        <new-tax-agency
            v-if="showModal"
            :agency_id="agency_id"
            :is_update="is_update"
            @close="showModal = false"
        ></new-tax-agency>

        <div class="mybizna-row">
            <div class="table-container mybizna-col-sm-8">
                <list-table
                    tableClass="wp-ListTable widefat fixed tax-rate-list mybizna-table table-striped table-dark tax-agencies-list"
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
                </list-table>
            </div>
            <div class="mybizna-col-sm-4">
                <tax-shortcuts></tax-shortcuts>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    components: {
        ListTable: window.$func.fetchComponent("components/list-table/ListTable.vue"),
        NewTaxAgency: window.$func.fetchComponent("components/tax/NewTaxAgency.vue"),
        TaxShortcuts: window.$func.fetchComponent("components/tax/TaxShortcuts.vue"),
    },

    data() {
        return {
            showModal: false,
            modalParams: null,
            columns: {
                // 'tax_agency_id': {label: 'ID'},
                tax_agency_name: {
                    label: this.$func.__("Agency Name", "erp"),
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
                    label: this.$func.__("Trash", "erp"),
                    iconClass: "flaticon-trash",
                },
            ],
            tax_agencies: [{}],
            buttonTitle: "",
            pageTitle: "",
            url: "",
            singleUrl: "",
            isActiveOptionDropdown: false,
            agency_id: null,
            is_update: false,
        };
    },

    created() {
        this.pageTitle = this.$route.name;
        this.url = this.$route.name.toLowerCase();

        this.$root.$on("refetch_tax_data", () => {
            this.fetchItems();
            this.is_update = false;
        });

        this.$root.$on("modal_closed", () => {
            this.is_update = false;
        });

        this.fetchItems();
    },

    computed: {
        row_data() {
            const items = this.rows;
            items.map((item) => {
                item.tax_agency_id = item.id;
                item.tax_agency_name = item.name;
            });
            return items;
        },
    },

    methods: {
        fetchItems() {
            this.rows = [];
            window.axios
                .get("tax-agencies", {
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
                name: "PaginateTaxAgencies",
                params: { page: page },
                query: queries,
            });

            this.fetchItems();
        },

        singleTaxAgency(tax_id) {
            this.$router.push({
                name: "SingleTaxAgency",
                params: { id: tax_id },
            });
        },

        onActionClick(action, row, index) {
            switch (action) {
                case "trash":
                    if (confirm(this.$func.__("Are you sure to delete?", "erp"))) {
                        window.axios
                            .delete("tax-agencies" + "/" + row.id)
                            .then((response) => {
                                this.$delete(this.rows, index);
                                this.showAlert(
                                    "success",
                                    this.$func.__("Deleted !", "erp")
                                );
                            });
                    }
                    break;

                case "edit":
                    this.showModal = true;
                    this.agency_id = row.id;
                    this.is_update = true;
                    this.fetchItems();
                    break;

                default:
                    break;
            }
        },

        onBulkAction(action, items) {
            if (action === "trash") {
                if (confirm(this.$func.__("Are you sure to delete?", "erp"))) {
                    window.axios
                        .delete("tax-agencies/delete/" + items.join(","))
                        .then((response) => {
                            const toggleCheckbox =
                                document.getElementsByClassName("column-cb")[0]
                                    .childNodes[0];

                            if (toggleCheckbox.checked) {
                                // simulate click event to remove checked state
                                toggleCheckbox.click();
                            }

                            this.fetchItems();
                            this.showAlert(
                                "success",
                                this.$func.__("Deleted !", "erp")
                            );
                        });
                }
            }
        },
    },
};
</script>

<style>
.table-container {
    width: 600px;
}

.app-tax-agencies .check-column {
    padding: 20px !important;
}

@media (min-width: 783px) {
    .app-tax-agencies .actions {
        text-align: right;
    }

    .app-tax-agencies .col--actions {
        float: left !important;
    }
    .app-tax-agencies .row-actions {
        text-align: right !important;
    }
}
</style>
