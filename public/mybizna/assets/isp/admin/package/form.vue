<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">

                <FormKit v-model="model.id" label="Id" id="id" type="hidden" validation="required" />
                <FormKit v-model="model.title" label="Title" id="title" type="text" validation="required" />
                <FormKit v-model="model.slug" label="Slug" id="slug" type="text" validation="required" />
                <FormKit v-model="model.billing_cycle_id" label="Billing Cycle" id="billing_cycle_id" type="text" validation="required" />
                <FormKit v-model="model.speed" label="Speed" id="speed" type="text" validation="required" />
                <FormKit v-model="model.speed_type"  label="Speed Type" id="speed_type" type="select" validation="required" :option="['kilobyte', 'megabyte']" />

            </div>
            <div class="col-md-6">
                <FormKit v-model="model.description"  label="Description" id="description" type="textarea" validation="required" />
                <FormKit v-model="model.published"  label="Published" id="published" type="switch" validation="required" />
                <FormKit v-model="model.is_hidden"  label="Hidden in Portal" id="is_hidden" type="switch" validation="required" />
                <FormKit v-model="model.featured"  label="Featured" id="featured" type="switch" validation="required" />

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
            path_param: ["isp", "package"],
            model: {
                id: "",
                title: "",
                slug: "",
                description: "",
                billing_cycle_id: "",
                speed: "",
                speed_type: "",
                published: "",
                is_hidden: "",
                featured: "",
                amount: "",
            },
        };
    }
};
</script>
