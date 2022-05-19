<template>
    <div class="container">

        <!-- Start .header-section -->
        <div class="content-header-section separator">
            <div class="row between-xs">
                <div class="col">
                    <h2 class="content-header__title">{{ this.$func.__('Purchases Transactions') }}</h2>
                    <combo-box
                        :options="pages"
                        :hasUrl="true"
                        :placeholder="this.$func.__('New Transaction')" />
                </div>
            </div>
        </div>
        <!-- End .header-section -->

        <purchases-stats />
        <transactions-filter  :types="filterTypes" :people="{title: this.$func.__('Vendor'), items: vendors}"/>
        <purchases-list />

    </div>
</template>

<script>

export default {

    components: {
        PurchasesStats: window.$func.fetchComponent('components/transactions/purchases/PurchasesStats.vue'),
        PurchasesList: window.$func.fetchComponent('components/transactions/purchases/PurchasesList.vue'),
        TransactionsFilter: window.$func.fetchComponent('components/transactions/TransactionsFilter.vue'),
        ComboBox: window.$func.fetchComponent('components/select/ComboBox.vue')
    },

    data() {
        return {
            pages: [
                { namedRoute: 'PurchaseCreate', name: this.$func.__('Create Purchase') },
                { namedRoute: 'PayPurchaseCreate', name: this.$func.__('Pay Purchase') },
                { namedRoute: 'PurchaseOrderCreate', name:  this.$func.__('Create Purchase Order') }
            ],
            filterTypes:[
                { id: 'purchase', name: this.$func.__('Purchase') },
                { id: 'pay_purchase', name: this.$func.__('Payment') },
                { id: 'receive_pay_purchase', name: this.$func.__('Receive') },
            ],
            pro_activated: false,
        };
    },

    computed: mapState({
        vendors: state => state.purchase.vendors
    }),

    created() {
        setTimeout(()=>{
            this.pro_activated =  this.$store.state.pro_activated ?  this.$store.state.pro_activated : false
            if(this.pro_activated ){
                this.pages.push({ namedRoute: 'PurchaseReturnList', name:  this.$func.__('Purchase Return') })
             }
        }, 200);

        if(!this.vendors.length){
            this.$store.dispatch('purchase/fetchVendors');
        }
    }

    };
</script>
