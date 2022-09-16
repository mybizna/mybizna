<template>
    <table-edit :path_param="path_param" :model="model">
        <div class="row">
            <div class="col-md-6">

                <FormKit label="Id" id="id" type="hidden" validation="required" />
                <FormKit label="Name" id="name" type="text" validation="required" />
                <FormKit label="Code" id="code" type="text" :readonly="true" validation="required" />
                <FormKit label="Code3" id="code3" type="text" :readonly="true" validation="required" />

            </div>
            <div class="col-md-6">
                <FormKit label="Latitude" id="latitude" type="text" :readonly="true" validation="required" />
                <FormKit label="Longitude" id="longitude" type="text" :readonly="true" validation="required" />

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
            path_param: ["core", "country"],
            model: {
                id: "",
                name: "",
                slug: "",
                code: "",
                unused: "",
                system: "",
            },

        };
    }
};
</script>
