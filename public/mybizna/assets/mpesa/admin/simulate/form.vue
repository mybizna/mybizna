<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">
                <FormKit v-model="model.id" label="Id" id="id" type="hidden" validation="required" />
                <FormKit v-model="model.amount" label="Amount" id="amount" type="text" validation="required" />
                <FormKit v-model="model.phone" label="Phone" id="phone" type="text" validation="required" />
                <FormKit v-model="model.reference" label="Reference" id="reference" type="text" validation="required" />
                <FormKit v-model="model.description" label="Description" id="description" type="text" validation="required" />
            </div>
            <div class="col-md-6">
                <FormKit v-model="model.gateway_id" label="Gateway" id="gateway_id" type="text" validation="required" />
                <FormKit v-model="model.completed" label="Completed" id="completed" type="text" validation="required" />
                <FormKit v-model="model.published" label="Published" id="published" type="switch" validation="required" />
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
            path_param: ["mpesa", "simulate"],
            model: {
                id: "",
                amount: "",
                phone: "",
                reference: "",
                description: "",
                gateway_id: "",
                completed: "",
                successful: "",
            },

        };
    }
};
</script>
