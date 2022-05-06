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
                        {{ this.$func.__("Tax Agency", "erp") }}
                    </h3>
                    <span  @click.prevent="closeModal"
                        ><i class="flaticon-close"></i
                    ></span>
                </div>

                <show-errors :error_msgs="form_errors" />
                <!-- end modal body title -->
                <form
                    action=""
                    method="post"
                    class="edit-customer-modal"
                    @submit.prevent="taxAgencyFormSubmit"
                >
                    <div>
                        <div class="form-group">
                            <label
                                >{{ this.$func.__("Tax Agency Name", "erp")
                                }}<span class="required-sign"
                                    >*</span
                                ></label
                            >
                            <!--<multi-select v-model="agency" :options="agencies" />-->
                            <input
                                type="text"
                                v-model="agency"
                                class="form-control form-contro-sm form-field"
                            />
                        </div>
                    </div>

                    <div class="pt-0">
                        <!-- buttons -->
                        <div class="buttons-wrapper text-right">
                            <submit-button
                                v-if="is_update"
                                :text="this.$func.__('Update', 'erp')"
                                :working="isWorking"
                            ></submit-button>
                            <submit-button
                                v-else
                                :text="this.$func.__('Save', 'erp')"
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
        agency_id: {
            type: [Number, String],
        },
        is_update: {
            type: Boolean,
        },
    },

    data() {
        return {
            agencies: [],
            agency: null,
            isWorking: false,
            form_errors: [],
        };
    },

    created() {
        if (this.is_update) {
            this.getAgency();
        }
    },

    methods: {
        closeModal: function () {
            this.$emit("close");
            this.$root.$emit("modal_closed");
        },

        getAgency() {
            window.axios
                .get(`/tax-agencies/${this.agency_id}`)
                .then((response) => {
                    this.agency = response.data.name;
                });
        },

        taxAgencyFormSubmit() {
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
                url = `/tax-agencies/${this.agency_id}`;
                msg = this.$func.__("Tax Agency Updated!", "erp");
            } else {
                rest = "post";
                url = `/tax-agencies`;
                msg = this.$func.__("Tax Agency Created!", "erp");
            }

            window.axios[rest](url, {
                agency_name: this.agency,
            })
                .catch((error) => {
                    throw error;
                })
                .then((res) => {
u                    this.showAlert("success", msg);
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

            if (!this.agency) {
                this.form_errors.push(this.$func.__("Agency Name is required.", "erp"));
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
