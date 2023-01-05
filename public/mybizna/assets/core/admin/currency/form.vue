<template>
    <table-edit :path_param="path_param" :model="model">
        <div class="row">
            <div class="col-md-6">

                <FormKit v-model="model.id" label="Id" id="id" type="hidden" validation="required" />
                <FormKit v-model="model.name" label="Name" id="name" type="text" validation="required" />
                <FormKit v-model="model.code" label="Code" id="code" type="text" validation="required" />
                <FormKit v-model="model.rate" label="rate" id="rate" type="text" validation="required" />

            </div>
            <div class="col-md-6">
                <FormKit v-model="model.buying" label="buying" id="buying" type="text" validation="required" />
                <FormKit v-model="model.selling" label="selling" id="selling" type="text" validation="required" />
                <FormKit v-model="model.published" label="Published" id="published" type="switch" validation="required" />
                <FormKit v-model="model.is_fetched" label="Is Fetched" id="is_fetched" type="switch" validation="required" />

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
            path_param: ["core", "currency"],
            model: {
                id: "",
                name: "",
                code: "",
                rate: "",
                buying: "",
                selling: "",
                published: "",
                is_fetched: "",
            },

        };
    }
};
</script>
