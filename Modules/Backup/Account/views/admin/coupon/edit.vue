<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">
                <FormKit label="Id" id="id" type="hidden" validation="required" />
                <FormKit label="Code" id="code" type="text" validation="required" />
                <FormKit label="Value" id="value" type="text" validation="required" />
                <FormKit label="Start Date" id="start_date" type="datetime" validation="required" />
                <FormKit label="End Date" id="end_date" type="datetime" validation="required" />
                <FormKit label="Applied" id="applied" type="switch" validation="required" />
                <FormKit label="Is Percent" id="is_percent" type="switch" validation="required" />
                <FormKit label="Published" id="published" type="switch" validation="required" />
                <FormKit label="Is Visible" id="is_visible" type="switch" validation="required" />
            </div>
            <div class="col-md-6">
                <FormKit label="Start Amount" id="start_amount" type="text" validation="required" />
                <FormKit label="End Amount" id="end_amount" type="text" validation="required" />
                <FormKit label="Description" id="description" type="text" validation="required" />
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
            path_param: ["account", "coupon"],
            model: {
                id: "",
                code: "",
                description: "",
                value: "",
                start_amount: "",
                end_amount: "",
                start_date: "",
                end_date: "",
                applied: "",
                is_percent: "",
                published: "",
                is_visible: "",
            },

        };
    }
};
</script>
