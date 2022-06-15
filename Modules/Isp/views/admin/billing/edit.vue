<template>
    <table-edit :path_param="path_param" :model="model">

        <div class="row">
            <div class="col-md-6">

                <FormKit label="User" id="user_id" type="text" validation="required" />
                <FormKit label="Amount" id="amount" type="text" validation="required" />
                <FormKit label="Completed" id="completed" type="switch" validation="required" />
                <FormKit label="Successful" id="successful" type="switch" validation="required" />

            </div>
            <div class="col-md-6">
                <FormKit label="Payment" id="payment_id" type="select" validation="required" :options="[
                    'Monaco',
                    'Vatican City',
                    'Maldives',
                    'Tuvalu',
                ]" placeholder="Select a planet" />
                <FormKit label="Description" id="Description" type="textarea" validation="required" />

            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <FormKit label="Payment" id="payment_id" type="checkbox" validation="required" :options="[
                    'Monaco',
                    'Vatican City',
                    'Maldives',
                    'Tuvalu',
                ]" placeholder="Select a planet" />
                <FormKit label="Payment" id="payment_id" type="radio" validation="required" :options="[
                    'Monaco',
                    'Vatican City',
                    'Maldives',
                    'Tuvalu',
                ]" placeholder="Select a planet" />
                <FormKit label="Dropzone" id="user_id" type="dropzone" validation="required" />
                <FormKit label="Face" id="user_id" type="face" validation="required" />
                <FormKit label="File" id="user_id" type="file" validation="required" />
                <FormKit label="Media" id="user_id" type="media" validation="required" />
                <FormKit label="OneTimePassword" id="user_id" type="noetimepassword" validation="required" />
                <FormKit label="RecordAutoComplete" id="user_id" type="recordautocomplete" validation="required" />
                <FormKit label="RecordPicker" id="user_id" type="recordpicker" validation="required" />
                <FormKit label="RecordSelect" id="user_id" type="recordselect" validation="required" />
                <FormKit label="Editor" id="user_id" type="editor" validation="required" />


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
                description: "",
                user_id: "",
                payment_id: "",
                amount: "",
                completed: "",
                successful: ""
            },

        };
    }
};
</script>
