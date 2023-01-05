<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">
                <FormKit v-model="model.id" label="Id" id="id" type="text" validation="required" />
                
                <FormKit v-model="model.title" label="Title" id="title" type="text" validation="required" />
                <FormKit v-model="model.username" label="Username" id="username" type="text" validation="required" />
                <FormKit v-model="model.password" label="Password" id="password" type="text" validation="required" />
                <FormKit v-model="model.database" label="Database" id="database" type="text" validation="required" />
            </div>
            <div class="col-md-6">
                <FormKit v-model="model.ip_address" label="IP Address" id="ip_address" type="text" validation="required" />
                <FormKit v-model="model.type" label="Type" id="type" type="text" validation="required" />
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
            path_param: ["isp", "gateway"],
            model: {
                id: "",
                title: "",
                username: "",
                password: "",
                database: "",
                ip_address: "",
                type: "",
                published: "",
            },

        };
    }
};
</script>
