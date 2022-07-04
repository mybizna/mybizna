<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">
                <FormKit label="Id" id="id" type="hidden" validation="required" />
                <FormKit label="Trn Date" id="trn_date" type="text" validation="required" />
                <FormKit label="Ref" id="ref" type="text" validation="required" />
                <FormKit label="Voucher No" id="voucher_no" type="text" validation="required" />
                <FormKit label="Voucher Amount" id="voucher_amount" type="text" validation="required" />
            </div>
            <div class="col-md-6">
                <FormKit label="Attachments" id="attachments" type="text" validation="required" />
                <FormKit label="Particulars" id="particulars" type="text" validation="required" />
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
            path_param: ["account", "transaction"],
            model: {
                id: "",
                trn_date: "",
                ref: "",
                voucher_no: "",
                voucher_amount: "",
                particulars: "",
                attachments: "",
            },

        };
    }
};
</script>
