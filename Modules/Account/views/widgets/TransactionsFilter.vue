<template>
    <div class="content-header-section separator mybizna-has-border-top">
        <div class="mybizna-row mybizna-between-xs">
            <div class="mybizna-col">
                <h2 class="content-header__title">{{ this.$func.__('Transactions', 'erp') }}</h2>
            </div>
            <div class="mybizna-col" ref="filterArea">
                <form class="mybizna-form form--inline" action="" @submit.prevent="filterList">
                    <div :class="['mybizna-has-dropdown', {'dropdown-opened': showFilters}]">
                        <a class="mybizna-btn btn--default dropdown-trigger filter-button" @click.prevent="toggleFilter">
                            <span><i class="flaticon-search-segment"></i>{{ this.$func.__('Filters', 'erp') }}</span>
                            <i class="flaticon-arrow-down-sign-to-navigate"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right mybizna-filter-container">
                            <div class="mybizna-panel mybizna-panel-default mybizna-filter-panel">
                                <h3>{{ this.$func.__('Filter', 'erp') }}</h3>
                                <div class="mybizna-panel-body">
                                    <h3>{{ this.$func.__('Date', 'erp') }}</h3>
                                    <div class="form-fields">
                                        <div class="start-date has-addons">
                                            <datepicker v-model="filters.start_date"></datepicker>
                                            <span class="flaticon-calendar"></span>
                                        </div>
                                        <span class="label-to">{{ this.$func.__('To', 'erp') }}</span>
                                        <div class="end-date has-addons">
                                            <datepicker v-model="filters.end_date"></datepicker>
                                            <span class="flaticon-calendar"></span>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-fields">
                                        <div class="form-field-wrapper" v-if="status">
                                            <h3>{{ this.$func.__('Status', 'erp') }}</h3>
                                            <div class="form-fields">
                                                <simple-select
                                                    v-model="filters.status"
                                                    :options="statuses"
                                                >
                                                </simple-select>
                                            </div>
                                        </div>
                                        <div  class="form-field-wrapper" v-if="types.length">
                                        <h3>{{ this.$func.__('Type', 'erp') }}</h3>
                                            <div class="form-fields">
                                                <simple-select
                                                    v-model="filters.type"
                                                    :options="types"
                                                >
                                                </simple-select>
                                            </div>
                                        </div>
                                    </div>

                                <div class="people" v-if="people.items.length">
                                    <br>
                                    <h3>{{ this.$func.__(people.title, 'erp') }}</h3>
                                    <div class="form-fields">
                                        <simple-select
                                            v-model="filters.people_id"
                                            :options="people.items"
                                        >
                                        </simple-select>
                                    </div>
                                </div>
                                </div>
                                <div class="mybizna-panel-footer">
                                    <input type="button" :value="__( 'Cancel', 'erp' )" class="mybizna-btn btn--cancel"
                                           @click="toggleFilter">
                                    <input type="reset" :value="__( 'Reset', 'erp' )" class="mybizna-btn btn--reset"
                                           @click="resetFilter">
                                    <input type="submit" :value="__( 'Submit', 'erp' )" class="mybizna-btn btn--primary">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mybizna-import-wrapper display-inline-block">
                        <a class="mybizna-btn btn--default" href="#" title="Import"><span class="flaticon-import"></span></a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</template>

<script>
import Datepicker from 'assets/components/base/Datepicker.vue';
import SimpleSelect from 'assets/components/select/SimpleSelect.vue';

export default {

    props: {
        status: {
            type: Boolean,
            required: false,
            default: function () {
                return true
            }
        },
        types: {
            type: Array,
            required: false,
            default: function () {
                return []
            }
        },
        people: {
            type: Object,
            required: false,
            default: function () {
                return {
                    title: '',
                    items: []
                }
            }
        }
    },

    components: {
        Datepicker,
        SimpleSelect
    },

    data() {
        return {
            showFilters: false,
            filters: {
                start_date: '',
                end_date: '',
                status: '',
                type: '',
                customer_id: ''
            },
            statuses: []
        };
    },

    created() {
        window.axios.get('/transactions/statuses').then(response => {
            this.statuses = response.data;
        }).catch(error => {
            throw error;
        });

         this.$root.$on('SimpleSelectChange', (data) => {
            const status = this.statuses.find(o => o.id === data.selected);
            this.filters.status = parseInt(status.id);
        });
    },

    mounted() {
        // Outside click event to hide filter content
        window.addEventListener('click', (e) => {
            if ( this.$refs.filterArea && !this.$refs.filterArea.contains(e.target) ){
                this.showFilters = false;
            }
        })
    },

    methods: {
        toggleFilter() {
            this.showFilters = !this.showFilters;
        },

        // Reset filter and reload list with those fields
        resetFilter() {
            this.filters = {
                start_date : '',
                end_date   : '',
                status     : '',
                type       : '',
                customer_id: ''
            };

            this.filterList();
        },

        filterList() {
            this.toggleFilter();

            this.$root.$emit('transactions-filter', this.filters);
        }

    }
};
</script>
<style>
.form-fields .vue-select {
    width: 100% !important;
}

.form-fields .form-field-wrapper:first-child{
    padding-right: 10px;
}

.btn--cancel {
    color: #000;
    background-color: #fff!important;
    border: 1px solid #e2e2e2!important;
    border-radius: 3px!important;
    padding: .313rem .7rem!important;
    float: left;
}

.btn--reset {
    color: #3c9fd4;
    background-color: #fff!important;
    border: 1px solid #e2e2e2!important;
    border-radius: 3px!important;
    padding: .313rem .7rem!important;
}
</style>
