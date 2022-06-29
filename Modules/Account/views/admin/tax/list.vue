<template>
    <table-list title="Account Tax" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["account", "tax"],
            model: {
                tax_rate_name: "",
                tax_number: "",
                default: "",
            },
            search_fields: [
                { type: "text", name: "tax_rate_name", label: "Tax Rate Name", ope: "", },
                { type: "text", name: "tax_number", label: "Tax Number", ope: "", },
                { type: "text", name: "default", label: "Default", ope: "", },
            ],
            table_fields: [
                { text: "Tax Rate Name", prop: "tax_rate_name", name: "tax_rate_name", },
                { text: "Tax Number", prop: "tax_number", name: "tax_number", },
                { text: "Default", prop: "default", name: "default", },
            ],
        };
    },
};
</script>
