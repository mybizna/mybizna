<template>
    <div class="mybizna-container">

        <!-- Start .header-section -->
        <div class="content-header-section separator">
            <div class="mybizna-row mybizna-between-xs">
                <div class="mybizna-col">
                    <h2 class="content-header__title">{{ window.$func.__('Sales Transactions', 'erp') }}</h2>
                    <combo-box
                        :options="pages"
                        :hasUrl="true"
                        :placeholder="__('New Transaction', 'erp')" />
                </div>
            </div>
        </div>
        <!-- End .header-section -->

        <sales-stats />
        <transactions-filter :types="filterTypes" :people="{title: window.$func.__('Customer', 'erp'), items: customers}"/>
        <sales-list />
    </div>
</template>

<script>
import ComboBox from 'assets/components/select/ComboBox.vue';
import SalesStats from 'assets/components/transactions/sales/SalesStats.vue';
import SalesList from 'assets/components/transactions/sales/SalesList.vue';
import TransactionsFilter from 'assets/components/transactions/TransactionsFilter.vue';
import {mapState} from "vuex";

export default {

    components: {
        SalesStats,
        SalesList,
        TransactionsFilter,
        ComboBox
    },

    data() {
        return {
            pages: [
                { namedRoute: 'InvoiceCreate', name: window.$func.__('Create Invoice', 'erp') },
                { namedRoute: 'RecPaymentCreate', name: window.$func.__('Receive Payment', 'erp') },
                { namedRoute: 'EstimateCreate', name: window.$func.__('Create Estimate', 'erp') }
            ],

            filterTypes:[
                { id: 'invoice', name: window.$func.__('Invoice', 'erp') },
                { id: 'payment', name: window.$func.__('Receive', 'erp') },
                { id: 'return_payment', name: window.$func.__('Payment', 'erp') },
                { id: 'estimate', name: window.$func.__('Estimate', 'erp') }
            ],

            pro_activated: false,
        };
    },

    created() {
        setTimeout(()=>{
            this.pro_activated =  this.$store.state.erp_pro_activated ?  this.$store.state.erp_pro_activated : false
            if(this.pro_activated ){
                this.pages.push({ namedRoute: 'SalesReturnList', name: window.$func.__('Sales Return', 'erp') })
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
