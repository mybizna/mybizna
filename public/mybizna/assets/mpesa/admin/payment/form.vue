<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">
                <FormKit v-model="model.id" label="Id" id="id" type="hidden" validation="required" />
                <FormKit v-model="model.first_name" label="First Name" id="first_name" type="text" validation="required" />
                <FormKit v-model="model.middle_name" label="Middle Name" id="middle_name" type="text" validation="required" />
                <FormKit v-model="model.last_name" label="Last Name" id="last_name" type="text" validation="required" />
                <FormKit v-model="model.trans_type" label="Trans Type" id="trans_type" type="text" validation="required" />
                <FormKit v-model="model.trans_id" label="Trans Id" id="trans_id" type="text" validation="required" />
                <FormKit v-model="model.trans_time" label="Trans Time" id="trans_time" type="text" validation="required" />
                <FormKit v-model="model.trans_amount" label="Trans Amount" id="trans_amount" type="text" validation="required" />
                <FormKit v-model="model.org_account" label="Org Account" id="org_account" type="text" validation="required" />
            </div>
            <div class="col-md-6">
                <FormKit v-model="model.business_short_code" label="Business Short Code" id="business_short_code" type="text" validation="required" />
                <FormKit v-model="model.bill_ref_number" label="Bill Ref Number" id="bill_ref_number" type="text" validation="required" />
                <FormKit v-model="model.invoice_number" label="Invoice Number" id="invoice_number" type="text" validation="required" />
                <FormKit v-model="model.third_party_id" label="Third Party Id" id="third_party_id" type="text" validation="required" />
                <FormKit v-model="model.msisdn" label="Msisdn" id="msisdn" type="text" validation="required" />
                <FormKit v-model="model.published" label="Published" id="published" type="switch" validation="required" />
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
            path_param: ["mpesa", "payment"],
            model: {
                id: "",
                trans_type: "",
                trans_id: "",
                trans_time: "",
                trans_amount: "",
                business_short_code: "",
                bill_ref_number: "",
                invoice_number: "",
                org_account: "",
                third_party_id: "",
                msisdn: "",
                first_name: "",
                middle_name: "",
                last_name: "",
                published: "",
            },

        };
    }
};
</script>
