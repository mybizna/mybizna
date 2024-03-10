<template>
    <div>
        <h1>Cart</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in cart" :key="item.id">
                    <td>{{ item.product.name }}</td>
                    <td>{{ item.quantity }}</td>
                    <td>{{ item.product.price }}</td>
                    <td>{{ item.product.price * item.quantity }}</td>
                </tr>
            </tbody>
        </table>
        <h3>Total: {{ total }}</h3>
        <button class="btn btn-primary" @click="checkout">Checkout</button>
    </div>
</template>

<script>
export default {
    computed: {
        cart() {
            return this.$store.getters.cart
        },
        total() {
            return this.$store.getters.total
        }
    },
    methods: {
        checkout() {
            this.$store.dispatch('checkout')
        }
    }
}

</script>