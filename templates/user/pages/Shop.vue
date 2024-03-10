<template>
    <div>
        <h1>Shop</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in products" :key="product.id">
                    <td>{{ product.name }}</td>
                    <td>{{ product.price }}</td>
                    <td>{{ product.quantity }}</td>
                    <td>{{ product.price * product.quantity }}</td>
                    <td>
                        <button @click="addToCart(product)">Add to Cart</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    computed: {
        products() {
            return this.$store.getters.products
        }
    },
    created() {
        this.$store.dispatch('fetchProducts')
    },
    methods: {
        addToCart(product) {
            this.$store.dispatch('addToCart', product)
        }
    }
}
</script>