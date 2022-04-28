<template>
    <div
        id="mybizna-tax-category-modal"
        class="mybizna-modal has-form mybizna-modal-open"
        role="dialog"
    >
        <div class="mybizna-modal-dialog">
            <div class="mybizna-modal-content">
                <!-- modal body title -->
                <div class="mybizna-modal-header">
                    <h3>
                        {{ is_update ? window.$func.__("Edit", "erp") : window.$func.__("Add", "erp") }}
                        {{ window.$func.__("Tax Category", "erp") }}
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
                    <div class="mybizna-modal-body">
                        <div class="mybizna-form-group">
                            <label
                                >{{ window.$func.__("Tax Category Name", "erp") }}
                                <span class="mybizna-required-sign"
                                    >*</span
                                ></label
                            >
                            <!--<multi-select v-model="category" :options="categories" />-->
                            <input
                                type="text"
                                v-model="category"
                                class="mybizna-form-field mybizna-required-sign"
                                required
                            />
                        </div>

                        <div class="mybizna-form-group mb-0">
                            <label>{{ window.$func.__("Description", "erp") }}</label>
                            <textarea
                                v-model="desc"
                                rows="4"
                                class="mybizna-form-field"
                                maxlength="250"
                            ></textarea>
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
                msg = window.$func.__("Tax Category Updated!", "erp");
            } else {
                rest = "post";
                url = `/tax-cats`;
                msg = window.$func.__("Tax Category Created!", "erp");
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
                    window.$func.__("Tax Category Name is required.", "erp")
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
