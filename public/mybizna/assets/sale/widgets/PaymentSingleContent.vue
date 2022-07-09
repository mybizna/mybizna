<template>
    <div >
        <div class="invoice-panel">
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
                <h4>{{ this.$func.__('Payment Details') }}</h4>
                <div class="row">
                    <div class="col-sm-6">
                        <h5>{{ type === "payment" ? this.$func.__('Payment From') : this.$func.__('Payment To') }}:</h5>
                        <div class="persons-info">
                            <strong>{{ payment.customer_name }}</strong><br>
                            <!-- {{ payment.billing_address }} -->
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <table class="invoice-info">
                            <tr>
                                <th>{{ this.$func.__('Voucher No') }}:</th>
                                <td>#{{ payment.voucher_no }}</td>
                            </tr>
                            <tr>
                                <th>{{ this.$func.__('Transaction Date') }}:</th>
                                <td>{{ formatDate( payment.trn_date ) }}</td>
                            </tr>
                            <tr>
                                <th>{{ this.$func.__('Created At') }}:</th>
                                <td>{{ formatDate( payment.created_at ) }}</td>
                            </tr>
                            <tr>
                                <th>{{ this.$func.__('Deposit To') }}:</th>
                                <td>{{ payment.account }}</td>
                            </tr>
                            <tr v-if="payment.transaction_charge">
                                <th>{{ this.$func.__('Transaction Charge') }}:</th>
                                <td>{{ moneyFormat( payment.transaction_charge )  }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="invoice-table">
                <table class="table form-table invoice-table">
                    <thead>
                        <tr>
                            <th>{{ this.$func.__('Sl.') }}</th>
                            <th>{{ this.$func.__('Invoice ID') }}</th>
                            <th>{{ this.$func.__('Amount') }}</th>
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
                                    <li><span>{{ this.$func.__('Total') }}:</span> {{ type === "return_payment" ? formatAmount(-1 * payment.amount, true) : formatAmount(payment.amount, true) }}</li>
                                </ul>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>

        <trans-particulars :particulars="payment.particulars" />

        <div class="invoice-attachments d-print-none">
            <h4>{{ this.$func.__('Attachments') }}</h4>
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
            acct_var: this.$mybizna_var /* global this.$mybizna_var */
        };
    }
};
</script>
