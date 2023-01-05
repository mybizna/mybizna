<template>
        <table-list title="Isp Payment Charge Rate" :path_param="path_param" :search_fields="search_fields" :model="model"
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
            path_param: ["isp", "payment_charge_rate"],
            model: {
                payment_charge_id: "",
                rate_id: "",
            },
            search_fields: [
                { type: "text", name: "payment_charge_id", label: "Payment Charge", ope: "", },
                { type: "text", name: "rate_id", label: "Rate", ope: "", },
            ],
            table_fields: [
                { text: "Payment Charge", prop: "payment_charge_id", name: "payment_charge_id", },
                { text: "Rate", prop: "rate_id", name: "rate_id", },
            ],
        };
    },
};
</script>
