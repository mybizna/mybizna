<template>
    <table-edit :path_param="path_param" :model="model">
        <div class="row">
            <div class="col-md-6">

                <FormKit label="Id" id="id" type="hidden" :readonly="true" validation="required" />
                <FormKit label="Module" id="module" type="text" :readonly="true" validation="required" />
                <FormKit label="Model" id="model" type="text" :readonly="true" validation="required" />
                <FormKit label="Name" id="name" type="text" :readonly="true" validation="required" />
                <FormKit label="Type" id="type" type="text" :readonly="true" validation="required" />
                <FormKit label="Value" id="value" type="text" validation="required" />
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
            path_param: ["core", "setting"],
            model: {
                id: "",
                module: "",
                model: "",
                name: "",
                type: "",
                value: "",
            },

        };
    }
};
</script>
