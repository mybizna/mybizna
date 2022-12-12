<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">

                <FormKit v-model="model.id" label="Id" id="id" type="hidden" validation="required" />
                <FormKit v-model="model.package_id" label="Package" id="package_id" type="text" validation="required" />
                <FormKit v-model="model.subscriber_id" label="Subscriber" id="subscriber_id" type="text" validation="required" />

            </div>
            <div class="col-md-6">
                <FormKit v-model="model.start_date" label="Start Date" id="start_date" type="textarea" validation="required" />
                <FormKit v-model="model.end_date" label="End Date" id="end_date" type="textarea" validation="required" />

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
            path_param: ["isp", "subscription"],
            model: {
                id: "",
                package_id: "",
                subscriber_id: "",
                start_date: "",
                end_date: "",
            },

        };
    }
};
</script>
