<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">
                <FormKit label="Id" id="id" type="hidden" validation="required" />
                <FormKit label="Amount" id="amount" type="text" validation="required" />
                <FormKit label="Gateway" id="gateway_id" type="text" validation="required" />
                <FormKit label="Invoice" id="invoice_id" type="text" validation="required" />
                <FormKit label="Transaction" id="transaction_id" type="text" validation="required" />
                <FormKit label="Receipt No" id="receipt_no" type="text" validation="required" />
                <FormKit label="Code" id="code" type="text" validation="required" />
            </div>
            <div class="col-md-6">
                <FormKit label="Description" id="description" type="text" validation="required" />
                <FormKit label="Completed" id="completed" type="switch" validation="required" />
                <FormKit label="Successful" id="successful" type="switch" validation="required" />
                <FormKit label="Canceled" id="canceled" type="switch" validation="required" />
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
                transaction_id: "",
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
