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
                { type: "text", name: "left_chart_of_account_id", label: "left_chart_of_account_id", ope: "", },
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
                {
                    text: "Partner",
                    prop: "[partner__first_name] - [partner__last_name]",
                    name: "partner_id",
                    foreign: ['partner__first_name', 'partner__last_name'],
                },
                {
                    text: "Left Chart of Account",
                    prop: "[account_chart_of_account__name]",
                    name: "left_chart_of_account_id",
                    foreign: ['account_chart_of_account__name'],
                },
                {
                    text: "Left Ledger",
                    prop: "[account_ledger__name]",
                    name: "left_ledger_id",
                    foreign: ['account_ledger__name'],
                },
                {
                    text: "Right Chart of Account",
                    prop: "[account_chart_of_account__name]",
                    name: "right_chart_of_account_id",
                    foreign: ['account_chart_of_account__name'],
                },
                {
                    text: "Right Ledger",
                    prop: "[account_ledger__name]",
                    name: "right_ledger_id",
                    foreign: ['account_ledger__name'],
                },
                { text: "type", prop: "type", name: "type", },
                { text: "is_processed", prop: "is_processed", is_boolean: true, name: "is_processed", },
            ],
        };
    },
};
</script>
