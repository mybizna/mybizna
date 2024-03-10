<template>
    <div>
        <h1>Airtime History</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Amount</th>
                    <th>Mobile Number</th>
                    <th>Network</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="history in airtimeHistory" :key="history.id">
                    <td>{{ history.amount }}</td>
                    <td>{{ history.mobile_number }}</td>
                    <td>{{ history.network }}</td>
                    <td>{{ history.created_at }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    computed: {
        airtimeHistory() {
            return this.$store.getters.airtimeHistory
        }
    },
    created() {
        this.$store.dispatch('fetchAirtimeHistory')
    }
}
</script>

