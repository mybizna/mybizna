
<template>
    <table-list title="Isp Subscription" :path_param="path_param" :search_fields="search_fields" :model="model"
        :table_fields="table_fields"></table-list>
</template>

<script>

export default {
    components: {
        TableList: window.$func.fetchComponent("components/common/TableList.vue")
    },
    data () {
        return {
            path_param: ["isp", "subscription"],
            model: {
                id: "",
                package_id: "",
                subscriber_id: "",
                start_date: "",
                end_date: "",
            },
            search_fields: [
                { type: "text", name: "package_id", label: "Package", ope: "", },
                { type: "text", name: "subscriber_id", label: "Subscriber", ope: "", },
                { type: "text", name: "start_date", label: "start_date", ope: "", },
                { type: "text", name: "end_date", label: "end_date", ope: "", },
            ],
            table_fields: [
                { 
                    text: "Package", 
                    prop: "[isp_package__title]", 
                    name: "package_id", 
                    foreign: ['isp_package__title',]
                },
                { 
                    text: "Subscriber", 
                    prop: "[isp_subscriber__username]", 
                    name: "subscriber_id", 
                    foreign: ['isp_subscriber__username',]
                },
                { text: "Package", prop: "package_id", name: "package_id", },
                { text: "Subscriber", prop: "subscriber_id", name: "subscriber_id", },
                { text: "Start Date", prop: "start_date", name: "start_date", },
                { text: "End Date", prop: "end_date", name: "end_date", },
            ],
        };
    }
};
</script>
