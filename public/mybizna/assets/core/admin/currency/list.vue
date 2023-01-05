<template>
    <table-list title="Currency" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["core", "currency"],
            model: {
                name: "",
                code: "",
                rate: "",
                buying: "",
                selling: "",
                published: "",
                is_fetched: "",
            },
            search_fields: [
                { type: "text", name: "name", label: "Name", ope: "", },
                { type: "text", name: "code", label: "code", ope: "", },
                { type: "switch", name: "published", label: "Published", ope: "", },
                { type: "switch", name: "Is Fetched", label: "is_fetched", ope: "", },
            ],
            table_fields: [
                { text: "Name", prop: "name", name: "name", },
                { text: "Code", prop: "code", name: "code", },
                { text: "Symbol", prop: "symbol", name: "symbol", },
                { text: "Rate", prop: "rate", name: "rate", },
                { text: "Buying", prop: "buying", name: "buying", },
                { text: "Selling", prop: "selling", name: "selling", },
                { text: "Published", prop: "published", align: "center", is_boolean: true, name: "published", },
                { text: "Is Fetched", prop: "is_fetched", align: "center", is_boolean: true, name: "is_fetched", },
            ],
        };
    },
};
</script>
