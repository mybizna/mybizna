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

    <edit-render :path_param="['account', 'chart_of_account']" title="Chart of Account" :model="model">

        <div class="row">
            <div class="col-md-6">

                <FormKit v-model="model.id" label="Id" id="id" type="hidden" validation="required" />
                <FormKit v-model="model.name" label="Name" id="name" type="text" validation="required" />
                <FormKit v-model="model.slug" label="Slug" id="slug" type="text" validation="required" />

            </div>
            <div class="col-md-6">

            </div>
        </div>


    </edit-render>
</template>

<script>
//generate sample form
export default {
    data: function () {
        return {
            id: null,
            model: {
                id: "",
                name: "",
                slug: "",
            },
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
