<template>
    <div class="mybizna-container invoice-create">
        <!-- Start .header-section -->
        <div class="content-header-section separator">
            <div class="mybizna-row mybizna-between-xs">
                <div class="mybizna-col">
                    <h2 v-if="estimateToInvoice()">
                        {{ this.$func.__("Convert into Invoice", "erp") }}
                    </h2>
                    <h2 v-else class="content-header__title">
                        {{ editMode ? this.$func.__("Edit", "erp") : this.$func.__("New", "erp") }}
                        {{ inv_title }}
                    </h2>
                </div>
            </div>
        </div>
        <!-- End .header-section -->

        <form action="" method="post" @submit.prevent="submitInvoiceForm">
            <div
                class="mybizna-panel mybizna-panel-default"
                style="padding-bottom: 0"
            >
                <show-errors :error_msgs="form_errors"></show-errors>

                <div class="mybizna-panel-body">
                    <div class="mybizna-row">
                        <div class="mybizna-col-sm-4">
                            <select-customers
                                v-model="basic_fields.customer"
                            ></select-customers>
                        </div>
                        <div class="mybizna-col-sm-4">
                            <div class="mybizna-form-group">
                                <label
                                    >{{ this.$func.__("Transaction Date", "erp")
                                    }}<span class="mybizna-required-sign"
                                        >*</span
                                    ></label
                                >
                                <datepicker
                                    v-model="basic_fields.trn_date"
                                ></datepicker>
                            </div>
                        </div>
                        <div class="mybizna-col-sm-4">
                            <div class="mybizna-form-group">
                                <label
                                    >{{ this.$func.__("Due Date", "erp")
                                    }}<span class="mybizna-required-sign"
                                        >*</span
                                    ></label
                                >
                                <datepicker
                                    v-model="basic_fields.due_date"
                                ></datepicker>
                            </div>
                        </div>
                        <div class="mybizna-col-sm-6">
                            <label>{{ this.$func.__("Billing Address", "erp") }}</label>
                            <textarea
                                v-model="basic_fields.billing_address"
                                rows="4"
                                class="mybizna-form-field"
                                :placeholder="this.$func.__('Type here', 'erp')"
                            ></textarea>
                        </div>
                    </div>
                    <!-- </form> -->
                </div>
            </div>

            <div class="mybizna-table-responsive">
                <!-- Start Invoice Items Table -->
                <div class="table-container">
                    <table class="mybizna-table mybizna-form-table">
                        <thead>
                            <tr>
                                <th scope="col" class="col--products">
                                    {{ this.$func.__("Product/Service", "erp") }}
                                </th>
                                <th scope="col" class="col--qty">
                                    {{ this.$func.__("Qty", "erp") }}
                                </th>
                                <th scope="col" class="col--unit-price">
                                    {{ this.$func.__("Unit Price", "erp") }}
                                </th>
                                <th scope="col" class="col--amount">
                                    {{ this.$func.__("Amount", "erp") }}
                                </th>
                                <th scope="col" class="col--tax">
                                    {{ this.$func.__("Tax", "erp") }}
                                    <span
                                        class="erp-help-tip .erp-tips"
                                        :title="
                                            this.$func.__(
                                                'Make sure you have created tax category, zone and rate. Also, make sure the tax category is added on the product.',
                                                'erp'
                                            )
                                        "
                                    ></span>
                                </th>
                                <th scope="col" class="col--actions"></th>
                            </tr>
                        </thead>
                        <tbody v-if="null != taxSummary">
                            <invoice-trn-row
                                :line="line"
                                :products="products"
                                :taxSummary="taxSummary"
                                :key="index"
                                v-for="(line, index) in transactionLines"
                            ></invoice-trn-row>

                            <tr class="add-new-line">
                                <td colspan="9" style="text-align: left">
                                    <button
                                        @click.prevent="addLine"
                                        class="mybizna-btn btn--primary add-line-trigger"
                                    >
                                        <i class="flaticon-add-plus-button"></i
                                        >{{ this.$func.__("Add Line", "erp") }}
                                    </button>
                                </td>
                            </tr>

                            <tr class="discount-rate-row inline-edit-row">
                                <td
                                    colspan="4"
                                    class="text-right with-multiselect"
                                >
                                    <select v-model="discountType">
                                        <option value="discount-percent">
                                            {{ this.$func.__("Discount percent", "erp") }}
                                        </option>
                                        <option value="discount-value">
                                            {{ this.$func.__("Discount value", "erp") }}
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <div class="discountType-box">
                                        <input
                                            type="text"
                                            class="mybizna-form-field"
                                            v-model="discount"
                                            :placeholder="discountType"
                                        />
                                        <em
                                            v-show="
                                                'discount-percent' ===
                                                discountType
                                            "
                                        >
                                            %</em
                                        >
                                    </div>
                                </td>
                                <td></td>
                            </tr>

                            <tr class="tax-rate-row inline-edit-row">
                                <td
                                    colspan="4"
                                    class="text-right with-multiselect"
                                >
                                    <multi-select
                                        v-model="taxRate"
                                        :options="taxRates"
                                        class="tax-rates"
                                        :placeholder="
                                            this.$func.__('Select sales tax', 'erp')
                                        "
                                    />
                                </td>
                                <td>
                                    <input
                                        type="text"
                                        class="mybizna-form-field"
                                        :value="moneyFormat(taxTotalAmount)"
                                        readonly
                                    />
                                </td>
                                <td></td>
                            </tr>

                            <tr class="total-amount-row inline-edit-row">
                                <td colspan="4" class="text-right">
                                    <span
                                        >{{ this.$func.__("Total Amount", "erp") }} =</span
                                    >
                                </td>
                                <td>
                                    <input
                                        type="text"
                                        class="mybizna-form-field"
                                        :value="moneyFormat(finalTotalAmount)"
                                        readonly
                                    />
                                </td>
                                <td></td>
                            </tr>
                            <tr class="mybizna-form-group inline-edit-row">
                                <td colspan="9" style="text-align: left">
                                    <label>{{
                                        this.$func.__("Particulars", "erp")
                                    }}</label>
                                    <textarea
                                        v-model="particulars"
                                        rows="4"
                                        maxlength="250"
                                        class="mybizna-form-field display-flex"
                                        :placeholder="this.$func.__('Particulars', 'erp')"
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
                                                erp_acct_assets +
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
                            <component
                                v-for="(component, compKey) in extraFields"
                                :key="'key-' + compKey"
                                :is="component"
                                :tran-type="inv_title"
                            />
                        </tbody>
                        <tfoot>
                            <tr>
                                <td
                                    v-if="estimateToInvoice()"
                                    colspan="9"
                                    style="text-align: right"
                                >
                                    <combo-button
                                        :options="[
                                            {
                                                id: 'update',
                                                text: this.$func.__(
                                                    'Save Conversion',
                                                    'erp'
                                                ),
                                            },
                                        ]"
                                    />
                                </td>
                                <td
                                    v-else
                                    colspan="9"
                                    style="text-align: right"
                                >
                                    <combo-button
                                        v-if="editMode"
                                        :options="updateButtons"
                                    />
                                    <combo-button
                                        v-else
                                        :options="createButtons"
                                    />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </form>

        <!-- End .mybizna-crm-table -->
    </div>
