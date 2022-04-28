<template>
    <div class="mybizna-container">

        <!-- Start .header-section -->
        <div class="content-header-section separator">
            <div class="mybizna-row mybizna-between-xs">
                <div class="mybizna-col">
                    <h2 class="content-header__title">{{ window.$func.__('Expenses Transactions', 'erp') }}</h2>
                    <combo-box :options="pages" :hasUrl="true" :placeholder="__('New Transaction', 'erp')" />
                </div>
            </div>
        </div>
        <!-- End .header-section -->

        <expenses-stats />

        <transactions-filter :types="filterTypes"  :people="{title: window.$func.__('Pay to', 'erp'), items: people}" />

        <expenses-list />

        <!-- End .mybizna-crm-table -->
    </div>
</template>

<script>
import 'assets/js/plugins/chart.min';
import 'assets/js/status_chart';

import ComboBox from 'assets/components/select/ComboBox.vue';
import ExpensesStats from 'assets/components/transactions/expenses/ExpensesStats.vue';
import ExpensesList from 'assets/components/transactions/expenses/ExpensesList.vue';
import TransactionsFilter from 'assets/components/transactions/TransactionsFilter.vue';
import {mapState} from "vuex";

export default {

    components: {
        ComboBox,
        ExpensesStats,
        ExpensesList,
        TransactionsFilter
    },

    data() {
        return {
            pages: [
                { namedRoute: 'ExpenseCreate', name: window.$func.__('Create Expense', 'erp') },
                { namedRoute: 'CheckCreate', name: window.$func.__('Create Check', 'erp') },
                { namedRoute: 'BillCreate', name: window.$func.__('Create Bill', 'erp') },
                { namedRoute: 'PayBillCreate', name: window.$func.__('Pay Bill', 'erp') }
            ],

            filterTypes:[
                {id: 'expense', name: window.$func.__('Expense', 'erp')},
                {id: 'bill', name: window.$func.__('Bill', 'erp')},
                {id: 'pay_bill', name: window.$func.__('Bill Payment', 'erp')},
                {id: 'check', name: window.$func.__('Check', 'erp')}
            ]
        };
    },
    created() {
        if(!this.people.length){
            this.$store.dispatch('expense/fetchPeople');
        }
    },
    computed: mapState({
        people: state => state.expense.people
    }),
};
</script>
