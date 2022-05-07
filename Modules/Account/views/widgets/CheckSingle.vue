<template>
    <div class="expense-single">
        <div >
            <div >
                <h2>{{ this.$func.__("Check", "erp") }}</h2>
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
                        <h4>{{ this.$func.__("Check", "erp") }}</h4>
                        <div class="row" v-if="null != expense_data">
                            <div class="col-sm-6">
                                <div class="persons-info">
                                    <strong>{{
                                        expense_data.people_name
                                    }}</strong
                                    ><br />
                                    {{ expense_data.address }}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <table class="invoice-info">
                                    <tr>
                                        <th>{{ this.$func.__("Check No", "erp") }}</th>
                                        <td>#{{ expense_data.check_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ this.$func.__("Transaction Date", "erp") }}:
                                        </th>
                                        <td>
                                            {{ formatDate(expense_data.date) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{{ this.$func.__("Created At", "erp") }}:</th>
                                        <td>
                                            {{
                                                formatDate(
                                                    expense_data.created_at
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
                        v-if="null != expense_data"
                    >
                        <table
                            class="table form-table invoice-table"
                        >
                            <thead>
                                <tr class="inline-edit-row">
                                    <th>{{ this.$func.__("Sl", "erp") }}</th>
                                    <th>{{ this.$func.__("Account", "erp") }}</th>
                                    <th>{{ this.$func.__("Particulars", "erp") }}</th>
                                    <th>{{ this.$func.__("Amount", "erp") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    :key="index"
                                    v-for="(
                                        line, index
                                    ) in expense_data.bill_details"
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
                                                        this.$func.__("Subtotal", "erp")
                                                    }}:</span
                                                >
                                                {{
                                                    moneyFormat(
                                                        expense_data.total
                                                    )
                                                }}
                                            </li>
                                            <li>
                                                <span
                                                    >{{
                                                        this.$func.__("Total", "erp")
                                                    }}:</span
                                                >
                                                {{
                                                    moneyFormat(
                                                        expense_data.total
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

                <div class="invoice-attachments d-print-none">
                    <h4>{{ this.$func.__("Attachments", "erp") }}</h4>
                    <a
                        class="attachment-item"
                        :href="attachment"
                        :key="index"
                        v-for="(attachment, index) in expense_data.attachments"
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
    },

    data() {
        return {
            company: null,
            expense_data: {},
            isWorking: false,
            acct_var: this.$mybizna_var /* global this.$mybizna_var */,
            print_data: null,
            type: "check",
            showModal: false,
            people_id: null,
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
        this.getCheck();
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

        getCheck() {
            this.isWorking = true;
            window.axios
                .get(`/expenses/checks/${this.$route.params.id}`)
                .then((response) => {
                    this.expense_data = response.data;
                    this.people_id = this.expense_data.people_id;
                })
                .catch((error) => {
                    throw error;
                })
                .then((e) => {})
                .then(() => {
                    this.print_data = this.expense_data;
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
input:not(.btn) {
    padding-top: 10px !important;
    padding-bottom: 10px !important;
}

@media print {
    .erp-nav-container {
        display: none;
    }
}
</style>
