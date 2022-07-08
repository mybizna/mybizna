<template>
    <table-list title="Invoice Status" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["account", "invoice_status"],
            model: {
                type_name: "",
                slug: "",
            },
            search_fields: [
                { type: "text", name: "type_name", label: "Type Name", ope: "", },
                { type: "text", name: "slug", label: "Slug", ope: "", },
            ],
            table_fields: [
                { text: "Type Name", prop: "type_name", name: "type_name", },
                { text: "Slug", prop: "slug", name: "slug", },
            ],
        };
    },
};
</script>
