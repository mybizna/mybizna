<template>
    <table-list title="Account Ledger Setting" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["account", "ledger_setting"],
            model: {
                ledger_id: "",
                short_code: "",
            },
            search_fields: [
                { type: "text", name: "ledger_id", label: "Ledger", ope: "", },
                { type: "text", name: "short_code", label: "Short Code", ope: "", },
            ],
            table_fields: [
                { text: "Ledger", prop: "ledger_id", name: "ledger_id", },
                { text: "Short Code", prop: "short_code", name: "short_code", },
            ],
        };
    },
};
</script>
