<template>
    <div id="tax-rate-modal" class="modal has-form modal-open" role="dialog">
        <div >
            <div >
                <!-- modal body title -->
                <div >
                    <h3>{{ this.$func.__('Add New Line') }}</h3>
                    <span  @click.prevent="closeModal"><i class="flaticon-close"></i></span>
                </div>

                <div class="invoice-table">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-3 ">
                                <label>{{ this.$func.__('Component') }}</label>
                                <input type="text" class="form-control form-contro-sm form-field" v-model="component_name" />
                            </div>
                            <div class="col-sm-3  with-multiselect">
                                <label>{{ this.$func.__('Agency') }}</label>
                                <multi-select
                                    v-model="agency"
                                    :options="agencies"/>
                            </div>
                            <div class="col-sm-3  with-multiselect">
                                <label>{{ this.$func.__('Tax Category') }}</label>
                                    <multi-select
                                    v-model="category"
                                    :options="categories" />
                            </div>
                            <div class="col-sm-3 ">
                                <label>{{ this.$func.__('Tax Rate') }}</label>
                                <input type="text" class="form-control form-contro-sm form-field" v-model="tax_rate"/>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group text-right mt-10 mb-0">
                                    <submit-button :text="this.$func.__( 'Save' )" @click.native.prevent="addTaxRate"></submit-button>
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

export default {

    components: {
        MultiSelect: window.$func.fetchComponent('components/select/MultiSelect.vue'),
        SubmitButton: window.$func.fetchComponent('components/base/SubmitButton.vue')
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
                this.showAlert('success', this.$func.__('Tax Rate Updated!'));
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
    .modal-dialog {
        max-width: 900px !important;
        margin: 50px auto;
    }

    .modal .modal-content  {
       min-height: 50vh !important;
    }

    .modal-header {
        padding: 30px 0 20px 40px !important;
    }

    .row {
       padding: 10px 40px !important;
   }

   .modal span.modal-close {
       line-height: 3 !important;
   }
</style>
