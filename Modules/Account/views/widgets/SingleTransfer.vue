<template>
    <div class=" sales-single">
        <div >
            <div >
                <h2>{{ this.$func.__("Transfer Money", "erp") }}</h2>
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

            <div >
                <div class="invoice-panel">
                    <div class="invoice-header">
                        <div class="invoice-logo">
                            <img
                                :src="company.logo"
                                alt="logo name"
                                width="100"
                                height="100"
                            />
                        </div>
                        <div class="invoice-address">
                            <address v-if="company.address">
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
                        <h4>{{ this.$func.__("Transfer Money", "erp") }}</h4>
                        <div class="row" v-if="voucher.created_by">
                            <div class="col-sm-6">
                                <h5>{{ this.$func.__("Created By", "erp") }}:</h5>
                                <div class="persons-info">
                                    <strong>{{
                                        voucher.created_by.display_name
                                    }}</strong
                                    ><br />
                                    {{ voucher.created_by.user_email }}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <table class="invoice-info">
                                    <tr>
                                        <th>
                                            {{ this.$func.__("Transaction Date", "erp") }}:
                                        </th>
                                        <td>
                                            {{ formatDate(voucher.trn_date) }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="invoice-table">
                        <table
                            class="table form-table invoice-table"
                        >
                            <thead>
                                <tr>
                                    <th>{{ this.$func.__("Voucher No", "erp") }}</th>
                                    <th>{{ this.$func.__("Account From", "erp") }}</th>
                                    <th>{{ this.$func.__("Amount", "erp") }}</th>
                                    <th>{{ this.$func.__("Account To", "erp") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>#{{ voucher.voucher }}</th>
                                    <th>{{ voucher.ac_from }}</th>
                                    <th>{{ moneyFormat(voucher.amount) }}</th>
                                    <th>{{ voucher.ac_to }}</th>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td
                                        class="invoice-amounts"
                                        colspan="7"
                                    >
                                        <h2>{{ this.$func.__("Particulars", "erp") }}</h2>
                                        <p v-if="voucher.particulars">
                                            {{ voucher.particulars }}
                                        </p>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <send-mail
                v-if="showModal"
                :data="print_data"
                :type="transfer_voucher"
            />
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            voucher: {},
            company: "",
            showModal: false,
            print_data: null,
        };
    },

    components: {
        SendMail: window.$func.fetchComponent('components/email/SendMail.vue'),
        Dropdown: window.$func.fetchComponent('components/base/Dropdown.vue'),
    },

    created() {
        this.getCompanyInfo();
        this.getVoucher();
    },

    methods: {
        getCompanyInfo() {
            window.axios.get(`/company`).then((response) => {
                this.company = response.data;
            });
        },

        getVoucher() {
            window.axios
                .get(`/accounts/transfers/${this.$route.params.id}`)
                .then((response) => {
                    this.voucher = response.data;
                    this.print_data = this.voucher;
                })
                .catch((error) => {
                    throw error;
                });
        },

        printPopup() {
            window.print();
        },
    },
};
</script>

<style>
.email-multiselect .multiselect__content-wrapper {
    display: none !important;
    height: 0 !important;
    visibility: hidden;
}
.email-multiselect .multiselect__tags {
    font-size: 12px;
    padding-left: 15px;
    border-radius: 3px;
}
.email-multiselect .multiselect__tags input {
    max-height: 30px;
    font-size: 12px;
}

.email-multiselect .multiselect__tag-icon {
    line-height: 18px;
}
.email-multiselect .multiselect input.multiselect__input {
    display: none;
}
.email-multiselect
    .multiselect.multiselect--active
    input.multiselect__input {
    display: block;
    width: 100% !important;
}

.sales-single {
    max-width: 960px;
    margin: 0 auto;
}
.sales-single .modal-footer {
    border-top: 1px solid #e2e2e2;
}
.sales-single .modal-header {
    border-bottom: 1px solid #e2e2e2;
}
.sales-single .form-field,
.sales-single .form-field input:not(.btn) {
    padding-top: 10px !important;
    padding-bottom: 10px !important;
}

.invoice-table td:last-child,
.invoice-table th:last-child {
    width: 100px !important;
}

@media print {
    .erp-nav-container {
        display: none;
    }
}
</style>
