<template>
    <table-list title="Account Ledger Category" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["account", "ledger_category"],
            model: {
                name: "",
                slug: "",
                chart_id: "",
                parent_id: "",
                system: "",
            },
            search_fields: [
                { type: "text", name: "name", label: "Name", ope: "", },
                { type: "text", name: "slug", label: "Slug", ope: "", },
                { type: "text", name: "chart_id", label: "Chart Id", ope: "", },
                { type: "text", name: "parent_id", label: "Parent", ope: "", },
                { type: "switch", name: "system", label: "System", ope: "", },
            ],
            table_fields: [
                { text: "Name", prop: "name", name: "name", },
                { text: "Slug", prop: "description", name: "description", },
                { text: "Chart", prop: "chart_id", name: "chart_id", },
                { text: "Parent", prop: "parent_id", name: "parent_id", },
                { text: "System", prop: "system", align: "center", is_boolean: true, name: "system", },
            ],
        };
    },
};
</script>
