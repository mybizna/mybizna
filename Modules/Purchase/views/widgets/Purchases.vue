<template>
    <div class="wperp-container">

        <!-- Start .header-section -->
        <div class="content-header-section separator">
            <div class="wperp-row wperp-between-xs">
                <div class="wperp-col">
                    <h2 class="content-header__title">{{ this.$func.__('Purchases Transactions', 'erp') }}</h2>
                    <combo-box
                        :options="pages"
                        :hasUrl="true"
                        :placeholder="__('New Transaction', 'erp')" />
                </div>
            </div>
        </div>
        <!-- End .header-section -->

        <purchases-stats />
        <transactions-filter  :types="filterTypes" :people="{title: this.$func.__('Vendor', 'erp'), items: vendors}"/>
        <purchases-list />

    </div>
</template>

<script>
import 'assets/js/plugins/chart.min';
import 'assets/js/status_chart';

import ComboBox from 'assets/components/select/ComboBox.vue';
import PurchasesStats from 'assets/components/transactions/purchases/PurchasesStats.vue';
import PurchasesList from 'assets/components/transactions/purchases/PurchasesList.vue';
import TransactionsFilter from 'assets/components/transactions/TransactionsFilter.vue';
import {mapState} from "vuex";

export default {

    components: {
        PurchasesStats,
        PurchasesList,
        TransactionsFilter,
        ComboBox
    },

    data() {
        return {
            pages: [
                { namedRoute: 'PurchaseCreate', name: this.$func.__('Create Purchase', 'erp') },
                { namedRoute: 'PayPurchaseCreate', name: this.$func.__('Pay Purchase', 'erp') },
                { namedRoute: 'PurchaseOrderCreate', name:  this.$func.__('Create Purchase Order', 'erp') }
            ],
            filterTypes:[
                { id: 'purchase', name: this.$func.__('Purchase', 'erp') },
                { id: 'pay_purchase', name: this.$func.__('Payment', 'erp') },
                { id: 'receive_pay_purchase', name: this.$func.__('Receive', 'erp') },
            ],
            pro_activated: false,
        };
    },

    computed: mapState({
        vendors: state => state.purchase.vendors
    }),

    created() {
        setTimeout(()=>{
            this.pro_activated =  this.$store.state.erp_pro_activated ?  this.$store.state.erp_pro_activated : false
            if(this.pro_activated ){
                this.pages.push({ namedRoute: 'PurchaseReturnList', name:  this.$func.__('Purchase Return', 'erp') })
             }
        }, 200);

        if(!this.vendors.length){
            this.$store.dispatch('purchase/fetchVendors');
        }
    }

    };
</script>
