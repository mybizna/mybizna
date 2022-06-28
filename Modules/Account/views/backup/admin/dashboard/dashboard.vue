<template>
    <div class="containers">
        <!-- Start .header-section -->
        <div class="content-header-section separator">
            <div class="row between-xs">
                <div class="col">
                    <h2 class="content-header__title">
                        {{ this.$func.__("Dashboard", "erp") }}
                    </h2>
                    <a
                        class="btn btn-primary"
                        :href="tutorialUrl"
                        id="btn-tutorial-start"
                    >
                        <span class="dashicons dashicons-controls-play"></span>
                        {{ this.$func.__(" Start Tutorial", "erp") }}
                    </a>
                </div>
            </div>
        </div>
        <!-- End .header-section -->

        <div class="dashboard">
            <div class="row">
                <div
                    class="col-md-9 col-sm-12 "
                >
                    <!-- Start .income-expense-section -->
                    <chart></chart>
                    <!-- End .income-expense-section -->
                </div>
                <div
                    class="col-md-3 col-sm-12 "
                >
                    <!-- Start .bank-accounts-section -->
                    <accounts></accounts>
                    <!-- End .bank-accounts-section -->
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 ">
                    <!-- Start .invoice-own-section -->
                    <div
                        class="invoice-own-section panel panel-default"
                    >
                        <div class="panel-heading bg-white">
                            <h4>
                                {{
                                    this.$func.__(
                                        "Invoice payable to you",
                                        "erp"
                                    )
                                }}
                            </h4>
                        </div>
                        <div class="panel-body pb-0">
                            <ul
                                class="list-unstyled list-table-content"
                                v-if="Object.values(to_receive).length"
                            >
                                <li>
                                    <span class="title">{{
                                        this.$func.__(
                                            "1-30 days overdue",
                                            "erp"
                                        )
                                    }}</span>
                                    <span class="price">{{
                                        formatAmount(to_receive.amount.first)
                                    }}</span>
                                </li>
                                <li>
                                    <span class="title">{{
                                        this.$func.__(
                                            "31-60 days overdue",
                                            "erp"
                                        )
                                    }}</span>
                                    <span class="price">{{
                                        formatAmount(to_receive.amount.second)
                                    }}</span>
                                </li>
                                <li>
                                    <span class="title">{{
                                        this.$func.__(
                                            "61-90 days overdue",
                                            "erp"
                                        )
                                    }}</span>
                                    <span class="price">{{
                                        formatAmount(to_receive.amount.third)
                                    }}</span>
                                </li>
                                <li class="total">
                                    <span class="title">{{
                                        this.$func.__("Total Balance", "erp")
                                    }}</span>
                                    <span class="price">{{
                                        total_receivable
                                    }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- End .invoice-own-section -->
                </div>
                <div class="col-sm-6 ">
                    <!-- Start .invoice-own-section -->
                    <div
                        class="invoice-own-section panel panel-default"
                    >
                        <div class="panel-heading bg-white">
                            <h4>
                                {{
                                    this.$func.__(
                                        "Bills you need to pay",
                                        "erp"
                                    )
                                }}
                            </h4>
                        </div>
                        <div class="panel-body pb-0">
                            <ul
                                class="list-unstyled list-table-content"
                                v-if="Object.values(to_pay).length"
                            >
                                <li>
                                    <span class="title">{{
                                        this.$func.__(
                                            "1-30 days overdue",
                                            "erp"
                                        )
                                    }}</span>
                                    <span class="price">{{
                                        formatAmount(to_pay.amount.first)
                                    }}</span>
                                </li>
                                <li>
                                    <span class="title">{{
                                        this.$func.__(
                                            "31-60 days overdue",
                                            "erp"
                                        )
                                    }}</span>
                                    <span class="price">{{
                                        formatAmount(to_pay.amount.second)
                                    }}</span>
                                </li>
                                <li>
                                    <span class="title">{{
                                        this.$func.__(
                                            "61-90 days overdue",
                                            "erp"
                                        )
                                    }}</span>
                                    <span class="price">{{
                                        formatAmount(to_pay.amount.third)
                                    }}</span>
                                </li>
                                <li class="total">
                                    <span class="title">{{
                                        this.$func.__("Total Balance", "erp")
                                    }}</span>
                                    <span class="price">{{
                                        total_payable
                                    }}</span>
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

export default {

    components: {
        Chart: window.$func.fetchComponent('components/dashboard/Chart.vue'),
        Accounts: window.$func.fetchComponent('components/dashboard/Accounts.vue')
    },

    data() {
        return {
            title1        : this.$func.__('Income & Expenses'),
            title2        : this.$func.__('Bank Accounts'),
            title3        : this.$func.__('Invoices owed to you'),
            title4        : this.$func.__('Bills to pay'),
            closable      : true,
            msg           : this.$func.__('Accounting'),
            to_receive    : [],
            to_pay        : [],
            tutorialUrl   : this.$mybizna_var.tut_url
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
