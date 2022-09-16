<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">
                <FormKit label="Id" id="id" type="hidden" validation="required" />
                <FormKit label="Title" id="title" type="text" validation="required" />
                <FormKit label="Subscription" id="subscription_id" type="text" validation="required" />
                <FormKit label="Invoice" id="invoice_id" type="text" validation="required" />
            </div>
            <div class="col-md-6">
                <FormKit label="Description" id="description" type="textarea" validation="required" />
                <FormKit label="Is Paid" id="is_paid" type="switch" validation="required" />
                <FormKit label="Completed" id="completed" type="switch" validation="required" />
                <FormKit label="Successful" id="successful" type="switch" validation="required" />
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

