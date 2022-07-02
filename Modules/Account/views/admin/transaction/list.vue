<template>
    <table-list title="Account Journal" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["account", "journal"],
            model: {
                trn_date: "",
                ref: "",
                voucher_no: "",
                voucher_amount: "",
                particulars: "",
                attachments: "",
            },
            search_fields: [
                { type: "text", name: "trn_date", label: "Title", ope: "", },
                { type: "text", name: "ref", label: "Description", ope: "", },
                { type: "text", name: "voucher_no", label: "Connection Id", ope: "", },
                { type: "text", name: "voucher_amount", label: "Invoice Id", ope: "", },
            ],
            table_fields: [
                { text: "Title", prop: "trn_date", name: "trn_date", },
                { text: "Ref", prop: "ref", name: "trn_date", },
                { text: "Voucher No", prop: "voucher_no", name: "voucher_no", },
                { text: "Voucher Amount", prop: "voucher_amount", name: "voucher_amount", },
            ],
        };
    },
};
</script>
