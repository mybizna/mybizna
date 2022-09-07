<template>
    <table-list title="Coupon" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["account", "coupon"],
            model: {
                code: "",
                description: "",
                value: "",
                start_amount: "",
                end_amount: "",
                start_date: "",
                end_date: "",
                applied: "",
                is_percent: "",
                published: "",
                is_visible: "",
            },


            search_fields: [
                { type: "text", name: "code", label: "Code", ope: "", },
                { type: "text", name: "description", label: "description", ope: "", },
                { type: "text", name: "value", label: "value", ope: "", },
                { type: "text", name: "start_amount", label: "start_amount", ope: "", },
                { type: "text", name: "end_amount", label: "end_amount", ope: "", },
                { type: "text", name: "start_date", label: "start_date", ope: "", },
                { type: "text", name: "end_date", label: "end_date", ope: "", },
                { type: "text", name: "applied", label: "applied", ope: "", },
                { type: "text", name: "is_percent", label: "is_percent", ope: "", },
                { type: "text", name: "published", label: "published", ope: "", },
                { type: "text", name: "is_visible", label: "is_visible", ope: "", },
            ],
            table_fields: [
                { text: "Code", prop: "code", name: "code", },
                { text: "description", prop: "description", name: "description", },
                { text: "value", prop: "value", name: "value", },
                { text: "start_amount", prop: "start_amount", name: "start_amount", },
                { text: "end_amount", prop: "end_amount", name: "end_amount", },
                { text: "start_date", prop: "start_date", name: "start_date", },
                { text: "Ref", prop: "end_date", name: "end_date", },
                { text: "end_date", prop: "applied", name: "applied", },
                { text: "is_percent", prop: "is_percent", name: "is_percent", },
                { text: "published", prop: "published", name: "published", },
                { text: "is_visible", prop: "is_visible", name: "is_visible", },

            ],
        };
    },
};
</script>
