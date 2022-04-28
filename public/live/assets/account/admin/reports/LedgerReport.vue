<template>
    <div class="ledger-report">
        <h2>{{ this.$func.__("Ledger Report", "erp") }}</h2>

        <form
            action=""
            method=""
            @submit.prevent="getLedgerReport"
            class="query-options no-print"
        >
            <div class="with-multiselect">
                <multi-select v-model="selectedLedger" :options="ledgers" />
            </div>

            <div class="mybizna-date-group">
                <datepicker v-model="start_date"></datepicker>
                <datepicker v-model="end_date"></datepicker>

                <button
                    class="mybizna-btn btn--primary add-line-trigger"
                    type="submit"
                >
                    {{ this.$func.__("Filter", "erp") }}
                </button>

                <a
                    href="#"
                    class="mybizna-btn btn--default print-btn"
                    @click.prevent="printPopup"
                >
                    <i class="flaticon-printer-1"></i>
                    &nbsp; {{ this.$func.__("Print", "erp") }}
                </a>
            </div>
        </form>

        <ul class="report-header" v-if="null !== selectedLedger">
            <li>
                <strong>{{ this.$func.__("Account No", "erp") }}:</strong>
                <em>{{ selectedLedger.code }}</em>
            </li>
            <li>
                <strong>{{ this.$func.__("Account Name", "erp") }}:</strong>
                <em>{{ selectedLedger.name }}</em>
            </li>
            <li>
                <strong>{{ this.$func.__("Currency", "erp") }}:</strong>
                <em>{{ symbol }}</em>
            </li>
            <li>
                <strong
                    >{{
                        this.$func.__("For the period of ( Transaction date )", "erp")
                    }}:</strong
                >
                <em>{{ formatDate(start_date) }}</em> to
                <em>{{ formatDate(end_date) }}</em>
            </li>
        </ul>

        <list-table
            tableClass="mybizna-table table-striped table-dark widefat ledger-table"
            :columns="columns"
            :rows="rows"
            :showCb="false"
        >
            <template slot="trn_no" slot-scope="data" v-if="data.row.trn_no">
                <strong>
                    <router-link
                        :to="{
                            name: 'DynamicTrnLoader',
                            params: { id: data.row.trn_no },
                        }"
                    >
                        <span>#{{ data.row.trn_no }}</span>
                    </router-link>
                </strong>
            </template>
            <template slot="balance" slot-scope="data">
                {{ moneyFormatwithDrCr(data.row.balance) }}
            </template>
            <template slot="debit" slot-scope="data">
                {{ moneyFormat(data.row.debit) }}
            </template>
            <template slot="credit" slot-scope="data">
                {{ moneyFormat(data.row.credit) }}
            </template>
            <template slot="tfoot">
                <tr class="tfoot">
                    <td colspan="3"></td>
                    <td data-left-align>{{ this.$func.__("Total", "erp") }} =</td>
                    <td data-colname="Debit">{{ moneyFormat(totalDebit) }}</td>
                    <td data-colname="Credit">
                        {{ moneyFormat(totalCredit) }}
                    </td>
                    <td></td>
                </tr>
            </template>
        </list-table>
    </div>
</template>

<script>
import ListTable from "assets/components/list-table/ListTable.vue";
import Datepicker from "assets/components/base/Datepicker.vue";
import MultiSelect from "assets/components/select/MultiSelect.vue";

export default {
    components: {
        ListTable,
        Datepicker,
        MultiSelect,
    },

    data() {
        return {
            start_date: null,
            end_date: null,
            selectedLedger: null,
            ledgers: [],
            openingBalance: 0,
            columns: {
                trn_date: { label: this.$func.__("Trns Date", "erp"), isColPrimary: true },
                created_at: { label: this.$func.__("Created At", "erp") },
                trn_no: { label: this.$func.__("Trns No", "erp") },
                particulars: { label: this.$func.__("Particulars", "erp") },
                debit: { label: this.$func.__("Debit", "erp") },
                credit: { label: this.$func.__("Credit", "erp") },
                balance: { label: this.$func.__("Balance", "erp") },
            },
            rows: [],
            totalDebit: 0,
            totalCredit: 0,
            symbol: erp_acct_var.symbol /* global erp_acct_var */,
        };
    },

    watch: {
        selectedLedger(newVal) {
            if (!isNaN(newVal.id)) {
                this.rows = [];
                this.totalDebit = 0;
                this.totalCredit = 0;
                //  this.$router.push({ params: { id: parseInt(newVal.id) } });
            }
        },
    },

    created() {
        this.getLedgers();

        // ? why is nextTick here ...? i don't know.
        this.$nextTick(function () {
            const dateObj = new Date();

            // with leading zero, and JS month are zero index based
            const month = ("0" + (dateObj.getMonth() + 1)).slice(-2);
            const day = ("0" + dateObj.getDate()).slice(-2);

            this.start_date = `${dateObj.getFullYear()}-${month}-01`;
            this.end_date = `${dateObj.getFullYear()}-${month}-${day}`;

            if (this.$route.params.ledgerName) {
                // Directly coming from chart of acounts
                this.selectedLedger = {
                    id: parseInt(this.$route.params.ledgerID),
                    name: this.$route.params.ledgerName,
                    code: this.$route.params.ledgerCode,
                };

                this.getLedgerReport();
            }
        });
    },

    methods: {
        getLedgers() {
            window.axios.get("/ledgers").then((res) => {
                this.ledgers = res.data;

                this.setDefault();
            });
        },

        setDefault() {
            if (this.$route.params.id && !this.$route.params.ledgerName) {
                // Normally refresh page
                const ledger = this.ledgers.filter((ledger, _) => {
                    return (
                        parseInt(ledger.id) === parseInt(this.$route.params.id)
                    );
                })[0];

                this.selectedLedger = {
                    id: parseInt(ledger.id),
                    name: ledger.name,
                    code: ledger.code,
                };

                this.getLedgerReport();
            }
        },

        getLedgerReport() {
            if (this.selectedLedger === null) return;


            this.rows = [];

            window.axios
                .get("/reports/ledger-report", {
                    params: {
                        ledger_id: this.selectedLedger.id,
                        start_date: this.start_date,
                        end_date: this.end_date,
                    },
                })
                .then((response) => {
                    this.rows = response.data.details;
                    this.totalDebit = response.data.extra.total_debit;
                    this.totalCredit = response.data.extra.total_credit;

                    this.rows.forEach((item) => {
                        item.trn_date = this.formatDate(item.trn_date);
                        item.created_at = this.formatDate(item.created_at);
                        item.id = item.trn_no
                            ? item.trn_no
                            : parseInt("" + Math.random() * 100000);
                    });

                })
                .catch((_) => {
                });
        },

        printPopup() {
            window.print();
        },
    },
};
</script>

