<template>
    <table-list title="Invoice" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["account", "invoice"],
            model: {
                title: "",
                partner_id: "",
                description: "",
                status: "",
                is_posted: "",
                total: "",
            },
            search_fields: [
                { type: "text", name: "title", label: "title", ope: "", },
                { type: "text", name: "partner_id", label: "partner_id", ope: "", },
                { type: "text", name: "status", label: "status", ope: "", },
                { type: "text", name: "is_posted", label: "is_posted", ope: "", },
            ],
            table_fields: [
                { text: "title", prop: "title", name: "title", },
                {
                    text: "Partner",
                    prop: "[partner__first_name] [partner__last_name]",
                    name: "partner_id",
                    foreign: ['partner__first_name', 'partner__last_name'],
                },
                { text: "description", prop: "description", name: "description", },
                { text: "status", prop: "status", name: "status",  },
                { text: "is_posted", prop: "is_posted", name: "is_posted", is_boolean: true, },
                { text: "total", prop: "total", name: "total",  },
            ],
        };
    },
};
</script>
