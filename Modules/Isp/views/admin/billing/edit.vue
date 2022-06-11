<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-sm-6">

                <FormKit label="User" id="user_id" type="text" validation="required" />
                <FormKit label="Amount" id="amount" type="text" validation="required" />
                <FormKit label="Completed" id="completed" type="text" validation="required" />
                <FormKit label="Successful" id="successful" type="text" validation="required" />

            </div>
            <div class="col-sm-6">
                <FormKit label="Payment" id="payment_id" type="select" validation="required" />
                <FormKit label="Description" id="Description" type="textarea" validation="required" />

            </div>
        </div>

    </table-edit>
</template>

<script>
export default {
    components: {
        TableEdit: window.$func.fetchComponent("components/common/TableEdit.vue")
    },
    data () {
        return {
            id: null,
            path_param: ["isp", "billing"],
            model: {
                id: "",
                description: "",
                user_id: "",
                payment_id: "",
                amount: "",
                completed: "",
                successful: ""
            },

        };
    }
};
</script>
