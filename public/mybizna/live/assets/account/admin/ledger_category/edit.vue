<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">

                <FormKit label="Id" id="id" type="hidden" validation="required" />
                <FormKit label="Name" id="name" type="text" validation="required" />
                <FormKit label="Slug" id="slug" type="text" validation="required" />
                <FormKit label="Chart" id="chart_id" type="text" validation="required" />
                <FormKit label="Parent" id="parent_id" type="text" validation="required" />

            </div>
            <div class="col-md-6">
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
            path_param: ["account", "ledger_category"],
            model: {
                id: "",
                name: "",
                slug: "",
                chart_id: "",
                parent_id: "",
                system: "",
            },

        };
    }
};
</script>
