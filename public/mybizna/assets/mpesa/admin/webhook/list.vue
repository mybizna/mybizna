
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
                val: "",
                conf: "",
                published: "",
            },
            search_fields: [
                { type: "text", name: "val", label: "Val", ope: "", },
                { type: "text", name: "conf", label: "Conf", ope: "", },
                { type: "text", name: "published", label: "Published", ope: "", },
            ],
            table_fields: [
                { text: "Val", prop: "val", name: "val", },
                { text: "Conf", prop: "conf", name: "conf", },
                { text: "Published", prop: "published", name: "published", },
            ],
        };
    }
};
</script>
