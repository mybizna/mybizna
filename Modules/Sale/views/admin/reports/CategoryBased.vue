<template>
    <div class="sales-tax-report">
        <h2 class="title-container">
            <span>{{ this.$func.__("Sales Tax Report (Category Based)", "erp") }}</span>

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
                        v-model="taxCategory"
                        :options="taxCategories"
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

        <ul class="report-header" v-if="null !== taxCategory">
            <li>
                <strong>{{ this.$func.__("Category Name", "erp") }}:</strong>
                <em> {{ taxCategory.name }}</em>
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
            tableClass="mybizna-table table-striped table-dark widefat sales-tax-table sales-tax-table-category"
            :columns="columns"
            :rows="taxes"
            :showCb="false"
        >
            <template slot="voucher_no" slot-scope="data">
                <strong>
                    <router-link
                        :to="{
                            name: 'SalesSingle',
                            params: {
                                id: data.row.voucher_no,
                                type: 'invoice',
                            },
                        }"
                    >
                        <span v-if="data.row.voucher_no"
                            >#{{ data.row.voucher_no }}</span
                        >
                    </router-link>
                </strong>
            </template>

            <template slot="tax_amount" slot-scope="data">
                {{ moneyFormat(parseFloat(data.row.tax_amount)) }}
            </template>

            <template slot="tfoot">
                <tr class="tfoot">
                    <td></td>
                    <td>{{ this.$func.__("Total", "erp") }} =</td>
                    <td>{{ moneyFormat(totalTax) }}</td>
                </tr>
            </template>
        </list-table>
    </div>
</template>

<script>
import ListTable from "../../list-table/ListTable.vue";
import Datepicker from "../../base/Datepicker.vue";
import MultiSelect from "../../select/MultiSelect.vue";

export default {
    components: {
        ListTable,
        Datepicker,
        MultiSelect,
    },

    data() {
        return {
            startDate: null,
            endDate: null,
            taxCategory: null,
            taxCategories: [],
            taxes: [],
            columns: {
                voucher_no: { label: this.$func.__("Voucher No", "erp") },
                trn_date: { label: this.$func.__("Transaction Date", "erp") },
                tax_amount: { label: this.$func.__("Tax Amount", "erp") },
            },
            symbol: erp_acct_var.symbol,
        };
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

    computed: {
        totalTax() {
            let total = 0;

            this.taxes.forEach((item) => {
                total += parseFloat(item.tax_amount);
            });

            return total;
        },
    },

    watch: {
        taxCategory() {
            this.taxes = [];
        },
    },

    methods: {
        fetchData() {

            window.axios
                .get("/tax-cats")
                .then((res) => {
                    this.taxCategories = res.data;
                })
                .then(() => {
                    if (
                        this.taxCategories &&
                        this.taxCategories[0] !== undefined
                    ) {
                        this.taxCategory = this.taxCategories[0];
                        this.getReport();
                    }
                });
        },

        getReport() {

            this.rows = [];

            window.axios
                .get("/reports/sales-tax", {
                    params: {
                        category_id: this.taxCategory.id,
                        start_date: this.startDate,
                        end_date: this.endDate,
                    },
                })
                .then((response) => {
                    this.taxes = response.data;
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
    .sales-tax-table-category thead th .column.trn_date,
    .sales-tax-table-category thead th .column.tax_amount {
        display: none;
    }

    .sales-tax-table-category tfoot tr.tfoot td:first-child {
        display: none !important;
    }
}
</style>
