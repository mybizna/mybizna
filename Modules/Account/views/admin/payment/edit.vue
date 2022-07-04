<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">
                <FormKit label="Id" id="id" type="hidden" validation="required" />
                <FormKit label="amount" id="amount" type="text" validation="required" />
                <FormKit label="gateway_id" id="gateway_id" type="text" validation="required" />
                <FormKit label="invoice_id" id="invoice_id" type="text" validation="required" />
                <FormKit label="receipt_no" id="receipt_no" type="text" validation="required" />
                <FormKit label="code" id="code" type="text" validation="required" />
            </div>
            <div class="col-md-6">
                <FormKit label="description" id="description" type="text" validation="required" />
                <FormKit label="completed" id="completed" type="switch" validation="required" />
                <FormKit label="successful" id="successful" type="switch" validation="required" />
                <FormKit label="canceled" id="canceled" type="canceled" validation="required" />
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
                invoice_id: "",
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
