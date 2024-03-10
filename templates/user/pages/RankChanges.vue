<template>
    <div>
        <h1>Rank Changes</h1>
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
    </div>
</template>

<script>
export default {
    computed: {
        rankChanges() {
            return this.$store.getters.rankChanges
        }
    },
    created() {
        this.$store.dispatch('fetchRankChanges')
    }
}
</script>