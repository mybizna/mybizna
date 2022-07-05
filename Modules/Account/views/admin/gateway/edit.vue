<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">
                <FormKit label="Id" id="id" type="hidden" validation="required" />
                <FormKit label="Title" id="title" type="text" validation="required" />
                <FormKit label="Slug" id="slug" type="text" validation="required" />
                <FormKit label="Currency_id" id="currency_id" type="select" validation="required" />
                <FormKit label="Image" id="image" type="text" validation="required" />
                <FormKit label="Url" id="url" type="text" validation="required" />
            </div>
            <div class="col-md-6">
                <FormKit label="Ordering" id="ordering" type="text" validation="required" />
                <FormKit label="Is Default" id="is_default" type="switch" validation="required" />
                <FormKit label="Is Hidden" id="is_hidden" type="switch" validation="required" />
                <FormKit label="Published" id="published" type="switch" validation="required" />
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
