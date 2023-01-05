<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">
                <FormKit v-model="model.id" label="Id" id="id" type="hidden" validation="required" />
                <FormKit v-model="model.code" label="Code" id="code" type="text" validation="required" />
                <FormKit v-model="model.value" label="Value" id="value" type="text" validation="required" />
                <FormKit v-model="model.start_date" label="Start Date" id="start_date" type="datetime" validation="required" />
                <FormKit v-model="model.end_date" label="End Date" id="end_date" type="datetime" validation="required" />
                <FormKit v-model="model.applied" label="Applied" id="applied" type="switch" validation="required" />
                <FormKit v-model="model.is_percent" label="Is Percent" id="is_percent" type="switch" validation="required" />
                <FormKit v-model="model.published" label="Published" id="published" type="switch" validation="required" />
                <FormKit v-model="model.is_visible" label="Is Visible" id="is_visible" type="switch" validation="required" />
            </div>
            <div class="col-md-6">
                <FormKit v-model="model.start_amount" label="Start Amount" id="start_amount" type="text" validation="required" />
                <FormKit v-model="model.end_amount" label="End Amount" id="end_amount" type="text" validation="required" />
                <FormKit v-model="model.description" label="Description" id="description" type="text" validation="required" />
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
