<template>
    <table-edit :path_param="path_param" :model="model">
        <div class="row">
            <div class="col-md-6">
                <label class="text-gray fs-14">Personal Detail</label>
                <div class="border-top border-blue-200 p-2 mb-2">
                    <FormKit label="Id" id="id" type="hidden" v-model="model.id" validation="required" />
                    <FormKit label="User" id="user_id" type="recordpicker" comp_url="partner/admin/user"
                        v-model="model.user_id" validation="required" />
                    <FormKit label="First Name" id="first_name" type="text" v-model="model.first_name"
                        validation="required" />
                    <FormKit label="Last Name" id="last_name" type="text" v-model="model.last_name"
                        validation="required" />
                    <FormKit label="Company" id="company" type="text" v-model="model.company" validation="required" />
                    <FormKit label="Country" id="country_id" type="recordselect"
                        comp_url="core/admin/country/recordselect" v-model="model.country_id" validation="required" />
                    <FormKit label="Currency" id="currency_id" type="recordselect"
                        comp_url="core/admin/currency/recordselect" v-model="model.currency_id" validation="required" />
                </div>
            </div>
            <div class="col-md-6">
                <label class="text-gray fs-14">Contact Detail</label>
                <div class="border-top border-blue-200 p-2 mb-2">
                    <FormKit label="Email" id="email" type="text" v-model="model.email" validation="required" />
                    <FormKit label="Phone" id="phone" type="text" v-model="model.phone" validation="required" />
                    <FormKit label="Mobile" id="mobile" type="text" v-model="model.mobile" validation="required" />
                    <FormKit label="Fax" id="fax" type="text" v-model="model.fax" validation="required" />
                    <FormKit label="Postal Code" id="postal_code" type="text" v-model="model.postal_code"
                        validation="required" />
                    <FormKit label="Other" id="other" type="text" v-model="model.other" validation="required" />
                </div>
            </div>
        </div>
        <div class="p-2"></div>

        <div class="row">
            <div class="col-md-6">
                <label class="text-gray fs-14">Other Detail</label>
                <div class="border-top border-blue-200 p-2 mb-2">
                    <FormKit label="Website" id="website" type="text" v-model="model.website" validation="required" />
                    <FormKit label="Life Stage" id="life_stage" type="text" v-model="model.life_stage"
                        validation="required" />
                    <FormKit label="City" id="city" type="text" v-model="model.city" validation="required" />
                    <FormKit label="State" id="state" type="text" v-model="model.state" validation="required" />

                </div>
            </div>
            <div class="col-md-6">
                <label class="text-gray fs-14">Address</label>
                <div class="border-top border-blue-200 p-2 mb-2">
                    <FormKit label="Address" id="address" type="textarea" v-model="model.address"
                        validation="required" />
                </div>
            </div>
        </div>

        <div class="p-2"></div>

        <div class="row">
            <div class="col-md-12">
                <FormKit label="Notes" id="notes" type="textarea" v-model="model.notes" validation="required" />
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
            path_param: ["partner", "partner"],

            model: {
                user_id: "",
                first_name: "",
                last_name: "",
                company: "",
                email: "",
                phone: "",
                mobile: "",
                other: "",
                website: "",
                fax: "",
                notes: "",
                street_1: "",
                street_2: "",
                city: "",
                state: "",
                postal_code: "",
                country_id: "",
                currency_id: "",
                life_stage: "",
            },

        };
    }
};
</script>
