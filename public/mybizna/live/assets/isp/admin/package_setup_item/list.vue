
<template>
    <table-list title="Isp Package Setup Item" :path_param="path_param" :search_fields="search_fields" :model="model"
        :table_fields="table_fields"></table-list>
</template>

<script>

export default {
    components: {
        TableList: window.$func.fetchComponent("components/common/TableList.vue")
    },
    data () {
        return {
            path_param: ["isp", "package_setup_item"],
            model: {
                id: "",
                title: "",
                description: "",
                package_id: "",
                amount: "",
                published: "",
            },
            search_fields: [
                { type: "text", name: "title", label: "Title", ope: "", },
                { type: "text", name: "description", label: "Description", ope: "", },
                { type: "text", name: "package_id", label: "Package", ope: "", },
                { type: "select", name: "amount", label: "amount", ope: "",  },
                { type: "switch", name: "published", label: "Is Paid", ope: "", },
            ],
            table_fields: [
                { text: "Title", prop: "title", name: "title", },
                { text: "Description", prop: "description", name: "description", },
                { text: "Package", prop: "package_id", name: "package_id", },
                { text: "Amount", prop: "amount", name: "amount", },
                { text: "Published", prop: "published", align: "center", is_boolean: true, name: "published", },
            ],
        };
    }
};
</script>
