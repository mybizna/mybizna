<template>
    <div>
        <h1>Downline</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Country</th>
                    <th>State</th>
                    <th>City</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="downline in downlines" :key="downline.id">
                    <td>{{ downline.full_name }}</td>
                    <td>{{ downline.email }}</td>
                    <td>{{ downline.phone_number }}</td>
                    <td>{{ downline.country }}</td>
                    <td>{{ downline.state }}</td>
                    <td>{{ downline.city }}</td>
                    <td>{{ downline.address }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    computed: {
        downlines() {
            return this.$store.getters.downlines
        }
    },
    created() {
        this.$store.dispatch('fetchDownlines')
    }
}
</script>
