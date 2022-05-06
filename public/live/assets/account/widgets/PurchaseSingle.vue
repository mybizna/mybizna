<template>
    <div class="purchase-single">
        <div >
            <div >
                <h4>{{ this.$func.__("Purchase", "erp") }}</h4>
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
                        <h4>{{ this.$func.__("Purchase", "erp") }}</h4>
                        <div class="row" v-if="null != purchase">
                            <div class="col-sm-6">
                                <div class="persons-info">
                                    <strong>{{ purchase.vendor_name }}</strong
                                    ><br />
                                    {{ purchase.billing_address }}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <table class="invoice-info">
                                    <tr>
                                        <th>{{ this.$func.__("Voucher No", "erp") }}:</th>
                                        <td>#{{ purchase.voucher_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ this.$func.__("Reference No", "erp") }}:
                                        </th>
                                        <td>
                                            <span v-if="purchase.ref">
                                                #{{ purchase.ref }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ this.$func.__("Transaction Date", "erp") }}:
                                        </th>
                                        <td>{{ formatDate(purchase.date) }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ this.$func.__("Due Date", "erp") }}:</th>
                                        <td>
                                            {{ formatDate(purchase.due_date) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{{ this.$func.__("Created At", "erp") }}:</th>
                                        <td>
                                            {{
                                                formatDate(purchase.created_at)
                                            }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="invoice-table" v-if="null != purchase">
                        <table
                            class="table form-table invoice-table"
                        >
                            <thead>
                                <tr>
                                    <th>{{ this.$func.__("Sl.", "erp") }}</th>
                                    <th>{{ this.$func.__("Item name", "erp") }}</th>
                                    <th>{{ this.$func.__("Qty", "erp") }}</th>
                                    <th>{{ this.$func.__("Unit Price", "erp") }}</th>
                                    <th>{{ this.$func.__("Amount", "erp") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    :key="index"
                                    v-for="(line, index) in purchase.line_items"
                                    class="inline-edit-row"
                                >
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ line.name }}</td>
                                    <td>{{ line.qty }}</td>
                                    <td>{{ moneyFormat(line.price) }}</td>
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
                                                        this.$func.__("Subtotal", "erp")
                                                    }}:</span
                                                >
                                                {{ moneyFormat(total.basic) }}
                                            </li>
                                            <li v-if="total.tax">
                                                <span
                                                    >{{
                                                        this.$func.__("VAT", "erp")
                                                    }}:</span
                                                >
                                                {{ moneyFormat(total.tax) }}
                                            </li>
                                            <li>
                                                <span
                                                    >{{
                                                        this.$func.__("Total", "erp")
                                                    }}:</span
                                                >
                                                {{ moneyFormat(total.final) }}
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <trans-particulars :particulars="purchase.particulars" />

                <div class="invoice-attachments d-print-none">
                    <h4>{{ this.$func.__("Attachments", "erp") }}</h4>
                    <a
                        class="attachment-item"
                        :href="attachment"
                        :key="index"
                        v-for="(attachment, index) in purchase.attachments"
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
        SendMail: window.$func.fetchComponent('components/email/SendMail.vue'),
        Dropdown: window.$func.fetchComponent('components/base/Dropdown.vue'),
        TransParticulars: window.$func.fetchComponent('components/transactions/TransParticulars.vu'),
    },

    data() {
        return {
            company: null,
            purchase: {},
            isWorking: false,
            acct_var: this.$erp_acct_var /* global this.$erp_acct_var */,
            print_data: null,
            type: "purchase",
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
        this.getPurchase();

    },
    computed: {
        total() {
            return {
                basic:
                    parseFloat(this.purchase.amount) -
                    parseFloat(this.purchase.tax),
                tax: parseFloat(this.purchase.tax),
                final: parseFloat(this.purchase.amount),
            };
        },
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
                .get(`/purchases/${this.$route.params.id}`)
                .then((response) => {
                    this.purchase = response.data;
                    this.people_id = this.purchase.vendor_id;
                    this.pdf_link = this.purchase.pdf_link;
                })
                .then((e) => {})
                .then(() => {
                    this.print_data = this.purchase;
                    this.isWorking = false;
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
.purchase-single {
    max-width: 960px;
    margin: 0 auto;
}
.purchase-single .modal-footer {
    border-top: 1px solid #e2e2e2;
}
.purchase-single .modal-header {
    border-bottom: 1px solid #e2e2e2;
}
.purchase-single .form-field,
.purchase-single input:not(.btn) {
    padding-top: 10px !important;
    padding-bottom: 10px !important;
}

@media print {
    .erp-nav-container {
        display: none;
    }
}
</style>
