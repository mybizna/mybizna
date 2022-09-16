<template>
    <table-edit :path_param="path_param" :model="model">
        <div class="row">
            <div class="col-md-6">

                <FormKit label="Id" id="id" type="hidden" validation="required" />
                <FormKit label="Currency Code" id="currency_code" type="text" validation="required" />
                <FormKit label="Country Code" id="country_code" type="text" validation="required" />
                <FormKit label="Country Code3" id="country_code3" type="text" validation="required" />

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
            path_param: ["core", "countrycurrency"],
            model: {
                id: "",
                currency_code: "",
                country_code: "",
                country_code3: "",
            },

        };
    }
};
</script>
