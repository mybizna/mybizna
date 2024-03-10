<template>
    <div>
        <h1>Upline</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Upline ID</th>
                    <th>Username</th>
                    <th>Rank</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="upline in uplines" :key="upline.id">
                    <td>{{ upline.id }}</td>
                    <td>{{ upline.username }}</td>
                    <td>{{ upline.rank }}</td>
                    <td>{{ upline.created_at }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    computed: {
        uplines() {
            return this.$store.getters.uplines
        }
    },
    created() {
        this.$store.dispatch('fetchUplines')
    }
}

</script>