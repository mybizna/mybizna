<template>
    <div class="mybizna-transactions-section mybizna-section">
        <!-- Start .mybizna-crm-table -->
        <div class="table-container">
            <div class="bulk-action">
                <a href="#"
                    ><i class="flaticon-trash"></i>{{ window.$func.__("Trash", "erp") }}</a
                >
                <a href="#" class="dismiss-bulk-action"
                    ><i class="flaticon-close"></i
                ></a>
            </div>

            <list-table
                :loading="listLoading"
                tableClass="mybizna-table table-striped table-dark widefat table2 transactions-table"
                action-column="actions"
                :columns="columns"
                :rows="rows"
                :total-items="paginationData.totalItems"
                :total-pages="paginationData.totalPages"
                :per-page="paginationData.perPage"
                :current-page="paginationData.currentPage"
                @pagination="goToPage"
                :actions="[]"
                @action:click="onActionClick"
            >
                <template slot="trn_no" slot-scope="data">
                    <strong v-if="isPayment(data.row)">
                        <router-link
                            :to="{
                                name: 'PayPurchaseSingle',
                                params: {
                                    id: data.row.id,
                                    type: data.row.type,
                                },
                            }"
                        >
                            #{{ data.row.id }}
                        </router-link>
                    </strong>
                    <strong v-else>
                        <router-link
                            :to="{
                                name: 'PurchaseSingle',
                                params: { id: data.row.id },
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
                    {{
                        isPayment(data.row)
                            ? data.row.pay_bill_vendor_name
                            : data.row.vendor_name
                    }}
                </template>
                <template slot="trn_date" slot-scope="data">
                    {{
                        isPayment(data.row)
                            ? formatDate(data.row.pay_bill_trn_date)
                            : formatDate(data.row.bill_trn_date)
                    }}
                </template>
                <template slot="due_date" slot-scope="data">
                    {{
                        isPayment(data.row)
                            ? "-"
                            : formatDate(data.row.due_date)
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
                                : formatAmount(data.row.due, true)
                        }}</span
                    >
                </template>
                <template slot="amount" slot-scope="data">
                    {{
                        isPayment(data.row)
                            ? formatAmount(data.row.pay_bill_amount)
                            : formatAmount(data.row.amount)
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
import ListTable from "assets/components/list-table/ListTable.vue";
/* global __ */
export default {
    components: {
        ListTable,
    },

    data() {
        return {
            columns: {
                trn_no: { label: window.$func.__("Voucher No.", "erp"), isColPrimary: true },
                type: { label: window.$func.__("Type", "erp") },
                ref: { label: window.$func.__("Ref", "erp") },
                customer_name: { label: window.$func.__("Customer", "erp") },
                trn_date: { label: window.$func.__("Trn Date", "erp") },
                due_date: { label: window.$func.__("Due Date", "erp") },
                due: { label: window.$func.__("Balance", "erp") },
                amount: { label: window.$func.__("Total", "erp") },
                status: { label: window.$func.__("Status", "erp") },
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
            actions: [],
            fetched: false,
        };
    },

    created() {
        this.$root.$on("transactions-filter", (filters) => {
            /*  this.$router.push({
                path : '/transactions/purchases',
                query: { start: filters.start_date, end: filters.end_date, status: filters.status }
            });
            */

            if (this.paginationData.currentPage !== 1) {
                this.paginationData.currentPage = 1;
                this.$router.push({ path: "/transactions/purchases" });
            }

            this.fetchItems(filters);
            this.fetched = true;
        });

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
                .get("/transactions/purchases", {
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
                        vendor_id: filters.people_id,
                    },
                })
                .then((response) => {
                    const mappedData = response.data.map((item) => {
                        if (
                            item.purchase_order === "1" ||
                            item.status_code === "1"
                        ) {
                            item["actions"] = [
                                { key: "edit", label: window.$func.__("Edit", "erp") },
                                {
                                    key: "to_purchase",
                                    label: window.$func.__("Make Purchase", "erp"),
                                },
                            ];
                        } else if (item.status_code === "8") {
                            item["actions"] = [
                                {
                                    key: "#",
                                    label: window.$func.__("No actions found", "erp"),
                                },
                            ];
                        } else if (item.type === "purchase") {
                            if (item.status_code !== "4") {
                                if (item.status_code === "7") {
                                    delete item["actions"];

                                    item["actions"] = [
                                        {
                                            key: "#",
                                            label: window.$func.__(
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
                                            key: "payment",
                                            label: window.$func.__("Payment", "erp"),
                                        },
                                        {
                                            key: "edit",
                                            label: window.$func.__("Edit", "erp"),
                                        },
                                        {
                                            key: "void",
                                            label: window.$func.__("Void", "erp"),
                                        },
                                    ];

                                    if (
                                        this.proActivated &&
                                        item.status_code !== "3"
                                    ) {
                                        item.actions.splice(1, 0, {
                                            key: "return",
                                            label: window.$func.__("Return", "erp"),
                                        });
                                    }
                                } else if (item.status_code === "10") {
                                    item["actions"] = [
                                        {
                                            key: "payment",
                                            label: window.$func.__("Payment", "erp"),
                                        },
                                    ];

                                    if (this.proActivated) {
                                        item.actions.splice(1, 0, {
                                            key: "return",
                                            label: window.$func.__("Return", "erp"),
                                        });
                                    }
                                } else if (item.status_code === "9") {
                                    if (parseFloat(item.due) !== 0) {
                                        item["actions"] = [
                                            {
                                                key: "payment",
                                                label: window.$func.__("Payment", "erp"),
                                            },
                                        ];
                                    } else {
                                        item["actions"] = [
                                            {
                                                key: "#",
                                                label: window.$func.__(
                                                    "No actions found",
                                                    "erp"
                                                ),
                                            },
                                        ];
                                    }
                                } else {
                                    item["actions"] = [
                                        {
                                            key: "void",
                                            label: window.$func.__("Void", "erp"),
                                        },
                                    ];

                                    if (
                                        this.proActivated &&
                                        item.status_code === "6"
                                    ) {
                                        item.actions.splice(1, 0, {
                                            key: "return",
                                            label: window.$func.__("Return", "erp"),
                                        });
                                    }
                                }
                            } else {
                                if (this.proActivated) {
                                    item["actions"] = [
                                        {
                                            key: "return",
                                            label: window.$func.__("Return", "erp"),
                                        },
                                    ];
                                } else {
                                    item["actions"] = [
                                        {
                                            key: "#",
                                            label: window.$func.__(
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
                                    label: window.$func.__("No actions found", "erp"),
                                },
                            ];
                        }

                        return item;
                    });

                    this.rows = mappedData;

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
                    if (confirm(__("Are you sure to delete?", "erp"))) {
                        window.axios
                            .delete("purchases/" + row.id)
                            .then((response) => {
                                this.$delete(this.rows, index);
                            });
                    }
                    break;

                case "edit":
                    if (row.type === "purchase") {
                        this.$router.push({
                            name: "PurchaseEdit",
                            params: { id: row.id },
                        });
                    }

                    break;

                case "payment":
                    if (row.type === "purchase") {
                        this.$router.push({
                            name: "PayPurchaseCreate",
                            params: {
                                vendor_id: row.vendor_id,
                                vendor_name: row.vendor_name,
                            },
                        });
                    }
                    break;

                case "return":
                    this.$router.push({
                        name: "PurchaseReturnInvoice",
                        params: { id: row.id },
                    });
                    break;

                case "void":
                    if (
                        confirm(
                            window.$func.__("Are you sure to void the transaction?", "erp")
                        )
                    ) {
                        if (row.type === "purchase") {
                            window.axios
                                .post("purchases/" + row.id + "/void")
                                .then((response) => {
                                    this.showAlert(
                                        "success",
                                        window.$func.__("Transaction has been void!", "erp")
                                    );
                                })
                                .catch((error) => {
                                    throw error;
                                });
                        }
                        if (
                            row.type === "pay_purchase" ||
                            row.type === "receive_pay_purchase"
                        ) {
                            window.axios
                                .post("pay-purchases/" + row.id + "/void")
                                .then((response) => {
                                    this.showAlert(
                                        "success",
                                        window.$func.__("Transaction has been void!", "erp")
                                    );
                                })
                                .then(() => {
                                    this.$router.push({ name: "Purchases" });
                                })
                                .catch((error) => {
                                    throw error;
                                });
                        }
                    }
                    break;

                case "to_purchase":
                    this.$router.push({
                        name: "PurchaseEdit",
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
                name: "PaginatePurchases",
                params: { page: page },
                query: queries,
            });

            this.fetchItems();
        },

        isPayment(row) {
            return (
                row.type === "pay_purchase" ||
                row.type === "receive_pay_purchase"
            );
        },

        getTrnType(row) {
            if (row.type === "purchase") {
                if (row.purchase_order === "1") {
                    return window.$func.__("Purchase Order", "erp");
                }

                return window.$func.__("Purchase", "erp");
            } else if (row.type === "pay_purchase") {
                return window.$func.__("Payment", "erp");
            } else {
                return window.$func.__("Receive", "erp");
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
