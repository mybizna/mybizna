<template>
    <table-list title="Account Tax Agency" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["account", "tax_agency"],
            model: {
                name: "",
                ecommerce_type: "",
            },
            search_fields: [
                { type: "text", name: "name", label: "Name", ope: "", },
                { type: "text", name: "ecommerce_type", label: "Ecommerce Type", ope: "", },
            ],
            table_fields: [
                { text: "Name", prop: "name", name: "name", },
                { text: "Ecommerce Type", prop: "ecommerce_type", name: "ecommerce_type", },
            ],
        };
    },
};
</script>
