<template>
    <div class="transactions-section section">
        <!-- Start .crm-table -->
        <div class="table-container">
            <div class="bulk-action">
                <a href="#"
                    ><i class="flaticon-trash"></i>{{ this.$func.__("Trash", "erp") }}</a
                >
                <a href="#" class="dismiss-bulk-action"
                    ><i class="flaticon-close"></i
                ></a>
            </div>

            <list-table
                :loading="listLoading"
                tableClass="table table-sm table-striped widefat table2 transactions-table"
                action-column="actions"
                :columns="columns"
                :rows="rows"
                :total-items="paginationData.totalItems"
                :total-pages="paginationData.totalPages"
                :per-page="paginationData.perPage"
                :current-page="paginationData.currentPage"
                :actions="[]"
                @pagination="goToPage"
                @action:click="onActionClick"
            >
                <template slot="trn_no" slot-scope="data">
                    <strong>
                        <router-link
                            :to="{
                                name: 'SalesSingle',
                                params: {
                                    id: data.row.id,
                                    type: data.row.type,
                                },
                            }"
                        >
                            #{{ data.row.id }}
                        </router-link>
                    </strong>
                </template>
                <template slot="type" slot-scope="data">
                    {{ getTrnType(data.row) }}
                </template>
                <template slot="ref" slot-scope="data">
                    {{ data.row.ref ? data.row.ref : "-" }}
                </template>
                <template slot="customer_name" slot-scope="data">
                    {{ data.row.inv_cus_name ? data.row.inv_cus_name : "-" }}
                </template>
                <template slot="trn_date" slot-scope="data">
                    {{
                        data.row.invoice_trn_date
                            ? formatDate(data.row.invoice_trn_date)
                            : "-"
                    }}
                </template>
                <template slot="due_date" slot-scope="data">
                    {{
                        isPayment(data.row)
                            ? "-"
                            : data.row.due_date
                            ? formatDate(data.row.due_date)
                            : "-"
                    }}
                </template>
                <template slot="due" slot-scope="data">
                    <span
                        :class="
                            parseFloat(data.row.due) < 0
                                ? 'cr-balance'
                                : 'dr-balance'
                        "
                        >{{
                            isPayment(data.row)
                                ? "-"
                                : data.row.due
                                ? formatAmount(data.row.due, true)
                                : "-"
                        }}</span
                    >
                </template>
                <template slot="amount" slot-scope="data">
                    {{
                        isPayment(data.row)
                            ? formatAmount(data.row.payment_amount)
                            : formatAmount(data.row.sales_amount)
                    }}
                </template>
                <template slot="status" slot-scope="data">
                    {{ data.row.status }}
                </template>

                <!-- custom row actions -->
                <template slot="action-list" slot-scope="data">
                    <li
                        v-for="(action, index) in data.row.actions"
                        :key="action.key"
                        :class="action.key"
                    >
                        <a
                            href="#"
                            @click.prevent="
                                onActionClick(action.key, data.row, index)
                            "
                        >
                            <i :class="action.iconClass"></i>{{ action.label }}
                        </a>
                    </li>
                </template>
            </list-table>
        </div>
    </div>
</template>

