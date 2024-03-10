<template>
    <div>
        <h1>Directs</h1>
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
                <tr v-for="direct in directs" :key="direct.id">
                    <td>{{ direct.full_name }}</td>
                    <td>{{ direct.email }}</td>
                    <td>{{ direct.phone_number }}</td>
                    <td>{{ direct.country }}</td>
                    <td>{{ direct.state }}</td>
                    <td>{{ direct.city }}</td>
                    <td>{{ direct.address }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    computed: {
        directs() {
            return this.$store.getters.directs
        }
    },
    created() {
        this.$store.dispatch('fetchDirects')
    }
}

</script>