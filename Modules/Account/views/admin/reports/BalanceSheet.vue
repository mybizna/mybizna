<template>
    <div class="balance-sheet">
        <h2 class="content-header__title">
            <span>{{ this.$func.__("Balance Sheet", "erp") }}</span>
        </h2>

        <div class="blnce-sheet-top">
            <form @submit.prevent="fetchItems" class="query-options no-print">
                <div v-if="!closingBtnVisibility" class="mybizna-date-group">
                    <datepicker v-model="start_date"></datepicker>
                    <datepicker v-model="end_date"></datepicker>
                    <button
                        class="mybizna-btn btn--primary add-line-trigger"
                        type="submit"
                    >
                        {{ this.$func.__("Filter", "erp") }}
                    </button>
                </div>

                <div v-else class="fn-year-info">
                    <div class="with-multiselect fyear-select">
                        <multi-select
                            v-model="selectedYear"
                            :options="fyears"
                        />
                    </div>

                    <div v-if="selectedYear">
                        {{ this.$func.__("Balance showing from", "erp") }}
                        <em>{{ selectedYear.start_date }}</em>
                        {{ this.$func.__("to", "erp") }}
                        <em>{{ selectedYear.end_date }}</em>
                    </div>
                </div>
            </form>

            <div class="closing-blnc no-print">
                <div class="close-check">
                    <input
                        type="checkbox"
                        id="prepare-close"
                        v-model="closingBtnVisibility"
                    />
                    <label for="prepare-close">{{
                        this.$func.__("Prepare for closing", "erp")
                    }}</label>
                </div>

                <a
                    @click.prevent="checkClosingPossibility"
                    :class="[
                        { visible: closingBtnVisibility },
                        'mybizna-btn btn--primary close-now-btn',
                    ]"
                    href="#"
                    >{{ this.$func.__("Close Now", "erp") }}</a
                >

                <a
                    href="#"
                    class="mybizna-btn btn--default print-btn"
                    @click.prevent="printPopup"
                >
                    <i class="flaticon-printer-1"></i>
                    &nbsp; {{ this.$func.__("Print", "erp") }}
                </a>
            </div>
        </div>

        <p>
            <strong
                >{{
                    this.$func.__(
                        "For the period of ( Transaction date )",
                        "erp"
                    )
                }}:</strong
            >
            <em>{{ start_date }}</em> {{ this.$func.__("to", "erp") }}
            <em>{{ end_date }}</em>
        </p>

        <div class="mybizna-panel-body">
            <div>
                <div class="mybizna-col-sm-12">
                    <list-table
                        tableClass="mybizna-table table-sm table-striped widefat balance-sheet-asset report-table"
                        :columns="columns1"
                        :rows="rows1"
                        :showItemNumbers="false"
                        :showCb="false"
                    >
                        <template slot="name" slot-scope="data">
                            <span v-html="data.row.name"></span>
                            <p
                                class="additional"
                                v-for="additional in data.row.additional"
                            >
                                {{ additional.name }}
                                <em>{{
                                    moneyFormat(Math.abs(additional.balance))
                                }}</em>
                            </p>
                        </template>
                        <template slot="balance" slot-scope="data">
                            <span v-if="isNaN(data.row.balance)">{{
                                data.row.balance
                            }}</span>
                            <span v-else
                                >{{ transformBalance(data.row.balance) }}
                            </span>
                        </template>

                        <template slot="tfoot">
                            <tr class="t-foot">
                                <td>
                                    {{ this.$func.__("Total Asset", "erp") }}
                                </td>
                                <td>{{ transformBalance(totalAsset) }}</td>
                            </tr>
                        </template>
                    </list-table>
                </div>

                <div class="mybizna-col-sm-12">
                    <list-table
                        tableClass="mybizna-table table-sm table-striped widefat balance-sheet-liability report-table"
                        :columns="columns2"
                        :rows="rows2"
                        :showItemNumbers="false"
                        :showCb="false"
                    >
                        <template slot="name" slot-scope="data">
                            <span v-html="data.row.name"> </span>
                            <p
                                class="additional"
                                v-for="additional in data.row.additional"
                            >
                                {{ additional.name }}
                                <em>{{
                                    moneyFormat(Math.abs(additional.balance))
                                }}</em>
                            </p>
                        </template>
                        <template slot="balance" slot-scope="data">
                            <span v-if="isNaN(data.row.balance)">{{
                                data.row.balance
                            }}</span>
                            <span v-else
                                >{{ transformBalance(data.row.balance) }}
                            </span>
                        </template>
                        <template slot="tfoot">
                            <tr class="t-foot">
                                <td>
                                    {{
                                        this.$func.__("Total Liability", "erp")
                                    }}
                                </td>
                                <td>{{ transformBalance(totalLiability) }}</td>
                            </tr>
                        </template>
                    </list-table>
                </div>

                <div class="mybizna-col-sm-12">
                    <list-table
                        tableClass="mybizna-table table-sm table-striped widefat balance-sheet-equity report-table"
                        :columns="columns3"
                        :rows="rows3"
                        :showItemNumbers="false"
                        :showCb="false"
                    >
                        <template slot="name" slot-scope="data">
                            <span v-html="data.row.name"> </span>
                        </template>
                        <template slot="balance" slot-scope="data">
                            <span v-if="isNaN(data.row.balance)">{{
                                data.row.balance
                            }}</span>
                            <span v-else
                                >{{ transformBalance(data.row.balance) }}
                            </span>
                        </template>
                        <template slot="tfoot">
                            <tr class="t-foot">
                                <td>
                                    {{ this.$func.__("Total Equity", "erp") }}
                                </td>
                                <td>{{ transformBalance(totalEquity) }}</td>
                            </tr>
                        </template>
                    </list-table>
                </div>

                <table
                    class="mybizna-table table-striped widefat liability-equity-balance report-table"
                >
                    <tbody>
                        <tr>
                            <td style="font-size: 16px; color: #00b33c">
                                {{ this.$func.__("Assets", "erp") }} =
                            </td>
                            <td style="font-size: 16px; color: #00b33c">
                                {{ transformBalance(totalAsset) }}
                            </td>
                            <td class="no-print"></td>
                            <td class="no-print"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 16px; color: #ff6666">
                                {{ this.$func.__("Liability", "erp") }} +
                                {{ this.$func.__("Equity", "erp") }} =
                            </td>
                            <td style="font-size: 16px; color: #ff6666">
                                {{ transformBalance(liability_equity) }}
                            </td>
                            <td class="no-print"></td>
                            <td class="no-print"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    components: {
        MultiSelect: window.$func.fetchComponent("components/select/MultiSelect.vue"),
        ListTable: window.$func.fetchComponent("components/list-table/ListTable.vue"),
        Datepicker: window.$func.fetchComponent("components/base/Datepicker.vue"),
    },

    data() {
        return {
            closingBtnVisibility: false,
            start_date: null,
            end_date: null,
            bulkActions: [
                {
                    key: "trash",
                    label: this.$func.__("Move to Trash", "erp"),
                    img:
                        this.$erp_acct_var.erp_assets +
                        "/images/trash.png" /* global this.$erp_acct_var */,
                },
            ],
            columns1: {
                name: { label: this.$func.__("Assets", "erp") },
                balance: { label: this.$func.__("Amount", "erp") },
            },
            columns2: {
                name: { label: this.$func.__("Liability", "erp") },
                balance: { label: this.$func.__("Amount", "erp") },
            },
            columns3: {
                name: { label: this.$func.__("Equity", "erp") },
                balance: { label: this.$func.__("Amount", "erp") },
            },
            rows1: [],
            rows2: [],
            rows3: [],
            fyears: [],
            totalAsset: 0,
            totalLiability: 0,
            totalEquity: 0,
            selectedYear: null,
        };
    },

    created() {
        // ? why is nextTick here ...? i don't know.
        /*  this.$nextTick(function() {
            const dateObj = new Date();

            // with leading zero, and JS month are zero index based
            const month = ('0' + (dateObj.getMonth() + 1)).slice(-2);

            this.start_date = `${dateObj.getFullYear()}-${month}-01`;
            this.end_date   = this.$erp_acct_var.current_date;

            this.fetchItems();
        });*/

        this.fetchFnYears();
    },

    computed: {
        liability_equity() {
            return (
                parseFloat(this.totalLiability) + parseFloat(this.totalEquity)
            );
        },
    },

    watch: {
        closingBtnVisibility(visible) {
            if (visible) {
                this.start_date = this.selectedYear.start_date;
                this.end_date = this.selectedYear.end_date;

                this.fetchItems();
            }
        },

        selectedYear(newVal) {
            // only whe `prepare close` is checked
            if (this.closingBtnVisibility) {
                this.start_date = newVal.start_date;
                this.end_date = newVal.end_date;

                this.fetchItems();
            }
        },
    },

    methods: {
        fetchItems() {
            this.rows = [];

            window.axios
                .get("/reports/balance-sheet", {
                    params: {
                        start_date: this.start_date,
                        end_date: this.end_date,
                    },
                })
                .then((response) => {
                    this.rows1 = response.data.rows1;
                    this.rows2 = response.data.rows2;
                    this.rows3 = response.data.rows3;
                    this.totalAsset = response.data.total_asset;
                    this.totalLiability = response.data.total_liability;
                    this.totalEquity = response.data.total_equity;
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

        fetchFnYears() {
            window.axios.get("/opening-balances/names").then((response) => {
                // get only last 5
                this.fyears = response.data.reverse().slice(0).slice(-5);
                this.getCurrentFnYear();
            });
        },

        getCurrentFnYear() {
            window.axios
                .get("/closing-balance/closest-fn-year")
                .then((response) => {
                    this.selectedYear = response.data;
                    this.start_date = response.data.start_date;
                    this.end_date = response.data.end_date;
                    this.fetchItems();
                });
        },

        printPopup() {
            window.print();
        },

        checkClosingPossibility() {
            if (!this.end_date) {
                this.showAlert(
                    "error",
                    this.$func.__("Please select financial year", "erp")
                );
                return false;
            }

            window.axios
                .get("/closing-balance/next-fn-year", {
                    params: {
                        date: this.end_date,
                    },
                })
                .then((response) => {
                    if (!response.data) {
                        this.showAlert(
                            "error",
                            this.$func.__(
                                "Please create a financial year which start after ",
                                "erp"
                            ) + this.end_date
                        );
                    } else {
                        this.closeBalancesheet(response.data.id);
                    }
                })
                .catch((error) => {
                    throw error;
                })
                .then(() => {});
        },

        closeBalancesheet(f_year_id) {
            window.axios
                .post("/closing-balance", {
                    f_year_id: f_year_id,
                    start_date: this.start_date,
                    end_date: this.end_date,
                })
                .then((response) => {
                    this.showAlert(
                        "success",
                        this.$func.__("Balance Sheet Closed!", "erp")
                    );
                    this.closingBtnVisibility = false;
                })
                .catch((error) => {
                    throw error;
                })
                .then(() => {});
        },
    },
};
</script>

<style>
.content-header__title {
    padding-top: 5px !important;
}
.content-header__title a {
    margin-left: 15px;
}
.balance-sheet .tablenav.top,
.balance-sheet .tablenav.bottom {
    display: none;
}
.blnce-sheet-top,
.query-options,
.close-check {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.blnce-sheet-top em,
.query-options em,
.close-check em {
    font-weight: bold;
}
.fyear-select {
    min-width: 200px;
    margin-bottom: 15px;
}

.closing-blnc {
    display: flex;
}

.close-now-btn {
    margin: 0 15px;
    visibility: hidden;
}
.close-now-btn.visible {
    visibility: visible;
}

.close-check label {
    margin: 0;
}

.close-check input {
    box-shadow: none;
    width: 20px;
    margin-top: 1px;
    height: 20px;
    border-radius: 3px;
}
.close-check input[type="checkbox"]:checked:before {
    margin: -1px 0 0 -2px;
}
.balance-sheet-asset tbody tr td:last-child {
    text-align: left !important;
}
.balance-sheet-asset .t-foot td:last-child {
    font-size: 16px;
}
.balance-sheet-asset .t-foot td {
    color: #2196f3;
    font-weight: bold;
}

@media screen and (max-width: 782px) {
    .report-table .balance-sheet-asset thead th .column.balance,
    .report-table .balance-sheet-liability thead th .column.balance,
    .report-table .balance-sheet-equity thead th .column.balance {
        display: none;
    }
}

.report-table tbody tr td:first-child {
    width: 70% !important;
}
.balance-sheet-liability tbody tr td:last-child {
    text-align: initial !important;
}
.balance-sheet-liability .t-foot td {
    color: #2196f3;
    font-weight: bold;
}
.balance-sheet-equity tbody tr td:last-child {
    text-align: initial !important;
}

.balance-sheet-equity .t-foot td {
    color: #2196f3;
    font-weight: bold;
}
.liability-equity-balance tr td {
    background-color: #f2f2f2;
    color: #2196f3;
    font-weight: bold;
}

.liability-equity-balance tr td:last-child td:nth-child(2) {
    font-size: 16px;
}

.additional {
    max-width: 300px;
    padding-left: 30px;
}
.additional em {
    float: right;
    display: inline-block;
}

@media print {
    .erp-nav-container {
        display: none;
    }
}

.no-print,
.no-print * {
    display: none !important;
}
.balance-sheet .mybizna-row .mybizna-col-sm-12 {
    width: 100%;
}

.balance-sheet p {
    margin-bottom: 20px;
}

.balance-sheet p em {
    font-weight: bold;
}
.balance-sheet .mybizna-table td,
.balance-sheet .mybizna-table th {
    padding: 3px 20px;
}

.balance-sheet .mybizna-table thead tr th {
    font-weight: bold;
}

.balance-sheet .mybizna-table thead tr th:not(:first-child) {
    text-align: right;
}

.balance-sheet .mybizna-table tbody tr td :not(:first-child) {
    text-align: right !important;
}
.balance-sheet .mybizna-table tfoot td:not(:first-child) {
    text-align: right !important;
}
</style>
