<template>
    <table-list title="Isp Payment" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["isp", "payment"],
            model: {
                title: "",
                subscription_id: "",
                invoice_id: "",
                description: "",
                is_paid: "",
                completed: "",
                successful: "",
            },
            search_fields: [
                { type: "text", name: "title", label: "Title", ope: "", },
                { type: "text", name: "subscription_id", label: "Subscription Id", ope: "", },
                { type: "text", name: "invoice_id", label: "Invoice Id", ope: "", },
                { type: "switch", name: "is_paid", label: "Is Paid", ope: "", },
                { type: "switch", name: "completed", label: "Completed", ope: "", },
                { type: "switch", name: "successful", label: "Successful", ope: "", },
            ],
            table_fields: [
                { text: "Title", prop: "title", name: "title", },
                { 
                    text: "Invoice", 
                    prop: "[account_invoice__title]", 
                    name: "invoice_id", 
                    foreign: ['account_invoice__title',]
                },
                {
                    text: "Subscription",
                    prop: "[isp_subscription__subscriber_id.isp_subscriber__username] - [isp_subscription__package_id.isp_package__title] [isp_subscription__package_id.isp_package__speed] [isp_subscription__package_id.isp_package__speed_type]",
                    name: "subscription_id",
                    foreign: ['isp_subscription__subscriber_id.isp_subscriber__username', 'isp_subscription__package_id.isp_package__title', 'isp_subscription__package_id.isp_package__speed', 'isp_subscription__package_id.isp_package__speed_type'],
                },
                { text: "Is Paid", prop: "is_paid", align: "center", is_boolean: true, name: "is_paid", },
                { text: "Completed", prop: "completed", align: "center", is_boolean: true, name: "completed", },
                { text: "Successful", prop: "successful", align: "center", is_boolean: true, name: "successful", },
            ],
        };
    },
};
</script>
