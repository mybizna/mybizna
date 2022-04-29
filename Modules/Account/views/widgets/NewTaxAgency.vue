<template>
    <div
        id="mybizna-tax-agency-modal"
        class="mybizna-modal has-form mybizna-modal-open"
        role="dialog"
    >
        <div class="mybizna-modal-dialog">
            <div class="mybizna-modal-content">
                <!-- modal body title -->
                <div class="mybizna-modal-header">
                    <h3>
                        {{
                            is_update
                                ? this.$func.__("Edit", "erp")
                                : this.$func.__("Add", "erp")
                        }}
                        {{ this.$func.__("Tax Agency", "erp") }}
                    </h3>
                    <span class="modal-close" @click.prevent="closeModal"
                        ><i class="flaticon-close"></i
                    ></span>
                </div>

                <show-errors :error_msgs="form_errors" />
                <!-- end modal body title -->
                <form
                    action=""
                    method="post"
                    class="modal-form edit-customer-modal"
                    @submit.prevent="taxAgencyFormSubmit"
                >
                    <div class="mybizna-modal-body">
                        <div class="mybizna-form-group">
                            <label
                                >{{ this.$func.__("Tax Agency Name", "erp")
                                }}<span class="mybizna-required-sign"
                                    >*</span
                                ></label
                            >
                            <!--<multi-select v-model="agency" :options="agencies" />-->
                            <input
                                type="text"
                                v-model="agency"
                                class="mybizna-form-field"
                            />
                        </div>
                    </div>

                    <div class="mybizna-modal-footer pt-0">
                        <!-- buttons -->
                        <div class="buttons-wrapper text-right">
                            <submit-button
                                v-if="is_update"
                                :text="__('Update', 'erp')"
                                :working="isWorking"
                            ></submit-button>
                            <submit-button
                                v-else
                                :text="__('Save', 'erp')"
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
import SubmitButton from "assets/components/base/SubmitButton.vue";
import ShowErrors from "assets/components/base/ShowErrors.vue";

export default {
    components: {
        SubmitButton,
        ShowErrors,
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
                this.form_errors.push(__("Agency Name is required.", "erp"));
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
