<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">
                <FormKit label="Id" id="id" type="hidden" validation="required" />
                <FormKit label="code" id="code" type="text" validation="required" />
                <FormKit label="value" id="value" type="text" validation="required" />
                <FormKit label="start_date" id="start_date" type="datetime" validation="required" />
                <FormKit label="end_date" id="end_date" type="datetime" validation="required" />
                <FormKit label="applied" id="applied" type="switch" validation="required" />
                <FormKit label="is_percent" id="is_percent" type="switch" validation="required" />
                <FormKit label="published" id="published" type="switch" validation="required" />
                <FormKit label="is_visible" id="is_visible" type="switch" validation="required" />
            </div>
            <div class="col-md-6">
                <FormKit label="start_amount" id="start_amount" type="text" validation="required" />
                <FormKit label="end_amount" id="end_amount" type="text" validation="required" />
                <FormKit label="description" id="description" type="text" validation="required" />
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
