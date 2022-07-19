<template>
    <table-list title="Account Ledger" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["account", "ledger"],
            model: {
                chart_id: "",
                category_id: "",
                name: "",
                slug: "",
                code: "",
                unused: "",
                system: "",
            },
            search_fields: [
                { type: "text", name: "name", label: "Name", ope: "", },
                { type: "text", name: "slug", label: "slug", ope: "", },
                { type: "text", name: "code", label: "code", ope: "", },
                { type: "text", name: "chart_id", label: "Chart", ope: "", },
                { type: "text", name: "category_id", label: "Category", ope: "", },
                { type: "switch", name: "unused", label: "Unused", ope: "", },
                { type: "switch", name: "system", label: "System", ope: "", },
            ],
            table_fields: [
                { text: "Name", prop: "name", name: "name", },
                { text: "Slug", prop: "slug", name: "slug", },
                { text: "Code", prop: "code", name: "code", },

                 {
                    text: "Chart of Account",
                    prop: "[account_chart_of_account__name]",
                    name: "chart_id",
                    foreign: ['account_chart_of_account__name'],
                },
                 {
                    text: "Category",
                    prop: "[account_ledger_category__name]",
                    name: "category_id",
                    foreign: ['account_ledger_category__name'],
                },
                { text: "Unused", prop: "unused", align: "center", is_boolean: true, name: "unused", },
                { text: "System", prop: "system", align: "center", is_boolean: true, name: "system", },
            ],
        };
    },
};
</script>
