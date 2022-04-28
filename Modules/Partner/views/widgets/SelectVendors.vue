<template>
    <div class="mybizna-form-group invoice-customers with-multiselect">
        <people-modal title="Add new vendor" type="vendor" v-if="showModal"></people-modal>
        <label>{{ window.$func.__('Vendor', 'erp') }}<span class="mybizna-required-sign">*</span></label>
        <multi-select v-model="selected" :options="options" />

        <a href="#" class="add-new-customer" @click="showModal = true">
            <i class="flaticon-add-plus-button"></i>{{ window.$func.__('Add new', 'erp') }}
        </a>
    </div>
</template>

<script>
import { mapState } from 'vuex';

import MultiSelect from 'assets/components/select/MultiSelect.vue';
import PeopleModal from 'assets/partner/widgets/PeopleModal.vue';

export default {

    components: {
        MultiSelect,
        PeopleModal
    },

    props: {
        value: {
            type: [String, Object, Array],
            default: ''
        },

        reset: {
            type: Boolean,
            default: false
        }
    },

    data() {
        return {
            selected: null,
            showModal: false
        };
    },

    watch: {
        value(newVal) {
            this.selected = newVal;
        },

        selected() {
            this.$emit('input', this.selected);
        },

        reset() {
            this.selected = [];
        }
    },

    computed: mapState({
        options: state => state.purchase.vendors
    }),

    created() {
        this.$store.dispatch('purchase/fetchVendors');

        this.$root.$on('options-query', query => {
            if (query) {
                this.getvendors(query);
            }
        });

        this.$on('modal-close', () => {
            this.showModal = false;
            this.people = null;
        });

        this.$root.$on('peopleUpdate', () => {
            self.showModal = false;
        });
    },

    methods: {
        getvendors(query) {
            window.axios.get('/people', {
                params: {
                    type: 'vendor',
                    search: query
                }
            }).then(response => {
                this.$store.dispatch('purchase/fillVendors', response.data);
            });
        }

    }
};
</script>

<style>

</style>
