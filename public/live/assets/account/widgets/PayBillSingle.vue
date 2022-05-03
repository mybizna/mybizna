<template>
    <div class="mybizna-modal-dialog paybill-single">
        <div class="mybizna-modal-content">
            <div class="mybizna-modal-header">
                <h2>{{ this.$func.__("Pay Bill", "erp") }}</h2>
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
                                        >{{
                                            this.$func.__("Send Mail", "erp")
                                        }}</a
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
                        <h4>{{ this.$func.__("Pay Bill", "erp") }}</h4>
                        <div class="mybizna-row" v-if="null != payBill">
                            <div class="mybizna-col-sm-6">
                                <div class="persons-info">
                                    <strong>{{ payBill.vendor_name }}</strong
                                    ><br />
                                </div>
                            </div>
                            <div class="mybizna-col-sm-6">
                                <table class="invoice-info">
                                    <tr>
                                        <th>
                                            {{
                                                this.$func.__(
                                                    "Voucher No",
                                                    "erp"
                                                )
                                            }}:
                                        </th>
                                        <td>#{{ payBill.voucher_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{
                                                this.$func.__(
                                                    "Reference No",
                                                    "erp"
                                                )
                                            }}:
                                        </th>
                                        <td>#{{ payBill.ref }}</td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{
                                                this.$func.__(
                                                    "Transaction Date",
                                                    "erp"
                                                )
                                            }}:
                                        </th>
                                        <td>
                                            {{ formatDate(payBill.trn_date) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{
                                                this.$func.__(
                                                    "Created At",
                                                    "erp"
                                                )
                                            }}:
                                        </th>
                                        <td>
                                            {{ formatDate(payBill.created_at) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{
                                                this.$func.__(
                                                    "Transaction From",
                                                    "erp"
                                                )
                                            }}:
                                        </th>
                                        <td>{{ payBill.trn_by }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mybizna-invoice-table" v-if="null != payBill">
                        <table
                            class="mybizna-table mybizna-form-table invoice-table"
                        >
                            <thead>
                                <tr class="inline-edit-row">
                                    <th>{{ this.$func.__("Sl.", "erp") }}</th>
                                    <th>
                                        {{ this.$func.__("Bill No", "erp") }}
                                    </th>
                                    <th>
                                        {{ this.$func.__("Amount", "erp") }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    :key="index"
                                    v-for="(
                                        line, index
                                    ) in payBill.bill_details"
                                    class="inline-edit-row"
                                >
                                    <td>{{ line.id }}</td>
                                    <td>{{ line.bill_no }}</td>
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
                                                        this.$func.__(
                                                            "Subtotal",
                                                            "erp"
                                                        )
                                                    }}:</span
                                                >
                                                {{
                                                    moneyFormat(payBill.amount)
                                                }}
                                            </li>
                                            <li>
                                                <span
                                                    >{{
                                                        this.$func.__(
                                                            "Total",
                                                            "erp"
                                                        )
                                                    }}:</span
                                                >
                                                {{
                                                    moneyFormat(payBill.amount)
                                                }}
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <trans-particulars :particulars="payBill.particulars" />

                <div class="invoice-attachments d-print-none">
                    <h4>{{ this.$func.__("Attachments", "erp") }}</h4>
                    <a
                        class="attachment-item"
                        :href="attachment"
                        :key="index"
                        v-for="(attachment, index) in payBill.attachments"
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
export default {
    components: {
        SendMail: window.$func.fetchComponent("components/email/SendMail.vue"),
        Dropdown: window.$func.fetchComponent("components/base/Dropdown.vue"),
        TransParticulars: window.$func.fetchComponent(
            "components/transactions/TransParticulars.vue"
        ),
    },

    data() {
        return {
            company: null,
            payBill: {},
            isWorking: false,
            acct_var: this.$erp_acct_var /* global this.$erp_acct_var */,
            print_data: null,
            type: "pay_bill",
            showModal: false,
            people_id: null,
            pdf_link: "#",
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
        this.getBill();

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
                .get(`/pay-bills/${this.$route.params.id}`)
                .then((response) => {
                    this.payBill = response.data;
                    this.people_id = this.payBill.vendor_id;
                    this.pdf_link = this.payBill.pdf_link;
                })
                .catch((error) => {
                    throw error;
                })
                .then((e) => {})
                .then(() => {
                    this.print_data = this.payBill;
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
.paybill-single {
    max-width: 960px;
    margin: 0 auto;
}
.paybill-single .mybizna-modal-footer {
    border-top: 1px solid #e2e2e2;
}
.paybill-single .mybizna-modal-header {
    border-bottom: 1px solid #e2e2e2;
}
.paybill-single .mybizna-form-field,
.paybill-single .mybizna-form-field input:not(.mybizna-btn) {
    padding-top: 10px !important;
    padding-bottom: 10px !important;
}

@media print {
    .erp-nav-container {
        display: none;
    }
}
</style>
