
<template>
    <table-list title="Isp Subscriber" :path_param="path_param" :search_fields="search_fields" :model="model"
        :table_fields="table_fields"></table-list>
</template>

<script>

export default {
    components: {
        TableList: window.$func.fetchComponent("components/common/TableList.vue")
    },
    data () {
        return {
            path_param: ["isp", "subscriber"],
            model: {
                id: "",
                username: "",
                password: "",
                partner_id: "",
            },
            search_fields: [
                { type: "text", name: "username", label: "Username", ope: "", },
                { type: "select", name: "partner_id", label: "Partner", ope: "", },
            ],
            username: "",
                password: "",
                partner_id: "",
            table_fields: [
                { text: "Username", prop: "username", name: "username", },
                { 
                    text: "Invoice", 
                    prop: "[partner__first_name] [partner__last_name]", 
                    name: "partner_id", 
                    foreign: ['partner__first_name','partner__last_name',]
                },
            ],
        };
    }
};
</script>
