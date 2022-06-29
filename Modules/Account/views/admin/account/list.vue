<template>
    <table-list title="Account" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["account", "account"],
            model: {
                name: "",
            },
            search_fields: [
                { type: "text", name: "name", label: "Name", ope: "", },
            ],
            table_fields: [
                { text: "Name", prop: "name", name: "name", },
            ],
        };
    },
};
</script>
