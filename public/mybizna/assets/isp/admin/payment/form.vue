<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">
                <FormKit v-model="model.id"  label="Id" id="id" type="hidden" validation="required" />
                <FormKit v-model="model.title"  label="Title" id="title" type="text" validation="required" />
                <FormKit v-model="model.subscription_id"  label="Subscription" id="subscription_id" type="text" validation="required" />
                <FormKit v-model="model.invoice_id"  label="Invoice" id="invoice_id" type="text" validation="required" />
            </div>
            <div class="col-md-6">
                <FormKit v-model="model.description"  label="Description" id="description" type="textarea" validation="required" />
                <FormKit v-model="model.is_paid"  label="Is Paid" id="is_paid" type="switch" validation="required" />
                <FormKit v-model="model.completed"  label="Completed" id="completed" type="switch" validation="required" />
                <FormKit v-model="model.successful"  label="Successful" id="successful" type="switch" validation="required" />
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
            path_param: ["isp", "payment"],
            model: {
                id: "",
                title: "",
                subscription_id: "",
                invoice_id: "",
                description: "",
                is_paid: "",
                completed: "",
                successful: "",
            },

        };
    }
};
</script>

