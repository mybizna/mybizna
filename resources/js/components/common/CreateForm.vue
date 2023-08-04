<template>
    <!-- Generate sample form for submitting user details -->
    <h1>User Details Form with Vue.js</h1>
    <form @submit.prevent="submitForm">
        <label for="name">Name:</label>
        <input type="text" v-model="user.name" required>
        <br>

        <label for="email">Email:</label>
        <input type="email" v-model="user.email" required>
        <br>

        <label for="age">Age:</label>
        <input type="number" v-model.number="user.age" required>
        <br>

        <button type="submit">Submit</button>
    </form>
</template>

<script>
//generate sample form
export default {
    data: function () {
        return {
            user: {
                name: '',
                email: '',
                age: ''
            }
        }
    },
    methods: {
        submitForm: function () {
            console.log(this.user);
        }
    }
};
</script>
