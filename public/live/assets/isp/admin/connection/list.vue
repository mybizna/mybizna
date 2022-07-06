
<template>
    <table-list title="Isp Connection" :path_param="path_param" :search_fields="search_fields" :model="model"
        :table_fields="table_fields"></table-list>
</template>

<script>

export default {
    components: {
        TableList: window.$func.fetchComponent("components/common/TableList.vue")
    },
    data () {
        return {
            path_param: ["isp", "connection"],
            model: {
                id: "",
                username: "",
                package_id: "",
                expiry_date: "",
                billing_date: "",
                is_paid: "",
                is_setup: "",
                status: ""
            },
            search_fields: [
                { type: "text", name: "username", label: "Username", ope: "", },
                { type: "select", name: "package_id", label: "Package", ope: "", },
                { type: "datetime", name: "expiry_date", label: "Expiry Date", ope: "", },
                { type: "datetime", name: "billing_date", label: "Billing Date", ope: "", },
                { type: "switch", name: "is_paid", label: "Is Paid", ope: "", },
                { type: "switch", name: "is_setup", label: "Is Setup", ope: "", },
                { type: "select", name: "status", label: "Status", ope: "", option: ['new', 'active', 'inactive', 'closed']},
            ],
            table_fields: [
                { text: "Title", prop: "username", name: "username", },
                { text: "Description", prop: "package_id", name: "package_id", },
                { text: "Start Time", prop: "expiry_date", name: "expiry_date", },
                { text: "End Time", prop: "billing_date", name: "billing_date", },
                { text: "Is Paid", prop: "is_paid", align: "center", is_boolean: true, name: "is_paid", },
                { text: "Is Setup", prop: "is_setup", align: "center", is_boolean: true, name: "is_setup", },
                { text: "Status", prop: "status", name: "status", },
            ],
        };
    }
};
</script>
