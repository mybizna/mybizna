<template>
    <div class="sales-tax-report">
        <h2 class="title-container">
            <span>{{ this.$func.__("Sales Tax Report (Agency Based)", "erp") }}</span>

            <router-link
                class="mybizna-btn btn--primary"
                :to="{ name: 'SalesTaxReportOverview' }"
            >
                {{ this.$func.__("Back", "erp") }}
            </router-link>
        </h2>

        <form @submit.prevent="getReport" class="query-options no-print">
            <div class="mybizna-date-group">
                <div class="with-multiselect">
                    <multi-select
                        v-model="selectedAgency"
                        :options="taxAgencies"
                        @input="getReport"
                    />
                </div>

                <datepicker v-model="startDate" />

                <datepicker v-model="endDate" />

                <button
                    class="mybizna-btn btn--primary add-line-trigger"
                    type="submit"
                >
                    {{ this.$func.__("Filter", "erp") }}
                </button>
            </div>

            <a
                href="#"
                class="mybizna-btn btn--default print-btn"
                @click.prevent="printPopup"
            >
                <i class="flaticon-printer-1"></i>
                &nbsp; {{ this.$func.__("Print", "erp") }}
            </a>
        </form>

        <ul class="report-header" v-if="null !== selectedAgency">
            <li>
                <strong>{{ this.$func.__("Agency Name", "erp") }}:</strong>
                <em> {{ selectedAgency.name }}</em>
            </li>

            <li>
                <strong>{{ this.$func.__("Currency", "erp") }}:</strong>
                <em> {{ symbol }}</em>
            </li>

            <li v-if="startDate && endDate">
                <strong
                    >{{
                        this.$func.__("For the period of (Transaction date)", "erp")
                    }}:</strong
                >
                <em> {{ formatDate(startDate) }}</em> to
                <em>{{ formatDate(endDate) }}</em>
            </li>
        </ul>

        <list-table
            tableClass="mybizna-table table-striped table-dark widefat sales-tax-table"
            :columns="columns"
            :rows="rows"
            :showCb="false"
        >
            <template slot="trn_no" slot-scope="data">
                <strong>
                    <router-link
                        :to="{
                            name: 'DynamicTrnLoader',
                            params: {
                                id: data.row.trn_no,
                            },
                        }"
                    >
                        <span v-if="data.row.trn_no"
                            >#{{ data.row.trn_no }}</span
                        >
                    </router-link>
                </strong>
            </template>

            <template slot="debit" slot-scope="data">
                {{ moneyFormat(data.row.debit) }}
            </template>

            <template slot="credit" slot-scope="data">
                {{ moneyFormat(data.row.credit) }}
            </template>

            <template slot="balance" slot-scope="data">
                {{ moneyFormat(data.row.balance) }}
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

export default {
    name: "SalesTaxReportCategoryBased",

    components: {
        ListTable:window.$func.fetchComponent('components/list-table/ListTable.vue'),
        Datepicker:window.$func.fetchComponent('components/base/Datepicker.vue'),
        MultiSelect:window.$func.fetchComponent('components/select/MultiSelect.vue'),
    },

    data() {
        return {
            startDate: null,
            endDate: null,
            selectedAgency: null,
            taxAgencies: [],
            openingBalance: 0,
            rows: [],
            totalDebit: 0,
            totalCredit: 0,
            symbol: erp_acct_var.symbol,
            columns: {
                trn_no: {
                    label: this.$func.__("Voucher No", "erp"),
                    isColPrimary: true,
                },
                trn_date: {
                    label: this.$func.__("Transaction Date", "erp"),
                },
                particulars: {
                    label: this.$func.__("Particulars", "erp"),
                },
                debit: {
                    label: this.$func.__("Debit", "erp"),
                },
                credit: {
                    label: this.$func.__("Credit", "erp"),
                },
                balance: {
                    label: this.$func.__("Balance", "erp"),
                },
            },
        };
    },

    watch: {
        selectedAgency() {
            this.rows = [];
        },
    },

    created() {
        this.$nextTick(() => {
            const dateObj = new Date();
            const month = ("0" + (dateObj.getMonth() + 1)).slice(-2);
            const year = dateObj.getFullYear();

            this.startDate = `${year}-${month}-01`;
            this.endDate = erp_acct_var.current_date;

            this.fetchData();
        });
    },

    methods: {
        fetchData() {

            window.axios
                .get("/tax-agencies")
                .then((res) => {
                    this.taxAgencies = res.data;
                })
                .then(() => {
                    if (this.taxAgencies && this.taxAgencies[0] !== undefined) {
                        this.selectedAgency = this.taxAgencies[0];
                        this.getReport();
                    }
                });
        },

        getReport() {

            this.rows = [];

            window.axios
                .get("/reports/sales-tax", {
                    params: {
                        agency_id: this.selectedAgency.id,
                        start_date: this.startDate,
                        end_date: this.endDate,
                    },
                })
                .then((response) => {
                    this.rows = response.data.details;
                    this.totalDebit = response.data.extra.total_debit;
                    this.totalCredit = response.data.extra.total_credit;

                    this.rows.forEach((item) => {
                        item.trn_date = this.formatDate(item.trn_date);
                        item.created_at = this.formatDate(item.created_at);
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
@media screen and (max-width: 782px) {
    .sales-tax-table tfoot tr:not(.inline-edit-row):not(.no-items) td {
        padding: 10px 10px 10px 35%;
    }

    .sales-tax-table tfoot tr td:first-child {
        display: none !important;
    }

    .sales-tax-table tfoot tr td[data-left-align] {
        padding-left: 10px !important;
    }
}
</style>
