<template>
    <div id="mybizna-tax-rate-modal" class="mybizna-modal has-form mybizna-modal-open" role="dialog">
        <div class="mybizna-modal-dialog">
            <div class="mybizna-modal-content">
                <!-- modal body title -->
                <div class="mybizna-modal-header">
                    <h3>{{ this.$func.__('Add New Line', 'erp') }}</h3>
                    <span class="modal-close" @click.prevent="closeModal"><i class="flaticon-close"></i></span>
                </div>

                <div class="mybizna-invoice-table">
                    <div class="mybizna-panel-body">
                        <div class="mybizna-row">
                            <div class="mybizna-col-sm-3 mybizna-col-xs-12">
                                <label>{{ this.$func.__('Component', 'erp') }}</label>
                                <input type="text" class="mybizna-form-field" v-model="component_name" />
                            </div>
                            <div class="mybizna-col-sm-3 mybizna-col-xs-12 with-multiselect">
                                <label>{{ this.$func.__('Agency', 'erp') }}</label>
                                <multi-select
                                    v-model="agency"
                                    :options="agencies"/>
                            </div>
                            <div class="mybizna-col-sm-3 mybizna-col-xs-12 with-multiselect">
                                <label>{{ this.$func.__('Tax Category', 'erp') }}</label>
                                    <multi-select
                                    v-model="category"
                                    :options="categories" />
                            </div>
                            <div class="mybizna-col-sm-3 mybizna-col-xs-12">
                                <label>{{ this.$func.__('Tax Rate', 'erp') }}</label>
                                <input type="text" class="mybizna-form-field" v-model="tax_rate"/>
                            </div>

                            <div class="mybizna-col-sm-12">
                                <div class="mybizna-form-group text-right mt-10 mb-0">
                                    <submit-button :text="__( 'Save', 'erp' )" @click.native.prevent="addTaxRate"></submit-button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</template>

<script>
import SubmitButton from 'assets/components/base/SubmitButton.vue';
import MultiSelect from 'assets/components/select/MultiSelect.vue';

export default {

    components: {
        MultiSelect,
        SubmitButton
    },

    data() {
        return {
            component_name: '',
            agency: '',
            category: '',
            tax_rate: '',
            agencies: [],
            categories: []
        };
    },

    created() {
        this.fetchData();
    },

    methods: {
        closeModal: function() {
            this.$emit('close');
        },

        addTaxRate() {

            window.axios.post(`/taxes/${this.$route.params.id}/line-add`, {
                tax_id: this.$route.params.id,
                component_name: this.component_name,
                agency_id: this.agency.id,
                tax_cat_id: this.category.id,
                tax_rate: this.tax_rate
            }).then(res => {
                this.showAlert('success', this.$func.__('Tax Rate Updated!', 'erp'));
            }).catch(error => {
                throw error;
            }).then(() => {
                this.resetData();
                this.isWorking = false;
                this.$emit('line_close');
                this.$root.$emit('refetch_tax_data');
                this.$router.push({ name: 'TaxRates' });
            });
        },

        fetchData() {
            window.axios.get('/tax-agencies').then((response) => {
                this.agencies = response.data;
            }).catch(error => {
                throw error;
            });

            window.axios.get('/tax-cats').then((response) => {
                this.categories = response.data;
            }).catch(error => {
                throw error;
            });
        },

        resetData() {
            Object.assign(this.$data, this.$options.data.call(this));
        }

    }
};
</script>

<style>
    .mybizna-modal-dialog {
        max-width: 900px !important;
        margin: 50px auto;
    }

    .mybizna-modal .mybizna-modal-content  {
       min-height: 50vh !important;
    }

    .mybizna-modal-header {
        padding: 30px 0 20px 40px !important;
    }

    .mybizna-row {
       padding: 10px 40px !important;
   }

   .mybizna-modal span.modal-close {
       line-height: 3 !important;
   }
</style>
