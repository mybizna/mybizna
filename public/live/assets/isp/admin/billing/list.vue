<template>
    <table-list title="Isp Billing" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["isp", "billing"],
            model: {
                title: "",
                connection_id: "",
                invoice_id: "",
                description: "",
                start_date: "",
                end_date: "",
                is_paid: "",
            },
            search_fields: [{
                    type: "text",
                    name: "title",
                    label: "Title",
                    ope: "",
                },
                {
                    type: "text",
                    name: "description",
                    label: "Description",
                    ope: "",
                },
                {
                    type: "text",
                    name: "connection_id",
                    label: "Connection Id",
                    ope: "",
                },

                {
                    type: "text",
                    name: "invoice_id",
                    label: "Invoice Id",
                    ope: "",
                },
                {
                    type: "datetime",
                    name: "start_date",
                    label: "Start Date",
                    ope: "",
                },
                {
                    type: "datetime",
                    name: "end_date",
                    label: "End Date",
                    ope: "",
                },
                {
                    type: "switch",
                    name: "is_paid",
                    label: "Is Paid",
                    ope: "",
                },
            ],
            table_fields: [
                {
                    text: "title",
                    prop: "title",
                },
                {
                    text: "description",
                    prop: "description",
                },
                {
                    text: "invoice_id",
                    prop: "invoice_id",
                },

                {
                    text: "connection_id",
                    prop: "connection_id",
                },
                {
                    text: "start_date",
                    prop: "start_date",
                    is_datetime: true,
                },
                {
                    text: "end_date",
                    prop: "end_date",
                    is_datetime: true,
                },

                {
                    text: "completed",
                    prop: "completed",
                    align: "center",
                    is_boolean: true,
                },
            ],
        };
    },
};
</script>
