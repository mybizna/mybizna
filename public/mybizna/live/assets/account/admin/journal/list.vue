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
                transaction_date: "",
                debit: "",
                credit: "",
                note: "",
                particulars: "",
            },

            search_fields: [
                { type: "text", name: "transaction_date", label: "transaction_date", ope: "", },
                { type: "text", name: "debit", label: "debit", ope: "", },
                { type: "text", name: "credit", label: "credit", ope: "", },
                { type: "text", name: "note", label: "note", ope: "", },
                { type: "text", name: "particulars", label: "particulars", ope: "", },
            ],
            table_fields: [
                { text: "Title", prop: "transaction_date", name: "transaction_date", },
                { text: "Ref", prop: "debit", name: "debit", },
                { text: "Ref", prop: "credit", name: "credit", },
                { text: "Ref", prop: "note", name: "note", },
                { text: "Ref", prop: "particulars", name: "particulars", },
            ],
        };
    },
};
</script>
