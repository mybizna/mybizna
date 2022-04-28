<template>
    <div class="mybizna-modal-dialog journal-single">
        <div class="mybizna-modal-content">
            <div class="mybizna-modal-header">
                <h2>{{ window.$func.__("Journal", "erp") }}</h2>
                <div class="d-print-none">
                    <a
                        href="#"
                        class="mybizna-btn btn--default print-btn"
                        @click.prevent="printPopup"
                    >
                        <i class="flaticon-printer-1"></i>
                        &nbsp; {{ window.$func.__("Print", "erp") }}
                    </a>
                </div>
            </div>
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
                        <h4>{{ window.$func.__("Journal", "erp") }}</h4>
                        <div class="mybizna-row" v-if="null != journal">
                            <div class="mybizna-col-sm-12 pull-right">
                                <table class="invoice-info">
                                    <tr>
                                        <th>{{ window.$func.__("Journal No", "erp") }}:</th>
                                        <td>#{{ journal.id }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ window.$func.__("Journal Ref", "erp") }}:</th>
                                        <td>{{ journal.ref }}</td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ window.$func.__("Journal Date", "erp") }}:
                                        </th>
                                        <td>
                                            {{ formatDate(journal.trn_date) }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mybizna-invoice-table" v-if="null != journal">
                        <table
                            class="mybizna-table mybizna-form-table invoice-table"
                        >
                            <thead>
                                <tr class="inline-edit-row">
                                    <th>{{ window.$func.__("Account", "erp") }}</th>
                                    <th>{{ window.$func.__("Particulars", "erp") }}</th>
                                    <th>{{ window.$func.__("Debit", "erp") }}</th>
                                    <th>{{ window.$func.__("Credit", "erp") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    :key="index"
                                    v-for="(line, index) in journal.line_items"
                                    class="inline-edit-row"
                                >
                                    <td>{{ line.account }}</td>
                                    <td>{{ line.particulars }}</td>
                                    <td>{{ line.debit }}</td>
                                    <td>{{ line.credit }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="inline-edit-row">
                                    <td colspan="7">
                                        <ul>
                                            <li>
                                                <span
                                                    >{{
                                                        window.$func.__("Balance", "erp")
                                                    }}:</span
                                                >
                                                {{ moneyFormat(journal.total) }}
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <trans-particulars :particulars="journal.particulars" />

                <div class="invoice-attachments d-print-none">
                    <h4>{{ window.$func.__("Attachments", "erp") }}</h4>
                    <a
                        class="attachment-item"
                        :href="attachment"
                        :key="index"
                        v-for="(attachment, index) in journal.attachments"
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
import TransParticulars from "assets/components/transactions/TransParticulars.vue";

export default {
    components: {
        TransParticulars,
    },

    data() {
        return {
            company: null,
            journal: {},
            isWorking: false,
            acct_var: erp_acct_var /* global erp_acct_var */,
        };
    },

    created() {
        this.getCompanyInfo();
        this.getJournal();
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

        getJournal() {
            this.isWorking = true;

            window.axios
                .get(`/journals/${this.$route.params.id}`)
                .then((response) => {
                    this.journal = response.data;
                })
                .catch((error) => {
                    throw error;
                })
                .then((e) => {})
                .then(() => {
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
.journal-single {
    max-width: 960px;
    margin: 0 auto;
}
.journal-single .mybizna-modal-footer {
    border-top: 1px solid #e2e2e2;
}
.journal-single .mybizna-modal-header {
    border-bottom: 1px solid #e2e2e2;
}
.journal-single .mybizna-form-field,
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
