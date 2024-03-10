<template>
    <div>
        <h1>Subscribe</h1>
        <form @submit.prevent="subscribe">
            <div class="form-group">
                <label for="plan">Plan</label>
                <select class="form-control" id="plan" v-model="plan" required>
                    <option value="Basic">Basic</option>
                    <option value="Standard">Standard</option>
                    <option value="Premium">Premium</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Subscribe</button>
        </form>
    </div>

</template>

<script>
export default {
    data() {
        return {
            plan: ''
        }
    },
    methods: {
        subscribe() {
            this.$store.dispatch('subscribe', {
                plan: this.plan
            })
        }
    }
}
</script>