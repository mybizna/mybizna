<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">
                <FormKit v-model="model.id" label="Id" id="id" type="hidden" validation="required" />
                <FormKit v-model="model.title" label="Title" id="title" type="text" validation="required" />
                <FormKit v-model="model.slug" label="Slug" id="slug" type="text" validation="required" />
                <FormKit v-model="model.currency_id" label="Currency_id" id="currency_id" type="select" validation="required" />
                <FormKit v-model="model.image" label="Image" id="image" type="text" validation="required" />
                <FormKit v-model="model.url" label="Url" id="url" type="text" validation="required" />
            </div>
            <div class="col-md-6">
                <FormKit v-model="model.ordering" label="Ordering" id="ordering" type="text" validation="required" />
                <FormKit v-model="model.is_default" label="Is Default" id="is_default" type="switch" validation="required" />
                <FormKit v-model="model.is_hidden" label="Is Hidden" id="is_hidden" type="switch" validation="required" />
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
            path_param: ["account", "gateway"],
            model: {
                id: "",
                title: "",
                slug: "",
                currency_id: "",
                image: "",
                url: "",
                ordering: "",
                is_default: "",
                is_hidden: "",
                published: "",
            },

        };
    }
};
</script>
