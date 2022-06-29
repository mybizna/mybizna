<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">

                <FormKit label="Id" id="id" type="hidden" validation="required" />
                <FormKit label="Trn Date" id="trn_date" type="text" validation="required" />
                <FormKit label="Amount" id="amount" type="text" validation="required" />
                <FormKit label="Agency" id="agency_id" type="text" validation="required" />
                <FormKit label="Ledger" id="ledger_id" type="text" validation="required" />

            </div>
            <div class="col-md-6">
                <FormKit label="Voucher No" id="voucher_no" type="text" validation="required" />
                <FormKit label="Voucher Type" id="voucher_type" type="text" validation="required" />
                <FormKit label="Trn By" id="trn_by" type="text" validation="required" />
                <FormKit label="Particulars" id="particulars" type="textarea" validation="required" />

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
            path_param: ["account", "billing"],
            model: {
                id: "",
                voucher_no: "",
                trn_date: "",
                particulars: "",
                amount: "",
                voucher_type: "",
                trn_by: "",
                agency_id: "",
                ledger_id: "",
            },

        };
    }
};
</script>
