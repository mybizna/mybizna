<template>
    <table-list title="Timezone" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["core", "timezone"],
            model: {
                country_id: "",
                name: "",
            },
            search_fields: [
                { type: "text", name: "name", label: "Name", ope: "", },
                { type: "text", name: "country_id", label: "Country", ope: "", },
            ],
            table_fields: [
                { text: "Name", prop: "name", name: "name", },
                {
                    text: "Country",
                    prop: "[core_country__name]",
                    name: "country_id",
                    foreign: ['core_country__name'],
                },
            ],
        };
    },
};
</script>
