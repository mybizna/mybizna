<template>
    <table-edit :path_param="path_param" :model="model">
        <div class="row">
            <div class="col-md-6">
                <FormKit label="Id" id="id" type="hidden" validation="required" />
                <FormKit label="title" id="title" type="text" validation="required" />
                <FormKit label="slug" id="slug" type="text" validation="required" />
                <FormKit label="value" id="value" type="text" validation="required" />
                <FormKit label="start_amount" id="start_amount" type="text" validation="required" />
                <FormKit label="end_amount" id="end_amount" type="text" validation="required" />
            </div>
            <div class="col-md-6">
                <FormKit label="is_percent" id="is_percent" type="text" validation="required" />
                <FormKit label="is_visible" id="is_visible" type="text" validation="required" />
                <FormKit label="published" id="published" type="text" validation="required" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <FormKit label="file_limit" id="file_limit" type="text" validation="required" />
                <FormKit label="file_type" id="file_type" type="text" validation="required" />
                <FormKit label="file_structure" id="file_structure" type="text" validation="required" />
                <FormKit label="file_suffix" id="file_suffix" type="text" validation="required" />
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
            path_param: ["account", "rate"],
            model: {
                id: "",
                title: "",
                slug: "",
                value: "",
                start_amount: "",
                end_amount: "",
                file_limit: "",
                file_type: "",
                file_structure: "",
                file_suffix: "",
                is_percent: "",
                is_visible: "",
                published: "",
            },

        };
    }
};
</script>
