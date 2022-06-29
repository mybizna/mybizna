<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">
                <FormKit label="Id" id="id" type="hidden" validation="required" />
                <FormKit label="Short Code" id="short_code" type="text" validation="required" />
                <FormKit label="Ledger" id="ledger_id" type="text" validation="required" />

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
                ledger_id: "",
                short_code: "",
            },

        };
    }
};
</script>
