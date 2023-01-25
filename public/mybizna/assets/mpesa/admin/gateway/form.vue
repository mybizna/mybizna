<template>
    <table-edit :path_param="path_param" :model="model">
        <div class="row">
            <div class="col-md-6">
                <FormKit v-model="model.id" label="Id" id="id" type="hidden" validation="required" />
                <FormKit v-model="model.title" label="Title" id="title" type="text" validation="required" />
                <FormKit v-model="model.slug" label="Slug" id="slug" type="text" validation="required" />
                <FormKit v-model="model.paybill_till" label="Paybill Till" id="paybill_till" type="text" validation="required" />
                 <FormKit v-model="model.shortcode" label="Short Code" id="shortcode" type="text" validation="required" />
                <FormKit v-model="model.key" label="Key" id="key" type="text" validation="required" />
                <FormKit v-model="model.secret" label="Secret" id="secret" type="text" validation="required" />
            </div>
            <div class="col-md-6">
                <FormKit v-model="model.ledger_id" label="Ledger Id" id="ledger_id" type="text" validation="required" />
                <FormKit v-model="model.initiator" label="Initiator" id="initiator" type="text" validation="required" />
                <FormKit v-model="model.type" label="Type" id="type" type="text" validation="required" />
                <FormKit v-model="model.passkey" label="Pass Key" id="passkey" type="text" validation="required" />
                <FormKit v-model="model.default" label="Default" id="default" type="switch" validation="required" />
                <FormKit v-model="model.published" label="Published" id="published" type="switch" validation="required" />
            </div>
            <div class="col-md-12">
                <FormKit v-model="model.description" label="Description" id="description" type="text" validation="required" />
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
            path_param: ["mpesa", "gateway"],
            model: {
                id: "",
                title: "",
                slug: "",
                key: "",
                secret: "",
                initiator: "",
                type: "",
                passkey: "",
                paybill_till: "",
                shortcode: "",
                ledger_id: "",
                passkey: "",
                description: "",
                published: "",
                default: "",
            },

        };
    }
};
</script>
