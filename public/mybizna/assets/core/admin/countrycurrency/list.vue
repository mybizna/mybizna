<template>
    <table-list title="Country Currency" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["core", "countrycurrency"],
            model: {
                currency_code: "",
                country_code: "",
                country_code3: "",
            },
            search_fields: [
                { type: "text", name: "currency_code", label: "Currency Code", ope: "", },
                { type: "text", name: "country_code", label: "Country Code", ope: "", },
                { type: "text", name: "country_code3", label: "Country Code3", ope: "", },
            ],
            table_fields: [
                { text: "Currency Code", prop: "currency_code", name: "currency_code", },
                { text: "Country Code", prop: "country_code", name: "country_code", },
                { text: "Country Code3", prop: "country_code3", name: "country_code3", },
            ],
        };
    },
};
</script>
