<template>
    <table-edit :path_param="path_param" :model="model">
        <div class="row">
            <div class="col-md-6">
                <FormKit v-model="model.id" label="Id" id="id" type="hidden" validation="required" />
                <FormKit v-model="model.name" label="Name" id="name" type="text" validation="required" />
                <FormKit v-model="model.country_code" label="country_code" id="country_code" type="text" validation="required" />
                <FormKit v-model="model.type" label="type" id="type" type="text" validation="required" />
                <FormKit v-model="model.item_id" label="item_id" id="item_id" type="text" validation="required" />
                <FormKit v-model="model.state_code" label="state_code" id="state_code" type="text" validation="required" />
            </div>
            <div class="col-md-6">

                <FormKit v-model="model.latitude" label="latitude" id="latitude" type="text" validation="required" />
                <FormKit v-model="model.longitude" label="longitude" id="longitude" type="text" validation="required" />
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
            path_param: ["core", "state"],
            model: {
                id: "",
                name: "",
                country_code: "",
                type: "",
                item_id: "",
                state_code: "",
                latitude: "",
                longitude: "",
            },

        };
    }
};
</script>
