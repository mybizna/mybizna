<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">

                <FormKit label="Id" id="id" type="hidden" validation="required" />
                <FormKit label="Title" id="title" type="text" validation="required" />
                <FormKit label="Connection" id="connection_id" type="text" validation="required" />
                <FormKit label="Invoice" id="invoice_id" type="text" validation="required" />
                <FormKit label="Start Date" id="start_date" type="datetime" validation="required" />
                <FormKit label="End Date" id="end_date" type="datetime" validation="required" />

            </div>
            <div class="col-md-6">
                <FormKit label="Description" id="description" type="textarea" validation="required" />
                <FormKit label="Is Paid" id="is_paid" type="switch" validation="required" />

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
            path_param: ["account", "ledger"],
            model: {
                id: "",
                chart_id: "",
                category_id: "",
                name: "",
                slug: "",
                code: "",
                unused: "",
                system: "",
            },

        };
    }
};
</script>
