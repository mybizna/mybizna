<template>
    <div>
        <h1>Order History</h1>
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
    </div>
</template>

<script>
export default {
    computed: {
        orders() {
            return this.$store.getters.orders
        }
    },
    created() {
        this.$store.dispatch('fetchOrders')
    }
}
</script>