<template>
    <div class="mybizna-container">

        <!-- Start .header-section -->
        <div class="content-header-section separator">
            <div class="mybizna-row mybizna-between-xs">
                <div class="mybizna-col">
                    <h2 class="content-header__title">{{ this.$func.__('Sales Transactions', 'erp') }}</h2>
                    <combo-box
                        :options="pages"
                        :hasUrl="true"
                        :placeholder="this.$func.__('New Transaction', 'erp')" />
                </div>
            </div>
        </div>
        <!-- End .header-section -->

        <sales-stats />
        <transactions-filter :types="filterTypes" :people="{title: this.$func.__('Customer', 'erp'), items: customers}"/>
        <sales-list />
    </div>
</template>

<script>

export default {

    components: {
        SalesStats : window.$func.fetchComponent('components/transactions/sales/SalesStats.vue'),
        SalesList : window.$func.fetchComponent('components/transactions/sales/SalesList.vue'),
        TransactionsFilter : window.$func.fetchComponent('components/transactions/sales/SalesList.vue'),
        ComboBox : window.$func.fetchComponent('components/select/ComboBox.vue')
    },

    data() {
        return {
            pages: [
                { namedRoute: 'InvoiceCreate', name: this.$func.__('Create Invoice', 'erp') },
                { namedRoute: 'RecPaymentCreate', name: this.$func.__('Receive Payment', 'erp') },
                { namedRoute: 'EstimateCreate', name: this.$func.__('Create Estimate', 'erp') }
            ],

            filterTypes:[
                { id: 'invoice', name: this.$func.__('Invoice', 'erp') },
                { id: 'payment', name: this.$func.__('Receive', 'erp') },
                { id: 'return_payment', name: this.$func.__('Payment', 'erp') },
                { id: 'estimate', name: this.$func.__('Estimate', 'erp') }
            ],

            pro_activated: false,
        };
    },

    created() {
        setTimeout(()=>{
            this.pro_activated =  this.$store.state.erp_pro_activated ?  this.$store.state.erp_pro_activated : false
            if(this.pro_activated ){
                this.pages.push({ namedRoute: 'SalesReturnList', name: this.$func.__('Sales Return', 'erp') })
            }
        }, 200);

        if(!this.customers.length){
            this.$store.dispatch('sales/fillCustomers', []);
        }
    },

    computed: mapState({
        customers: state => state.sales.customers
    }),

};
</script>

<style>
</style>
