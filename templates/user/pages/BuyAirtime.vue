<template>
    <div>
        <h1>Buy Airtime</h1>
        <form @submit.prevent="buyAirtime">
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" class="form-control" id="amount" v-model="amount" required>
            </div>
            <div class="form-group">
                <label for="mobile_number">Mobile Number</label>
                <input type="text" class="form-control" id="mobile_number" v-model="mobile_number" required>
            </div>
            <div class="form-group">
                <label for="network">Network</label>
                <select class="form-control" id="network" v-model="network" required>
                    <option value="MTN">MTN</option>
                    <option value="GLO">GLO</option>
                    <option value="AIRTEL">AIRTEL</option>
                    <option value="9MOBILE">9MOBILE</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Buy Airtime</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            amount: '',
            mobile_number: '',
            network: ''
        }
    },
    methods: {
        buyAirtime() {
            this.$store.dispatch('buyAirtime', {
                amount: this.amount,
                mobile_number: this.mobile_number,
                network: this.network
            })
        }
    }
}

</script>