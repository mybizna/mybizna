<template>
    <table-list title="Account Opening Balance" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["account", "opening_balance"],
            model: {
                financial_year_id: "",
                chart_id: "",
                ledger_id: "",
                type: "",
                debit: "",
                credit: "",
            },
            search_fields: [
                { type: "text", name: "type", label: "Type", ope: "", },
                { type: "text", name: "financial_year_id", label: "Financial Year", ope: "", },
                { type: "text", name: "chart_id", label: "Chart Id", ope: "", },
                { type: "text", name: "ledger_id", label: "Ledger Id", ope: "", },
                { type: "text", name: "debit", label: "Debit", ope: "", },
                { type: "text", name: "credit", label: "Credit", ope: "", },
            ],
            table_fields: [
                { text: "Type", prop: "type", name: "type", },
                { text: "Financial Year", prop: "financial_year_id", name: "financial_year_id", },
                { text: "Chart", prop: "chart_id", name: "chart_id", },
                { text: "Ledger", prop: "ledger_id", name: "ledger_id", },
                { text: "Debit", prop: "debit", name: "debit", },
                { text: "Credit", prop: "credit", name: "credit", },
            ],
        };
    },
};
</script>
