
<template>
    <table-list title="Isp Connection Invoice" :path_param="path_param" :search_fields="search_fields" :model="model"
        :table_fields="table_fields"></table-list>
</template>


<script>

export default {
    components: {
        TableList: window.$func.fetchComponent("components/common/TableList.vue")
    },
    data () {
        return {
            path_param: ["isp", "connection_invoice"],
            model: {
                id: "",
            },
            search_fields: [

            ],
            table_fields: [
                { text: "Connection", prop: "connection_id", name: "connection_id", },
                { text: "Invoice", prop: "invoice_id", name: "invoice_id", },
            ],
        };
    }
};
</script>
