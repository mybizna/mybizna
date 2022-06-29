<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">

                <FormKit label="Id" id="id" type="hidden" validation="required" />
                <FormKit label="Tax Rate Name" id="tax_rate_name" type="text" validation="required" />
                <FormKit label="Tax Number" id="tax_number" type="text" validation="required" />
                <FormKit label="Default" id="default" type="text" validation="required" />

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
            path_param: ["account", "tax"],
            model: {
                id: "",
                tax_rate_name: "",
                tax_number: "",
                default: "",
            },

        };
    }
};
</script>
