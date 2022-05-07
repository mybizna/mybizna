<template>
    <div class="container chart-accounts">
        <div class="content-header-section separator">
            <div class="row between-xs">
                <div class="col-6">
                    <h2 class="content-header__title">
                        {{ this.$func.__("Chart of Accounts", "erp") }}
                        <router-link
                            class="btn btn-primary"
                            :to="{ name: 'AddChartAccounts' }"
                            id="erp-add-chart-of-account"
                        >
                            {{ this.$func.__("Add New", "erp") }}
                        </router-link>
                    </h2>
                </div>
                <div class="col-6">
                    <h4>{{ this.$func.__("Search Ledger", "erp") }}</h4>
                    <input
                        type="text"
                        class="form-control form-contro-sm form-field"
                        v-model="search"
                    />
                </div>
            </div>
        </div>

        <ul v-if="search">
            <list-table
                ="table table-sm table-striped widefat table2 chart-list"
                action-column="actions"
                :columns="columns"
                :actions="actions"
                :showCb="false"
                :rows="filteredLedgers"
                @action:click="onActionClick"
            >
                <template slot="ledger_name" slot-scope="data">
                    <router-link
                        :to="{
                            name: 'LedgerSingle',
                            params: {
                                id: data.row.id,
                                ledgerID: data.row.id,
                                ledgerName: data.row.name,
                                ledgerCode: data.row.code,
                            },
                        }"
                        >{{ data.row.name }}
                    </router-link>
                </template>
                <template slot="trn_count" slot-scope="data">
                    <router-link
                        :to="{
                            name: 'LedgerReport',
                            params: {
                                id: data.row.id,
                                ledgerID: data.row.id,
                                ledgerName: data.row.name,
                                ledgerCode: data.row.code,
                            },
                        }"
                        >{{ data.row.trn_count }}
                    </router-link>
                </template>
                <template
                    slot="row-actions"
                    slot-scope="data"
                    v-if="data.row.system != null"
                >
                    <strong class="sys-acc">{{ this.$func.__("System", "erp") }}</strong>
                </template>
            </list-table>
        </ul>
        <ul v-else>
            <li :key="index" v-for="(chart, index) in chartAccounts">
                <div style="display: flex">
                    <h3>{{ chart.label }}</h3>
                    <span
                        class="erp-help-tip .erp-tips"
                        :title="
                            this.$func.__(
                                'System account could not be edited or deleted anyway as those are defined by the accounting terms.',
                                'erp'
                            )
                        "
                    ></span>
                </div>

                <list-table
                    tableClass="table table-sm table-striped widefat table2 chart-list"
                    action-column="actions"
                    :columns="columns"
                    :actions="actions"
                    :showCb="false"
                    :rows="ledgers[parseInt(chart.id)]"
                    @action:click="onActionClick"
                >
                    <template slot="ledger_name" slot-scope="data">
                        <router-link
                            :to="{
                                name: 'LedgerSingle',
                                params: {
                                    id: data.row.id,
                                    ledgerID: data.row.id,
                                    ledgerName: data.row.name,
                                    ledgerCode: data.row.code,
                                },
                            }"
                            >{{ data.row.name }}
                        </router-link>
                    </template>
                    <template slot="trn_count" slot-scope="data">
                        <router-link
                            :to="{
                                name: 'LedgerReport',
                                params: {
                                    id: data.row.id,
                                    ledgerID: data.row.id,
                                    ledgerName: data.row.name,
                                    ledgerCode: data.row.code,
                                },
                            }"
                            >{{ data.row.trn_count }}
                        </router-link>
                    </template>
                    <template
                        slot="row-actions"
                        slot-scope="data"
                        v-if="data.row.system != null"
                    >
                        <strong class="sys-acc">{{
                            this.$func.__("System", "erp")
                        }}</strong>
                    </template>
                </list-table>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            columns: {
                code: { label: this.$func.__("Code", "erp"), isColPrimary: true },
                ledger_name: { label: this.$func.__("Name", "erp") },
                balance: { label: this.$func.__("Balance", "erp") },
                trn_count: { label: this.$func.__("Count", "erp") },
                actions: { label: this.$func.__("Actions", "erp") },
            },
            actions: [
                { key: "edit", label: this.$func.__("Edit", "erp") },
                // { key: 'trash', label: 'Delete' }
            ],

            chartAccounts: [],
            ledgers: [],
            temp_ledgers: this.$mybizna_var.ledgers /* global this.$this.$this.$mybizna_var */,
            search: "",
            curSymbol: this.$mybizna_var.symbol || "$",
        };
    },

    computed: {
        filteredLedgers() {
            var self = this;
            return this.temp_ledgers.filter(function (ledger) {
                return (
                    ledger.name
                        .toLowerCase()
                        .indexOf(self.search.toLowerCase()) >= 0
                );
            });
        },
    },

    components: {
        ListTable: window.$func.fetchComponent('components/list-table/ListTable.vue'),
    },

    created() {
        this.fetchChartAccounts();
        this.fetchLedgers();
    },

    methods: {
        groupBy(arr, fn) {
            /* https://30secondsofcode.org/ */
            return arr
                .map(typeof fn === "function" ? fn : (val) => val[fn])
                .reduce((acc, val, i) => {
                    acc[val] = (acc[val] || []).concat(arr[i]);
                    return acc;
                }, {});
        },

        fetchChartAccounts() {
            this.chartAccounts = [];
            window.axios
                .get("/ledgers/accounts")
                .then((response) => {
                    this.chartAccounts = response.data;

                })
                .catch((error) => {
                    throw error;
                });
        },

        fetchLedgers() {
            this.temp_ledgers.forEach((ledger) => {
                ledger.balance = this.transformBalance(ledger.balance);
            });
            this.ledgers = this.groupBy(this.temp_ledgers, "chart_id");
        },

        transformBalance(val) {
            if (val === null && typeof val === "object") {
                val = 0;
            }

            if (typeof val === "string") {
                val = val.split(this.curSymbol)[1];
            }

            if (val < 0) {
                return `Cr. ${this.moneyFormat(Math.abs(val))}`;
            }

            return `Dr. ${this.moneyFormat(val)}`;
        },

        onActionClick(action, row, index) {
            switch (action) {
                case "trash":
                    if (confirm(this.$func.__("Are you sure to delete?", "erp"))) {

                        window.axios
                            .delete(`/ledgers/${row.id}`)
                            .then((response) => {
                                this.fetchChartAccounts();

                            })
                            .catch((error) => {
                                throw error;
                            });
                    }
                    break;

                case "edit":
                    this.$router.push({
                        name: "ChartAccountsEdit",
                        params: { id: row.id },
                    });
                    break;

                default:
            }
        },
    },
};
</script>

<style>
.chart-accounts .tablenav,
.chart-accounts .tablenav,
.chart-accounts .column-cb,
.chart-accounts .check-column {
    display: none !important;
}

.chart-accounts li {
    margin-bottom: 20px;
}

.chart-accounts .chart-list .sys-acc {
    color: #ff6f00;
}

.chart-accounts .chart-list thead,
.chart-accounts .chart-list tfoot {
    width: 25%;
}
.chart-accounts .chart-list tfoot th:last-child {
    text-align: right;
}

.chart-accounts th.column.actions {
    float: right;
}

.chart-list tr .ledger_name {
    width: 40%;
}

.chart-accounts .erp-help-tip {
    font-size: 1.3em;
    left: 3px;
    top: 3.5px;
}
</style>
