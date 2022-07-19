<template>
    <table-list title="Payment" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["account", "payment"],
            model: {
                gateway_id: "",
                amount: "",
                invoice_id: "",
                transaction_id: "",
                description: "",
                receipt_no: "",
                code: "",
                completed: "",
                successful: "",
                canceled: "",
            },

            search_fields: [
                { type: "text", name: "gateway_id", label: "gateway_id", ope: "", },
                { type: "text", name: "amount", label: "amount", ope: "", },
                { type: "text", name: "description", label: "description", ope: "", },
                { type: "text", name: "receipt_no", label: "receipt_no", ope: "", },
                { type: "text", name: "code", label: "code", ope: "", },
                { type: "text", name: "completed", label: "completed", ope: "", },
                { type: "text", name: "successful", label: "successful", ope: "", },
                { type: "text", name: "canceled", label: "canceled", ope: "", },
            ],
            table_fields: [
                {
                    text: "Gateway",
                    prop: "[account_gateway__title]",
                    name: "gateway_id",
                    foreign: ['account_gateway__title'],
                },
                { text: "amount", prop: "amount", name: "amount", },
                { text: "description", prop: "description", name: "description", },
                { text: "receipt_no", prop: "receipt_no", name: "receipt_no", },
                { text: "code", prop: "code", name: "code", },
                { text: "completed", prop: "completed", is_boolean: true, name: "completed", },
                { text: "successful", prop: "successful", is_boolean: true, name: "successful", },
                { text: "canceled", prop: "canceled", is_boolean: true, name: "canceled", },
            ],
        };
    },
};
</script>
