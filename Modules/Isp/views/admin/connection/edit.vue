<template>
    <table-edit :path_param="path_param" :model="model">

  $table->increments('id');
        $table->string('username');
        $table->string('password');
        $table->integer('package_id')->unsigned()->nullable();
        $table->integer('invoice_id')->unsigned()->nullable();
        $table->integer('partner_id')->unsigned()->nullable();
        $table->string('params')->nullable();
        $table->dateTime('expiry_date')->nullable();
        $table->dateTime('billing_date')->nullable();
        $table->boolean('is_paid')->default(false)->nullable();
        $table->boolean('is_setup')->default(false)->nullable();
        $table->enum('status', ['new', 'active', 'inactive', 'closed'])->default('new')->nullable();

        <div class="row">
            <div class="col-md-6">

                <FormKit label="Id" id="id" type="hidden" validation="required" />
                <FormKit label="username" id="username" type="text" validation="required" />
                <FormKit label="password" id="password" type="text" validation="required" />
                <FormKit label="package" id="package_id" type="text" validation="required" />
                <FormKit label="Invoice" id="invoice_id" type="text" validation="required" />
                <FormKit label="Invoice" id="invoice_id" type="text" validation="required" />
                <FormKit label="Start Date" id="start_date" type="datetime" validation="required" />
                <FormKit label="End Date" id="end_date" type="datetime" validation="required" />

            </div>
            <div class="col-md-6">
                <FormKit label="Payment" id="payment_id" type="select" validation="required" :options="[
                    'Monaco',
                    'Vatican City',
                    'Maldives',
                    'Tuvalu',
                ]" placeholder="Select a planet" />
                <FormKit label="Description" id="description" type="textarea" validation="required" />
                <FormKit label="Is Paid" id="is_paid" type="switch" validation="required" />

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
            path_param: ["isp", "billing"],
            model: {
                id: "",
                title: "",
                connection_id: "",
                invoice_id: "",
                description: "",
                start_date: "",
                end_date: "",
                is_paid: "",
            },

        };
    }
};
</script>
