<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">
                <FormKit label="Id" id="id" type="hidden" validation="required" />
                <FormKit label="note" id="note" type="text" validation="required" />
                <FormKit label="transaction_date" id="transaction_date" type="text" validation="required" />
                <FormKit label="debit" id="debit" type="text" validation="required" />
                <FormKit label="credit" id="credit" type="text" validation="required" />
            </div>
            <div class="col-md-6">
                <FormKit label="Particulars" id="particulars" type="text" validation="required" />
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
            path_param: ["account", "journal"],
            model: {
                id: "",
                transaction_date: "",
                debit: "",
                credit: "",
                note: "",
                particulars: "",
            },

        };
    }
};
</script>
