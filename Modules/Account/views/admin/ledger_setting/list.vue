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
                left_ledger_id: "",
                right_chart_of_account_id: "",
                right_ledger_id: "",
            },


            search_fields: [
                { type: "text", name: "title", label: "title", ope: "", },
                { type: "text", name: "slug", label: "slug", ope: "", },
                { type: "text", name: "left_ledger_id", label: "left_ledger_id", ope: "", },
                { type: "text", name: "right_chart_of_account_id", label: "right_chart_of_account_id", ope: "", },
                { type: "text", name: "right_ledger_id", label: "right_ledger_id", ope: "", },
            ],
            table_fields: [
                { text: "title", prop: "title", name: "title", },
                { text: "slug", prop: "slug", name: "slug", },
                { text: "Short", prop: "left_ledger_id", name: "left_ledger_id", },
                { text: "Short", prop: "right_chart_of_account_id", name: "right_chart_of_account_id", },
                { text: "Short", prop: "right_ledger_id", name: "right_ledger_id", },
            ],
        };
    },
};
</script>
