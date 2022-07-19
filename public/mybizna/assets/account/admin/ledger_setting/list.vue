<template>
    <table-list title="Ledger Setting" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["account", "ledger_setting"],
            model: {
                title: "",
                slug: "",
                left_chart_of_account_id: "",
                left_ledger_id: "",
                right_chart_of_account_id: "",
                right_ledger_id: "",
            },
            search_fields: [
                { type: "text", name: "title", label: "title", ope: "", },
                { type: "text", name: "slug", label: "slug", ope: "", },
                { type: "text", name: "left_chart_of_account_id", label: "left_chart_of_account_id", ope: "", },
                { type: "text", name: "left_ledger_id", label: "left_ledger_id", ope: "", },
                { type: "text", name: "right_chart_of_account_id", label: "right_chart_of_account_id", ope: "", },
                { type: "text", name: "right_ledger_id", label: "right_ledger_id", ope: "", },
            ],
            table_fields: [
                { text: "Title", prop: "title", name: "title", },
                { text: "Slug", prop: "slug", name: "slug", },

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
            ],
        };
    },
};
</script>
