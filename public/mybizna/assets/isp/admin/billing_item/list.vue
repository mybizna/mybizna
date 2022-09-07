<template>
        <table-list title="Isp Billing Item" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["isp", "billing_item"],
            model: {
                title: "",
                description: "",
                billing_id: "",
                amount: "",
            },
            search_fields: [
                { type: "text", name: "title", label: "Title", ope: "", },
                { type: "text", name: "description", label: "Description", ope: "", },
                { type: "text", name: "billing_id", label: "Billing Id", ope: "", },
                { type: "select", name: "amount", label: "Amount", ope: "", option: ['hour', 'day', 'week', 'month'] },
            ],
            table_fields: [
                { text: "Title", prop: "title", name: "title", },
                { text: "Description", prop: "description", name: "description", },
                { text: "Billing_Id", prop: "billing_id", name: "billing_id", },
                { text: "Amount", prop: "amount", name: "amount", },
            ],
        };
    },
};
</script>
