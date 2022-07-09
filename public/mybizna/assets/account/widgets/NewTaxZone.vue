<template>
    <div
        id="tax-agency-modal"
        class="modal has-form modal-open"
        role="dialog"
    >
        <div >
            <div >
                <!-- modal body title -->
                <div >
                    <h3>
                        {{
                            is_update
                                ? this.$func.__("Edit", "erp")
                                : this.$func.__("Add", "erp")
                        }}
                        {{ this.$func.__("Tax Zone", "erp") }}
                    </h3>
                    <span  @click.prevent="closeModal"
                        ><i class="flaticon-close"></i
                    ></span>
                </div>
                <!-- end modal body title -->
                <show-errors :error_msgs="form_errors"></show-errors>

                <form
                    method="post"
                    class="edit-customer-modal"
                    @submit.prevent="taxZoneFormSubmit"
                >
                    <div >
                        <div class="form-group">
                            <label
                                >{{ this.$func.__("Tax Zone Name", "erp") }}
                                <span class="required-sign"
                                    >*</span
                                ></label
                            >
                            <input
                                type="text"
                                v-model="rate_name"
                                class="form-control form-contro-sm form-field"
                                required
                            />
                        </div>

                        <div class="form-group">
                            <label>{{
                                this.$func.__("Tax Number", "erp")
                            }}</label>
                            <input
                                type="text"
                                v-model="tax_number"
                                class="form-control form-contro-sm form-field"
                                :placeholder="this.$func.__('Enter Tax Number')"
                            />
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input
                                    type="checkbox"
                                    v-model="is_default"
                                    class="form-check-input"
                                />
                                <span class="form-check-sign"></span>
                                <span class="field-label"
                                    >{{
                                        this.$func.__(
                                            "Is this tax default",
                                            "erp"
                                        )
                                    }}?</span
                                >
                            </label>
                        </div>
                    </div>

                    <div class="pt-0">
                        <!-- buttons -->
                        <div class="buttons-wrapper text-right">
                            <submit-button
                                v-if="is_update"
                                :text="this.$func.__('Update')"
                                :working="isWorking"
                            ></submit-button>
                            <submit-button
                                v-else
                                :text="this.$func.__('Save')"
                                :working="isWorking"
                            ></submit-button>
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
        SubmitButton: window.$func.fetchComponent('components/base/SubmitButton.vue'),
        ShowErrors: window.$func.fetchComponent('components/base/ShowErrors.vue'),
    },

    props: {
        rate_name_id: {
            type: [Number, String],
        },
        is_update: {
            type: Boolean,
            default: false,
        },
    },

    data() {
        return {
            tax_number: "",
            is_default: false,
            rate_name: "",
            isWorking: false,
            form_errors: [],
        };
    },

    created() {
        if (this.is_update) {
            this.getRateName();
        }
    },

    methods: {
        closeModal() {
            this.$emit("close");
            this.$root.$emit("modal_closed");
        },

        getRateName() {
            window.axios
                .get(`/tax-rate-names/${this.rate_name_id}`)
                .then((response) => {
                    this.rate_name = response.data.tax_rate_name;
                    this.is_default = response.data.default === "1";
                    this.tax_number = response.data.tax_number;
                });
        },

        taxZoneFormSubmit() {
            this.validateForm();

            if (this.form_errors.length) {
                window.scrollTo({
                    top: 10,
                    behavior: "smooth",
                });

                return;
            }

            var rest, url, msg;

            if (this.is_update) {
                rest = "put";
                url = `/tax-rate-names/${this.rate_name_id}`;
                msg = this.$func.__("Tax Zone Updated!", "erp");
            } else {
                rest = "post";
                url = `/tax-rate-names`;
                msg = this.$func.__("Tax Zone Created!", "erp");
            }

            window.axios[rest](url, {
                tax_rate_name: this.rate_name,
                tax_number: this.tax_number,
                default: this.is_default,
            })
                .catch((error) => {
                    throw error;
                })
                .then((res) => {
                    this.showAlert("success", msg);
                })
                .then(() => {
                    this.resetData();
                    this.isWorking = false;
                    this.$emit("close");
                    this.$root.$emit("refetch_tax_data");
                });
        },

        validateForm() {
            this.form_errors = [];

            if (!this.rate_name) {
                this.form_errors.push(this.$func.__("Tax Zone Name is required.", "erp"));
            }
        },

        resetData() {
            Object.assign(this.$data, this.$options.data.call(this));
        },
    },
};
</script>

<style>
.modal-close .flaticon-close {
    font-size: inherit;
}
</style>
