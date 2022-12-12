
<template>
    <table-list title="Mpesa Gateway" :path_param="path_param" :search_fields="search_fields" :model="model"
        :table_fields="table_fields"></table-list>
</template>


<script>

export default {
    components: {
        TableList: window.$func.fetchComponent("components/common/TableList.vue")
    },
    data () {
        return {
            path_param: ["mpesa", "gateway"],
            model: {
                id: "",
                title: "",
                slug: "",
                key: "",
                secret: "",
                initiator: "",
                till_bill_no: "",
                passkey: "",
                shortcode: "",
                ledger_id: "",
                passkey: "",
                description: "",
                published: "",
            },
            search_fields: [
                { type: "text", name: "title", label: "Title", ope: "", },
                { type: "text", name: "slug", label: "Slug", ope: "", },
                { type: "text", name: "key", label: "Key", ope: "", },
                { type: "text", name: "initiator", label: "Initiator", ope: "", },
                { type: "text", name: "shortcode", label: "Short Code", ope: "", },
                { type: "text", name: "passkey", label: "Pass Key", ope: "", },
                { type: "text", name: "published", label: "Published", ope: "", },
            ],
            table_fields: [
                { text: "Title", prop: "title", name: "title", },
                { text: "Slug", prop: "slug", name: "slug", },
                { text: "Key", prop: "key", name: "key", },
                { text: "Secret", prop: "secret", name: "secret", },
                { text: "Till Bill No", prop: "till_bill_no", name: "till_bill_no", },
                { text: "Short Code", prop: "shortcode", name: "shortcode", },
                { text: "Published", prop: "published", name: "published", },
                { text: "Default", prop: "default", name: "default", },
            ],
        };
    }
};
</script>
