<template>
    <table-edit :path_param="path_param" :model="model">
        <div class="row">
            <div class="col-md-6">
                <FormKit label="Id" id="id" type="hidden" validation="required" />
                <FormKit label="Title" id="title" type="text" validation="required" />
                <FormKit label="Slug" id="slug" type="text" validation="required" />
                <FormKit label="Left Ledger" id="left_ledger_id" type="text" validation="required" />
                <FormKit label="Right Chart Of Account" id="right_chart_of_account_id" type="text" validation="required" />
                <FormKit label="Right Ledger" id="right_ledger_id" type="text" validation="required" />
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
            path_param: ["account", "ledger_setting"],
            model: {
                id: "",
                title: "",
                slug: "",
                left_ledger_id: "",
                right_chart_of_account_id: "",
                right_ledger_id: "",
            },

        };
    }
};
</script>
