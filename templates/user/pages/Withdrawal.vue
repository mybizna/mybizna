<template>
    <div>
        <h1>Withdrawal</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="withdrawal in withdrawals" :key="withdrawal.id">
                    <td>{{ withdrawal.amount }}</td>
                    <td>{{ withdrawal.created_at }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    computed: {
        withdrawals() {
            return this.$store.getters.withdrawals
        }
    },
    created() {
        this.$store.dispatch('fetchWithdrawals')
    }
}
</script>