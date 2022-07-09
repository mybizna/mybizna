<template>
    <div class="expense-single">
        <div >
            <div >
                <h2>{{ this.$func.__("Tax Payment", "erp") }}</h2>
                <div class="d-print-none">
                    <a
                        href="#"
                        class="btn btn-default print-btn"
                        @click.prevent="printPopup"
                    >
                        <i class="flaticon-printer-1"></i>
                        &nbsp; {{ this.$func.__("Print", "erp") }}
                    </a>
                    <!-- todo: more action has some dropdown and will implement later please consider as planning -->
                    <dropdown>
                        <template slot="button">
                            <a href="#" class="btn btn-default">
                                <i class="flaticon-settings-work-tool"></i>
                                &nbsp; {{ this.$func.__("More Action", "erp") }}
                            </a>
                        </template>
                        <template slot="dropdown">
                            <ul role="menu">
                                <li>
                                    <a
                                        href="#"
                                        @click.prevent="showModal = true"
                                        >{{ this.$func.__("Send Mail", "erp") }}</a
                                    >
                                </li>
                            </ul>
                        </template>
                    </dropdown>
                </div>
            </div>

            <send-mail v-if="showModal" :data="print_data" :type="type" />

            <div >
                <div class="invoice-panel">
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
                        <h4>{{ this.$func.__("Tax Payment to", "erp") }}</h4>
                        <div class="row" v-if="null != tax_pay_data">
                            <div class="col-sm-6">
                                <div class="persons-info">
                                    <strong>{{ tax_pay_data.agency_id }}</strong
                                    ><br />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <table class="invoice-info">
                                    <tr>
                                        <th>{{ this.$func.__("Voucher No", "erp") }}</th>
                                        <td>#{{ tax_pay_data.voucher_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ this.$func.__("Payment Date", "erp") }}:
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
                        class="invoice-table"
                        v-if="null != tax_pay_data"
                    >
                        <table
                            class="table form-table invoice-table"
                        >
                            <thead>
                                <tr>
                                    <th>{{ this.$func.__("Voucher No", "erp") }}</th>
                                    <th>{{ this.$func.__("Account", "erp") }}</th>
                                    <th>{{ this.$func.__("Voucher Type", "erp") }}</th>
                                    <th>{{ this.$func.__("Amount", "erp") }}</th>
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
                                                        this.$func.__("Total", "erp")
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
                                        class="invoice-amounts"
                                        colspan="7"
                                    >
                                        <h2>{{ this.$func.__("Particulars", "erp") }}</h2>
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

export default {
    components: {
        SendMail: window.$func.fetchComponent('components/email/SendMail.vue'),
        Dropdown: window.$func.fetchComponent('components/base/Dropdown.vue'),
    },

    data() {
        return {
            company: null,
            tax_pay_data: {},
            isWorking: false,
            acct_var: this.$mybizna_var /* global this.$mybizna_var */,
            print_data: null,
            type: "expense",
            showModal: false,
        };
    },
    emits: {
        // Validate submit event
        close: () => {
            this.showModal = false;
            return true;
        },
    },


    created() {
        this.getCompanyInfo();
        this.getExpense();

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
.expense-single .modal-footer {
    border-top: 1px solid #e2e2e2;
}
.expense-single .modal-header {
    border-bottom: 1px solid #e2e2e2;
}
.expense-single .form-field,
.expense-single input:not(.btn) {
    padding-top: 10px !important;
    padding-bottom: 10px !important;
}

@media print {
    .erp-nav-container {
        display: none;
    }
}
</style>
