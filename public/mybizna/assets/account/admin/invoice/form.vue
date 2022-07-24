<template>
    <table-edit :path_param="path_param" :model="model">

   <FormKit button_label="Select Customer" id="partner_id" type="recordpicker" comp_url="partner/admin/partner/list.vue"
                    :setting="setting.partner_id" v-model="model.partner_id" validation="required" />

        <div class="row">
            <div class="col-md-4">
                <span class="underline">From</span>
                <address>
                    <strong>Mybizna, Inc.</strong><br>
                    P.O Box 767 - 00618<br>
                    Nairobi, Kenya<br>
                    Phone: +254 713 034 569<br>
                    Email: info@mybizna.com
                </address>
            </div>
            <div class="col-md-4">
                <span class="underline">To</span>
                <address>
                    <strong>John Doe</strong><br>
                    P.O Box 767 - 00618<br>
                    Nairobi, Kenya<br>
                    Phone: +254 713 034 569<br>
                    Email: info@mybizna.com
                </address>

            </div>
            <div class="col-md-4">
                <b>Invoice #007612</b><br>
                <br>
                <b>Order ID:</b> 4F3S8J<br>
                <b>Payment Due:</b> 2/22/2014<br>
                <b>Account:</b> 968-34567
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <FormKit label="Description" id="description" type="textarea" validation="required" />
            </div>
            <div class="col-md-6">
                <FormKit label="Status" id="status" type="switch" validation="required" />
                <FormKit label="Successful" id="successful" type="switch" validation="required" />
            </div>
            <div class="col-md-6">
                <FormKit label="Completed" id="completed" type="switch" validation="required" />
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
            path_param: ["account", "invoice"],
            setting: {
                partner_id: {
                    path_param: ["partner", "partner"],
                    fields: ['first_name', 'last_name', 'email'],
                    template: '[first_name] [last_name] - [email]',
                },
            },
            model: {
                id: "",
                partner_id: "",
                description: "",
                status: "",
                completed: "",
                successful: "",
            },

        };
    }
};
</script>
