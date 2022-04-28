<template>
    <div class="mybizna-modal-dialog paypurchase-single">
        <div class="mybizna-modal-content">
            <div class="mybizna-modal-header">
                <h2>{{ trnType() }}</h2>
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
                    <dropdown>
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
                </div>
            </div>

            <send-mail
                v-if="showModal"
                :userid="people_id"
                :data="print_data"
                :type="type"
            />

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
                        <h4>{{ this.$func.__("Payment Details", "erp") }}</h4>
                        <div class="mybizna-row" v-if="null != payPurchase">
                            <div class="mybizna-col-sm-6">
                                <h5>
                                    {{
                                        type === "pay_purchase"
                                            ? this.$func.__("Payment To", "erp")
                                            : this.$func.__("Payment From", "erp")
                                    }}:
                                </h5>
                                <div class="persons-info">
                                    <strong>{{
                                        payPurchase.vendor_name
                                    }}</strong
                                    ><br />
                                    {{ payPurchase.billing_address }}
                                </div>
                            </div>
                            <div class="mybizna-col-sm-6">
                                <table class="invoice-info">
                                    <tr>
                                        <th>{{ this.$func.__("Voucher No", "erp") }}:</th>
                                        <td>#{{ payPurchase.voucher_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ this.$func.__("Reference No", "erp") }}:
                                        </th>
                                        <td>
                                            <span v-if="payPurchase.ref">
                                                #{{ payPurchase.ref }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ this.$func.__("Transaction Date", "erp") }}:
                                        </th>
                                        <td>
                                            {{
                                                formatDate(payPurchase.trn_date)
                                            }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{{ this.$func.__("Created At", "erp") }}:</th>
                                        <td>
                                            {{
                                                formatDate(
                                                    payPurchase.created_at
                                                )
                                            }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ this.$func.__("Transaction From", "erp") }}:
                                        </th>
                                        <td>{{ payPurchase.trn_by }}</td>
                                    </tr>
                                    <tr
                                        v-if="
                                            parseFloat(
                                                payPurchase.transaction_charge
                                            )
                                        "
                                    >
                                        <th>
                                            {{
                                                this.$func.__("Transaction Charge", "erp")
                                            }}:
                                        </th>
                                        <td>
                                            {{ payPurchase.transaction_charge }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mybizna-invoice-table" v-if="null != payPurchase">
                        <table
                            class="mybizna-table mybizna-form-table invoice-table"
                        >
                            <thead>
                                <tr>
                                    <th>{{ this.$func.__("Sl.", "erp") }}</th>
                                    <th>{{ this.$func.__("Purchase No", "erp") }}</th>
                                    <th>{{ this.$func.__("Vendor", "erp") }}</th>
                                    <th>{{ this.$func.__("Amount", "erp") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    :key="index"
                                    v-for="(
                                        line, index
                                    ) in payPurchase.purchase_details"
                                    class="inline-edit-row"
                                >
                                    <td>{{ line.id }}</td>
                                    <td>{{ line.purchase_no }}</td>
                                    <td>{{ line.vendor_name }}</td>
                                    <td>
                                        {{
                                            line.type === "receive_pay_purchase"
                                                ? formatAmount(
                                                      -1 * line.amount,
                                                      true
                                                  )
                                                : formatAmount(
                                                      line.amount,
                                                      true
                                                  )
                                        }}
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
                                                    type ===
                                                    "receive_pay_purchase"
                                                        ? formatAmount(
                                                              -1 *
                                                                  payPurchase.amount,
                                                              true
                                                          )
                                                        : formatAmount(
                                                              payPurchase.amount,
                                                              true
                                                          )
                                                }}
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <trans-particulars :particulars="payPurchase.particulars" />

                <div class="invoice-attachments d-print-none">
                    <h4>{{ this.$func.__("Attachments", "erp") }}</h4>
                    <a
                        class="attachment-item"
                        :href="attachment"
                        :key="index"
                        v-for="(attachment, index) in payPurchase.attachments"
                        download
                    >
                        <img
                            :src="
                                acct_var.acct_assets + '/images/file-thumb.png'
                            "
                        />
                        <div class="attachment-meta">
                            <span>{{
                                attachment.substring(
                                    attachment.lastIndexOf("/") + 1
                                )
                            }}</span
                            ><br />
                            <!-- <span class="text-muted">file size</span> -->
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SendMail from "assets/components/email/SendMail.vue";
import Dropdown from "assets/components/base/Dropdown.vue";
import TransParticulars from "assets/components/transactions/TransParticulars.vue";

export default {
    components: {
        SendMail,
        Dropdown,
        TransParticulars,
    },

    data() {
        return {
            company: null,
            payPurchase: {},
            isWorking: false,
            acct_var: erp_acct_var /* global erp_acct_var */,
            print_data: null,
            type: null,
            showModal: false,
            people_id: null,
            pdf_link: "#",
        };
    },

    created() {
        this.type = this.$route.params.type;
        this.getCompanyInfo();
        this.getPurchase();

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

        getPurchase() {
            this.isWorking = true;

            window.axios
                .get(`/pay-purchases/${this.$route.params.id}`)
                .then((response) => {
                    this.payPurchase = response.data;
                    this.people_id = this.payPurchase.vendor_id;
                    this.pdf_link = this.payPurchase.pdf_link;
                })
                .catch((error) => {
                    throw error;
                })
                .then((e) => {})
                .then(() => {
                    this.print_data = this.payPurchase;
                    this.isWorking = false;
                });
        },

        trnType() {
            if (this.type === "receive_pay_purchase") {
                return this.$func.__("Receive", "erp");
            }

            return this.$func.__("Payment", "erp");
        },

        printPopup() {
            window.print();
        },
    },
};
</script>

<style>
.paypurchase-single {
    max-width: 960px;
    margin: 0 auto;
}
.paypurchase-single .mybizna-modal-footer {
    border-top: 1px solid #e2e2e2;
}
.paypurchase-single .mybizna-modal-header {
    border-bottom: 1px solid #e2e2e2;
}
.paypurchase-single .mybizna-form-field,
input:not(.mybizna-btn) {
    padding-top: 10px !important;
    padding-bottom: 10px !important;
}

@media print {
    .erp-nav-container {
        display: none;
    }
}
</style>
