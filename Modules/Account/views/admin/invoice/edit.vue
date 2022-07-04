<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">
                <FormKit label="Id" id="id" type="hidden" validation="required" />
                <FormKit label="Partner" id="partner_id" type="text" validation="required" />
                <FormKit label="status" id="status" type="switch" validation="required" />
                <FormKit label="completed" id="completed" type="switch" validation="required" />
                <FormKit label="successful" id="successful" type="switch" validation="required" />
            </div>
            <div class="col-md-6">
                <FormKit label="description" id="description" type="text" validation="required" />
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
            path_param: ["account", "invoice"],
            model: {
                id: "",
                partner_id: "",
                description: "",
                status: "",
                completed: "",
                successful: "",
            },

        };
    }
};
</script>