<script>
/* global __ */
export default {
    components: {
        ListTable: window.$func.fetchComponent('components/list-table/ListTable.vue'),
    },

    data() {
        return {
            columns: {
                trn_no: { label: this.$func.__("Voucher No.", "erp"), isColPrimary: true },
                type: { label: this.$func.__("Type", "erp") },
                ref: { label: this.$func.__("Ref", "erp") },
                customer_name: { label: this.$func.__("Customer", "erp") },
                trn_date: { label: this.$func.__("Trn Date", "erp") },
                due_date: { label: this.$func.__("Due Date", "erp") },
                due: { label: this.$func.__("Balance", "erp") },
                amount: { label: this.$func.__("Total", "erp") },
                status: { label: this.$func.__("Status", "erp") },
                actions: { label: "" },
            },
            listLoading: false,
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
        };
    },
   emits: {
        // Validate submit event
        "transactions-filter": ({ filters }) => {
       /*  this.$router.push({
                path : '/transactions/sales',
                query: { start: filters.start_date, end: filters.end_date, status: filters.status, type: filters.type }
            });*/

            if (this.paginationData.currentPage !== 1) {
                this.paginationData.currentPage = 1;
                this.$router.push({ path: "/transactions/sales" });
            }

            this.fetchItems(filters);
            this.fetched = true;
            return true;
        },
    },
    created() {

        const filters = {};
        // Get start & end date from url on page load
        if (this.$route.query.start && this.$route.query.end) {
            filters.start_date = this.$route.query.start;
            filters.end_date = this.$route.query.end;
        }
        if (this.$route.query.status) {
            filters.status = this.$route.query.status;
        }

        if (!this.fetched) {
            this.fetchItems(filters);
        }
    },

    computed: {
        proActivated() {
            return this.$store.state.pro_activated
                ? this.$store.state.pro_activated
                : false;
        },
    },

    // watch: {
    //     $route: 'fetchItems'
    // },

    methods: {
        fetchItems(filters = {}) {
            this.rows = [];

            window.axios
                .get("/transactions/sales", {
                    params: {
                        per_page: this.paginationData.perPage,
                        page:
                            this.$route.params.page === undefined
                                ? this.paginationData.currentPage
                                : this.$route.params.page,
                        start_date: filters.start_date,
                        end_date: filters.end_date,
                        status: filters.status,
                        type: filters.type,
                        customer_id: filters.people_id,
                    },
                })
                .then((response) => {
                    this.rows = response.data.map((item) => {
                        if (item.estimate === "1" || item.status_code === "1") {
                            item["actions"] = [
                                { key: "edit", label: this.$func.__("Edit", "erp") },
                                {
                                    key: "to_invoice",
                                    label: this.$func.__("Make Invoice", "erp"),
                                },
                            ];
                        } else if (item.status_code === "8") {
                            item["actions"] = [
                                {
                                    key: "#",
                                    label: this.$func.__("No actions found", "erp"),
                                },
                            ];
                        } else if (item.type === "invoice") {
                            if (item.status_code !== "4") {
                                if (item.status_code === "7") {
                                    delete item["actions"];

                                    item["actions"] = [
                                        {
                                            key: "#",
                                            label: this.$func.__(
                                                "No actions found",
                                                "erp"
                                            ),
                                        },
                                    ];
                                } else if (
                                    item.status_code === "2" ||
                                    item.status_code === "3" ||
                                    item.status_code === "5"
                                ) {
                                    item["actions"] = [
                                        {
                                            key: "receive",
                                            label: this.$func.__("Payment", "erp"),
                                        },
                                        {
                                            key: "edit",
                                            label: this.$func.__("Edit", "erp"),
                                        },
                                        {
                                            key: "void",
                                            label: this.$func.__("Void", "erp"),
                                        },
                                    ];

                                    if (
                                        this.proActivated &&
                                        item.status_code !== "3"
                                    ) {
                                        item.actions.splice(1, 0, {
                                            key: "return",
                                            label: this.$func.__("Receive Return", "erp"),
                                        });
                                    }
                                } else if (item.status_code === "10") {
                                    item["actions"] = [
                                        {
                                            key: "receive",
                                            label: this.$func.__("Payment", "erp"),
                                        },
                                    ];

                                    if (this.proActivated) {
                                        item.actions.splice(1, 0, {
                                            key: "return",
                                            label: this.$func.__("Receive Return", "erp"),
                                        });
                                    }
                                } else if (item.status_code === "9") {
                                    if (parseFloat(item.due) !== 0) {
                                        item["actions"] = [
                                            {
                                                key: "receive",
                                                label: this.$func.__("Payment", "erp"),
                                            },
                                        ];
                                    } else {
                                        item["actions"] = [
                                            {
                                                key: "#",
                                                label: this.$func.__(
                                                    "No actions found",
                                                    "erp"
                                                ),
                                            },
                                        ];
                                    }
                                } else {
                                    item["actions"] = [
                                        { key: "void", label: "Void" },
                                    ];

                                    if (
                                        this.proActivated &&
                                        item.status_code === "6"
                                    ) {
                                        item.actions.splice(1, 0, {
                                            key: "return",
                                            label: this.$func.__("Receive Return", "erp"),
                                        });
                                    }
                                }
                            } else {
                                if (this.proActivated) {
                                    item["actions"] = [
                                        {
                                            key: "return",
                                            label: this.$func.__("Receive Return", "erp"),
                                        },
                                    ];
                                } else {
                                    item["actions"] = [
                                        {
                                            key: "#",
                                            label: this.$func.__(
                                                "No actions found",
                                                "erp"
                                            ),
                                        },
                                    ];
                                }
                            }
                        } else {
                            item["actions"] = [
                                {
                                    key: "#",
                                    label: this.$func.__("No actions found", "erp"),
                                },
                            ];
                        }

                        return item;
                    });

                    this.paginationData.totalItems = parseInt(
                        response.headers["x-wp-total"]
                    );
                    this.paginationData.totalPages = parseInt(
                        response.headers["x-wp-totalpages"]
                    );

                    this.listLoading = false;
                })
                .catch((error) => {
                    this.listLoading = false;
                    throw error;
                });
        },

        onActionClick(action, row, index) {
            switch (action) {
                case "trash":
                    if (confirm(this.$func.__("Are you sure to delete?", "erp"))) {
                        window.axios
                            .delete("invoices/" + row.id)
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
                    if (row.type === "invoice") {
                        this.$router.push({
                            name: "InvoiceEdit",
                            params: { id: row.id },
                        });
                    }

                    if (
                        row.type === "payment" ||
                        row.type === "return_payment"
                    ) {
                        this.$router.push({
                            name: "RecPaymentEdit",
                            params: { id: row.id },
                        });
                    }
                    break;

                case "receive":
                    this.$router.push({
                        name: "RecPaymentCreate",
                        params: {
                            customer_id: row.inv_cus_id,
                            customer_name: row.inv_cus_name,
                        },
                    });
                    break;

                case "return":
                    this.$router.push({
                        path: `/transactions/sales/return/${row.id}/create`,
                    });
                    break;

                case "void":
                    if (
                        confirm(
                            this.$func.__("Are you sure to void the transaction?", "erp")
                        )
                    ) {
                        if (row.type === "invoice") {
                            window.axios
                                .post("invoices/" + row.id + "/void")
                                .then((response) => {
                                    this.showAlert(
                                        "success",
                                        this.$func.__("Transaction has been void!", "erp")
                                    );
                                })
                                .catch((error) => {
                                    throw error;
                                });
                        }
                        if (row.type === "payment") {
                            window.axios
                                .post("payments/" + row.id + "/void")
                                .then((response) => {
                                    this.showAlert(
                                        "success",
                                        this.$func.__("Transaction has been void!", "erp")
                                    );
                                })
                                .then(() => {
                                    this.$router.push({ name: "Sales" });
                                })
                                .catch((error) => {
                                    throw error;
                                });
                        }
                    }
                    break;

                case "to_invoice":
                    this.$router.push({
                        name: "InvoiceEdit",
                        params: { id: row.id },
                        query: { convert: true },
                    });
                    break;

                default:
                    break;
            }
        },

        goToPage(page) {
            this.listLoading = true;
            const queries = Object.assign({}, this.$route.query);
            this.paginationData.currentPage = page;
            this.$router.push({
                name: "PaginateSales",
                params: { page: page },
                query: queries,
            });

            this.fetchItems();
        },

        isPayment(row) {
            return row.type === "payment" || row.type === "return_payment";
        },

        isReturnPayment(row) {
            return row.type === "return_payment";
        },

        getTrnType(row) {
            if (row.type === "invoice") {
                if (row.estimate == "1") {
                    return this.$func.__("Estimate", "erp");
                }

                return this.$func.__("Invoice", "erp");
            } else if (row.type === "return_payment") {
                return this.$func.__("Payment", "erp");
            } else {
                return this.$func.__("Receive", "erp");
            }
        },
    },
};
</script>

<style>
.transactions-table .tablenav,
.transactions-table .column-cb,
.transactions-table .check-column {
    display: none;
}

.due {
    font-weight: 600;
}

.dr-balance {
    color: #00b33c;
}

.cr-balance {
    color: #ff6666;
}
</style>
