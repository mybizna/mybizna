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
                {
                    text: "Partner",
                    prop: "[partner__first_name] [partner__last_name]",
                    name: "partner_id",
                    foreign: ['partner__first_name', 'partner__last_name'],
                },
                { text: "description", prop: "description", name: "description", },
                { text: "status", prop: "status", name: "status", is_boolean: true, },
                { text: "completed", prop: "completed", name: "completed", is_boolean: true, },
                { text: "successful", prop: "successful", name: "successful", is_boolean: true, },
            ],
        };
    },
};
</script>
