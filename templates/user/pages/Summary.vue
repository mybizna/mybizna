<template>
    <div>
        <h1>Summary</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="order in orders" :key="order.id">
                    <td>{{ order.id }}</td>
                    <td>{{ order.amount }}</td>
                    <td>{{ order.created_at }}</td>
                </tr>
            </tbody>
        </table>
        <table class="table">
            <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="payment in payments" :key="payment.id">
                    <td>{{ payment.id }}</td>
                    <td>{{ payment.amount }}</td>
                    <td>{{ payment.created_at }}</td>
                </tr>
            </tbody>
        </table>
        <table class="table">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="rankChange in rankChanges" :key="rankChange.id">
                    <td>{{ rankChange.rank }}</td>
                    <td>{{ rankChange.from }}</td>
                    <td>{{ rankChange.to }}</td>
                    <td>{{ rankChange.created_at }}</td>
                </tr>
            </tbody>
        </table>
        <table class="table">
            <thead>
                <tr>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="invoice in invoices" :key="invoice.id">
                    <td>{{ invoice.amount }}</td>
                    <td>{{ invoice.created_at }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    computed: {
        invoices() {
            return this.$store.getters.invoices
        },
        orders() {
            return this.$store.getters.orders
        },
        payments() {
            return this.$store.getters.payments
        },
        rankChanges() {
            return this.$store.getters.rankChanges
        }
    },
    created() {
        this.$store.dispatch('fetchInvoices')
        this.$store.dispatch('fetchOrders')
        this.$store.dispatch('fetchPayments')
        this.$store.dispatch('fetchRankChanges')
    }
}
</script>