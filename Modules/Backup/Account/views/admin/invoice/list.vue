<template>
    <table-list title="Invoice" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["account", "invoice"],
            model: {
                partner_id: "",
                description: "",
                status: "",
                completed: "",
                successful: "",
            },


            search_fields: [
                { type: "text", name: "partner_id", label: "partner_id", ope: "", },
                { type: "text", name: "description", label: "description", ope: "", },
                { type: "text", name: "status", label: "status", ope: "", },
                { type: "text", name: "completed", label: "completed", ope: "", },
                { type: "text", name: "successful", label: "successful", ope: "", },
            ],
            table_fields: [
                { text: "partner_id", prop: "partner_id", name: "partner_id", },
                { text: "description", prop: "description", name: "description", },
                { text: "status", prop: "status", name: "status", },
                { text: "completed", prop: "completed", name: "completed", },
                { text: "successful", prop: "successful", name: "successful", },
            ],
        };
    },
};
</script>
