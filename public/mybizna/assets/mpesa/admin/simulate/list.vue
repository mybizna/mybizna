
<template>
    <table-list title="Mpesa Simulate" :path_param="path_param" :search_fields="search_fields" :model="model"
        :table_fields="table_fields"></table-list>
</template>


<script>

export default {
    components: {
        TableList: window.$func.fetchComponent("components/common/TableList.vue")
    },
    data () {
        return {
            path_param: ["mpesa", "simulate"],
            model: {
                id: "",
                amount: "",
                phone: "",
                reference: "",
                description: "",
                gateway_id: "",
                completed: "",
                successful: "",
            },
            search_fields: [
                { type: "text", name: "amount", label: "Amount", ope: "", },
                { type: "text", name: "phone", label: "Phone", ope: "", },
                { type: "text", name: "reference", label: "Reference", ope: "", },
                { type: "text", name: "gateway_id", label: "Gateway Id", ope: "", },
                { type: "text", name: "completed", label: "Completed", ope: "", },
                { type: "text", name: "successful", label: "Successful", ope: "", },
            ],
            table_fields: [
                { text: "Amount", prop: "amount", name: "amount", },
                { text: "Phone", prop: "phone", name: "phone", },
                { text: "Reference", prop: "reference", name: "reference", },
                { text: "Gateway Id", prop: "gateway_id", name: "gateway_id", },
                { text: "Completed", prop: "completed", name: "completed", },
                { text: "Successful", prop: "successful", name: "successful", },
            ],
        };
    }
};
</script>
