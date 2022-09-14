<template>
    <table-edit :path_param="path_param" :model="model">
        <div class="row">
            <div class="col-md-6">
                <FormKit label="Id" id="id" type="hidden" validation="required" />
                <FormKit label="Name" id="name" type="text" validation="required" />
                <FormKit label="country_code" id="country_code" type="text" validation="required" />
                <FormKit label="type" id="type" type="text" validation="required" />
                <FormKit label="item_id" id="item_id" type="text" validation="required" />
                <FormKit label="state_code" id="state_code" type="text" validation="required" />
            </div>
            <div class="col-md-6">

                <FormKit label="latitude" id="latitude" type="text" validation="required" />
                <FormKit label="longitude" id="longitude" type="text" validation="required" />
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
