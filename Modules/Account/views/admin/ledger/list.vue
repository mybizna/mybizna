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
                { text: "Chart", prop: "chart_id", name: "chart_id", },
                { text: "Category", prop: "category_id", name: "category_id", },
                { text: "Unused", prop: "unused", align: "center", is_boolean: true, name: "unused", },
                { text: "System", prop: "system", align: "center", is_boolean: true, name: "system", },
            ],
        };
    },
};
</script>
