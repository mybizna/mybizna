<template>
    <table-edit :path_param="path_param" :model="model">
        <div class="row">
            <div class="col-md-6">
                <FormKit label="Id" id="id" type="hidden" v-model="model.id" validation="required" />
                <FormKit label="Title" id="title" type="text" v-model="model.title" validation="required" />
                <div class="border border-gray rounded p-2 mb-2 mt-3">
                    <label class="text-gray-700 fs-12">Left Move</label>
                    <FormKit label="Left Chart of Account" id="left_chart_of_account_id" type="recordselect"
                        v-model="model.left_chart_of_account_id" :setting="setting.left_chart_of_account_id"
                        validation="required" />
                    <FormKit :disabled="!model.left_chart_of_account_id" label="Left Ledger" id="left_ledger_id"
                        type="recordselect" v-model="model.left_ledger_id" :filter="model.left_chart_of_account_id"
                        :setting="setting.left_ledger_id" validation="required" />
                </div>
            </div>
            <div class="col-md-6">
                <FormKit label="Slug" id="slug" type="text" v-model="model.slug" validation="required" />
                <div class="border border-gray rounded p-2 mb-2 mt-3">
                    <label class="text-gray-700 fs-12">Right Move</label>
                    <FormKit label="Right Chart of Account" id="right_chart_of_account_id" type="recordselect"
                        :setting="setting.right_chart_of_account_id" v-model="model.right_chart_of_account_id"
                        validation="required" />
                    <FormKit :disabled="!model.right_chart_of_account_id" label="Right Ledger" id="right_ledger_id"
                        type="recordselect" v-model="model.right_ledger_id" :filter="model.right_chart_of_account_id"
                        :setting="setting.right_ledger_id" validation="required" />

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
            path_param: ["account", "ledger_setting"],
            setting: {
                left_chart_of_account_id: { url: "chart_of_account/recordselect?type=left" },
                left_ledger_id: { url: "ledger/recordselect?chart_of_account_id=", filter: this.model.left_chart_of_account_id },
                right_chart_of_account_id: { url: "chart_of_account/recordselect?type=right" },
                right_ledger_id: { url: "ledger/recordselect?chart_of_account_id=", filter: this.model.right_chart_of_account_id },
            },
            model: {
                id: "",
                title: "",
                slug: "",
                left_chart_of_account_id: "",
                left_ledger_id: "",
                right_chart_of_account_id: "",
                right_ledger_id: "",
            },

        };
    }
};
</script>
