<template>
    <table-list title="Account Cash at Bank" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["account", "cash_at_bank"],
            model: {
                name: "",
                balance: "",
                ledger_id: "",
            },

            search_fields: [
                { type: "text", name: "name", label: "Name", ope: "", },
                { type: "text", name: "balance", label: "Balance", ope: "", },
                { type: "text", name: "ledger_id", label: "Ledger Id", ope: "", },
            ],
            table_fields: [
                { text: "Name", prop: "name", name: "name", },
                { text: "Balance", prop: "balance", name: "balance", },
                { text: "Ledger", prop: "ledger_id", name: "ledger_id", },
            ],
        };
    },
};
</script>
