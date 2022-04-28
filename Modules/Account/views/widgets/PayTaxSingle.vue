<template>
    <div class="mybizna-modal-dialog expense-single">
        <div class="mybizna-modal-content">
            <div class="mybizna-modal-header">
                <h2>{{ window.$func.__("Tax Payment", "erp") }}</h2>
                <div class="d-print-none">
                    <a
                        href="#"
                        class="mybizna-btn btn--default print-btn"
                        @click.prevent="printPopup"
                    >
                        <i class="flaticon-printer-1"></i>
                        &nbsp; {{ window.$func.__("Print", "erp") }}
                    </a>
                    <!-- todo: more action has some dropdown and will implement later please consider as planning -->
                    <dropdown>
                        <template slot="button">
                            <a href="#" class="mybizna-btn btn--default">
                                <i class="flaticon-settings-work-tool"></i>
                                &nbsp; {{ window.$func.__("More Action", "erp") }}
                            </a>
                        </template>
                        <template slot="dropdown">
                            <ul role="menu">
                                <li>
                                    <a
                                        href="#"
                                        @click.prevent="showModal = true"
                                        >{{ window.$func.__("Send Mail", "erp") }}</a
                                    >
                                </li>
                            </ul>
                        </template>
                    </dropdown>
                </div>
            </div>

            <send-mail v-if="showModal" :data="print_data" :type="type" />

            <div class="mybizna-modal-body">
                <div class="mybizna-invoice-panel">
                    <div class="invoice-header" v-if="null != company">
                        <div class="invoice-logo">
                            <img
                                :src="company.logo"
                                alt="logo name"
                                width="100"
                                height="100"
                            />
                        </div>
                        <div class="invoice-address">
                            <address>
                                <strong>{{ company.name }}</strong
                                ><br />
                                {{ company.address.address_1 }}<br />
                                {{ company.address.address_2 }}<br />
                                {{ company.address.city }}<br />
                                {{ company.address.country }}
                            </address>
                        </div>
                    </div>

                    <div class="invoice-body">
                        <h4>{{ window.$func.__("Tax Payment to", "erp") }}</h4>
                        <div class="mybizna-row" v-if="null != tax_pay_data">
                            <div class="mybizna-col-sm-6">
                                <div class="persons-info">
                                    <strong>{{ tax_pay_data.agency_id }}</strong
                                    ><br />
                                </div>
                            </div>
                            <div class="mybizna-col-sm-6">
                                <table class="invoice-info">
                                    <tr>
                                        <th>{{ window.$func.__("Voucher No", "erp") }}</th>
                                        <td>#{{ tax_pay_data.voucher_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ window.$func.__("Payment Date", "erp") }}:
                                        </th>
                                        <td>
                                            {{
                                                formatDate(
                                                    tax_pay_data.trn_date
                                                )
                                            }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div
                        class="mybizna-invoice-table"
                        v-if="null != tax_pay_data"
                    >
                        <table
                            class="mybizna-table mybizna-form-table invoice-table"
                        >
                            <thead>
                                <tr>
                                    <th>{{ window.$func.__("Voucher No", "erp") }}</th>
                                    <th>{{ window.$func.__("Account", "erp") }}</th>
                                    <th>{{ window.$func.__("Voucher Type", "erp") }}</th>
                                    <th>{{ window.$func.__("Amount", "erp") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="inline-edit-row">
                                    <td>{{ tax_pay_data.voucher_no }}</td>
                                    <td>{{ tax_pay_data.ledger_id }}</td>
                                    <td>{{ tax_pay_data.voucher_type }}</td>
                                    <td>
                                        {{ moneyFormat(tax_pay_data.amount) }}
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="inline-edit-row">
                                    <td colspan="7">
                                        <ul>
                                            <li>
                                                <span
                                                    >{{
                                                        window.$func.__("Total", "erp")
                                                    }}:</span
                                                >
                                                {{
                                                    moneyFormat(
                                                        tax_pay_data.amount
                                                    )
                                                }}
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <br />
                                <tr>
                                    <td
                                        class="mybizna-invoice-amounts"
                                        colspan="7"
                                    >
                                        <h2>{{ window.$func.__("Particulars", "erp") }}</h2>
                                        <p v-if="tax_pay_data.particulars">
                                            {{ tax_pay_data.particulars }}
                                        </p>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SendMail from "assets/components/email/SendMail.vue";
import Dropdown from "assets/components/base/Dropdown.vue";

export default {
    components: {
        SendMail,
        Dropdown,
    },

    data() {
        return {
            company: null,
            tax_pay_data: {},
            isWorking: false,
            acct_var: erp_acct_var /* global erp_acct_var */,
            print_data: null,
            type: "expense",
            showModal: false,
        };
    },

    created() {
        this.getCompanyInfo();
        this.getExpense();

        this.$root.$on("close", () => {
            this.showModal = false;
        });
    },

    methods: {
        getCompanyInfo() {
            window.axios
                .get(`/company`)
                .then((response) => {
                    this.company = response.data;
                })
                .then((e) => {})
                .then(() => {
                    this.isWorking = false;
                });
        },

        getExpense() {
            this.isWorking = true;

            window.axios
                .get(`/taxes/tax-records/${this.$route.params.id}`)
                .then((response) => {
                    this.tax_pay_data = response.data;
                })
                .catch((error) => {
                    throw error;
                })
                .then((e) => {})
                .then(() => {
                    this.print_data = this.tax_pay_data;
                    this.isWorking = false;
                });
        },

        printPopup() {
            window.print();
        },
    },
};
</script>

<style>
.expense-single {
    max-width: 960px;
    margin: 0 auto;
}
.expense-single .mybizna-modal-footer {
    border-top: 1px solid #e2e2e2;
}
.expense-single .mybizna-modal-header {
    border-bottom: 1px solid #e2e2e2;
}
.expense-single .mybizna-form-field,
.expense-single input:not(.mybizna-btn) {
    padding-top: 10px !important;
    padding-bottom: 10px !important;
}

@media print {
    .erp-nav-container {
        display: none;
    }
}
</style>
