<template>
    <table-list title="Account Billing" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["account", "billing"],
            model: {
                title: "",
                connection_id: "",
                invoice_id: "",
                description: "",
                start_date: "",
                end_date: "",
                is_paid: "",
            },
            search_fields: [
                { type: "text", name: "title", label: "Title", ope: "", },
                { type: "text", name: "description", label: "Description", ope: "", },
                { type: "text", name: "connection_id", label: "Connection Id", ope: "", },
                { type: "text", name: "invoice_id", label: "Invoice Id", ope: "", },
                { type: "datetime", name: "start_date", label: "Start Date", ope: "", },
                { type: "datetime", name: "end_date", label: "End Date", ope: "", },
                { type: "switch", name: "is_paid", label: "Is Paid", ope: "", },
            ],
            table_fields: [
                { text: "Title", prop: "title", name: "title", },
                { text: "Description", prop: "description", name: "description", },
                { text: "Invoice", prop: "invoice_id", name: "invoice_id", },
                {
                    text: "Connecx",
                    prop: "[account_connection__username]-[account_connection__package_id.account_package__title] [account_connection__package_id.account_package__speed] [account_connection__package_id.account_package__speed_type]",
                    name: "connection_id",
                    foreign: ['account_connection__username', 'account_connection__package_id.account_package__title', 'account_connection__package_id.account_package__speed', 'account_connection__package_id.account_package__speed_type'],
                },
                { text: "Start Time", prop: "start_date", is_datetime: true, name: "start_date", },
                { text: "End Time", prop: "end_date", is_datetime: true, name: "end_date", },
                { text: "Is Paid", prop: "is_paid", align: "center", is_boolean: true, name: "is_paid", },
            ],
        };
    },
};
</script>
