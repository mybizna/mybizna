<template>
    <table-edit :path_param="path_param" :model="model">
        <div class="row">
            <div class="col-md-6">

                <FormKit v-model="model.id" label="Id" id="id" type="hidden" validation="required" />
                <FormKit v-model="model.name" label="Name" id="name" type="text" validation="required" />
                <FormKit v-model="model.code" label="Code" id="code" type="text" validation="required" />
                <FormKit v-model="model.slug" label="Slug" id="slug" type="text" validation="required" />
                <FormKit v-model="model.category_id" label="Category" id="category_id" type="text" validation="required" />
                <FormKit v-model="model.chart_id" label="Chart" id="chart_id" type="text" validation="required" />

            </div>
            <div class="col-md-6">
                <FormKit v-model="model.unused" label="Unused" id="unused" type="switch" validation="required" />
                <FormKit v-model="model.system" label="System" id="system" type="switch" validation="required" />

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
            path_param: ["account", "ledger"],
            model: {
                id: "",
                chart_id: "",
                category_id: "",
                name: "",
                slug: "",
                code: "",
                unused: "",
                system: "",
            },

        };
    }
};
</script>
