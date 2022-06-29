<template>
    <table-list title="Account Billing" :path_param="path_param" :search_fields="search_fields" :model="model"
        :table_fields="table_fields"></table-list>
</template>

<script>
export default {
    components: {
        TableList: window.$func.fetchComponent(
            "components/common/TableList.vue"
        ),
    },
    data () {
        return {
            path_param: ["account", "billing"],
            model: {
                voucher_no: "",
                trn_date: "",
                particulars: "",
                amount: "",
                voucher_type: "",
                trn_by: "",
                agency_id: "",
                ledger_id: "",
            },
            search_fields: [
                { type: "text", name: "voucher_no", label: "Voucher No", ope: "", },
                { type: "text", name: "agency_id", label: "Agency Id", ope: "", },
                { type: "text", name: "ledger_id", label: "Ledger Id", ope: "", },
            ],
            table_fields: [
                { text: "Voucher No", prop: "voucher_no", name: "voucher_no", },
                { text: "Voucher Type", prop: "voucher_type", name: "voucher_type", },
                { text: "Trn Date", prop: "trn_date", name: "trn_date", },
                { text: "Amount", prop: "amount", name: "amount", },
                { text: "Agency", prop: "agency_id", name: "agency_id", },
                { text: "Ledger", prop: "ledger_id", name: "ledger_id", },
            ],
        };
    },
};
</script>
