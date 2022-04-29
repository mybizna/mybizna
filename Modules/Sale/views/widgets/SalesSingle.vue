<template>
    <div class="mybizna-modal-dialog sales-single">
        <div class="mybizna-modal-content">
            <div class="mybizna-modal-header">
                <h2 v-if="null != type">{{ trnType(type) }}</h2>
                <div class="d-print-none">
                    <a
                        href="#"
                        class="mybizna-btn btn--default print-btn"
                        @click.prevent="printPopup"
                    >
                        <i class="flaticon-printer-1"></i>
                        &nbsp; {{ this.$func.__("Print", "erp") }}
                    </a>
                    <!-- todo: more action has some dropdown and will implement later please consider as planning -->

                    <dropdown v-if="acct_var.pdf_plugin_active">
                        <template slot="button">
                            <a href="#" class="mybizna-btn btn--default">
                                <i class="flaticon-settings-work-tool"></i>
                                &nbsp; {{ this.$func.__("More Action", "erp") }}
                            </a>
                        </template>
                        <template slot="dropdown">
                            <ul role="menu">
                                <li>
                                    <a :href="pdf_link">{{
                                        this.$func.__("Export as PDF", "erp")
                                    }}</a>
                                </li>
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

                    <template v-if="invoice">
                        <a
                            href="#"
                            class="mybizna-btn btn--default print-btn"
                            v-clipboard="copyLink"
                            @success="handleSuccess"
                            @error="handleError"
                            >{{ this.$func.__("Copy Link", "erp") }}</a
                        >
                    </template>
                </div>
            </div>

            <invoice-single-content
                v-if="null != invoice && null != company"
                :invoice="invoice"
                :company="company"
            />

            <payment-single-content
                v-if="null != payment && null != company"
                :payment="payment"
                :company="company"
                :type="type"
            />

            <send-mail
                v-if="showModal"
                :userid="user_id"
                :data="print_data"
                :type="type"
            />
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            isWorking: false,
            invoice: null,
            payment: null,
            type: null,
            company: null,
            acct_var: erp_acct_var /* global erp_acct_var */,
            showModal: false,
            print_data: null,
            copyLink: "#",
            user_id: null,
            pdf_link: "#",
        };
    },

    components: {
        InvoiceSingleContent : window.$func.fetchComponent('components/transactions/sales/InvoiceSingleContent.vue'),
        PaymentSingleContent : window.$func.fetchComponent('components/transactions/sales/PaymentSingleContent.vue'),
        SendMail : window.$func.fetchComponent('components/email/SendMail.vue'),
        Dropdown : window.$func.fetchComponent('components/base/Dropdown.vue'),
    },

    created() {
        /* If this page load directly,
            then we don't have the type or type is `undefined`
            thats why we need to load the type from database */
        const params = this.$route.params;

        if (typeof params.type === "undefined") {
            this.getSalesType(params.id);
        } else {
            this.loadData(params.type);
        }

        this.getCompanyInfo();

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

        getSalesType(id) {
            window.axios
                .get(`/transactions/type/${id}`)
                .then((response) => {
                    this.loadData(response.data);
                })
                .then((e) => {})
                .then(() => {
                    this.isWorking = false;
                });
        },

        loadData(type) {
            this.type = type;

            if (type === "invoice") {
                this.getInvoice();
            } else if (type === "payment" || type === "return_payment") {
                this.getPayment();
            }
        },

        getInvoiceType() {
            if (this.invoice !== null && this.invoice.estimate === "1") {
                return this.$func.__("Estimate", "erp");
            } else {
                return this.$func.__("Invoice", "erp");
            }
        },

        getInvoice() {
            this.isWorking = true;

            window.axios
                .get(`/invoices/${this.$route.params.id}`)
                .then((response) => {
                    this.invoice = response.data;
                })
                .then(() => {
                    this.print_data = this.invoice;
                    this.copyLink = this.invoice.readonly_url;
                    this.pdf_link = this.invoice.pdf_link;
                    this.isWorking = false;
                    this.user_id = this.print_data.customer_id;
                });
        },

        getPayment() {
            this.isWorking = true;

            window.axios
                .get(`/payments/${this.$route.params.id}`)
                .then((response) => {
                    this.payment = response.data;
                })
                .then(() => {
                    this.print_data = this.payment;
                    this.pdf_link = this.payment.pdf_link;
                    this.user_id = this.print_data.customer_id;
                    this.isWorking = false;
                });
        },

        trnType(type) {
            if (type === "payment") {
                return this.$func.__("Receive", "erp");
            } else if (type === "return_payment") {
                return this.$func.__("Payment", "erp");
            }

            return this.getInvoiceType();
        },

        printPopup() {
            window.print();
        },

        handleSuccess(e) {
            alert(erp_acct_var.link_copy_success);
        },

        handleError(e) {
            alert(erp_acct_var.link_copy_error);
        },
    },
};
</script>

<style>
.mybizna-email-multiselect .multiselect__content-wrapper {
    display: none !important;
    height: 0 !important;
    visibility: hidden;
}
.mybizna-email-multiselect .multiselect__tags {
    font-size: 12px;
    padding-left: 15px;
    border-radius: 3px;
}
.mybizna-email-multiselect .multiselect__tags input {
    max-height: 30px;
    font-size: 12px;
}

.mybizna-email-multiselect .multiselect__tag-icon {
    line-height: 18px;
}
.mybizna-email-multiselect .multiselect input.multiselect__input {
    display: none;
}
.mybizna-email-multiselect
    .multiselect
    .multiselect--active
    input.multiselect__input {
    display: block;
    width: 100% !important;
}

.sales-single {
    max-width: 960px;
    margin: 0 auto;
}
.sales-single .mybizna-modal-footer {
    border-top: 1px solid #e2e2e2;
}
.sales-single .mybizna-modal-header {
    border-bottom: 1px solid #e2e2e2;
}
.sales-single .mybizna-form-field,
.sales-single input:not(.mybizna-btn) {
    padding-top: 10px !important;
    padding-bottom: 10px !important;
}

@media print {
    .erp-nav-container {
        display: none;
    }
}
</style>
