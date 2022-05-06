<template>
    <div
        id="tax-category-modal"
        class="modal has-form modal-open"
        role="dialog"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- modal body title -->
                <div class="modal-header">
                    <h3>
                        {{ is_update ? this.$func.__("Edit", "erp") : this.$func.__("Add", "erp") }}
                        {{ this.$func.__("Tax Category", "erp") }}
                    </h3>
                    <span class="modal-close" @click.prevent="closeModal"
                        ><i class="flaticon-close"></i
                    ></span>
                </div>

                <show-errors :error_msgs="form_errors"></show-errors>
                <!-- end modal body title -->
                <form
                    action=""
                    method="post"
                    class="modal-form edit-customer-modal"
                    @submit.prevent="taxCatFormSubmit"
                >
                    <div class="modal-body">
                        <div class="form-group">
                            <label
                                >{{ this.$func.__("Tax Category Name", "erp") }}
                                <span class="required-sign"
                                    >*</span
                                ></label
                            >
                            <!--<multi-select v-model="category" :options="categories" />-->
                            <input
                                type="text"
                                v-model="category"
                                class="form-control form-contro-sm form-field required-sign"
                                required
                            />
                        </div>

                        <div class="form-group mb-0">
                            <label>{{ this.$func.__("Description", "erp") }}</label>
                            <textarea
                                v-model="desc"
                                rows="4"
                                class="form-control form-contro-sm form-field"
                                maxlength="250"
                            ></textarea>
                        </div>
                    </div>

                    <div class="modal-footer pt-0">
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
        cat_id: {
            type: [Number, String],
        },
        is_update: {
            type: Boolean,
        },
    },

    data() {
        return {
            categories: [],
            category: null,
            desc: null,
            isWorking: false,
            form_errors: [],
        };
    },

    created() {
        if (this.is_update) {
            this.getCategory();
        }
    },

    methods: {
        closeModal: function () {
            this.$emit("close");
            this.$root.$emit("modal_closed");
        },

        getCategory() {
            window.axios.get(`/tax-cats/${this.cat_id}`).then((response) => {
                this.category = response.data.name;
                this.desc = response.data.description;
            });
        },

        taxCatFormSubmit() {
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
                url = `/tax-cats/${this.cat_id}`;
                msg = this.$func.__("Tax Category Updated!", "erp");
            } else {
                rest = "post";
                url = `/tax-cats`;
                msg = this.$func.__("Tax Category Created!", "erp");
            }


            window.axios[rest](url, {
                name: this.category,
                description: this.desc,
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

            if (!this.category) {
                this.form_errors.push(
                    this.$func.__("Tax Category Name is required.", "erp")
                );
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
