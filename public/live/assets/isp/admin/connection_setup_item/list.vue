
<template>
    <table-list title="Isp Connection Setup Item" :path_param="path_param" :search_fields="search_fields" :model="model"
        :table_fields="table_fields"></table-list>
</template>

<script>

export default {
    components: {
        TableList: window.$func.fetchComponent("components/common/TableList.vue")
    },
    data () {
        return {
            path_param: ["isp", "connection_setup_item"],
            model: {
                id: "",
                title: "",
                description: "",
                connection_id: "",
                amount: "",
            },
            search_fields: [
                { type: "text", name: "title", label: "Title", ope: "", },
                { type: "text", name: "description", label: "Description", ope: "", },
                { type: "text", name: "connection_id", label: "Connection", ope: "", },
                { type: "switch", name: "amount", label: "Amount", ope: "", },
            ],
            table_fields: [
                { text: "Title", prop: "title", name: "title", },
                { text: "Description", prop: "description", name: "description", },
                { text: "Connection", prop: "connection_id", name: "connection_id", },
                { text: "Amount", prop: "amount", name: "amount", },
            ],
        };
    }
};
</script>
