<template>
    <table-list title="Core Setting" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["core", "setting"],
            model: {
                module: "",
                model: "",
                name: "",
                type: "",
                value: "",
            },

            search_fields: [
                { type: "text", name: "module", label: "Module", ope: "", },
                { type: "text", name: "model", label: "Model", ope: "", },
                { type: "text", name: "name", label: "Name", ope: "", },
                { type: "text", name: "type", label: "Type", ope: "", },
                { type: "text", name: "value", label: "Value", ope: "", },
            ],
            table_fields: [
                { text: "Slug", prop: "module", name: "module", },
                { text: "Code", prop: "model", name: "model", },
                { text: "Name", prop: "name", name: "name", },
                { text: "Name", prop: "type", name: "type", },
                { text: "Name", prop: "value", name: "value", },
            ],
        };
    },
};
</script>
