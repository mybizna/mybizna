<template>
    <div>
        <div class="content-header-section separator mybizna-has-border-top">
            <div class="mybizna-row mybizna-between-xs">
                <div class="mybizna-col">
                    <h2 class="content-header__title">
                        {{ this.$func.__("Transactions", "erp") }}
                    </h2>
                </div>
                <div class="mybizna-col">
                    <form class="mybizna-form form--inline">
                        <div
                            :class="[
                                'mybizna-has-dropdown',
                                { 'dropdown-opened': showFilters },
                            ]"
                        >
                            <a
                                class="mybizna-btn btn--default dropdown-trigger filter-button"
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
                                class="dropdown-menu dropdown-menu-right mybizna-filter-container"
                            >
                                <div
                                    class="mybizna-panel mybizna-panel-default mybizna-filter-panel"
                                >
                                    <h3>
                                        {{ this.$func.__("Filter", "erp") }}
                                    </h3>
                                    <div class="mybizna-panel-body">
                                        <h3>
                                            {{ this.$func.__("Date", "erp") }}
                                        </h3>
                                        <div class="form-fields">
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
                                    <div class="mybizna-panel-footer">
                                        <input
                                            type="reset"
                                            value="Cancel"
                                            class="mybizna-btn btn--default"
                                            @click="toggleFilter"
                                        />
                                        <input
                                            type="submit"
                                            value="Submit"
                                            class="mybizna-btn btn--primary"
                                            @click.prevent="filterList"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="mybizna-import-wrapper display-inline-block"
                        >
                            <a
                                class="mybizna-btn btn--default"
                                href="#"
                                title="Import"
                                ><span class="flaticon-import"></span
                            ></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="mybizna-transactions-section mybizna-section">
            <div class="table-container">
                <list-table
                    tableClass="mybizna-table table-sm people-trns-table table-striped widefat"
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
                    label: this.$func.__('Move to Trash', 'erp'),
                    img: this.$erp_acct_var.erp_assets + '/images/trash.png' /* global this.$erp_acct_var */
                }
            ],
            columns: {
                trn_date   : { label: this.$func.__('Transaction Date', 'erp'), isColPrimary: true },
                created_at : { label: this.$func.__('Created At', 'erp') },
                voucher_no : { label: this.$func.__('Voucher No', 'erp') },
                particulars: { label: this.$func.__('Particulars', 'erp') },
                debit      : { label: this.$func.__('Debit', 'erp') },
                credit     : { label: this.$func.__('Credit', 'erp') },
                balance    : { label: this.$func.__('Balance', 'erp') }
            },
            actions : [
                { key: 'edit', label: this.$func.__('Edit', 'erp') },
                { key: 'trash', label: this.$func.__('Delete', 'erp') }
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
                    'Are you sure to delete?', 'erp'))) {
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
