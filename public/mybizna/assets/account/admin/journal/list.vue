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
                transaction_id: "",
                debit: "",
                credit: "",
                note: "",
                particulars: "",
            },
            search_fields: [
                { type: "text", name: "transaction_id", label: "transaction_id", ope: "", },
                { type: "text", name: "debit", label: "debit", ope: "", },
                { type: "text", name: "credit", label: "credit", ope: "", },
                { type: "text", name: "note", label: "note", ope: "", },
                { type: "text", name: "particulars", label: "particulars", ope: "", },
            ],
            table_fields: [
                {
                    text: "Transaction",
                    prop: "[account_transaction__amount] : [account_transaction__description]",
                    name: "transaction_id",
                    foreign: ['account_transaction__amount', 'account_transaction__description'],
                },
                { text: "Debit", prop: "debit", name: "debit", },
                { text: "Credit", prop: "credit", name: "credit", },
                { text: "Note", prop: "note", name: "note", },
                { text: "Particulars", prop: "particulars", name: "particulars", },
            ],
        };
    },
};
</script>
