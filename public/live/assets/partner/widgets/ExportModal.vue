<template>
    <div id="people-modal">
        <div class="container">
            <div id="import-customer-modal" class="modal has-form modal-open" role="dialog">
                <div >
                    <div >
                        <div >
                            <h3>{{ title }}</h3>
                            <span >
                                <i class="flaticon-close" @click="$parent.$emit('modal-close')"></i>
                            </span>
                        </div>

                        <form action="" method="post" class="edit-customer-modal" id="export_form">
                            <div >
                                <div class="erp-grid-container">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="fields">
                                                <h3>{{ description }}<span class="required"> *</span></h3>
                                            </label>
                                        </div>

                                        <div class="col-3">
                                            <h3>
                                                <input type="checkbox" id="selecctall" @change.prevent="selectFields" />
                                                {{ this.$func.__('Select all', 'erp') }}
                                            </h3>
                                        </div>
                                    </div>

                                    <div class="row" id="fields">
                                        <div v-for="(field, key) in peopleFields" :key="key" class="col-2">
                                            <label>
                                                <input type="checkbox" name="fields[]" :value="field" :checked="selectAll">
                                                {{ strTitleCase(field) }}
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row"></div>

                                    <div class="row">
                                        <p class="description">{{ this.$func.__( '**Only selected fields will be on the csv file.', 'erp' ) }}</p>
                                    </div>
                                </div>

                                <input type="hidden" name="type" :value="peopleType">
                                <input type="hidden" name="erp_export_csv" value="1">
                                <input type="hidden" name="_wpnonce" :value="nonce">

                            </div>

                            <div class="pt-0">
                                <div class="buttons-wrapper text-right">
                                    <button class="btn btn-default modal-close" @click="$parent.$emit('modal-close')" type="reset">{{ this.$func.__('Cancel', 'erp') }}</button>
                                    <button class="btn btn-primary" type="submit">{{ this.$func.__('Export', 'erp') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {

    props: {
        type: {
            type: String
        },
        title: {
            required: true
        },
    },

    data() {
        return {
            sampleUrl: '',
            peopleFields: [],
            fieldsHtml: '',
            nonce: '',
            description: '',
            peopleType: '',
            selectAll: false,
        };
    },

    created() {
        this.peopleType   = 'customers' == this.type ? 'customer' : 'vendor';
        this.peopleFields = this.$erp_acct_var.erp_fields ? this.$erp_acct_var.erp_fields[this.peopleType].fields : [];
        this.nonce        = this.$erp_acct_var.export_import_nonce;
        this.description  = 'customer' === this.peopleType
                          ? this.$func.__('Select customer fields to export', 'erp')
                          : this.$func.__('Select vendor fields to export', 'erp');
    },

    methods: {
        selectFields() {
            this.selectAll = ! this.selectAll;
        },

        strTitleCase(string) {
            var str = string.toString().replace(/_/g, ' ');

            return str.toLowerCase().split(' ').map(function (word) {
                return (word.charAt(0).toUpperCase() + word.slice(1));
            }).join(' ');
        },
    },
};
</script>

<style>
    .modal-close
        .flaticon-close {
            font-size: inherit;
        }
    }

    .description {
        color: grey;
    }
</style>
