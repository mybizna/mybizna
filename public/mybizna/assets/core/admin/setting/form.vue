<template>
    <table-edit :path_param="path_param" :model="model">
        <div class="row">
            <div class="col-md-6">

                <FormKit v-model="model.id" label="Id" id="id" type="hidden" :readonly="true" validation="required" />
                <FormKit v-model="model.module" label="Module" id="module" type="text" :readonly="true" validation="required" />
                <FormKit v-model="model.model" label="Model" id="model" type="text" :readonly="true" validation="required" />
                <FormKit v-model="model.name" label="Name" id="name" type="text" :readonly="true" validation="required" />
                <FormKit v-model="model.type" label="Type" id="type" type="text" :readonly="true" validation="required" />
                <FormKit v-model="model.value" label="Value" id="value" type="text" validation="required" />
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
