<template>
    <table-list title="State" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["core", "state"],
            model: {
                name: "",
                country_code: "",
                type: "",
                item_id: "",
                state_code: "",
                latitude: "",
                longitude: "",
            },
            search_fields: [
                { type: "text", name: "name", label: "Name", ope: "", },
                { type: "text", name: "country_code", label: "Country Code", ope: "", },
                { type: "text", name: "type", label: "Type", ope: "", },
                { type: "text", name: "item_id", label: "Item Id", ope: "", },
                { type: "text", name: "state_code", label: "State Code", ope: "", },
                { type: "text", name: "latitude", label: "Latitude", ope: "", },
                { type: "text", name: "longitude", label: "Longitude", ope: "", },
            ],
            table_fields: [
                { text: "Name", prop: "name", name: "name", },
                { text: "Country Code", prop: "country_code", name: "country_code", },
                { text: "Type", prop: "type", name: "type", },
                { text: "Item Id", prop: "item_id", name: "item_id", },
                { text: "State Code", prop: "state_code", name: "state_code", },
                { text: "Latitude", prop: "latitude", name: "latitude", },
                { text: "Longitude", prop: "longitude", name: "longitude", },

            ],
        };
    },
};
</script>
