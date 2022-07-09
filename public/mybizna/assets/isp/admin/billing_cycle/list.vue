<template>
    <table-list title="Isp Billing Cycle" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["isp", "billing_cycle"],
            model: {
                title: "",
                description: "",
                duration: "",
                duration_type: "",
                published: "",
            },
            search_fields: [
                { type: "text", name: "title", label: "Title", ope: "", },
                { type: "text", name: "description", label: "Description", ope: "", },
                { type: "text", name: "duration", label: "Duration", ope: "", },
                { type: "select", name: "duration_type", label: "Duration Type", ope: "", option: ['hour', 'day', 'week', 'month'] },
                { type: "switch", name: "published", label: "Is Paid", ope: "", },
            ],
            table_fields: [
                { text: "Title", prop: "title", name: "title", },
                { text: "Description", prop: "description", name: "description", },
                { text: "Start Time", prop: "duration", name: "duration", },
                { text: "End Time", prop: "duration_type", name: "duration_type", },
                { text: "Is Paid", prop: "published", align: "center", is_boolean: true, name: "published", },
            ],
        };
    },
};
</script>