</template>

<script>

/* global this.$erp_acct_var */
export default {
    components: {
        MultiSelect: window.$func.fetchComponent('components/select/MultiSelect.vue'),
        Datepicker: window.$func.fetchComponent('components/base/Datepicker.vue'),
        FileUpload: window.$func.fetchComponent('components/base/FileUpload.vue'),
        ComboButton: window.$func.fetchComponent('components/select/ComboButton.vue'),
        InvoiceTrnRow: window.$func.fetchComponent('components/invoice/InvoiceTrnRow.vue'),
        SelectCustomers: window.$func.fetchComponent('components/people/SelectCustomers.vue'),
        ShowErrors: window.$func.fetchComponent('components/base/ShowErrors.vue'),
    },

    data() {
        return {
            basic_fields: {
                customer: "",
                trn_date: "",
                due_date: "",
                billing_address: "",
            },

            createButtons: [
                { id: "save", text: this.$func.__("Save", "erp") },
                // {id: 'send_create', text: this.$func.__('Create and Send', 'erp')},
                { id: "new_create", text: this.$func.__("Save and New", "erp") },
                { id: "draft", text: this.$func.__("Save as Draft", "erp") },
            ],

            updateButtons: [
                { id: "update", text: this.$func.__("Update", "erp") },
                // {id: 'send_update', text: this.$func.__('Update and Send', 'erp')},
                { id: "new_update", text: this.$func.__("Update and New", "erp") },
                { id: "draft", text: this.$func.__("Save as Draft", "erp") },
            ],

            extraFields: [],
            editMode: false,
            voucherNo: 0,
            discountType: "discount-percent",
            discount: 0,
            status: null,
            taxRate: null,
            taxSummary: null,
            products: [],
            particulars: "",
            attachments: [],
            transactionLines: [],
            taxRates: [],
            taxTotalAmount: 0,
            finalTotalAmount: 0,
            inv_title: "",
            inv_type: {},
            erp_acct_assets: this.$erp_acct_var.acct_assets,
            form_errors: [],
        };
    },

    watch: {
        "basic_fields.customer"() {
            if (!this.editMode) {
                this.getCustomerAddress();
            }
        },

        taxRate(newVal) {
            this.$store.dispatch("sales/setTaxRateID", newVal.id);
        },

        discount() {
            this.discountChanged();
        },

        discountType() {
            this.discountChanged();
        },

        invoiceTotalAmount() {
            this.discountChanged();
        },
    },

    computed: {
        ...mapState({
            invoiceTotalAmount: (state) => state.sales.invoiceTotalAmount,
        }),
        ...mapState({ actionType: (state) => state.combo.btnID }),
    },

    created() {
        if (this.$route.name === "EstimateCreate") {
            this.inv_title = "Estimate";
            this.inv_type = { id: 1, name: "Estimate" };
        } else {
            this.inv_title = "Invoice";
            this.inv_type = { id: 0, name: "Invoice" };
        }

        this.prepareDataLoad();

        this.$root.$on("remove-row", (index) => {
            this.$delete(this.transactionLines, index);
            this.updateFinalAmount();
        });

        this.$root.$on("total-updated", (amount) => {
            this.updateFinalAmount();
        });
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
                 *? this.getProducts()
                 *? this.getTaxRates()
                 * load products and taxes, before invoice load
                 */
                const [request1, request2] = await Promise.all([
                    window.axios.get("/products", {
                        params: {
                            number: -1,
                        },
                    }),
                    window.axios.get("/taxes/summary"),
                ]);
                const request3 = await window.axios.get(
                    `/invoices/${this.$route.params.id}`
                );

                if (!request3.data.line_items.length) {
                    this.showAlert(
                        "error",
                        this.$func.__("Invoice does not exists!", "erp")
                    );
                    return;
                }

                const canEdit = Boolean(Number(request3.data.editable));

                if (!canEdit) {
                    this.showAlert("error", "Can't edit");
                    return;
                }

                this.products = request1.data;
                this.taxSummary = request2.data;
                this.taxRates = this.getUniqueTaxRates(request2.data);
                this.setDataForEdit(request3.data);

                // initialize combo button id with `update`
                this.$store.dispatch("combo/setBtnID", "update");
            } else {
                /**
                 * ----------------------------------------------
                 * create a new invoice
                 * -----------------------------------------------
                 */
                this.getProducts();
                this.getTaxRates();

                this.basic_fields.trn_date = this.$erp_acct_var.current_date;
                this.basic_fields.due_date = this.$erp_acct_var.current_date;
                this.transactionLines.push({}, {}, {});

                // initialize combo button id with `save`
                this.$store.dispatch("combo/setBtnID", "save");
            }
        },

        setDataForEdit(invoice) {
            this.basic_fields.customer = {
                id: parseInt(invoice.customer_id),
                name: invoice.customer_name,
            };
            this.basic_fields.billing_address = invoice.billing_address;
            this.basic_fields.trn_date = invoice.trn_date;
            this.basic_fields.due_date = invoice.due_date;
            this.status = invoice.status;
            this.transactionLines = invoice.line_items;
            this.taxTotalAmount = invoice.tax;
            this.finalTotalAmount = invoice.debit;
            this.particulars = invoice.particulars;
            this.attachments = invoice.attachments;
            this.discountType = invoice.discount_type;

            if (invoice.discount_type === "discount-percent") {
                this.discount =
                    (parseFloat(invoice.discount) * 100) /
                    parseFloat(invoice.amount);
            } else {
                this.discount = invoice.discount;
            }

            this.taxRate = {
                id: parseInt(invoice.tax_rate_id),
                name: this.getTaxRateNameByID(invoice.tax_rate_id),
            };

            if (invoice.estimate === "1") {
                this.inv_title = "Estimate";
                this.inv_type = { id: 1, name: "Estimate" };
                this.finalTotalAmount =
                    parseFloat(invoice.amount) +
                    parseFloat(invoice.tax) -
                    parseFloat(this.discount);
            }
        },

        estimateToInvoice() {
            const estimate = 1;

            return estimate === this.inv_type.id && this.$route.query.convert;
        },

        getProducts() {

            window.axios
                .get("/products", {
                    params: {
                        number: -1,
                    },
                })
                .then((response) => {
                    this.products = response.data;

                })
                .catch((error) => {
                    throw error;
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

        discountChanged() {
            let discount = this.discount;

            if (this.discountType === "discount-percent") {
                discount = (this.invoiceTotalAmount * discount) / 100;
            }

            this.$store.dispatch("sales/setDiscount", discount);
        },

        getTaxRates() {
            window.axios.get("/taxes/summary").then((response) => {
                this.taxSummary = response.data;

                this.taxRates = this.getUniqueTaxRates(this.taxSummary);
            });
        },

        getTaxRateNameByID(id) {
            // Array.find()
            const taxRate = this.taxRates.find((rate) => {
                return rate.id === parseInt(id);
            });

            if (taxRate) {
                return taxRate.name;
            }

            return null;
        },

        getUniqueTaxRates(taxes) {
            return Array.from(new Set(taxes.map((tax) => tax.tax_rate_id))).map(
                (tax_rate_id) => {
                    const tax = taxes.find(
                        (tax) => tax.tax_rate_id === tax_rate_id
                    );

                    if (tax.default) {
                        // set default tax rate name for invoice
                        this.taxRate = {
                            id: tax_rate_id,
                            name: tax.tax_rate_name,
                        };
                        this.$store.dispatch("sales/setTaxRateID", tax_rate_id);
                    }

                    return {
                        id: tax_rate_id,
                        name: tax.tax_rate_name,
                    };
                }
            );
        },

        addLine() {
            this.transactionLines.push({});
        },

        updateFinalAmount() {
            let taxAmount = 0;
            let totalDiscount = 0;
            let totalAmount = 0;

            this.transactionLines.forEach((element) => {
                if (element.qty) {
                    taxAmount += parseFloat(element.taxAmount);
                    totalDiscount += isNaN(element.discount)
                        ? 0.0
                        : parseFloat(element.discount);
                    totalAmount += parseFloat(element.amount);
                }
            });

            this.$store.dispatch("sales/setInvoiceTotalAmount", totalAmount);

            const finalAmount = totalAmount - totalDiscount + taxAmount;

            this.taxTotalAmount = taxAmount.toFixed(2);
            this.finalTotalAmount = finalAmount.toFixed(2);
        },

        formatLineItems() {
            var lineItems = [];

            this.transactionLines.forEach((line) => {
                if (line.qty) {
                    lineItems.push({
                        product_id: line.selectedProduct.id,
                        product_type_name:
                            line.selectedProduct.product_type_name,
                        tax_cat_id: line.taxCatID,
                        qty: line.qty,
                        unit_price: line.unitPrice,
                        tax: line.taxAmount,
                        tax_rate: line.taxRate,
                        discount: line.discount,
                        item_total: line.amount,
                    });
                }
            });

            return lineItems;
        },

        updateInvoice(requestData) {

            window.axios
                .put(`/invoices/${this.voucherNo}`, requestData)
                .then((res) => {

                    let message = this.$func.__("Invoice Updated!", "erp");

                    if (this.estimateToInvoice()) {
                        message = this.$func.__("Conversion Successful!", "erp");
                    }

                    this.showAlert("success", message);
                })
                .catch((error) => {
                    throw error;
                })
                .then(() => {
                    if (
                        this.actionType === "update" ||
                        this.actionType === "draft"
                    ) {
                        this.$router.push({ name: "Sales" });
                    } else if (this.actionType === "new_update") {
                        this.resetFields();
                    }
                });
        },

        createInvoice(requestData) {

            window.axios
                .post("/invoices", requestData)
                .then((res) => {
                    this.showAlert("success", this.inv_title + " Created!");
                })
                .catch((error) => {
                    throw error;
                })
                .then(() => {
                    if (
                        this.actionType === "save" ||
                        this.actionType === "draft"
                    ) {
                        this.$router.push({ name: "Sales" });
                    } else if (this.actionType === "new_create") {
                        this.resetFields();
                    }
                });
        },

        submitInvoiceForm() {
            this.validateForm();

            if (this.form_errors.length) {
                window.scrollTo({
                    top: 10,
                    behavior: "smooth",
                });
                return;
            }

            this.isWorking = true;

            if (this.actionType === "draft") {
                this.status = 1;
            } else {
                this.status = 2;
            }

            const requestData = [];

            if (this.editMode) {
                this.updateInvoice(requestData);
            } else {
                this.createInvoice(requestData);
            }
        },

        removeFile(index) {
            this.$delete(this.attachments, index);
        },

        resetFields() {
            // why can't we use `form.reset()` ?

            this.basic_fields.customer = { id: null, name: null };
            this.basic_fields.trn_date = this.$erp_acct_var.current_date;
            this.basic_fields.due_date = this.$erp_acct_var.current_date;
            this.basic_fields.billing_address = "";
            this.particulars = "";
            this.attachments = [];
            this.transactionLines = [];
            this.discountType = "discount-percent";
            this.discount = 0;
            this.taxTotalAmount = 0;
            this.finalTotalAmount = 0;
            this.isWorking = false;

            this.transactionLines.push({}, {}, {});

            this.$store.dispatch("combo/setBtnID", "save");
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

            if (!this.basic_fields.trn_date) {
                this.form_errors.push(
                    this.$func.__("Transaction Date is required.", "erp")
                );
            }

            if (!this.basic_fields.due_date) {
                this.form_errors.push(this.$func.__("Due Date is required.", "erp"));
            }

            if (!parseFloat(this.finalTotalAmount)) {
                this.form_errors.push(this.$func.__("Total amount can't be zero.", "erp"));
            }

            if (this.noFulfillLines(this.transactionLines, "selectedProduct")) {
                this.form_errors.push(this.$func.__("Please select a product.", "erp"));
            }
        },
    },
};
</script>

<style>
tr.padded {
    height: 50px;
}

.discount-rate-row select {
    width: 235px;
    height: 34px;
}

.discount-rate-row input {
    width: 130px !important;
}

.discount-rate-row .discountType-box {
    display: flex;
    align-items: center;
}

.tax-rate-row .tax-rates {
    width: 235px;
    float: right;
}

.attachment-item {
    box-shadow: 0 0 0 1px rgba(76, 175, 80, 0.3);
    padding: 3px;
    position: relative;
    height: 58px;
    margin: 10px 0;
}
.attachment-item .remove-file {
    position: absolute;
    top: -10px;
    right: -10px;
    font-size: 13px;
    color: #fff;
    cursor: pointer;
    background: #f44336;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    text-align: center;
}

.attachment-item img {
    float: left;
}

.attachment-meta h3 {
    margin-left: 50px;
    text-align: left;
    line-height: 2;
}

.invoice-create .dropdown {
    width: 100%;
}

.invoice-create .col--products {
    width: 400px;
}

.invoice-create .col--qty {
    width: 80px;
}

.invoice-create .col--unit-price {
    width: 120px;
}

.invoice-create .col--amount {
    width: 200px;
}

.invoice-create .col--tax {
    text-align: center;
    width: 100px;
}

.invoice-create .product-select .with-multiselect .multiselect__select,
.invoice-create .with-multiselect .multiselect__tags {
    min-height: 33px !important;
    margin-top: 4px;
}

.invoice-create .with-multiselect .multiselect__placeholder {
    margin-top: 3px;
}

.invoice-create .invoice-create .erp-help-tip {
    color: #2f4f4f;
    font-size: 1.2em;
}

@media (max-width: 782px) {
    .invoice-create .col--qty input {
        padding: 5px !important;
    }

    .invoice-create .col--uni_price,
    .invoice-create .col--amount,
    .invoice-create .col--tax,
    .invoice-create .col--actions {
        display: table-cell !important;
        width: 10%;
    }
    .invoice-create .col--uni_price input,
    .invoice-create .col--amount input,
    .invoice-create .col--tax input,
    .invoice-create .col--actions input {
        padding: 5px !important;
    }

    .invoice-create
        tr:not(.inline-edit-row):not(.no-items)
        td:not(.column-primary)::before {
        display: none !important;
    }

    .invoice-create td {
        padding-left: 5px !important;
        padding-right: 5px !important;
    }
}
</style>
