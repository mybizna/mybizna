<template>
    <table-edit :path_param="path_param" :model="model">
        <div class="row">
            <div class="col-md-6">
                <FormKit label="Id" id="id" type="hidden" validation="required" />
                <FormKit label="Title" id="title" type="text" validation="required" />
                <FormKit label="Slug" id="slug" type="text" validation="required" />
                <FormKit label="Value" id="value" type="text" validation="required" />
                <FormKit label="Start Amount" id="start_amount" type="text" validation="required" />
                <FormKit label="End Amount" id="end_amount" type="text" validation="required" />
            </div>
            <div class="col-md-6">
                <FormKit label="Is Percent" id="is_percent" type="text" validation="required" />
                <FormKit label="Is Visible" id="is_visible" type="text" validation="required" />
                <FormKit label="Published" id="published" type="text" validation="required" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <FormKit label="File Limit" id="file_limit" type="text" validation="required" />
                <FormKit label="File Type" id="file_type" type="text" validation="required" />
                <FormKit label="File Structure" id="file_structure" type="text" validation="required" />
                <FormKit label="File Suffix" id="file_suffix" type="text" validation="required" />
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
