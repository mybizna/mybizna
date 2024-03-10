<template>
    <div>
        <h1>Invoices</h1>
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
        }
    },
    created() {
        this.$store.dispatch('fetchInvoices')
    }
}
</script>
