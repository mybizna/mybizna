<template>
    <div class="app-customers">
        <div class="content-header-section separator">
            <div class="row between-xs">
                <div class="col">
                    <h2 class="content-header__title">
                        {{ this.$func.__("Record Sales Tax Payment", "erp") }}
                    </h2>
                </div>
            </div>
        </div>

        <div class="panel panel-default pb-0">
            <div class="panel-body">
                <form
                    action="#"
                    class="form"
                    method="post"
                    @submit.prevent="submitForTaxPay"
                >
                    <show-errors :error_msgs="form_errors" />

                    <div class="row gutter-20">
                        <div class="col-sm-4 with-multiselect">
                            <label
                                >{{ this.$func.__("Payment Method", "erp")
                                }}<span class="required-sign">
                                    *</span
                                ></label
                            >
                            <multi-select
                                v-model="trn_by"
                                :options="pay_methods"
                            ></multi-select>
                        </div>
                        <div class="col-sm-4 mb-20">
                            <label>
                                <span v-if="'debit' == voucher_type.id">{{
                                    this.$func.__("Payment From", "erp")
                                }}</span>
                                <span v-else>{{
                                    this.$func.__("Deposit To", "erp")
                                }}</span>
                                <span class="required-sign">*</span>
                            </label>

                            <select-accounts
                                v-model="deposit_to"
                                :override_accts="accts_by_chart"
                            ></select-accounts>
                        </div>
                        <div class="col-sm-4 ">
                            <div class="form-group">
                                <label
                                    >{{ this.$func.__("Payment Date", "erp")
                                    }}<span class="required-sign">
                                        *</span
                                    ></label
                                >
                                <div class="has-datepicker pay-tax-date">
                                    <datepicker v-model="trn_date"></datepicker>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 ">
                            <div class="form-group with-multiselect">
                                <label>{{ this.$func.__("Payment To", "erp") }}</label>
                                <multi-select
                                    v-model="agency"
                                    :options="agencies"
                                />
                            </div>
                        </div>
                        <div class="col-sm-4 ">
                            <div class="form-group">
                                <label>{{ this.$func.__("Tax Amount", "erp") }}</label>
                                <input
                                    type="number"
                                    min="0"
                                    step="0.01"
                                    v-model="tax_amount"
                                    class="form-control form-contro-sm form-field"
                                    :placeholder="this.$func.__('Enter Tax Amount', 'erp')"
                                />

                                <span
                                    >{{ this.$func.__("Due Amount", "erp") }}:
                                    <span class="text-theme">{{
                                        moneyFormat(dueAmount)
                                    }}</span></span
                                >
                            </div>
                        </div>
                        <div class="col-sm-4 ">
                            <div class="form-group with-multiselect">
                                <label>{{ this.$func.__("Voucher Type", "erp") }}</label>
                                <multi-select
                                    v-model="voucher_type"
                                    :options="voucher_types"
                                    :placeholder="
                                        this.$func.__('Enter Voucher Type', 'erp')
                                    "
                                />
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <label>{{ this.$func.__("Particulars", "erp") }}</label>
                            <textarea
                                rows="3"
                                v-model="particulars"
                                maxlength="250"
                                class="form-control form-contro-sm form-field"
                                :placeholder="this.$func.__('Enter Particulars', 'erp')"
                            ></textarea>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group text-right mt-10 mb-0">
                                <submit-button
                                    :text="this.$func.__('Save', 'erp')"
                                    :working="isWorking"
                                ></submit-button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    components: {
        Datepicker: window.$func.fetchComponent('components/base/Datepicker.vue'),
        MultiSelect: window.$func.fetchComponent('components/select/MultiSelect.vue'),
        SubmitButton: window.$func.fetchComponent('components/base/SubmitButton.vue'),
        SelectAccounts: window.$func.fetchComponent('components/select/SelectAccounts.vue'),
        ShowErrors: window.$func.fetchComponent('components/base/ShowErrors.vue'),
    },

    data() {
        return {
            agencies: [],
            pay_methods: [],
            accts_by_chart: [],
            trn_by: { id: null, name: null },
            deposit_to: { id: null, name: null },
            agency: { id: null, name: null },
            tax_amount: 0,
            dueAmount: 0,
            particulars: "",
            isWorking: false,
            form_errors: [],
            trn_date: this.$mybizna_var.current_date /* global this.$mybizna_var */,
            voucher_type: { id: "debit", name: this.$func.__("Debit", "erp") },
            voucher_types: [
                { id: "debit", name: this.$func.__("Debit", "erp") },
                { id: "credit", name: this.$func.__("Credit", "erp") },
            ],
        };
    },

    watch: {
        agency() {
            this.getDuePayAmount();
        },

        trn_by() {
            this.changeAccounts();
        },
    },

    created() {
        this.getPayMethods();
        this.getAgencies();
    },

    methods: {
        getPayMethods() {
            window.axios
                .get("/transactions/payment-methods")
                .then((response) => {
                    this.pay_methods = response.data;
                });
        },

        changeAccounts() {
            this.accts_by_chart = [];
            if (this.trn_by.id === "2" || this.trn_by.id === "3") {
                window.axios.get("/ledgers/bank-accounts").then((response) => {
                    this.accts_by_chart = response.data;
                    this.accts_by_chart.forEach((element) => {
                        if (
                            !Object.prototype.hasOwnProperty.call(
                                element,
                                "balance"
                            )
                        ) {
                            element.balance = 0;
                        }
                    });
                });
            } else if (this.trn_by.id === "1") {
                window.axios.get("/ledgers/cash-accounts").then((response) => {
                    this.accts_by_chart = response.data;
                    this.accts_by_chart.forEach((element) => {
                        if (
                            !Object.prototype.hasOwnProperty.call(
                                element,
                                "balance"
                            )
                        ) {
                            element.balance = 0;
                        }
                    });
                });
                /* global erp_reimbursement_var */
            } else if (
                erp_reimbursement_var.erp_reimbursement_module !==
                    "undefined" &&
                erp_reimbursement_var.erp_reimbursement_module === "1"
            ) {
                window.axios
                    .get("/people-transactions/balances")
                    .then((response) => {
                        this.accts_by_chart = response.data;
                        this.accts_by_chart.forEach((element) => {
                            if (
                                !Object.prototype.hasOwnProperty.call(
                                    element,
                                    "balance"
                                )
                            ) {
                                element.balance = 0;
                            }
                        });
                    });
            }
            this.$root.$emit("account-changed");
        },

        getAgencies() {
            window.axios.get("/tax-agencies").then((response) => {
                this.agencies = response.data;
            });
        },

        getDuePayAmount() {
            if (!this.agency.id) return;

            // ? or... we could bring due along with agencies
            window.axios
                .get(`/tax-agencies/due/${this.agency.id}`)
                .then((response) => {
                    this.dueAmount = parseFloat(response.data);
                });
        },

        submitForTaxPay() {
            this.validateForm();

            if (this.form_errors.length) {
                window.scrollTo({
                    top: 10,
                    behavior: "smooth",
                });
                return;
            }


            window.axios
                .post("/taxes/pay-tax", {
                    agency_id: this.agency.id,
                    trn_date: this.trn_date,
                    trn_by: this.trn_by.id,
                    ledger_id: this.deposit_to.id,
                    particulars: this.particulars,
                    voucher_type: this.voucher_type.id,
                    amount: parseFloat(this.tax_amount),
                })
                .catch((error) => {
                    throw error;
                })
                .then((res) => {
                    this.showAlert("success", this.$func.__("Tax Paid!", "erp"));
                })
                .then(() => {
                    this.$router.push({ name: "TaxRecords" });
                    this.resetData();
                    this.isWorking = false;
                });
        },

        resetData() {
            this.trn_by = { id: null, name: null };
            this.deposit_to = { id: null, name: null };
            this.agency = { id: null, name: null };
            this.tax_amount = 0;
            this.dueAmount = 0;
            this.particulars = "";
            this.isWorking = false;
            this.form_errors = [];
            this.trn_date = this.$mybizna_var.current_date;
            this.voucher_type = { id: "debit", name: this.$func.__("Debit", "erp") };
        },

        validateForm() {
            this.form_errors = [];

            if (!this.trn_by.id) {
                this.form_errors.push(
                    this.$func.__("Payment method Name is required.", "erp")
                );
            }

            if (!this.deposit_to.id) {
                this.form_errors.push(this.$func.__("Deposit to is required.", "erp"));
            }

            if (!this.agency.id) {
                this.form_errors.push(this.$func.__("Agency to is required.", "erp"));
            }

            if (!this.trn_date) {
                this.form_errors.push(this.$func.__("Date is required.", "erp"));
            }

            if (!this.tax_amount) {
                this.form_errors.push(this.$func.__("Tax amount is required.", "erp"));
            }

            // if ( this.tax_amount > this.dueAmount ) {
            //     this.form_errors.push(this.$func.__('Please pay according to your due balance.', 'erp'));
            // }

            if (
                parseFloat(this.deposit_to.balance) <
                parseFloat(this.finalTotalAmount)
            ) {
                this.form_errors.push(
                    this.$func.__("Not enough balance in selected account.", "erp")
                );
            }
        },
    },
};
</script>

<style>
.pay-tax-date .has-dropdown {
    width: 100%;
}

.text-theme {
    color: #1a9ed4;
    font-weight: 400;
    margin-left: 10px;
}
</style>
