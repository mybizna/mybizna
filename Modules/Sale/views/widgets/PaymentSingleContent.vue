<template>
    <div class="mybizna-modal-body">
        <div class="mybizna-invoice-panel">
            <div class="invoice-header">
                <div class="invoice-logo">
                    <img :src="company.logo" alt="logo name" width="100" height="100">
                </div>
                <div class="invoice-address">
                    <address>
                        <strong>{{ company.name }}</strong><br>
                        {{ company.address.address_1 }}<br>
                        {{ company.address.address_2 }}<br>
                        {{ company.address.city }}<br>
                        {{ company.address.country }}
                    </address>
                </div>
            </div>

            <div class="invoice-body">
                <h4>{{ this.$func.__('Payment Details', 'erp') }}</h4>
                <div class="mybizna-row">
                    <div class="mybizna-col-sm-6">
                        <h5>{{ type === "payment" ? this.$func.__('Payment From', 'erp') : this.$func.__('Payment To', 'erp') }}:</h5>
                        <div class="persons-info">
                            <strong>{{ payment.customer_name }}</strong><br>
                            <!-- {{ payment.billing_address }} -->
                        </div>
                    </div>
                    <div class="mybizna-col-sm-6">
                        <table class="invoice-info">
                            <tr>
                                <th>{{ this.$func.__('Voucher No', 'erp') }}:</th>
                                <td>#{{ payment.voucher_no }}</td>
                            </tr>
                            <tr>
                                <th>{{ this.$func.__('Transaction Date', 'erp') }}:</th>
                                <td>{{ formatDate( payment.trn_date ) }}</td>
                            </tr>
                            <tr>
                                <th>{{ this.$func.__('Created At', 'erp') }}:</th>
                                <td>{{ formatDate( payment.created_at ) }}</td>
                            </tr>
                            <tr>
                                <th>{{ this.$func.__('Deposit To', 'erp') }}:</th>
                                <td>{{ payment.account }}</td>
                            </tr>
                            <tr v-if="payment.transaction_charge">
                                <th>{{ this.$func.__('Transaction Charge', 'erp') }}:</th>
                                <td>{{ moneyFormat( payment.transaction_charge )  }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mybizna-invoice-table">
                <table class="mybizna-table mybizna-form-table invoice-table">
                    <thead>
                        <tr>
                            <th>{{ this.$func.__('Sl.', 'erp') }}</th>
                            <th>{{ this.$func.__('Invoice ID', 'erp') }}</th>
                            <th>{{ this.$func.__('Amount', 'erp') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr :key="index" v-for="(detail, index) in payment.line_items">
                            <th>#{{ index+1 }}</th>
                            <th>{{ detail.invoice_no }}</th>
                            <td>{{ detail.type === "return_payment" ? formatAmount(-1 * detail.amount, true) : formatAmount(detail.amount, true) }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <ul>
                                    <li><span>{{ this.$func.__('Total', 'erp') }}:</span> {{ type === "return_payment" ? formatAmount(-1 * payment.amount, true) : formatAmount(payment.amount, true) }}</li>
                                </ul>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>

        <trans-particulars :particulars="payment.particulars" />

        <div class="invoice-attachments d-print-none">
            <h4>{{ this.$func.__('Attachments', 'erp') }}</h4>
            <a class="attachment-item" :href="attachment"
               :key="index"
               v-for="(attachment, index) in payment.attachments" download>
                <img :src="acct_var.acct_assets + '/images/file-thumb.png'">
                <div class="attachment-meta">
                    <span>{{attachment.substring(attachment.lastIndexOf('/')+1) }}</span><br>
                    <!-- <span class="text-muted">file size</span> -->
                </div>
            </a>
        </div>

    </div>
</template>

<script>

export default {

    components: {
        TransParticulars : window.$func.fetchComponent('components/transactions/TransParticulars.vue')
    },

    props: {
        payment: {
            type: Object
        },
        company: {
            type: Object
        },
        type: {
            type: String
        },
    },

    data() {
        return {
            acct_var: erp_acct_var /* global erp_acct_var */
        };
    }
};
</script>
