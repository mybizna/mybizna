<template>
    <div>
        <div class="content-header-section separator has-border-top">
            <div class="row between-xs">
                <div class="col">
                    <h2 class="content-header__title">
                        {{ this.$func.__("Transactions", "erp") }}
                    </h2>
                </div>
                <div class="col">
                    <form class="form form--inline">
                        <div
                            :class="[
                                'has-dropdown',
                                { 'dropdown-opened': showFilters },
                            ]"
                        >
                            <a
                                class="btn btn-default dropdown-trigger filter-button"
                                @click.prevent="toggleFilter"
                            >
                                <span
                                    ><i class="flaticon-search-segment"></i
                                    >{{ this.$func.__("Filters", "erp") }}</span
                                >
                                <i
                                    class="flaticon-arrow-down-sign-to-navigate"
                                ></i>
                            </a>
                            <div
                                class="dropdown-menu dropdown-menu-right filter-container"
                            >
                                <div
                                    class="panel panel-default filter-panel"
                                >
                                    <h3>
                                        {{ this.$func.__("Filter", "erp") }}
                                    </h3>
                                    <div class="panel-body">
                                        <h3>
                                            {{ this.$func.__("Date", "erp") }}
                                        </h3>
                                        <div class="form-control form-contro-sm form-fields">
                                            <div class="start-date has-addons">
                                                <datepicker
                                                    v-model="filters.start_date"
                                                ></datepicker>
                                                <span
                                                    class="flaticon-calendar"
                                                ></span>
                                            </div>
                                            <span class="label-to">{{
                                                this.$func.__("To", "erp")
                                            }}</span>
                                            <div class="end-date has-addons">
                                                <datepicker
                                                    v-model="filters.end_date"
                                                ></datepicker>
                                                <span
                                                    class="flaticon-calendar"
                                                ></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <input
                                            type="reset"
                                            value="Cancel"
                                            class="btn btn-default"
                                            @click="toggleFilter"
                                        />
                                        <input
                                            type="submit"
                                            value="Submit"
                                            class="btn btn-primary"
                                            @click.prevent="filterList"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="import-wrapper display-inline-block"
                        >
                            <a
                                class="btn btn-default"
                                href="#"
                                title="Import"
                                ><span class="flaticon-import"></span
                            ></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="transactions-section section">
            <div class="table-container">
                <list-table
                    tableClass="table table-sm people-trns-table table-striped widefat"
                    action-column="actions"
                    :columns="columns"
                    :rows="rows"
                    :actions="actions"
                    :showCb="false"
                    @action:click="onActionClick"
                >
                    <template slot="voucher_no" slot-scope="data">
                        <strong>
                            <router-link
                                :to="{
                                    name: 'DynamicTrnLoader',
                                    params: { id: data.row.voucher_no },
                                }"
                            >
                                <span v-if="data.row.voucher_no"
                                    >#{{ data.row.voucher_no }}</span
                                >
                            </router-link>
                        </strong>
                    </template>
                    <template slot="debit" slot-scope="data">
                        <span v-if="data.row.debit">{{
                            moneyFormat(data.row.debit)
                        }}</span>
                        <span v-else>-</span>
                    </template>
                    <template slot="credit" slot-scope="data">
                        <span v-if="data.row.credit">
                            {{ moneyFormat(data.row.credit) }}
                        </span>
                        <span v-else>-</span>
                    </template>
                </list-table>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    components: {
        ListTable: window.$func.fetchComponent('components/list-table/ListTable.vue'),
        Datepicker: window.$func.fetchComponent('components/base/Datepicker.vue')
    },
    props: ['rows'],

    data() {
        return {
            bulkActions: [
                {
                    key: 'trash',
                    label: this.$func.__('Move to Trash'),
                    img: this.$mybizna_var.assets + '/images/trash.png' /* global this.$mybizna_var */
                }
            ],
            columns: {
                trn_date   : { label: this.$func.__('Transaction Date'), isColPrimary: true },
                created_at : { label: this.$func.__('Created At') },
                voucher_no : { label: this.$func.__('Voucher No') },
                particulars: { label: this.$func.__('Particulars') },
                debit      : { label: this.$func.__('Debit') },
                credit     : { label: this.$func.__('Credit') },
                balance    : { label: this.$func.__('Balance') }
            },
            actions : [
                { key: 'edit', label: this.$func.__('Edit') },
                { key: 'trash', label: this.$func.__('Delete') }
            ],
            showFilters: false,
            filters: {
                start_date: '',
                end_date: ''
            }
        };
    },

    methods: {
        toggleFilter() {
            this.showFilters = !this.showFilters;
        },

        filterList() {
            this.toggleFilter();
            this.$root.$emit('people-transaction-filter', this.filters);
        },

        onActionClick(action, row, index) {
            switch (action) {
            case 'trash':
                if (confirm(
                    'Are you sure to delete?'))) {
                    this.$root.$emit('delete-transaction', row.id);
                }
                break;

            case 'edit':
                this.showModal = true;
                this.people = row;
                break;
            }
        }
    }

};
</script>

<style>
.people-trns-table tbody tr td:last-child {
    text-align: left !important;
}
.open-dropdown-menu {
    visibility: visible !important;
    opacity: 1 !important;
}
</style>
