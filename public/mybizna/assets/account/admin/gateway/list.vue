<template>
    <table-list title="Gateway" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["account", "gateway"],
            model: {
                title: "",
                slug: "",
                currency_id: "",
                image: "",
                url: "",
                ordering: "",
                is_default: "",
                is_hidden: "",
                published: "",
            },


            search_fields: [
                { type: "text", name: "title", label: "title", ope: "", },
                { type: "text", name: "slug", label: "slug", ope: "", },
                { type: "text", name: "currency_id", label: "currency_id", ope: "", },
                { type: "text", name: "image", label: "image", ope: "", },
                { type: "text", name: "url", label: "url", ope: "", },
                { type: "text", name: "ordering", label: "ordering", ope: "", },
                { type: "text", name: "is_default", label: "is_default", ope: "", },
                { type: "text", name: "is_hidden", label: "is_hidden", ope: "", },
                { type: "text", name: "ref", label: "Description", ope: "", },
            ],
            table_fields: [
                { text: "title", prop: "title", name: "title", },
                { text: "slug", prop: "slug", name: "slug", },
                { text: "currency_id", prop: "currency_id", name: "currency_id", },
                 {
                    text: "Currency",
                    prop: "[core_currency__name]",
                    name: "currency_id",
                    foreign: ['core_currency__name'],
                },
                { text: "image", prop: "image", name: "image", },
                { text: "url", prop: "url", name: "url", },
                { text: "Ordering", prop: "ordering", name: "ordering", },
                { text: "Default", prop: "is_default", name: "is_default", },
                { text: "Hidden", prop: "is_hidden", name: "is_hidden", },
                { text: "Published", prop: "published", name: "published", },
            ],
        };
    },
};
</script>
