<template>
    <table-list title="Partner" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["partner", "partner"],
            model: {
                user_id: "",
                first_name: "",
                last_name: "",
                email: "",
                phone: "",
                country_id: "",
            },

            search_fields: [
                { type: "text", name: "first_name", label: "First Name", ope: "", },
                { type: "text", name: "last_name", label: "Last Name", ope: "", },
                { type: "text", name: "email", label: "Email", ope: "", },
                { type: "text", name: "mobile", label: "Mobile", ope: "", },
                { type: "text", name: "country_id", label: "Country", ope: "", },
            ],
            table_fields: [
                { text: "First Name", prop: "first_name", name: "first_name", },
                { text: "Last Name", prop: "last_name", name: "last_name", },
                { text: "Email", prop: "email", name: "email", },
                { text: "Phone", prop: "phone", name: "phone", },
                { text: "Mobile", prop: "mobile", name: "mobile", },
                { text: "Country", prop: "country_id", name: "country_id", },
                { text: "Currency", prop: "currency_id", name: "currency_id", },
            ],
        };
    },
};
</script>