<style>
.ledger-report h2 {
    padding-top: 15px;
}

.ledger-report .print-btn {
    float: right;
}

.ledger-report .tablenav,
.ledger-report .column-cb,
.ledger-report .check-column {
    display: none;
}

.ledger-report .query-options {
    display: inline-block !important;
    padding: 20px 0;
    width: 100%;
}

.ledger-report .with-multiselect {
    width: 200px;
    float: left;
    margin-right: 50px;
}

.ledger-report .mybizna-btn {
    margin-top: 2px;
}

.ledger-report .report-header {
    width: 420px;
    padding: 10px 0 0 0;
}
.ledger-report .report-header li {
    display: flex;
    justify-content: space-between;
}

.ledger-report .ledger-table tbody tr td:last-child {
    text-align: left !important;
}

.ledger-report .ledger-table tbody tr:last-child td:last-child {
    font-weight: bold;
}

@media screen and ( max-width: 782px ) {
    .ledger-report tfoot tr:not(.inline-edit-row):not(.no-items) td {
        padding: 10px 10px 10px 35%;
    }

    .ledger-report tfoot tr td:first-child {
        display: none !important;
    }

    .ledger-report tfoot trtd[data-left-align] {
        padding-left: 10px !important;
    }
}

@media print {
    .erp-nav-container {
        display: none;
    }

    .no-print,
    .no-print * {
        display: none !important;
    }

    .ledger-report .report-header {
        margin: 0 0 20px 0;
    }

    .ledger-report .mybizna-table.ledger-table th.trn_date,
    .ledger-report .mybizna-table.ledger-table th.created_at,
    .ledger-report .mybizna-table.ledger-table .balance {
        min-width: 118px;
    }

    .ledger-report .mybizna-table.ledger-table th.trn_no {
        min-width: 95px;
    }

    .ledger-report .mybizna-table.ledger-table td.column.particulars {
        text-align: left !important;
    }

    .ledger-report .mybizna-table.ledger-table tr th:first-child,
    .ledger-report .mybizna-table.ledger-table tr td:last-child {
        padding-left: 5px;
    }

    .ledger-report .mybizna-table.ledger-table tr th:last-child,
    .ledger-report .mybizna-table.ledger-table tr td:last-child {
        padding-right: 5px;
    }

    .ledger-report .mybizna-table.ledger-table td,
    .ledger-report .mybizna-table.ledger-table th {
        padding: 3px 0;
    }

    .ledger-report .mybizna-table.ledger-table thead tr th {
        font-weight: bold;
    }
    .ledger-report .mybizna-table.ledger-table thead tr th :nth-child(5),
    .ledger-report .mybizna-table.ledger-table thead tr th :nth-child(6),
    .ledger-report .mybizna-table.ledger-table thead tr th :nth-child(7) {
        min-width: 100px;
        text-align: right;
    }

    .ledger-report .mybizna-table.ledger-table tbody tr td:nth-child(5),
    .ledger-report .mybizna-table.ledger-table tbody tr td:nth-child(6),
    .ledger-report .mybizna-table.ledger-table tbody tr td:nth-child(7) {
        min-width: 100px;
        text-align: right !important;
    }
}

.ledger-report .mybizna-table.ledger-table tbody tr:last-child td:last-child {
    font-weight: bold;
}

.ledger-report .mybizna-table.ledger-table tfoot td:nth-child(3),
.ledger-report .mybizna-table.ledger-table tfoot td:nth-child(4) {
    text-align: right !important;
}
</style>
