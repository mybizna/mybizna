
<template>
     <table-list title="Isp Package" :path_param="path_param" :search_fields="search_fields" :model="model"
        :table_fields="table_fields"></table-list>
</template>

<script>

export default {
    components: {
        TableList: window.$func.fetchComponent("components/common/TableList.vue")
    },
    data () {
        return {
            path_param: ["isp", "package"],
            model: {
                id: "",
                title: "",
                slug: "",
                description: "",
                billing_cycle_id: "",
                speed: "",
                speed_type: "",
                published: "",
                is_hidden: "",
                published: "",
                amount: "",
            },
            search_fields: [
                { type: "text", name: "title", label: "Title", ope: "", },
                { type: "text", name: "billing_cycle_id", label: "Billing Cycle", ope: "", },
                { type: "text", name: "speed", label: "Speed", ope: "", },
                { type: "select", name: "speed_type", label: "Speed Type", ope: "", option:  ['kilobyte', 'megabyte'] },
                { type: "switch", name: "is_hidden", label: "Hidden", ope: "", },
                { type: "switch", name: "featured", label: "Featured", ope: "", },
                { type: "switch", name: "published", label: "Published", ope: "", },
            ],
            table_fields: [
                { text: "Title", prop: "title", name: "title", },
                { text: "Slug", prop: "slug", name: "slug", },
                { text: "Billing Cycle", prop: "billing_cycle_id", name: "billing_cycle_id", },
                { text: "Speed", prop: "speed", name: "speed", },
                { text: "Speed Type", prop: "speed_type", name: "speed_type", },
                { text: "Duration Type", prop: "duration_type", name: "duration_type", },
                { text: "Amount", prop: "amount", name: "amount", },
                { text: "Hidden in Portal", prop: "is_hidden", align: "center", is_boolean: true, name: "hidden", },
                { text: "Featured", prop: "featured", align: "center", is_boolean: true, name: "featured", },
                { text: "Published", prop: "published", align: "center", is_boolean: true, name: "published", },
            ],
        };
    }
};
</script>
