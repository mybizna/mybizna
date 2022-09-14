<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">
                <FormKit label="Id" id="id" type="hidden" validation="required" />
                <FormKit label="Title" id="title" type="text" validation="required" />
                <FormKit label="Package" id="package_id" type="text" validation="required" />
                <FormKit label="Ledger" id="ledger_id" type="text" validation="required" />
            </div>
            <div class="col-md-6">
                <FormKit label="Price" id="price" type="text" validation="required" />
                <FormKit label="Quantity" id="quantity" type="text" validation="required" />
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
            path_param: ["isp", "package_charge"],
            model: {
                id: "",
                title: "",
                package_id: "",
                ledger_id: "",
                description: "",
                quantity: "",
                price: "",
                published: "",
            },

        };


    }
};
</script>
