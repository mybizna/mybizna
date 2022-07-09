<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">

                <FormKit label="Id" id="id" type="hidden" validation="required" />
                <FormKit label="Title" id="title" type="text" validation="required" />
                <FormKit label="Billing Cycle" id="billing_cycle_id" type="text" validation="required" />
                <FormKit label="Speed" id="speed" type="text" validation="required" />
                <FormKit label="Speed Type" id="speed_type" type="select" validation="required" :option="['kilobyte', 'megabyte']" />

            </div>
            <div class="col-md-6">
                <FormKit label="Description" id="description" type="textarea" validation="required" />
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
            path_param: ["isp", "package"],
            model: {
                id: "",
                title: "",
                description: "",
                billing_cycle_id: "",
                speed: "",
                speed_type: "",
                published: "",
                amount: "",
            },

        };
    }
};
</script>
