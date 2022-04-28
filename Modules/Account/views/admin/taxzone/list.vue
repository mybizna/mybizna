<template>
    <div class="app-tax-zones">
        <div class="content-header-section separator">
            <div class="mybizna-row mybizna-between-xs">
                <div class="mybizna-col">
                    <h2 class="content-header__title">
                        {{ window.$func.__("Tax Zones", "erp") }}
                    </h2>
                    <a
                        class="mybizna-btn btn--primary"
                        @click.prevent="showModal = true"
                    >
                        <span>{{ window.$func.__("Add Tax Zone", "erp") }}</span>
                    </a>
                </div>
            </div>
        </div>

        <new-tax-zone
            v-if="showModal"
            :rate_name_id="rate_name_id"
            :is_update="is_update"
            @close="showModal = false"
        ></new-tax-zone>

        <div class="mybizna-row">
            <div class="table-container mybizna-col-sm-8">
                <list-table
                    tableClass="wp-ListTable widefat fixed tax-zone-list mybizna-table table-striped table-dark"
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
                    <template slot="default" slot-scope="data">
                        {{ "1" === data.row.default ? "&#x02713;" : "" }}
                    </template>
                </list-table>
            </div>
            <div class="mybizna-col-sm-4">
                <tax-shortcuts></tax-shortcuts>
            </div>
        </div>
    </div>
</template>

<script>
import ListTable from "assets/components/list-table/ListTable.vue";
import NewTaxZone from "assets/components/tax/NewTaxZone.vue";
import TaxShortcuts from "assets/components/tax/TaxShortcuts.vue";

export default {
    components: {
        NewTaxZone,
        ListTable,
        TaxShortcuts,
    },

    data() {
        return {
            modalParams: null,
            columns: {
                tax_rate_name: {
                    label: window.$func.__("Tax Zone Name", "erp"),
                    isColPrimary: true,
                },
                tax_number: { label: window.$func.__("Tax Number", "erp") },
                default: { label: window.$func.__("Default", "erp") },
                actions: { label: window.$func.__("Actions", "erp") },
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
                    label: window.$func.__("Edit", "erp"),
                    iconClass: "flaticon-edit",
                },
                {
                    key: "trash",
                    label: window.$func.__("Delete", "erp"),
                    iconClass: "flaticon-trash",
                },
            ],
            bulkActions: [
                {
                    key: "trash",
                    label: window.$func.__("Move to Trash", "erp"),
                    iconClass: "flaticon-trash",
                },
            ],
            taxes: [{}],
            buttonTitle: "",
            pageTitle: "",
            url: "",
            singleUrl: "",
            isActiveOptionDropdown: false,
            singleTaxRateModal: false,
            showModal: false,
            rate_name_id: null,
            is_update: false,
        };
    },

    created() {
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
                item.tax_id = item.id;
                item.tax_name = item.name;
            });

            return items;
        },
    },

    methods: {
        fetchItems() {

            this.rows = [];
            window.axios
                .get("/tax-rate-names", {
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
                name: "PaginateTaxZones",
                params: { page: page },
                query: queries,
            });

            this.fetchItems();
        },

        singleTaxRate(tax_id) {
            this.$router.push({
                name: "SingleTaxRate",
                params: { id: tax_id },
            });
        },

        onActionClick(action, row, index) {
            switch (action) {
                case "trash":
                    if (confirm(__("Are you sure to delete?", "erp"))) {
                        window.axios
                            .delete("tax-rate-names" + "/" + row.id)
                            .then((response) => {
                                this.$delete(this.rows, index);
                                this.showAlert(
                                    "success",
                                    window.$func.__("Deleted !", "erp")
                                );
                            });
                    }
                    break;

                case "edit":
                    this.showModal = true;
                    this.rate_name_id = row.id;
                    this.is_update = true;
                    this.fetchItems();
                    break;

                default:
                    break;
            }
        },

        onBulkAction(action, items) {
            if (action === "trash") {
                if (confirm(__("Are you sure to delete?", "erp"))) {
                    window.axios
                        .delete("tax-rate-names/delete/" + items.join(","))
                        .then((response) => {
                            const toggleCheckbox =
                                document.getElementsByClassName("column-cb")[0]
                                    .childNodes[0];

                            if (toggleCheckbox.checked) {
                                // simulate click event to remove checked state
                                toggleCheckbox.click();
                            }

                            this.fetchItems();
                            this.showAlert("success", window.$func.__("Deleted !", "erp"));
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
.erp-acct-tax-menus {
    margin-left: 600px;
}

.combo-box {
    margin-right: 10px !important;
}

@media (min-width: 783px) {
    .app-tax-zones .col--actions {
        float: left !important;
    }
    .app-tax-zones .row-actions {
        text-align: left !important;
    }
}

.app-tax-zones .check-column {
    padding: 20px !important;
}

.app-tax-zones tbody .column.default {
    color: #388e3c;
    font-size: 26px;
    line-height: 26px;
}
</style>
