<template>
    <div class="mybizna-modal-dialog bill-single">
        <div class="mybizna-modal-content">
            <div class="mybizna-modal-header">
                <h2>Bill</h2>
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
                                    <a :href="pdf_link">{{
                                        window.$func.__("Export as PDF", "erp")
                                    }}</a>
                                </li>
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
                        <h4>{{ window.$func.__("Bill", "erp") }}</h4>
                        <div class="mybizna-row" v-if="null != bill">
                            <div class="mybizna-col-sm-6">
                                <div class="persons-info">
                                    <strong>{{ bill.vendor_name }}</strong
                                    ><br />
                                    {{ bill.billing_address }}
                                </div>
                            </div>
                            <div class="mybizna-col-sm-6">
                                <table class="invoice-info">
                                    <tr>
                                        <th>{{ window.$func.__("Voucher No", "erp") }}:</th>
                                        <td>#{{ bill.voucher_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ window.$func.__("Reference No", "erp") }}:
                                        </th>
                                        <td>
                                            <span v-if="bill.ref">
                                                #{{ bill.ref }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ window.$func.__("Transaction Date", "erp") }}:
                                        </th>
                                        <td>{{ formatDate(bill.trn_date) }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ window.$func.__("Due Date", "erp") }}:</th>
                                        <td>{{ formatDate(bill.due_date) }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ window.$func.__("Created At", "erp") }}:</th>
                                        <td>
                                            {{ formatDate(bill.created_at) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{{ window.$func.__("Amount Due", "erp") }}:</th>
                                        <td>{{ moneyFormat(bill.due) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mybizna-invoice-table" v-if="null != bill">
                        <table
                            class="mybizna-table mybizna-form-table invoice-table"
                        >
                            <thead>
                                <tr>
                                    <th>{{ window.$func.__("Sl", "erp") }}</th>
                                    <th>{{ window.$func.__("Account", "erp") }}</th>
                                    <th>{{ window.$func.__("Particulars", "erp") }}</th>
                                    <th>{{ window.$func.__("Amount", "erp") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    :key="index"
                                    v-for="(line, index) in bill.bill_details"
                                    class="inline-edit-row"
                                >
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ line.ledger_name }}</td>
                                    <td>{{ line.particulars }}</td>
                                    <td>{{ moneyFormat(line.amount) }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="inline-edit-row">
                                    <td colspan="7">
                                        <ul>
                                            <li>
                                                <span
                                                    >{{
                                                        window.$func.__("Subtotal", "erp")
                                                    }}:</span
                                                >
                                                {{ moneyFormat(bill.amount) }}
                                            </li>
                                            <li>
                                                <span
                                                    >{{
                                                        window.$func.__("Total", "erp")
                                                    }}:</span
                                                >
                                                {{ moneyFormat(bill.amount) }}
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <trans-particulars :particulars="bill.particulars" />

                <div class="invoice-attachments d-print-none">
                    <h4>{{ window.$func.__("Attachments", "erp") }}</h4>
                    <a
                        class="attachment-item"
                        :href="attachment"
                        :key="index"
                        v-for="(attachment, index) in bill.attachments"
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
            bill: {},
            isWorking: false,
            acct_var: erp_acct_var /* global erp_acct_var */,
            print_data: null,
            type: "bill",
            showModal: false,
            people_id: null,
            pdf_link: "#",
        };
    },

    created() {
        this.getCompanyInfo();
        this.getBill();

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

        getBill() {
            this.isWorking = true;
            window.axios
                .get(`/bills/${this.$route.params.id}`)
                .then((response) => {
                    this.bill = response.data;
                    this.people_id = this.bill.vendor_id;
                    this.pdf_link = this.bill.pdf_link;
                })
                .catch((error) => {
                    throw error;
                })
                .then((e) => {})
                .then(() => {
                    this.print_data = this.bill;
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
.bill-single {
    max-width: 960px;
    margin: 0 auto;
}
.bill-single .mybizna-modal-footer {
    border-top: 1px solid #e2e2e2;
}
.bill-single .mybizna-modal-header {
    border-bottom: 1px solid #e2e2e2;
}
.bill-single .mybizna-form-field,
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
