<template>
    <table-edit :path_param="path_param" :model="model">
        <div class="row">
            <div class="col-md-6">

                <FormKit label="Id" id="id" type="hidden" validation="required" />
                <FormKit label="Name" id="name" type="text" validation="required" />
                <FormKit label="Code" id="code" type="text" validation="required" />
                <FormKit label="Slug" id="slug" type="text" validation="required" />
                <FormKit label="Category" id="category_id" type="text" validation="required" />
                <FormKit label="Chart" id="chart_id" type="text" validation="required" />

            </div>
            <div class="col-md-6">
                <FormKit label="Unused" id="unused" type="switch" validation="required" />
                <FormKit label="System" id="system" type="switch" validation="required" />

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
