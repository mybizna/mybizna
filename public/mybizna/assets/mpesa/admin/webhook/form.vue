<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">
                <FormKit v-model="model.id" label="Val" id="val" type="text" validation="required" />
                <FormKit v-model="model.conf" label="Conf" id="conf" type="text" validation="required" />
                <FormKit v-model="model.published" label="Published" id="published" type="switch" validation="required" />
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
            path_param: ["mpesa", "webhook"],
            model: {
                id: "",
                val: "",
                conf: "",
                published: "",
            },

        };
    }
};
</script>
