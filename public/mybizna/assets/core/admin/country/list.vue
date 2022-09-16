<template>
    <table-list title="Country" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["core", "country"],
            model: {
                name: "",
                slug: "",
                code: "",
                unused: "",
                system: "",
            },
            search_fields: [
                { type: "text", name: "name", label: "Name", ope: "", },
                { type: "text", name: "code", label: "code", ope: "", },
                { type: "text", name: "code3", label: "code3", ope: "", },
                { type: "text", name: "latitude", label: "latitude", ope: "", },
                { type: "text", name: "longitude", label: "longitude", ope: "", },
            ],
            table_fields: [
                { text: "Name", prop: "name", name: "name", },
                { text: "Code", prop: "code", name: "code", },
                { text: "Code3", prop: "code3", name: "code3", },
                { text: "Code3", prop: "latitude", name: "latitude", },
                { text: "Code3", prop: "longitude", name: "longitude", },
            ],
        };
    },
};
</script>
