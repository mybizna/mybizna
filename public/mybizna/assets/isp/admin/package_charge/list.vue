
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
                package_id: "",
                ledger_id: "",
                description: "",
                quantity: "",
                price: "",
                published: "",
            },
            search_fields: [
                { type: "text", name: "title", label: "Title", ope: "", },
                { type: "text", name: "package_id", label: "Package", ope: "", },
                { type: "text", name: "ledger_id", label: "Ledger", ope: "", },
                { type: "text", name: "quantity", label: "quantity", ope: "",  },
                { type: "text", name: "price", label: "price", ope: "",  },
                { type: "switch", name: "published", label: "Is Paid", ope: "", },
            ],
            table_fields: [
                { text: "Title", prop: "title", name: "title", },
                { text: "Package", prop: "package_id", name: "package_id", },
                { text: "Ledger", prop: "ledger_id", name: "ledger_id", },
                { text: "Quantity", prop: "quantity", name: "quantity", },
                { text: "Price", prop: "price", name: "price", },
                { text: "Published", prop: "published", align: "center", is_boolean: true, name: "published", },
            ],
        };
    }
};
</script>
