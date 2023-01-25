
<template>
    <table-list title="Mpesa Webhook" :path_param="path_param" :search_fields="search_fields" :model="model"
        :table_fields="table_fields"></table-list>
</template>


<script>

export default {
    components: {
        TableList: window.$func.fetchComponent("components/common/TableList.vue")
    },
    data () {
        return {
            path_param: ["mpesa", "webhook"],
            model: {
                id: "",
                slug: "",
                validation_url: "",
                confirmation_url: "",
                paybill_till: "",
                shortcode: "",
                published: "",
            },
            search_fields: [
                { type: "text", name: "slug", label: "Slug", ope: "", },
                { type: "text", name: "validation_url", label: "Validation Url", ope: "", },
                { type: "text", name: "confirmation_url", label: "Confirmation Url", ope: "", },
                { type: "text", name: "paybill_till", label: "Paybill Till", ope: "", },
                { type: "text", name: "published", label: "Published", ope: "", },
            ],
            table_fields: [
                { text: "Slug", prop: "slug", name: "slug", },
                { text: "Validation Url", prop: "validation_url", name: "validation_url", },
                { text: "Confirmation Url", prop: "confirmation_url", name: "confirmation_url", },
                { text: "Paybill Till", prop: "paybill_till", name: "paybill_till", },
                { text: "Shortcode", prop: "shortcode", name: "shortcode", },
                { text: "Published", prop: "published", name: "published", },
            ],
        };
    }
};
</script>