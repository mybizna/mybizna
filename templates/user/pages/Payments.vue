<template>
    <div>
        <h1>Payment History</h1>
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
    </div>
</template>

<script>
export default {
    computed: {
        payments() {
            return this.$store.getters.payments
        }
    },
    created() {
        this.$store.dispatch('fetchPayments')
    }
}
</script>