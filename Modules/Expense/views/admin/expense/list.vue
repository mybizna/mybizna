<template>
    <div class="mybizna-transactions-section mybizna-section">
        <!-- Start .mybizna-crm-table -->
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
                tableClass="mybizna-table table-striped widefat table2 transactions-table"
                action-column="actions"
                :columns="columns"
                :rows="row_items"
                :total-items="paginationData.totalItems"
                :total-pages="paginationData.totalPages"
                :per-page="paginationData.perPage"
                :current-page="paginationData.currentPage"
                @pagination="goToPage"
                :actions="[]"
                @action:click="onActionClick"
            >
                <template slot="trn_no" slot-scope="data">
                    <strong>
                        <router-link :to="data.row.singleView">
                            #{{ data.row.id }}
                        </router-link>
                    </strong>
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
                <template slot="status" slot-scope="data">
                    {{ data.row.status }}
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
                vendor_name: { label: this.$func.__("People", "erp") },
                trn_date: { label: this.$func.__("Trn Date", "erp") },
                due_date: { label: this.$func.__("Due Date", "erp") },
                due: { label: this.$func.__("Due", "erp") },
                amount: { label: this.$func.__("Total", "erp") },
                status: { label: this.$func.__("Status", "erp") },
                actions: { label: "" },
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
            actions: [],
            fetched: false,
        };
    },

    created() {
        this.$root.$on("transactions-filter", (filters) => {
            /*  this.$router.push({
                path : '/transactions/expenses',
                query: { start: filters.start_date, end: filters.end_date, status: filters.status }
            });
            */

            if (this.paginationData.currentPage !== 1) {
                this.paginationData.currentPage = 1;
                this.$router.push({ path: "/transactions/expenses" });
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

    // watch: {
    //     $route: 'fetchItems'
    // },

    methods: {
        fetchItems(filters = {}) {
            this.rows = [];

            window.axios
                .get("/transactions/expenses", {
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
                    // if ( confirm('Are you sure to delete?') ) {
                    //     window.axios.delete('invoices/' + row.id).then( response => {
                    //         this.$delete(this.rows, index);
                    //     });
                    // }
                    break;

                case "edit":
                    if (row.trn_type === "expense") {
                        this.$router.push({
                            name: "ExpenseEdit",
                            params: { id: row.id },
                        });
                    }

                    if (row.trn_type === "bill") {
                        this.$router.push({
                            name: "BillEdit",
                            params: { id: row.id },
                        });
                    }

                    if (row.trn_type === "check") {
                        this.$router.push({
                            name: "CheckEdit",
                            params: { id: row.id },
                        });
                    }

                    break;

                case "payment":
                    if (row.trn_type === "bill") {
                        this.$router.push({
                            name: "PayBillCreate",
                            params: {
                                vendor_id: row.vendor_id,
                                vendor_name: row.vendor_name,
                            },
                        });
                    }
                    break;

                case "void":
                    if (
                        confirm(
                            this.$func.__("Are you sure to void the transaction?", "erp")
                        )
                    ) {
                        if (
                            row.trn_type === "expense" ||
                            row.trn_type === "check"
                        ) {
                            window.axios
                                .post("expenses/" + row.id + "/void")
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
                        if (row.trn_type === "bill") {
                            window.axios
                                .post("bills/" + row.id + "/void")
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
                        if (row.trn_type === "pay_bill") {
                            window.axios
                                .post("pay-bills/" + row.id + "/void")
                                .then((response) => {
                                    this.showAlert(
                                        "success",
                                        this.$func.__("Transaction has been void!", "erp")
                                    );
                                })
                                .then(() => {
                                    this.$router.push({ name: "Expenses" });
                                })
                                .catch((error) => {
                                    throw error;
                                });
                        }
                    }
                    break;

                case "to_expense":
                    this.$router.push({
                        name: "ExpenseEdit",
                        params: { id: row.id },
                        query: { convert: true },
                    });
                    break;

                default:
                    break;
            }
        },

        goToPage(page) {
            const queries = Object.assign({}, this.$route.query);
            this.paginationData.currentPage = page;
            this.$router.push({
                name: "PaginateExpenses",
                params: { page: page },
                query: queries,
            });

            this.fetchItems();
        },
    },

    computed: {
        row_items() {
            if (!this.rows.length) {
                return this.rows;
            }
            let temp;
            const items = this.rows.map((item) => {
                switch (item.type) {
                    case "pay_bill":
                        temp = {
                            id: item.id,
                            trn_no: item.id,
                            type: this.$func.__("Pay Bill", "erp"),
                            trn_type: "pay_bill",
                            ref: item.ref ? item.ref : "-",
                            vendor_name: item.pay_bill_vendor_name,
                            trn_date: this.formatDate(item.pay_bill_trn_date),
                            due_date: "-",
                            due: "-",
                            amount: this.formatAmount(item.pay_bill_amount),
                            status: item.status,
                            singleView: {
                                name: "PayBillSingle",
                                params: { id: item.id },
                            },
                            actions: [
                                { key: "void", label: this.$func.__("Void", "erp") },
                            ],
                        };
                        break;

                    case "bill":
                        temp = {
                            id: item.id,
                            trn_no: item.id,
                            type: this.$func.__("Bill", "erp"),
                            trn_type: "bill",
                            ref: item.ref ? item.ref : "-",
                            vendor_id: item.vendor_id,
                            vendor_name: item.vendor_name,
                            trn_date: this.formatDate(item.bill_trn_date),
                            due_date: this.formatDate(item.due_date),
                            due: this.formatAmount(item.due),
                            amount: this.formatAmount(item.amount),
                            status: item.status,
                            singleView: {
                                name: "BillSingle",
                                params: { id: item.id },
                            },
                            actions: [
                                {
                                    key: "payment",
                                    label: this.$func.__("Make Payment", "erp"),
                                },
                                { key: "edit", label: this.$func.__("Edit", "erp") },
                                { key: "void", label: this.$func.__("Void", "erp") },
                            ],
                        };
                        break;

                    case "expense":
                        temp = {
                            id: item.id,
                            trn_no: item.id,
                            type: this.$func.__("Expense", "erp"),
                            trn_type: "expense",
                            ref: item.exp_ref ? item.exp_ref : "-",
                            vendor_name: item.expense_people_name,
                            trn_date: this.formatDate(item.expense_trn_date),
                            due_date: "-",
                            due: "-",
                            amount: this.formatAmount(item.expense_amount),
                            status: item.status,
                            singleView: {
                                name: "ExpenseSingle",
                                params: { id: item.id },
                            },
                            actions: [
                                { key: "void", label: this.$func.__("Void", "erp") },
                            ],
                        };
                        break;

                    case "check":
                        temp = {
                            id: item.id,
                            trn_no: item.id,
                            type: this.$func.__("Check", "erp"),
                            trn_type: "check",
                            ref: item.ref ? item.ref : "-",
                            vendor_name: item.expense_people_name,
                            trn_date: this.formatDate(item.expense_trn_date),
                            due_date: "-",
                            due: "-",
                            amount: this.formatAmount(item.expense_amount),
                            status: item.status,
                            singleView: {
                                name: "CheckSingle",
                                params: { id: item.id },
                            },
                            actions: [
                                { key: "void", label: this.$func.__("Void", "erp") },
                            ],
                        };
                        break;

                    default:
                        break;
                }

                if (
                    item.status_code === "2" ||
                    item.status_code === "3" ||
                    item.status_code === "5"
                ) {
                    temp["actions"] = [
                        { key: "payment", label: this.$func.__("Make Payment", "erp") },
                        { key: "edit", label: this.$func.__("Edit", "erp") },
                        { key: "void", label: this.$func.__("Void", "erp") },
                    ];
                } else if (item.status_code === "1") {
                    temp["actions"] = [
                        { key: "to_expense", label: this.$func.__("Make Expense", "erp") },
                    ];
                } else {
                    temp["actions"] = [
                        { key: "#", label: this.$func.__("No actions found", "erp") },
                    ];
                }

                return temp;
            });

            return items;
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
</style>
