<template>
    <div class="mybizna-container">
        <!-- Start .header-section -->
        <div class="content-header-section separator">
            <div class="mybizna-row mybizna-between-xs">
                <div class="mybizna-col">
                    <h2 class="content-header__title">{{ this.$func.__('Transfer Money', 'erp') }}</h2>
                </div>
            </div>
        </div>
        <!-- End .header-section -->
        <div class="mybizna-panel mybizna-panel-default pb-0">
            <div class="mybizna-panel-body">
                <form action="" method="post" class="modal-form edit-customer-modal" @submit.prevent="submitTransfer">
                    <div class="mybizna-modal-body">
                        <!-- add new product form -->
                        <div class="mybizna-row mybizna-gutter-20">
                            <div class="mybizna-form-group mybizna-col-sm-6 mybizna-col-xs-12">
                                <label for="transfer_funds_from">{{ this.$func.__('Transfer Funds From', 'erp') }}</label>
                                <div class="mybizna-custom-select with-multiselect">
                                    <multi-select id="transfer_funds_from" name="from" v-model="transferFrom" :multiple="false" :options="fa" :placeholder="this.$func.__('Select Account', 'erp')"></multi-select>
                                </div>
                                <span class="balance mt-10 display-inline-block">{{ this.$func.__('Balance', 'erp') }}: {{transformBalance(transferFrom.balance)}}</span>
                            </div>
                            <div class="mybizna-form-group mybizna-col-sm-6 mybizna-col-xs-12">
                                <label for="transfer_funds_to">{{ this.$func.__('Transfer Funds To', 'erp') }}</label>

                                <div class="mybizna-custom-select with-multiselect">
                                    <multi-select id="transfer_funds_to" name="to" v-model="transferTo" :multiple="false" :options="ta" :placeholder="this.$func.__('Select Account', 'erp')"></multi-select>
                                </div>
                                <span class="balance mt-10 display-inline-block">{{ this.$func.__('Balance', 'erp') }}: {{transformBalance(transferTo.balance)}}</span>
                            </div>
                            <div class="mybizna-form-group mybizna-col-sm-6 mybizna-col-xs-12">
                                <label for="transfer_amount">{{ this.$func.__('Transfer Amount', 'erp') }} <span class="mybizna-required-sign">*</span></label>
                                <input required min="0" step="0.01" type="number" name="transfer_amount" id="transfer_amount" class="mybizna-form-field" placeholder="$100.00" v-model="amount">
                            </div>
                            <div class="mybizna-form-group mybizna-col-sm-6 mybizna-col-xs-12">
                                <label for="transfer_date">{{ this.$func.__('Transfer Date', 'erp') }}</label>
                                <datepicker id="transfer_date" class="mybizna-form-field" name="transfer_date" v-model="transferdate"></datepicker>
                            </div>
                            <div class="mybizna-col-xs-12 mybizna-form-group">
                                <label for="particulars">{{ this.$func.__('Particulars', 'erp') }}</label>
                                <textarea name="particulars" id="particulars" rows="3" maxlength="250" class="mybizna-form-field" :placeholder="this.$func.__('Type Here', 'erp')" v-model="particulars"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mybizna-modal-footer pt-0">
                        <button class="mybizna-btn btn--primary" type="submit">{{ this.$func.__('Transfer Money', 'erp') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</template>

<script>

export default {
    components: {
        MultiSelect: window.$func.fetchComponent('components/select/MultiSelect.vue'),
        Datepicker: window.$func.fetchComponent('components/base/Datepicker.vue')
    },

    data() {
        return {
            transferFrom: { balance : 0 },
            transferTo  : { balance : 0 },
            accounts    : [],
            fa          : [],
            ta          : [],
            transferdate: erp_acct_var.current_date, /* global erp_acct_var */
            particulars : '',
            amount      : ''
        };
    },

    created() {
        this.fetchAccounts();
    },

    mounted() {
        // `transfer` request from account list row action
        if (this.$route.params.ac_id) {
            this.transferFrom  = {
                id  : parseInt(this.$route.params.ac_id),
                name: this.$route.params.ac_name
            };
        }
    },

    methods: {
        fetchAccounts() {
            window.axios.get('accounts').then((response) => {
                this.accounts = response.data;
                this.fa = response.data;
                this.ta = response.data;
            });
        },

        transformBalance(val) {
            if (val < 0) {
                return `Cr. ${this.moneyFormat(Math.abs(val))}`;
            }
            return `Dr. ${this.moneyFormat(val)}`;
        },

        submitTransfer() {
            window.axios.post('/accounts/transfer', {
                date           : this.transferdate,
                from_account_id: this.transferFrom.id,
                to_account_id  : this.transferTo.id,
                amount         : this.amount,
                particulars    : this.particulars
            }).then(res => {
                this.showAlert('success', this.$func.__('Transfer Successful!', 'erp'));
                this.fetchAccounts();
                this.resetData();
                this.$router.push('/settings/banks/transfers');
            }).catch(err => {
                const msg = err.response.data.message;
                this.showAlert('error', msg);
            });
        },

        resetData() {
            this.transferFrom = { balance : 0 };
            this.transferTo   = { balance : 0 };
            this.accounts     = [];
            this.transferdate = erp_acct_var.current_date;
            this.particulars  = '';
            this.amount       = '';
        }
    },
    watch: {
        /* global jQuery */
        'transferFrom'() {
            const id = this.transferFrom.id;
            this.ta = jQuery.grep(this.accounts, function(e) {
                return e.id !== id;
            });
        },

        'transferTo'() {
            const id = this.transferTo.id;
            this.fa = jQuery.grep(this.accounts, function(e) {
                return e.id !== id;
            });
        }
    }
};
</script>

<style>
    .mybizna-modal {
        z-index: 999 !important;
    }

    #transfer_amount {
        height: 36px;
    }

    #transfer_date {
        padding: 0 !important;
        height: 36px;
        border: 0 none;
    }
</style>
