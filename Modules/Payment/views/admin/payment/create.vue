<template>
    <div class="container rec-payment">
        <!-- Start .header-section -->
        <div class="content-header-section separator">
            <div class="row between-xs">
                <div class="col">
                    <h2 class="content-header__title">
                        {{ this.$func.__("Payment", "erp") }}
                    </h2>
                </div>
            </div>
        </div>
        <!-- End .header-section -->

        <form action="" method="post" @submit.prevent="SubmitForPayment">
            <div
                class="panel panel-default"
                style="padding-bottom: 0"
            >
                <div class="panel-body">
                    <show-errors :error_msgs="form_errors"></show-errors>

                    <form action="" class="form" method="post">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <!-- @input="getDueInvoices"  -->
                                    <select-customers
                                        v-model="basic_fields.customer"
                                    ></select-customers>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>{{ this.$func.__("Reference", "erp") }}</label>
                                    <input
                                        type="text"
                                        class="form-control form-contro-sm form-field"
                                        v-model="basic_fields.trn_ref"
                                    />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label
                                        >{{ this.$func.__("Payment Date", "erp")
                                        }}<span class="required-sign"
                                            >*</span
                                        ></label
                                    >
                                    <datepicker
                                        v-model="basic_fields.payment_date"
                                    ></datepicker>
                                </div>
                            </div>
                            <div class="col-sm-4 with-multiselect">
                                <label
                                    >{{ this.$func.__("Payment Method", "erp")
                                    }}<span class="required-sign"
                                        >*</span
                                    ></label
                                >
                                <multi-select
                                    v-model="basic_fields.trn_by"
                                    :options="pay_methods"
                                ></multi-select>
                            </div>
                            <div class="col-sm-4">
                                <label
                                    >{{ this.$func.__("Deposit to", "erp")
                                    }}<span class="required-sign"
                                        >*</span
                                    ></label
                                >
                                <select-accounts
                                    v-model="basic_fields.deposit_to"
                                    :reset="reset"
                                    :override_accts="accts_by_chart"
                                ></select-accounts>
                            </div>

                            <div
                                class="col-sm-4"
                                v-if="basic_fields.trn_by.id === '2'"
                            >
                                <div class="form-group">
                                    <label>{{
                                        this.$func.__("Transaction Charge", "erp")
                                    }}</label>
                                    <input
                                        type="text"
                                        class="form-control form-contro-sm form-field"
                                        v-model="bank_data.trn_charge"
                                    />
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <label>{{
                                    this.$func.__("Billing Address", "erp")
                                }}</label>
                                <textarea
                                    v-model.trim="basic_fields.billing_address"
                                    rows="4"
                                    class="form-control form-contro-sm form-field"
                                    :placeholder="this.$func.__('Type here')"
                                ></textarea>
                            </div>

                            <check-fields
                                v-if="basic_fields.trn_by.id === '3'"
                                @updateCheckFields="setCheckFields"
                            ></check-fields>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <!-- Start .crm-table -->
                <div class="table-container">
                    <table class="table form-table">
                        <thead>
                            <tr class="inline-edit-row">
                                <th scope="col" class="col--id">
                                    {{ this.$func.__("Voucher No", "erp") }}
                                </th>
                                <th scope="col">{{ this.$func.__("Due Date", "erp") }}</th>
                                <th scope="col">{{ this.$func.__("Total", "erp") }}</th>
                                <th scope="col">{{ this.$func.__("Balance", "erp") }}</th>
                                <th scope="col">{{ this.$func.__("Amount", "erp") }}</th>
                                <th scope="col" class="col--actions"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                :key="key"
                                v-for="(invoice, key) in invoices"
                                class="inline-edit-row"
                            >
                                <td scope="row" class="col--id">
                                    #{{ invoice.invoice_no }}
                                </td>
                                <td
                                    class="col--due-date"
                                    :data-colname="this.$func.__('Due Date')"
                                >
                                    {{ invoice.due_date }}
                                </td>
                                <td
                                    class="col--total"
                                    :data-colname="this.$func.__('Total')"
                                >
                                    {{ moneyFormat(invoice.amount) }}
                                </td>
                                <td
                                    class="col--due"
                                    :data-colname="this.$func.__('Due')"
                                >
                                    {{ formatAmount(invoice.due, true) }}
                                </td>
                                <td
                                    class="col--amount"
                                    :data-colname="this.$func.__('Amount')"
                                >
                                    <input
                                        type="number"
                                        step="0.01"
                                        :max="Math.abs(invoice.due)"
                                        v-model="totalAmounts[key]"
                                        @keyup="updateFinalAmount"
                                        class="form-control form-contro-sm form-field text-right"
                                    />
                                </td>
                                <td
                                    class="delete-row"
                                    :data-colname="
                                        this.$func.__('Remove Above Selection')
                                    "
                                >
                                    <a @click.prevent="removeRow(key)" href="#"
                                        ><i class="flaticon-trash"></i
                                    ></a>
                                </td>
                            </tr>

                            <tr class="total-amount-row inline-edit-row">
                                <td class="text-right pr-0" colspan="4">
                                    {{ this.$func.__("Total Amount", "erp") }}
                                </td>
                                <td
                                    class="text-right"
                                    :data-colname="this.$func.__('Total Amount')"
                                >
                                    <input
                                        type="text"
                                        class="form-control form-contro-sm form-field text-right"
                                        name="finalamount"
                                        :value="moneyFormat(finalTotalAmount)"
                                        readonly
                                        disabled
                                    />
                                </td>
                                <td class="text-right"></td>
                            </tr>
                        </tbody>
                        <tr class="form-group inline-edit-row">
                            <td colspan="9" style="text-align: left">
                                <label>{{ this.$func.__("Particulars", "erp") }}</label>
                                <textarea
                                    v-model="particulars"
                                    rows="4"
                                    maxlength="250"
                                    class="form-control form-contro-sm form-field display-flex"
                                    :placeholder="
                                        this.$func.__('Internal Information')
                                    "
                                ></textarea>
                            </td>
                        </tr>
                        <tr class="inline-edit-row">
                            <td>
                                <div
                                    class="attachment-item"
                                    :key="index"
                                    v-for="(file, index) in attachments"
                                >
                                    <img
                                        :src="
                                           mybizna_assets +
                                            '/images/file-thumb.png'
                                        "
                                    />
                                    <span
                                        class="remove-file"
                                        @click="removeFile(index)"
                                        >&#10007;</span
                                    >

                                    <div class="attachment-meta">
                                        <h3>{{ getFileName(file) }}</h3>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="add-attachment-row inline-edit-row">
                            <td colspan="9" style="text-align: left">
                                <div class="attachment-container">
                                    <label class="col--attachement">{{
                                        this.$func.__("Attachment", "erp")
                                    }}</label>
                                    <file-upload
                                        v-model="attachments"
                                        url="/invoices/attachments"
                                    />
                                </div>
                            </td>
                        </tr>
                        <tfoot>
                            <tr class="inline-edit-row">
                                <td colspan="9" style="text-align: right">
                                    <combo-button :options="createButtons" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </form>
    </div>
