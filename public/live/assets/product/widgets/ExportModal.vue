<template>
    <div id="product-export-modal">
        <div class="container">
            <div
                id="import-customer-modal"
                class="modal has-form modal-open"
                role="dialog"
            >
                <div >
                    <div >
                        <div >
                            <h3>{{ this.$func.__("Export Products", "erp") }}</h3>
                            <span >
                                <i
                                    class="flaticon-close"
                                    @click="$parent.$emit('close')"
                                ></i>
                            </span>
                        </div>

                        <form
                            action=""
                            method="post"
                            class="edit-customer-modal"
                            id="export_form"
                        >
                            <div >
                                <div class="erp-grid-container">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="fields">
                                                <h3>
                                                    {{
                                                        this.$func.__(
                                                            "Select product fields to export",
                                                            "erp"
                                                        )
                                                    }}
                                                    <span class="required">
                                                        *</span
                                                    >
                                                </h3>
                                            </label>
                                        </div>

                                        <div class="col-3">
                                            <h3>
                                                <input
                                                    type="checkbox"
                                                    id="selecctall"
                                                    @change.prevent="
                                                        selectFields
                                                    "
                                                />
                                                {{ this.$func.__("Select all", "erp") }}
                                            </h3>
                                        </div>
                                    </div>

                                    <div class="row" id="fields">
                                        <div
                                            v-for="(
                                                field, key
                                            ) in productsFields"
                                            :key="key"
                                            class="col-2"
                                        >
                                            <label>
                                                <input
                                                    type="checkbox"
                                                    name="fields[]"
                                                    :value="field"
                                                    :checked="selectAll"
                                                />
                                                {{ strTitleCase(field) }}
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row"></div>

                                    <div class="row">
                                        <p class="description">
                                            {{
                                                this.$func.__(
                                                    "**Only selected fields will be on the csv file.",
                                                    "erp"
                                                )
                                            }}
                                        </p>
                                    </div>
                                </div>

                                <input
                                    type="hidden"
                                    name="type"
                                    :value="exportType"
                                />
                                <input
                                    type="hidden"
                                    name="export_csv"
                                    value="1"
                                />
                                <input
                                    type="hidden"
                                    name="_wpnonce"
                                    :value="nonce"
                                />
                            </div>

                            <div class="pt-0">
                                <div class="buttons-wrapper text-right">
                                    <button
                                        class="btn btn-default modal-close"
                                        @click="$parent.$emit('close')"
                                        type="reset"
                                    >
                                        {{ this.$func.__("Cancel", "erp") }}
                                    </button>
                                    <button
                                        class="btn btn-primary"
                                        type="submit"
                                    >
                                        {{ this.$func.__("Export", "erp") }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            productsFields: [],
            nonce: "",
            description: "",
            exportType: "product",
            selectAll: false,
        };
    },

    created() {
        this.productsFields = this.$mybizna_var.fields
            ? this.$mybizna_var.fields[this.exportType].fields
            : [];
        this.nonce = this.$mybizna_var.export_import_nonce;
    },

    methods: {
        selectFields() {
            this.selectAll = !this.selectAll;
        },

        strTitleCase(string) {
            var str = string.toString().replace(/_/g, " ");

            return str
                .toLowerCase()
                .split(" ")
                .map((word) => {
                    return word.charAt(0).toUpperCase() + word.slice(1);
                })
                .join(" ");
        },
    },
};
</script>

<style>
.modal-close .flaticon-close {
    font-size: inherit;
}

.description {
    color: grey;
}
</style>
