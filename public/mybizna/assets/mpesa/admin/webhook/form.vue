<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">
                <FormKit v-model="model.id" label="Id" id="id" type="text" validation="required" />
                <FormKit v-model="model.slug" label="Slug" id="slug" type="text" validation="required" />
                <FormKit v-model="model.validation_url" label="Validation Url" id="validation_url" type="text" validation="required" />
                <FormKit v-model="model.confirmation_url" label="Confirmation Url" id="confirmation_url" type="text" validation="required" />
                <FormKit v-model="model.paybill_till" label="Paybill Till" id="paybill_till" type="text" validation="required" />
                <FormKit v-model="model.shortcode" label="Shortcode" id="shortcode" type="text" validation="required" />
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
                slug: "",
                validation_url: "",
                confirmation_url: "",
                paybill_till: "",
                shortcode: "",
                published: "",
            },

        };
    }
};
</script>
