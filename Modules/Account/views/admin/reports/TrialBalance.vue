<template>
    <div class="trial-balance">
        <h2>{{ this.$func.__("Trial Balance", "erp") }}</h2>

        <div class="with-multiselect fyear-select">
            <multi-select
                v-model="selectedYear"
                @input="onYearSelected"
                :options="fyears"
            />
        </div>

        <form @submit.prevent="getTrialBalance" class="query-options no-print">
            <div class="date-btn-group">
                <datepicker v-model="start_date"></datepicker>
                <datepicker v-model="end_date"></datepicker>
            </div>

            <button
                class="btn btn-primary add-line-trigger"
                type="submit"
            >
                {{ this.$func.__("View", "erp") }}
            </button>

            <a
                href="#"
                class="btn btn-default print-btn"
                @click.prevent="printPopup"
            >
                <i class="flaticon-printer-1"></i> &nbsp;
                {{ this.$func.__("Print", "erp") }}
            </a>
        </form>

        <p>
            <strong
                >{{
                    this.$func.__("For the period of ( Transaction date )", "erp")
                }}:</strong
            >
            <em>{{ start_date }}</em> {{ this.$func.__("to", "erp") }}
            <em>{{ end_date }}</em>
        </p>

        <table class="table table-striped widefat">
            <thead>
                <tr>
                    <th>{{ this.$func.__("Account Name", "erp") }}</th>
                    <th>{{ this.$func.__("Debit Total", "erp") }}</th>
                    <th>{{ this.$func.__("Credit Total", "erp") }}</th>
                </tr>
            </thead>
            <tbody :key="key" v-for="(chart, key) in chrtAcct">
                <tr v-if="rows[chart.id] && debugMode">
                    <h1>{{ chart.label }}</h1>
                </tr>

                <tr
                    :key="index"
                    v-for="(row, index) in rows[chart.id]"
                    class="inline-edit-row"
                >
                    <td>
                        <details v-if="row.additional" open>
                            <summary>{{ row.name }}</summary>
                            <p
                                :key="additional.id"
                                v-for="additional in row.additional"
                            >
                                <strong>{{ additional.name }}</strong>
                                <em>{{
                                    moneyFormat(Math.abs(additional.balance))
                                }}</em>
                            </p>
                        </details>

                        <span v-else>{{ row.name }}</span>
                    </td>

                    <td>
                        {{
                            Math.sign(row.balance) === 1
                                ? moneyFormat(row.balance)
                                : ""
                        }}
                    </td>
                    <td>
                        {{
                            Math.sign(row.balance) === -1
                                ? moneyFormat(Math.abs(row.balance))
                                : ""
                        }}
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="t-foot inline-edit-row">
                    <td>{{ this.$func.__("Total", "erp") }}</td>
                    <td>{{ moneyFormat(totalDebit) }}</td>
                    <td>{{ moneyFormat(Math.abs(totalCredit)) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>

export default {
    components: {
        Datepicker: window.$func.fetchComponent('components/base/Datepicker.vue'),
        MultiSelect: window.$func.fetchComponent('components/select/MultiSelect.vue'),
    },

    data() {
        return {
            bulkActions: [
                {
                    key: "trash",
                    label: this.$func.__("Move to Trash", "erp"),
                    img:
                        this.$mybizna_var.erp_assets +
                        "/images/trash.png" /* global var */,
                },
            ],
            columns: {
                name: { label: this.$func.__("Account Name", "erp") },
                debit: { label: this.$func.__("Debit Total", "erp") },
                credit: { label: this.$func.__("Credit Total", "erp") },
            },
            rows: [],
            fyears: [],
            totalDebit: 0,
            totalCredit: 0,
            chrtAcct: null,
            start_date: null,
            end_date: null,
            selectedYear: null,
        };
    },

    computed: {
        debugMode() {
            return this.$mybizna_var.erp_debug_mode === "1";
        },
    },

    created() {
        this.fetchFnYears();
        // ? why is nextTick here ...? I don't know.
        this.$nextTick(function () {
            // with leading zero, and JS month are zero index based
            // const dateObj = new Date();

            // const month = ('0' + (dateObj.getMonth() + 1)).slice(-2);

            if (this.$route.query.start) {
                this.start_date = this.$route.query.start;
                this.end_date = this.$route.query.end;
            } else {
                this.closestFnYear();
            }
        });

        this.getChartOfAccts();
    },

    methods: {
        closestFnYear() {
            window.axios.get("/reports/closest-fn-year").then((response) => {
                this.start_date = response.data.start_date;
                this.end_date = response.data.end_date;

                this.getTrialBalance();
                this.setFnYear(response.data);
            });
        },

        setFnYear(closestYear) {
            let year = this.fyears.filter((item) => {
                return item.id === closestYear.id;
            });

            this.selectedYear = year.length ? year[0] : null;
        },
        onYearSelected() {
            this.start_date = this.selectedYear.start_date;
            this.end_date = this.selectedYear.end_date;

            this.selectedYear = {
                id: parseInt(this.selectedYear.id),
                name: this.selectedYear.name,
            };

            this.getTrialBalance();
        },

        updateDate() {
            /* this.$router.push({ path: this.$route.path,
                query: {
                    start: this.start_date,
                    end  : this.end_date
                } });*/
        },

        getChartOfAccts() {
            window.axios.get("/ledgers/accounts").then((response) => {
                this.chrtAcct = response.data;

                this.setDateAndGetTb();
            });
        },

        setDateAndGetTb() {
            // this.updateDate();
            this.getTrialBalance();
        },

        fetchFnYears() {
            window.axios.get("/opening-balances/names").then((response) => {
                // get only last 5
                this.fyears = response.data.reverse().slice(0).slice(-5);
            });
        },

        getTrialBalance() {
            this.updateDate();

            this.rows = [];

            window.axios
                .get("/reports/trial-balance", {
                    params: {
                        start_date: this.start_date,
                        end_date: this.end_date,
                    },
                })
                .then((response) => {
                    this.rows = response.data.rows;
                    this.totalDebit = response.data.total_debit;
                    this.totalCredit = response.data.total_credit;

                })
                .catch((e) => {
                });
        },

        printPopup() {
            window.print();
        },
    },
};
</script>

<style>
.trial-balance h2 {
    padding-top: 15px;
}

.trial-balance tr h1 {
    padding-left: 10px;
    font-size: 15px;
    font-weight: bold;
}

.trial-balance .col--check {
    display: none;
}

.trial-balance .tablenav .top,
.trial-balance .tablenav .bottom {
    display: none;
}

.trial-balance tbody tr td:last-child {
    text-align: initial !important;
}

.trial-balance .t-foot td {
    color: #2196f3;
    font-weight: bold;
}

.trial-balance .query-options {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 500px;
    padding: 20px 0;
}

.trial-balance .fyear-select {
    width: 320px;
    margin-bottom: 0;
    margin-top: 10px;
}

.trial-balance details summary {
    margin-bottom: 15px;
}
.trial-balance details summary:focus {
    outline: 0;
}

.trial-balance details p {
    display: flex;
    justify-content: space-between;
    max-width: 300px;
    padding: 3px;
}

@media screen {
    .trial-balance .inline-edit-row td {
        padding: 18px 10px;
    }

    .trial-balance .inline-edit-row td:first-child {
        padding-left: 20px;
    }
}

@media (max-width: 782px) {
    .trial-balance .inline-edit-row td:first-child {
        border-right: 1px solid #eeeeee;
    }

    .trial-balance .inline-edit-row td:last-child {
        border-left: 1px solid #eeeeee;
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

    .trial-balance p {
        margin-bottom: 0;
    }
    .trial-balance p em {
        font-weight: bold;
    }

    .trial-balance .table {
        margin-top: 20px;
    }
    .trial-balance .table td,
    .trial-balance .table th {
        padding: 3px 20px;
    }

    .trial-balance .table thead tr th {
        font-weight: bold;
    }

    .trial-balance .table thead tr th:not(:first-child) {
        text-align: right;
    }

    .trial-balance .table tbody tr td:not(:first-child) {
        text-align: right !important;
    }
}

.trial-balance .table tfoot td:not(:first-child) {
    text-align: right !important;
}

.trial-balance details {
    margin: 0;
    padding: 0;
}
.trial-balance details summary {
    margin-bottom: 2px;
}
</style>
