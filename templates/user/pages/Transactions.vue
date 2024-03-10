<template>
    <div>
        <h1>Transactions</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="transaction in transactions" :key="transaction.id">
                    <td>{{ transaction.id }}</td>
                    <td>{{ transaction.amount }}</td>
                    <td>{{ transaction.created_at }}</td>
                </tr>
            </tbody>
        </table>
       
    </div>
</template>

<script>
export default {
    computed: {
        transactions() {
            return this.$store.getters.transactions
        }
    },
    created() {
        this.$store.dispatch('fetchTransactions')
    }
}
</script>