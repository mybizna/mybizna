<template>
    <table-list title="Rate" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["account", "rate"],
            model: {
                title: "",
                slug: "",
                value: "",
                start_amount: "",
                end_amount: "",
                file_limit: "",
                file_type: "",
                file_structure: "",
                file_suffix: "",
                is_percent: "",
                is_visible: "",
                published: "",
            },

            search_fields: [
                { type: "text", name: "title", label: "title", ope: "", },
                { type: "text", name: "slug", label: "slug", ope: "", },
                { type: "text", name: "value", label: "value", ope: "", },
                { type: "text", name: "start_amount", label: "start_amount", ope: "", },
                { type: "text", name: "end_amount", label: "end_amount", ope: "", },
                { type: "text", name: "is_visible", label: "is_visible", ope: "", },
                { type: "text", name: "is_percent", label: "is_percent", ope: "", },
                { type: "text", name: "published", label: "published", ope: "", },
            ],
            table_fields: [
                { text: "Title", prop: "title", name: "title", },
                { text: "slug", prop: "slug", name: "slug", },
                { text: "value", prop: "value", name: "value", },
                { text: "start_amount", prop: "start_amount", name: "start_amount", },
                { text: "end_amount", prop: "end_amount", name: "end_amount", },
                { text: "is_visible", prop: "is_visible", is_boolean: true, name: "is_visible", },
                { text: "is_percent", prop: "is_percent", is_boolean: true, name: "is_percent", },
                { text: "published", prop: "published", is_boolean: true, name: "published", },
            ],
        };
    },
};
</script>
