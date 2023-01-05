<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">
                <FormKit v-model="model.id" label="Id" id="id" type="hidden" validation="required" />
                <FormKit v-model="model.amount" label="Amount" id="amount" type="text" validation="required" />
                <FormKit v-model="model.gateway_id" label="Gateway" id="gateway_id" type="text" validation="required" />
                <FormKit v-model="model.receipt_no" label="Receipt No" id="receipt_no" type="text" validation="required" />
                <FormKit v-model="model.code" label="Code" id="code" type="text" validation="required" />
            </div>
            <div class="col-md-6">
                <FormKit v-model="model.description" label="Description" id="description" type="text" validation="required" />
                <FormKit v-model="model.completed" label="Completed" id="completed" type="switch" validation="required" />
                <FormKit v-model="model.successful" label="Successful" id="successful" type="switch" validation="required" />
                <FormKit v-model="model.canceled" label="Canceled" id="canceled" type="switch" validation="required" />
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
            path_param: ["account", "payment"],
            model: {
                id: "",
                gateway_id: "",
                amount: "",
                description: "",
                receipt_no: "",
                code: "",
                completed: "",
                successful: "",
                canceled: "",
            },

        };
    }
};
</script>
