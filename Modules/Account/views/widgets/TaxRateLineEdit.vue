<template>
    <div id="mybizna-tax-rate-modal" class="mybizna-modal has-form mybizna-modal-open" role="dialog">
        <div class="mybizna-modal-dialog">
            <div class="mybizna-modal-content">
                <!-- modal body title -->
                <div class="mybizna-modal-header">
                    <h3>{{tax_rate.tax_rate_name}}</h3>
                    <span class="modal-close" @click.prevent="closeModal"><i class="flaticon-close"></i></span>
                </div>

                <div class="mybizna-invoice-table">
                    <div class="mybizna-panel-body">
                        <tax-rate-row
                            :index="row_data.id"
                            :component_line="row_data"
                            :agencies="agencies"
                            :categories="categories"
                        />
                    </div>

                </div>
            </div>
        </div>
    </div>

</template>

<script>
import TaxRateRow from 'assets/components/tax/TaxRateRow.vue';

export default {

    components: {
        TaxRateRow
    },

    props: {
        tax_id: {
            type: [Number, String]
        },
        row_data: {
            type: [Object]
        }
    },

    data() {
        return {
            tax_rate: {},
            agency: '',
            category: '',
            isWorking: false,
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

        fetchData() {
            const taxid = this.tax_id;

            window.axios.get(`/taxes/${taxid}`).then((response) => {
                this.tax_rate = response.data;
            }).catch(error => {
                throw error;
            });

            window.axios.get('/tax-agencies').then((response) => {
                this.agencies = [];
                this.agencies = response.data;
            }).catch(error => {
                throw error;
            });

            window.axios.get('/tax-cats').then((response) => {
                this.categories = [];
                this.categories = response.data;
            }).catch(error => {
                throw error;
            });
        }
    }
};
</script>

<style>
    .mybizna-modal-dialog {
        max-width: 900px!important;
        margin: 50px auto;
    }

    .mybizna-modal .mybizna-modal-content  {
       min-height: 50vh !important;
    }

    .mybizna-modal-header {
        padding: 30px 0 20px 40px !important;
    }

    .mybizna-modal span.modal-close {
       line-height: 3 !important;
   }
</style>
