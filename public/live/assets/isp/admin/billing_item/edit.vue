<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">

                <FormKit label="Id" id="id" type="hidden" validation="required" />
                <FormKit label="Title" id="title" type="text" validation="required" />
                <FormKit label="Billing" id="billing_id" type="text" validation="required" />
                <FormKit label="Amount" id="amount" type="text" validation="required" />

            </div>
            <div class="col-md-6">
                <FormKit label="Description" id="description" type="textarea" validation="required" />

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
            path_param: ["isp", "billing_item"],
            model: {
                id: "",
                title: "",
                description: "",
                billing_id: "",
                amount: "",
            },

        };
    }
};
</script>
