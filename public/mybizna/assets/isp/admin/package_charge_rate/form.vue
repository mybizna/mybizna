<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">
                <FormKit label="Id" id="id" type="hidden" validation="required" />
                <FormKit label="Package Charge" id="package_charge_id" type="text" validation="required" />
                <FormKit label="Rate" id="rate_id" type="text" validation="required" />
            </div>
            <div class="col-md-6">
                <FormKit label="Published" id="published" type="switch" validation="required" />
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
            path_param: ["isp", "package_charge_rate"],
            model: {
                id: "",
                package_charge_id: "",
                rate_id: "",
                published: "",
            },

        };
    }
};
</script>
