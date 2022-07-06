<template>
    <table-list title="Transaction" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["account", "transaction"],
            model: {
                amount: "",
                description: "",
                partner_id: "",
                left_ledger_id: "",
                right_chart_of_account_id: "",
                right_ledger_id: "",
                type: "",
                is_processed: "",
            },

            search_fields: [
                { type: "text", name: "amount", label: "amount", ope: "", },
                { type: "text", name: "description", label: "description", ope: "", },
                { type: "text", name: "partner_id", label: "partner_id", ope: "", },
                { type: "text", name: "left_ledger_id", label: "left_ledger_id", ope: "", },
                { type: "text", name: "right_chart_of_account_id", label: "right_chart_of_account_id", ope: "", },
                { type: "text", name: "right_ledger_id", label: "right_ledger_id", ope: "", },
                { type: "text", name: "type", label: "type", ope: "", },
                { type: "text", name: "is_processed", label: "is_processed", ope: "", },
            ],
            table_fields: [
                { text: "amount", prop: "amount", name: "amount", },
                { text: "description", prop: "description", name: "description", },
                { text: "partner_id", prop: "partner_id", name: "partner_id", },
                { text: "left_ledger_id", prop: "left_ledger_id", name: "left_ledger_id", },
                { text: "right_chart_of_account_id", prop: "right_chart_of_account_id", name: "right_chart_of_account_id", },
                { text: "right_ledger_id", prop: "right_ledger_id", name: "right_ledger_id", },
                { text: "type", prop: "type", name: "type", },
                { text: "is_processed", prop: "is_processed", name: "is_processed", },
            ],
        };
    },
};
</script>
