<template>
    <div class="mybizna-containers">

        <!-- Start .header-section -->
        <div class="content-header-section separator">
            <div class="mybizna-row mybizna-between-xs">
                <div class="mybizna-col">
                    <h2 class="content-header__title">{{ this.$func.__('Dashboard', 'erp') }}</h2>
                    <a class="mybizna-btn btn--primary" :href="tutorialUrl" id="btn-tutorial-start">
                        <span class="dashicons dashicons-controls-play"></span>
                        {{ this.$func.__(' Start Tutorial', 'erp') }}
                    </a>
                </div>
            </div>
        </div>
        <!-- End .header-section -->

        <div class="mybizna-dashboard">
            <div class="mybizna-row">
                <div class="mybizna-col-md-9 mybizna-col-sm-12 mybizna-col-xs-12">
                    <!-- Start .income-expense-section -->
                    <chart></chart>
                    <!-- End .income-expense-section -->
                </div>
                <div class="mybizna-col-md-3 mybizna-col-sm-12 mybizna-col-xs-12">
                    <!-- Start .bank-accounts-section -->
                    <accounts></accounts>
                    <!-- End .bank-accounts-section -->
                </div>
            </div>

            <div class="mybizna-row">
                    <div class="mybizna-col-sm-6 mybizna-col-xs-12" >
                        <!-- Start .invoice-own-section -->
                        <div class="invoice-own-section mybizna-panel mybizna-panel-default">
                            <div class="mybizna-panel-heading mybizna-bg-white">
                                <h4>{{ this.$func.__('Invoice payable to you', 'erp') }}</h4>
                            </div>
                            <div class="mybizna-panel-body pb-0">
                                <ul class="mybizna-list-unstyled list-table-content" v-if="Object.values(to_receive).length">
                                    <li>
                                        <span class="title">{{ this.$func.__('1-30 days overdue', 'erp') }}</span>
                                        <span class="price">{{formatAmount(to_receive.amount.first)}}</span>
                                    </li>
                                    <li>
                                        <span class="title">{{ this.$func.__('31-60 days overdue', 'erp') }}</span>
                                        <span class="price">{{formatAmount(to_receive.amount.second)}}</span>
                                    </li>
                                    <li>
                                        <span class="title">{{ this.$func.__('61-90 days overdue', 'erp') }}</span>
                                        <span class="price">{{formatAmount(to_receive.amount.third)}}</span>
                                    </li>
                                    <li class="total">
                                        <span class="title">{{ this.$func.__('Total Balance', 'erp') }}</span>
                                        <span class="price">{{total_receivable}}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- End .invoice-own-section -->
                    </div>
                    <div class="mybizna-col-sm-6 mybizna-col-xs-12 ">
                        <!-- Start .invoice-own-section -->
                        <div class="invoice-own-section mybizna-panel mybizna-panel-default">
                            <div class="mybizna-panel-heading mybizna-bg-white">
                                <h4>{{ this.$func.__('Bills you need to pay', 'erp') }}</h4>
                            </div>
                            <div class="mybizna-panel-body pb-0">
                                <ul class="mybizna-list-unstyled list-table-content"  v-if="Object.values(to_pay).length">
                                    <li>
                                        <span class="title">{{ this.$func.__('1-30 days overdue', 'erp') }}</span>
                                        <span class="price">{{formatAmount(to_pay.amount.first)}}</span>
                                    </li>
                                    <li>
                                        <span class="title">{{ this.$func.__('31-60 days overdue', 'erp') }}</span>
                                        <span class="price">{{formatAmount(to_pay.amount.second)}}</span>
                                    </li>
                                    <li>
                                        <span class="title">{{ this.$func.__('61-90 days overdue', 'erp') }}</span>
                                        <span class="price">{{formatAmount(to_pay.amount.third)}}</span>
                                    </li>
                                    <li class="total">
                                        <span class="title">{{ this.$func.__('Total Balance', 'erp') }}</span>
                                        <span class="price">{{total_payable}}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- End .invoice-own-section -->
                    </div>
                </div>

        </div>
    </div>
</template>

<script>
import Accounts from 'assets/components/dashboard/Accounts.vue';
import Chart from 'assets/components/dashboard/Chart.vue';

export default {

    components: {
        Chart,
        Accounts
    },

    data() {
        return {
            title1        : this.$func.__('Income & Expenses', 'erp'),
            title2        : this.$func.__('Bank Accounts', 'erp'),
            title3        : this.$func.__('Invoices owed to you', 'erp'),
            title4        : this.$func.__('Bills to pay', 'erp'),
            closable      : true,
            msg           : this.$func.__('Accounting', 'erp'),
            to_receive    : [],
            to_pay        : [],
            tutorialUrl   : erp_acct_var.erp_acct_tut_url
        };
    },

    computed: {
        total_receivable() {
            const amounts = Object.values(this.to_receive.amount);
            const total = amounts.reduce((amount, item) => {
                return amount + parseFloat(item);
            }, 0);

            return this.formatAmount(total);
        },

        total_payable() {
            const amounts = Object.values(this.to_pay.amount);
            const total = amounts.reduce((amount, item) => {
                return amount + parseFloat(item);
            }, 0);
            return this.formatAmount(total);
        }
    },

    created() {
        this.fetchReceivables();
        this.fetchPayables();
    },

    methods: {
        fetchReceivables() {
            this.to_receive = [];
            window.axios.get('invoices/overview-receivable').then((res) => {
                this.to_receive = res.data;
            });
        },

        fetchPayables() {
            this.to_pay = [];
            window.axios.get('bills/overview-payable').then((res) => {
                this.to_pay = res.data;
            });
        }
    }
};
</script>
