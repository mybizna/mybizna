<template>
    <div>
        <h1>Add Fund</h1>
        <form @submit.prevent="addFund">
        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" class="form-control" id="amount" v-model="amount" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" v-model="description" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Fund</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            amount: '',
            description: ''
        }
    },
    methods: {
        addFund() {
            this.$store.dispatch('addFund', {
                amount: this.amount,
                description: this.description
            })
        }
    }
}
</script>
