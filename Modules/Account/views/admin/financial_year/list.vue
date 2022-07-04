<template>
    <table-list title="Financial Year" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["account", "financial_year"],
            model: {
                name: "",
                description: "",
                start_date: "",
                end_date: "",
            },
            search_fields: [
                { type: "text", name: "name", label: "Title", ope: "", },
                { type: "text", name: "description", label: "Description", ope: "", },
                { type: "datetime", name: "start_date", label: "Start Date", ope: "", },
                { type: "datetime", name: "end_date", label: "End Date", ope: "", },
            ],
            table_fields: [
                { text: "Name", prop: "name", name: "name", },
                { text: "Description", prop: "description", name: "description", },
                { text: "Start Time", prop: "start_date", is_datetime: true, name: "start_date", },
                { text: "End Time", prop: "end_date", is_datetime: true, name: "end_date", },
            ],
        };
    },
};
</script>
