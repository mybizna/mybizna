<template>
    <table-edit :path_param="path_param" :model="model" :recordpicker="recordpicker">
        <div class="row">
            <div class="col-md-6">
                <FormKit label="Id" id="id" type="hidden" v-model="model.id" validation="required" />
                <FormKit label="Partner" id="partner_id" type="recordpicker" comp_url="partner/admin/partner/list.vue"
                    :setting="recordpicker.partner_id" v-model="model.partner_id" validation="required" />
                <FormKit label="Amount" id="amount" type="text" v-model="model.amount" validation="required" />
                <FormKit label="Description" id="description" type="textarea" v-model="model.description"
                    validation="required" />
                <FormKit label="Is Processed" id="is_processed" type="switch" v-model="model.is_processed"
                    validation="required" />
            </div>
            <div class="col-md-6">
                <FormKit label="Type" id="type" type="select" v-model="model.type" validation="required" />

                <div class="border border-gray rounded p-2 mb-2">
                    <label class="text-gray-700 fs-12">Left Move</label>
                    <FormKit label="Left Chart of Account" id="left_chart_of_account_id" type="recordselect"
                        comp_url="chart_of_account/recordselect?type=left" v-model="model.left_chart_of_account_id"
                        validation="required" />
                    <FormKit label="Left Ledger" id="left_ledger_id" type="recordselect" v-model="model.left_ledger_id"
                        comp_url="ledger/recordselect?chart_of_account_id=" :filter="model.left_chart_of_account_id"
                        validation="required" />
                </div>
                <div class="border border-gray rounded p-2 mb-2">
                    <label class="text-gray-700 fs-12">Right Move</label>
                    <FormKit label="Right Chart of Account" id="right_chart_of_account_id" type="recordselect"
                        comp_url="chart_of_account/recordselect?type=right" v-model="model.right_chart_of_account_id"
                        validation="required" />
                    <FormKit label="Right Ledger" id="right_ledger_id" type="recordselect"
                        v-model="model.right_ledger_id" comp_url="ledger/recordselect?chart_of_account_id="
                        :filter="model.right_chart_of_account_id" validation="required" />
                </div>

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
            recordpicker: {
                partner_id: {
                    path_param: ["partner", "partner"],
                    fields: ['first_name', 'last_name', 'email'],
                    template: '[first_name] [last_name] - [email]',
                }
            },
            model: {
                id: "",
                amount: "",
                description: "",
                partner_id: "",
                left_chart_of_account_id: "",
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
