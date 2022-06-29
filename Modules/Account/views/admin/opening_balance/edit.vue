<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">

                <FormKit label="Id" id="id" type="hidden" validation="required" />
                <FormKit label="Type" id="type" type="text" validation="required" />
                <FormKit label="Financial Year" id="financial_year_id" type="text" validation="required" />
                <FormKit label="Chart" id="chart_id" type="text" validation="required" />
                <FormKit label="Ledger" id="ledger_id" type="text" validation="required" />

            </div>
            <div class="col-md-6">

                <FormKit label="Debit" id="debit" type="text" validation="required" />
                <FormKit label="Credit" id="credit" type="text" validation="required" />

            </div>
        </div>


    </table-edit>
</template>

<script>
export default {
    components: {
        TableEdit: window.$func.fetchComponent("components/common/TableEdit.vue")
    },
    data () {
        return {
            id: null,
            path_param: ["account", "opening_balance"],
            model: {
                id: "",
                financial_year_id: "",
                chart_id: "",
                ledger_id: "",
                type: "",
                debit: "",
                credit: "",
            },

        };
    }
};
</script>
