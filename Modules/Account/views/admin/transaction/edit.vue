<template>
    <table-edit :path_param="path_param" :model="model">
        <div class="row">
            <div class="col-md-6">
                <FormKit label="Id" id="id" type="hidden" validation="required" />
                <FormKit label="Amount" id="amount" type="text" validation="required" />
                <FormKit label="Partner" id="partner_id" type="text" validation="required" />
                <FormKit label="Left Ledger" id="left_ledger_id" type="text" validation="required" />
                <FormKit label="Right Chart of Account" id="right_chart_of_account_id" type="text"
                    validation="required" />
                <FormKit label="Right Ledger" id="right_ledger_id" type="text" validation="required" />
                <FormKit label="Type" id="type" type="text" validation="required" />
                <FormKit label="Is Processed" id="is_processed" type="text" validation="required" />
            </div>
            <div class="col-md-6">
                <FormKit label="Description" id="description" type="text" validation="required" />
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
            path_param: ["account", "transaction"],
            model: {
                id: "",
                amount: "",
                description: "",
                partner_id: "",
                left_ledger_id: "",
                right_chart_of_account_id: "",
                right_ledger_id: "",
                type: "",
                is_processed: "",
            },

        };
    }
};
</script>