</template>

<script>

export default {
    components: {
        SelectAccounts: window.$func.fetchComponent('components/select/SelectAccounts.vue'),
        Datepicker: window.$func.fetchComponent('components/base/Datepicker.vue'),
        FileUpload: window.$func.fetchComponent('components/base/FileUpload.vue'),
        SelectCustomers: window.$func.fetchComponent('components/select/SelectAccounts.vue'),
        MultiSelect: window.$func.fetchComponent('components/select/MultiSelect.vue'),
        CheckFields: window.$func.fetchComponent('componentss/check/CheckFields.vue'),
        ShowErrors: window.$func.fetchComponent('components/base/ShowErrors.vue'),
        ComboButton: window.$func.fetchComponent('components/select/ComboButton.vue'),
    },

    data() {
        return {
            basic_fields: {
                customer: "",
                trn_ref: "",
                payment_date: "",
                deposit_to: "",
                billing_address: "",
                trn_by: "",
            },

            check_data: {
                bank_name: "",
                payer_name: "",
                check_no: "",
            },

            bank_data: {
                trn_charge: 0,
            },

            createButtons: [
                { id: "save", text: this.$func.__("Save", "erp") },
                { id: "new_create", text: this.$func.__("Save and New", "erp") },
                { id: "draft", text: this.$func.__("Save as Draft", "erp") },
            ],

            form_errors: [],

            editMode: false,
            voucherNo: 0,
            invoices: [],
            attachments: [],
            totalAmounts: [],
            pay_methods: [],
            finalTotalAmount: 0,
            particulars: "",
            isWorking: false,
            accts_by_chart: [],
           mybizna_assets: this.$mybizna_var.acct_assets /* global this.$mybizna_var */,
            reset: false,
            negativeAmount: [],
            negativeTotal: false,
        };
    },

    watch: {
        finalTotalAmount(newval) {
            this.finalTotalAmount = newval;
        },

        "basic_fields.customer"() {
            this.getCustomerAddress();
            this.getDueInvoices();
        },

        "basic_fields.trn_by"() {
            this.changeAccounts();
        },
    },

    computed: {
        ...mapState({ actionType: (state) => state.combo.btnID }),
    },

    created() {
        this.prepareDataLoad();

        // initialize combo button id with `save`
        this.$store.dispatch("combo/setBtnID", "save");
    },

    mounted() {
        // `receive payment` request from invoice list row action
        if (this.$route.params.customer_id) {
            this.basic_fields.customer = {
                id: parseInt(this.$route.params.customer_id),
                name: this.$route.params.customer_name,
            };
        }
    },

    methods: {
        async prepareDataLoad() {
            /**
             * ----------------------------------------------
             * check if editing
             * -----------------------------------------------
             */
            if (this.$route.params.id) {
                this.editMode = true;
                this.voucherNo = this.$route.params.id;

                /**
                 * Duplicates of
                 *? this.getPayMethods()
                 */
                const request1 = await window.axios.get(
                    "/transactions/payment-methods"
                );
                const request2 = await window.axios.get(
                    `/invoices/${this.$route.params.id}`
                );

                if (!request2.data.line_items.length) {
                    this.showAlert(
                        "error",
                        this.$func.__("Invoice does not exists!", "erp")
                    );
                    return;
                }

                this.pay_methods = request1.data;
                this.setDataForEdit(request2.data);
            } else {
                /**
                 * ----------------------------------------------
                 * create a new Receive Payment
                 * -----------------------------------------------
                 */
                this.basic_fields.payment_date = this.$mybizna_var.current_date;

                this.getPayMethods();
            }
        },

        getPayMethods() {

            window.axios
                .get("/transactions/payment-methods")
                .then((response) => {
                    this.pay_methods = response.data;

                })
                .catch((error) => {
                    throw error;
                });
        },

        setCheckFields(check_data) {
            this.check_data = check_data;
        },

        getDueInvoices() {
            this.invoices = [];

            const customerId = this.basic_fields.customer.id;
            let idx = 0;
            let finalAmount = 0;

            if (!customerId) {
                return;
            }

            window.axios
                .get(`/invoices/due/${customerId}`)
                .then((response) => {
                    response.data.forEach((element) => {
                        this.invoices.push({
                            id: element.id,
                            invoice_no: element.voucher_no,
                            due_date: element.due_date,
                            amount: parseFloat(element.amount),
                            due: parseFloat(element.due),
                        });
                    });
                })
                .then(() => {
                    this.invoices.forEach((element, index) => {
                        this.totalAmounts[idx++] = Math.abs(
                            parseFloat(element.due)
                        );

                        if (parseFloat(element.due) < 0) {
                            this.negativeAmount[index] = true;
                        }

                        finalAmount += parseFloat(element.due);
                    });

                    if (parseFloat(finalAmount) < 0) {
                        this.negativeTotal = true;
                    }

                    this.finalTotalAmount = Math.abs(
                        parseFloat(finalAmount).toFixed(2)
                    );
                    this.invoices.due = Math.abs(this.invoices.due);
                });
        },

        getCustomerAddress() {
            const customer_id = this.basic_fields.customer.id;

            if (!customer_id) {
                this.basic_fields.billing_address = "";
                return;
            }

            window.axios.get(`/people/${customer_id}`).then((response) => {
                const billing = response.data;

                let street_1 = billing.street_1 ? billing.street_1 + "," : "";
                let street_2 = billing.street_2 ? billing.street_2 : "";
                let city = billing.city ? billing.city : "";
                let state = billing.state ? billing.state + "," : "";
                let postal_code = billing.postal_code
                    ? billing.postal_code
                    : "";
                let country = billing.country ? billing.country : "";

                const address = `${street_1} ${street_2} \n${city} \n${state} ${postal_code} \n${country}`;

                this.basic_fields.billing_address = address;
            });
        },

        updateFinalAmount() {
            let finalAmount = 0;

            this.totalAmounts.forEach((element, index) => {
                finalAmount += this.negativeAmount[index]
                    ? -1 * parseFloat(element)
                    : parseFloat(element);
            });

            this.negativeTotal = parseFloat(finalAmount) < 0 ? true : false;
            this.finalTotalAmount = Math.abs(
                parseFloat(finalAmount).toFixed(2)
            );
        },

        SubmitForPayment(event) {
            this.validateForm();

            if (this.form_errors.length) {
                window.scrollTo({
                    top: 10,
                    behavior: "smooth",
                });
                return;
            }

            this.invoices.forEach((element, index) => {
                element["line_total"] = this.negativeAmount[index]
                    ? -1 * parseFloat(this.totalAmounts[index])
                    : parseFloat(this.totalAmounts[index]);
            });


            let trn_status = null;
            if (this.actionType === "draft") {
                trn_status = 1;
            } else {
                trn_status = 4;
            }

            let deposit_id = this.basic_fields.deposit_to.id;

            if (this.basic_fields.trn_by.id === 4) {
                deposit_id = this.basic_fields.deposit_to.people_id;
            }

            let bank_trn_charge = 0;

            if (parseInt(this.basic_fields.trn_by.id) === 2) {
                bank_trn_charge = this.bank_data.trn_charge;
            }

            window.axios
                .post("/payments", {
                    customer_id: this.basic_fields.customer.id,
                    ref: this.basic_fields.trn_ref,
                    trn_date: this.basic_fields.payment_date,
                    line_items: this.invoices,
                    attachments: this.attachments,
                    type: "payment",
                    status: trn_status,
                    particulars: this.particulars,
                    deposit_to: deposit_id,
                    trn_by: this.basic_fields.trn_by.id,
                    check_no: parseInt(this.check_data.check_no),
                    name: this.check_data.payer_name,
                    bank: this.check_data.bank_name,
                    bank_trn_charge: bank_trn_charge,
                })
                .then((res) => {

                    this.showAlert("success", this.$func.__("Payment Created!", "erp"));
                    this.reset = true;

                    if (
                        this.actionType === "save" ||
                        this.actionType === "draft"
                    ) {
                        this.$router.push({ name: "Sales" });
                    } else if (this.actionType === "new_create") {
                        this.resetFields();
                    }
                })
                .catch((error) => {
                    throw error;
                });
        },

        changeAccounts() {
            this.accts_by_chart = [];
            if (
                this.basic_fields.trn_by.id === "2" ||
                this.basic_fields.trn_by.id === "3"
            ) {
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
            } else if (this.basic_fields.trn_by.id === "1") {
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
                /* globalmybizna_reimbursement_var */
            } else if (this.basic_fields.trn_by.id === "4") {
                if (
                   mybizna_reimbursement_var.reimbursement_module !==
                        "undefined" &&
                   mybizna_reimbursement_var.reimbursement_module === "1"
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
            }
            this.$root.$emit("account-changed");
        },

        validateForm() {
            this.form_errors = [];

            if (
                !Object.prototype.hasOwnProperty.call(
                    this.basic_fields.customer,
                    "id"
                )
            ) {
                this.form_errors.push(this.$func.__("Customer Name is required.", "erp"));
            }

            if (!this.basic_fields.payment_date) {
                this.form_errors.push(
                    this.$func.__("Transaction Date is required.", "erp")
                );
            }

            if (
                !Object.prototype.hasOwnProperty.call(
                    this.basic_fields.deposit_to,
                    "id"
                )
            ) {
                this.form_errors.push(
                    this.$func.__("Deposit Account is required.", "erp")
                );
            }

            if (
                !Object.prototype.hasOwnProperty.call(
                    this.basic_fields.trn_by,
                    "id"
                )
            ) {
                this.form_errors.push(this.$func.__("Payment Method is required.", "erp"));
            }

            if (!parseFloat(this.finalTotalAmount)) {
                this.form_errors.push(this.$func.__("Total amount can't be zero.", "erp"));
            }
        },

        showPaymentModal() {
            this.getDueInvoices();
        },

        resetData() {
            this.basic_fields = {
                customer: "",
                trn_ref: "",
                payment_date: this.$mybizna_var.current_date,
                deposit_to: "",
                billing_address: "",
                trn_by: "",
            };

            this.check_data = {
                bank_name: "",
                payer_name: "",
                check_no: "",
            };

            this.form_errors = [];
            this.invoices = [];
            this.attachments = [];
            this.totalAmounts = [];
            this.finalTotalAmount = 0;
            this.particulars = "";
            this.isWorking = false;
            this.reset = false;

            this.$store.dispatch("combo/setBtnID", "save");
        },

        removeRow(index) {
            this.$delete(this.invoices, index);
            this.$delete(this.totalAmounts, index);
            this.$delete(this.negativeAmount, index);
            this.updateFinalAmount();
        },
    },
};
</script>

<style>
.rec-payment .dropdown {
    width: 100%;
}

.rec-payment .col--amount {
    width: 200px;
}
</style>
