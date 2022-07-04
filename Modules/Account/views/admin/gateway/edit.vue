<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">
                <FormKit label="Id" id="id" type="hidden" validation="required" />
                <FormKit label="title" id="title" type="text" validation="required" />
                <FormKit label="slug" id="slug" type="text" validation="required" />
                <FormKit label="currency_id" id="currency_id" type="select" validation="required" />
                <FormKit label="image" id="image" type="text" validation="required" />
                <FormKit label="url" id="url" type="text" validation="required" />
            </div>
            <div class="col-md-6">
                <FormKit label="ordering" id="ordering" type="text" validation="required" />
                <FormKit label="is_default" id="is_default" type="switch" validation="required" />
                <FormKit label="is_hidden" id="is_hidden" type="switch" validation="required" />
                <FormKit label="published" id="published" type="switch" validation="required" />
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
