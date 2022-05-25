<template>
    <div class="income-statement">
        <h2 class="content-header__title">
            {{ this.$func.__("Income Statement", "erp") }}
        </h2>

        <form @submit.prevent="fetchItems" class="query-options no-print">
            <div class="date-group">
                <datepicker v-model="start_date"></datepicker>
                <datepicker v-model="end_date"></datepicker>
                <button
                    class="btn btn-primary add-line-trigger"
                    type="submit"
                >
                    {{ this.$func.__("Filter", "erp") }}
                </button>
            </div>

            <a
                href="#"
                class="btn btn-default print-btn"
                @click.prevent="printPopup"
            >
                <i class="flaticon-printer-1"></i>
                &nbsp; {{ this.$func.__("Print", "erp") }}
            </a>
        </form>

        <p>
            <strong
                >{{
                    this.$func.__(
                        "For the period of ( Transaction date )",
                        "erp"
                    )
                }}:</strong
            >
            <em>{{ start_date }}</em> to <em>{{ end_date }}</em>
        </p>

        <list-table
            tableClass="table table-sm table-striped widefat income-statement income-balance-report"
            :columns="columns1"
            :rows="rows1"
            :showItemNumbers="false"
            :showCb="false"
        >
            <template slot="amount" slot-scope="data">
                {{ transformBalance(Math.abs(data.row.balance)) }}
            </template>
            <template slot="tfoot">
                <tr class="t-foot">
                    <td>{{ this.$func.__("Total Income", "erp") }}</td>
                    <td>{{ transformBalance(Math.abs(income)) }}</td>
                </tr>
            </template>
        </list-table>

        <list-table
            tableClass="table table-sm table-striped widefat income-statement income-balance-report"
            :columns="columns2"
            :rows="rows2"
            :showItemNumbers="false"
            :showCb="false"
        >
            <template slot="amount" slot-scope="data">
                {{ transformBalance(Math.abs(data.row.balance)) }}
            </template>
            <template slot="tfoot">
                <tr class="t-foot">
                    <td>{{ this.$func.__("Total Expense", "erp") }}</td>
                    <td>{{ transformBalance(Math.abs(expense)) }}</td>
                </tr>
            </template>
        </list-table>

        <table
            class="table table-striped widefat income-statement-balance income-balance-report"
        >
            <template v-if="profit >= 0">
                <tbody class="col-sm-12">
                    <tr>
                        <td>
                            <strong>{{
                                this.$func.__("Profit", "erp")
                            }}</strong>
                        </td>
                        <td>{{ moneyFormat(Math.abs(profit)) }}</td>
                        <td class="no-print"></td>
                    </tr>
                </tbody>
            </template>
            <template v-else>
                <tbody class="col-sm-12">
                    <tr>
                        <td>
                            <strong>{{ this.$func.__("Loss", "erp") }}</strong>
                        </td>
                        <td>{{ moneyFormat(Math.abs(loss)) }}</td>
                        <td class="no-print"></td>
                    </tr>
                </tbody>
            </template>
        </table>
    </div>
</template>

<script>
export default {
    components: {
        ListTable: window.$func.fetchComponent("components/list-table/ListTable.vue"),
        Datepicker: window.$func.fetchComponent("components/base/Datepicker.vue"),
    },

    data() {
        return {
            start_date: null,
            end_date: null,
            bulkActions: [
                {
                    key: "trash",
                    label: this.$func.__("Move to Trash", "erp"),
                    img:
                        this.$mybizna_var.assets +
                        "/images/trash.png" /* global mybizna_var */,
                },
            ],
            columns1: {
                name: { label: this.$func.__("Account Name", "erp") },
                amount: { label: this.$func.__("Amount", "erp") },
            },

            columns2: {
                name: { label: this.$func.__("Account Name", "erp") },
                amount: { label: this.$func.__("Amount", "erp") },
            },
            rows1: [],
            rows2: [],
            income: 0,
            expense: 0,
            profit: 0,
            loss: 0,
        };
    },

    created() {
        this.$nextTick(function () {
            const dateObj = new Date();

            // with leading zero, and JS month are zero index based
            const month = ("0" + (dateObj.getMonth() + 1)).slice(-2);

            if (this.$route.query.start) {
                this.start_date = this.$route.query.start;
                this.end_date = this.$route.query.end;
            } else {
                this.start_date = `${dateObj.getFullYear()}-${month}-01`;
                this.end_date = this.$mybizna_var.current_date;
            }

            // this.updateDate();

            this.fetchItems();
        });
    },

    methods: {
        updateDate() {
            this.$router.push({
                path: this.$route.path,
                query: {
                    start: this.start_date,
                    end: this.end_date,
                },
            });
        },

        fetchItems() {
            this.updateDate();

            this.rows1 = [];
            this.rows2 = [];
            window.axios
                .get("/reports/income-statement", {
                    params: {
                        start_date: this.start_date,
                        end_date: this.end_date,
                    },
                })
                .then((response) => {
                    this.rows1 = response.data.rows1;
                    this.rows2 = response.data.rows2;
                    this.income = response.data.income;
                    this.expense = response.data.expense;
                    this.profit = response.data.profit;
                    this.loss = response.data.loss;
                })
                .catch((error) => {
                    throw error;
                });
        },

        transformBalance(val) {
            if (val === null && typeof val === "object") {
                val = 0;
            }

            if (val < 0) {
                return `Cr. ${this.moneyFormat(Math.abs(val))}`;
            }

            return `Dr. ${this.moneyFormat(val)}`;
        },

        printPopup() {
            window.print();
        },
    },
};
</script>

<style>
.content-header__title {
    padding-top: 5px !important;
}
.income-statement tbody tr td:last-child {
    text-align: left !important;
}

.income-balance-report tbody tr td:first-child {
    width: 70% !important;
}

.income-balance-report thead tr th:first-child {
    width: 70% !important;
}

.income-statement .tablenav.top,
.income-statement .tablenav.bottom {
    display: none;
}

.income-statement .print-btn {
    float: right;
}

.income-statement .query-options {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    padding: 20px 0;
}

@media screen and (max-width: 782px) {
    .income-statement thead th.column.amount {
        display: none !important;
    }

    .income-statement tbody tr {
        border-top: 1px solid black;
    }
}

.income-statement .t-foot td {
    color: #2196f3;
    font-weight: bold;
}
.income-statement-balance tr td {
    background-color: #f2f2f2;
    color: #2196f3;
    font-weight: bold;
}

@media print {
    .income-statement p {
        margin-bottom: 20px;
    }
    .income-statement p em {
        font-weight: bold;
    }
}

.erp-nav-container {
    display: none;
}

.no-print,
.no-print * {
    display: none !important;
}
.table.income-balance-report td,
.table.income-balance-report th {
    padding: 3px 20px;
}
.table.income-balance-report thead tr th {
    font-weight: bold;
}
.table.income-balance-report thead tr th:not(:first-child) {
    text-align: right;
}

.table.income-balance-report tbody tr td:not(:first-child) {
    text-align: right !important;
}
.table.income-balance-report tfoot td:not(:first-child) {
    text-align: right !important;
}
</style>
