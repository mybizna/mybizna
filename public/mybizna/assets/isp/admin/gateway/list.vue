
<template>
    <table-list title="Isp Gateway" :path_param="path_param" :search_fields="search_fields" :model="model"
        :table_fields="table_fields"></table-list>
</template>


<script>

export default {
    components: {
        TableList: window.$func.fetchComponent("components/common/TableList.vue")
    },
    data () {
        return {
            path_param: ["isp", "gateway"],
            model: {
                id: "",
                title: "",
                username: "",
                password: "",
                database: "",
                ip_address: "",
                port: "",
                type: "",
                published: "",
            },
            search_fields: [
                { type: "text", name: "title", label: "Title", ope: "", },
                { type: "text", name: "username", label: "Username", ope: "", },
                { type: "text", name: "database", label: "Database", ope: "", },
                { type: "text", name: "ip_address", label: "IP Address", ope: "", },
                { type: "text", name: "port", label: "Port", ope: "", },
                { type: "text", name: "published", label: "Published", ope: "", },
            ],
            table_fields: [
                { text: "Title", prop: "title", name: "title", },
                { text: "Username", prop: "username", name: "username", },
                { text: "Password", prop: "password", name: "password", },
                { text: "Database", prop: "database", name: "database", },
                { text: "IP Address", prop: "ip_address", name: "ip_address", },
                { text: "Port", prop: "port", name: "port", },
                { text: "Type", prop: "type", name: "type", },
                { text: "Published", prop: "published", name: "published", },
            ],
        };
    }
};
</script>
