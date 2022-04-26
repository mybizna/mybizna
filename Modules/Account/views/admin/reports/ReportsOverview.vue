<template>
    <ul class="reports-overview">
        <li>
            <h3>{{ this.$func.__("Trial Balance", "erp") }}</h3>
            <p>
                {{
                    this.$func.__(
                        "Trial balance is the bookkeeping or accounting report that lists the balances in each of general ledger accounts",
                        "erp"
                    )
                }}.
            </p>

            <router-link
                class="wperp-btn btn--primary"
                :to="{ name: 'TrialBalance' }"
                >{{ this.$func.__("View Report", "erp") }}</router-link
            >
        </li>

        <li>
            <h3>{{ this.$func.__("Ledger Report", "erp") }}</h3>
            <p>
                {{
                    this.$func.__(
                        "The ledger report contains the classified and detailed information of all the individual accounts including the debit and credit aspects.",
                        "erp"
                    )
                }}
            </p>

            <router-link
                class="wperp-btn btn--primary"
                :to="{ name: 'LedgerSingle', params: { id: 7 } }"
                >{{ this.$func.__("View Report", "erp") }}</router-link
            >
        </li>

        <li>
            <h3>{{ this.$func.__("Income Statement", "erp") }}</h3>
            <p>
                {{
                    this.$func.__(
                        "A summary of a management's performance reflected as the profitability of an organization during the time interval",
                        "erp"
                    )
                }}.
            </p>

            <router-link
                class="wperp-btn btn--primary"
                :to="{ name: 'IncomeStatement' }"
                >View Report</router-link
            >
        </li>

        <li>
            <h3>{{ this.$func.__("Sales Tax", "erp") }}</h3>
            <p>
                {{
                    this.$func.__(
                        "It generates report based on the sales tax charged or paid for the current financial cycle/year",
                        "erp"
                    )
                }}.
            </p>

            <router-link
                class="wperp-btn btn--primary"
                :to="{ name: 'SalesTaxReportOverview' }"
                >{{ this.$func.__("View Report", "erp") }}</router-link
            >
        </li>

        <li>
            <h3>{{ this.$func.__("Balance Sheet", "erp") }}</h3>
            <p>
                {{
                    this.$func.__(
                        'This report gives you an immediate status of your accounts at a specified date. You can call it a "Snapshot" view of the current position (day) of the financial year',
                        "erp"
                    )
                }}.
            </p>

            <router-link
                class="wperp-btn btn--primary"
                :to="{ name: 'BalanceSheet' }"
                >{{ this.$func.__("View Report", "erp") }}</router-link
            >
        </li>

        <component
            v-for="(component, index) in reportLists"
            :key="index"
            :is="component"
        />
    </ul>
</template>

<script>
export default {
    data() {
        return {
            reportLists: window.acct.hooks.applyFilters(
                "acctExtensionReportsList",
                []
            ),
            proEnable: false,
            proActivated: false,
        };
    },

    watch: {
        "$store.state..common.erp_pro_activated": function () {
            console.log(this.$store.state.erp_pro_activated + "ok");
        },
    },

    mounted() {
        setTimeout(() => {
            this.proActivated = this.$store.state.erp_pro_activated;
        }, 200);
    },
};
</script>

<style>
.reports-overview {
    margin: 0;
    padding: 10px;
    display: flex;
    flex-wrap: wrap;
}
.reports-overview li {
    font-size: 20px;
    background: #fff;
    margin-bottom: 1px;
    padding: 15px;
    width: 48%;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.04);
    margin: 10px;
    border-radius: 3px;
}
.reports-overview li h3 {
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    padding-bottom: 10px;
    font-weight: normal;
    color: #263238;
}

.reports-overview li p {
    font-size: 15px;
    color: #525252;
}
</style>
