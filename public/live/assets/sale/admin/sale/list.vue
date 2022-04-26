<template>
    <div class="wperp-transactions-section wperp-section">
        <!-- Start .wperp-crm-table -->
        <div class="table-container">
            <div class="bulk-action">
                <a href="#"
                    ><i class="flaticon-trash"></i>{{ this.$func.__("Trash", "erp") }}</a
                >
                <a href="#" class="dismiss-bulk-action"
                    ><i class="flaticon-close"></i
                ></a>
            </div>
        </div>
    </div>
</template>

<script>
/* global this.$func.__ */
export default {
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

    created() {
        alert("created");

         /*this.$root.$on("transactions-filter", (filters) => {
             this.$router.push({
                path : '/transactions/sales',
                query: { start: filters.start_date, end: filters.end_date, status: filters.status, type: filters.type }
            });

            if (this.paginationData.currentPage !== 1) {
                this.paginationData.currentPage = 1;
                this.$router.push({ path: "/transactions/sales" });
            }

            this.fetchItems(filters);
            this.fetched = true;
        });*/

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
            return this.$store.state.erp_pro_activated
                ? this.$store.state.erp_pro_activated
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
                .get("admin/transactions/sales", {
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
                    console.log(response);
                    this.rows = response.data.records.map((item) => {
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
                    this.$store.dispatch("spinner/setSpinner", false);
                })
                .catch((error) => {
                    this.listLoading = false;
                    this.$store.dispatch("spinner/setSpinner", false);
                    throw error;
                });
        },

        onActionClick(action, row, index) {
            switch (action) {
                case "trash":
                    if (confirm(this.$func.__("Are you sure to delete?", "erp"))) {
                        this.$store.dispatch("spinner/setSpinner", true);
                        window.axios
                            .delete("invoices/" + row.id)
                            .then((response) => {
                                this.$delete(this.rows, index);

                                this.$store.dispatch(
                                    "spinner/setSpinner",
                                    false
                                );
                                this.showAlert(
                                    "success",
                                    this.$func.__("Deleted !", "erp")
                                );
                            })
                            .catch((error) => {
                                this.$store.dispatch(
                                    "spinner/setSpinner",
                                    false
                                );
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
.transactions-table .tablenav .column-cb .check-column {
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
