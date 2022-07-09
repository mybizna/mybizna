<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">

                <FormKit label="Connection" id="connection_id" type="text" validation="required" />
                <FormKit label="Invoice" id="invoice_id" type="text" validation="required" />

            </div>
            <div class="col-md-6">

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
            path_param: ["isp", "connection_invoice"],
            model: {
                id: "",
                connection_id: "",
                invoice_id: "",
            },

        };
    }
};
</script>
