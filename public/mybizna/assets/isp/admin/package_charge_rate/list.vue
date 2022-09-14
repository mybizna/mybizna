
<template>
    <table-list title="Isp Package Charge Rate" :path_param="path_param" :search_fields="search_fields" :model="model"
        :table_fields="table_fields"></table-list>
</template>

<script>

export default {
    components: {
        TableList: window.$func.fetchComponent("components/common/TableList.vue")
    },
    data () {
        return {
            path_param: ["isp", "package_charge_rate"],
            model: {
                id: "",
                package_charge_id: "",
                rate_id: "",
                published: "",
            },
            search_fields: [
                { type: "text", name: "package_charge_id", label: "Package Charge", ope: "", },
                { type: "text", name: "rate_id", label: "Rate", ope: "",  },
                { type: "switch", name: "published", label: "Is Paid", ope: "", },
            ],
            table_fields: [
                { text: "Package Charge", prop: "package_charge_id", name: "package_charge_id", },
                { text: "Rate", prop: "rate_id", name: "rate_id", },
                { text: "Published", prop: "published", align: "center", is_boolean: true, name: "published", },
            ],

        };
    }
};
</script>
