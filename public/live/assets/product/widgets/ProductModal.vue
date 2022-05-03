<template>
    <div id="mybizna-product-modal">
        <div class="mybizna-container">
            <div class="mybizna-modal mybizna-modal-open has-form" role="dialog">
                <div class="mybizna-modal-dialog">
                    <div class="mybizna-modal-content">
                        <div class="mybizna-modal-header">
                            <h3 v-if="!product">
                                {{ this.$func.__("Add", "erp") }} {{ title }}
                            </h3>
                            <h3 v-else>
                                {{ this.$func.__("Update", "erp") }} {{ title }}
                            </h3>
                            <span class="modal-close">
                                <i
                                    class="flaticon-close"
                                    @click.prevent="$parent.$emit('close')"
                                ></i>
                            </span>
                        </div>
                        <div class="mybizna-modal-body">
                            <ul class="errors" v-if="error_msg.length">
                                <li
                                    v-for="(error, index) in error_msg"
                                    :key="index"
                                >
                                    * {{ error }}
                                </li>
                            </ul>
                            <!-- modal body title -->
                            <!-- add new product form -->
                            <form
                                action=""
                                method="post"
                                @submit.prevent="saveProduct"
                                class="add-product-form mybizna-form-horizontal"
                            >
                                <!-- product name field -->

                                <div class="mybizna-row">
                                    <div class="mybizna-col-sm-3 mybizna-col-xs-12">
                                        <label
                                            >{{ this.$func.__("Product Name", "erp") }}
                                            <span class="mybizna-required-sign"
                                                >*</span
                                            ></label
                                        >
                                    </div>
                                    <div class="mybizna-col-sm-9 mybizna-col-xs-12">
                                        <input
                                            type="text"
                                            class="mybizna-form-field"
                                            :placeholder="
                                                this.$func.__(
                                                    'Enter Product Name Here',
                                                    'erp'
                                                )
                                            "
                                            v-model="ProductFields.name"
                                            required
                                        />
                                    </div>
                                </div>

                                <!-- product/service details panel -->
                                <div
                                    class="mybizna-panel mybizna-panel-default panel-product-details"
                                >
                                    <div class="mybizna-panel-heading">
                                        <span
                                            class="panel-badge panel-badge-primary"
                                        ></span>
                                        <span>{{
                                            this.$func.__("Product/Service Details", "erp")
                                        }}</span>
                                    </div>
                                    <div class="mybizna-panel-body">
                                        <div class="mybizna-row">
                                            <div
                                                class="mybizna-col-sm-3 mybizna-col-xs-12"
                                            >
                                                <label
                                                    >{{
                                                        this.$func.__(
                                                            "Product Type",
                                                            "erp"
                                                        )
                                                    }}
                                                    <span
                                                        class="mybizna-required-sign"
                                                        >*</span
                                                    ></label
                                                >
                                            </div>
                                            <div
                                                class="mybizna-col-sm-9 mybizna-col-xs-12"
                                            >
                                                <div class="with-multiselect">
                                                    <multi-select
                                                        v-model="
                                                            ProductFields.type
                                                        "
                                                        :options="productType"
                                                        :disabled="false"
                                                        :multiple="false"
                                                    />
                                                    <!-- <i class="flaticon-arrow-down-sign-to-navigate"></i> -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mybizna-row">
                                            <div
                                                class="mybizna-col-sm-3 mybizna-col-xs-12"
                                            >
                                                <label>{{
                                                    this.$func.__("Category", "erp")
                                                }}</label>
                                            </div>
                                            <div
                                                class="mybizna-col-sm-9 mybizna-col-xs-12"
                                            >
                                                <div class="with-multiselect">
                                                    <multi-select
                                                        v-model="
                                                            ProductFields.categories
                                                        "
                                                        :options="categories"
                                                        :multiple="false"
                                                    />
                                                    <!-- <i class="flaticon-arrow-down-sign-to-navigate"></i> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- product/service details panel -->
                                <div
                                    class="mybizna-panel mybizna-panel-default panel-product-info"
                                >
                                    <div class="mybizna-panel-heading">
                                        <span
                                            class="panel-badge panel-badge-info"
                                        ></span>
                                        <span>{{
                                            this.$func.__("Product Information", "erp")
                                        }}</span>
                                    </div>
                                    <div class="mybizna-panel-body">
                                        <div class="mybizna-row">
                                            <div
                                                class="mybizna-col-sm-3 mybizna-col-xs-12"
                                            >
                                                <label for="cost-price">{{
                                                    this.$func.__("Cost Price", "erp")
                                                }}</label>
                                            </div>
                                            <div
                                                class="mybizna-col-sm-9 mybizna-col-xs-12"
                                            >
                                                <input
                                                    type="text"
                                                    name="cost-price"
                                                    id="cost-price"
                                                    value="0"
                                                    class="dk-form-field"
                                                    v-model="
                                                        ProductFields.costPrice
                                                    "
                                                />
                                            </div>
                                        </div>
                                        <div class="mybizna-row">
                                            <div
                                                class="mybizna-col-sm-3 mybizna-col-xs-12"
                                            >
                                                <label for="sale-price"
                                                    >{{
                                                        this.$func.__("Sale Price", "erp")
                                                    }}
                                                    <span
                                                        class="mybizna-required-sign"
                                                        >*</span
                                                    ></label
                                                >
                                            </div>
                                            <div
                                                class="mybizna-col-sm-9 mybizna-col-xs-12"
                                            >
                                                <input
                                                    type="text"
                                                    name="sale-price"
                                                    id="sale-price"
                                                    value="0"
                                                    class="dk-form-field"
                                                    v-model="
                                                        ProductFields.salePrice
                                                    "
                                                    required
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Miscellaneous panel -->
                                <div
                                    class="mybizna-panel mybizna-panel-default panel-miscellaneous"
                                >
                                    <div class="mybizna-panel-heading">
                                        <span
                                            class="panel-badge panel-badge-secondary"
                                        ></span>
                                        <span>{{
                                            this.$func.__("Miscellaneous", "erp")
                                        }}</span>
                                    </div>
                                    <div class="mybizna-panel-body">
                                        <div class="mybizna-row">
                                            <div
                                                class="mybizna-col-sm-3 mybizna-col-xs-12 product-owner"
                                            >
                                                <label>
                                                    {{ this.$func.__("Owner", "erp") }}
                                                    <span
                                                        v-show="selfOwner"
                                                        class="mybizna-required-sign"
                                                        >*</span
                                                    >
                                                </label>
                                            </div>
                                            <div
                                                class="mybizna-col-sm-9 mybizna-col-xs-12"
                                            >
                                                <input
                                                    type="checkbox"
                                                    v-model="selfOwner"
                                                    value="self"
                                                    :required="selfOwner"
                                                />
                                                {{ this.$func.__("self", "erp") }}
                                            </div>

                                            <div
                                                class="mybizna-col-sm-3 mybizna-col-xs-12"
                                                v-show="!selfOwner"
                                            >
                                                <label>
                                                    {{ this.$func.__("Vendor", "erp") }}
                                                    <span
                                                        class="mybizna-required-sign"
                                                        >*</span
                                                    >
                                                </label>
                                            </div>
                                            <div
                                                class="mybizna-col-sm-9 mybizna-col-xs-12"
                                                v-show="!selfOwner"
                                            >
                                                <div class="with-multiselect">
                                                    <multi-select
                                                        v-model="
                                                            ProductFields.vendor
                                                        "
                                                        :options="vendors"
                                                        :multiple="false"
                                                    />
                                                    <!-- <i class="flaticon-arrow-down-sign-to-navigate"></i> -->
                                                </div>
                                            </div>
                                            <div
                                                class="mybizna-col-sm-3 mybizna-col-xs-12"
                                            >
                                                <label
                                                    >{{
                                                        this.$func.__(
                                                            "Tax Category",
                                                            "erp"
                                                        )
                                                    }}
                                                    <span
                                                        class="erp-help-tip .erp-tips"
                                                        :title="
                                                            this.$func.__(
                                                                'Selecting tax category is important if you want to have tax on that product while selling.',
                                                                'erp'
                                                            )
                                                        "
                                                    ></span
                                                ></label>
                                            </div>
                                            <div
                                                class="mybizna-col-sm-9 mybizna-col-xs-12"
                                            >
                                                <div class="with-multiselect">
                                                    <multi-select
                                                        v-model="
                                                            ProductFields.tax_cat_id
                                                        "
                                                        :options="tax_cats"
                                                        :multiple="false"
                                                    />
                                                    <!-- <i class="flaticon-arrow-down-sign-to-navigate"></i> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- buttons -->
                                <div class="buttons-wrapper text-right">
                                    <button
                                        class="mybizna-btn btn--default"
                                        @click.prevent="$parent.$emit('close')"
                                    >
                                        {{ this.$func.__("Cancel", "erp") }}
                                    </button>
                                    <button
                                        v-if="!product"
                                        class="mybizna-btn btn--primary"
                                    >
                                        {{ this.$func.__("Save", "erp") }}
                                    </button>
                                    <button
                                        v-else
                                        class="mybizna-btn btn--primary"
                                    >
                                        {{ this.$func.__("Update", "erp") }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    components: {
        MultiSelect:window.$func.fetchComponent('components/select/MultiSelect.vue'),
    },

    props: {
        product: {
            type: Object,
            default: () => [],
        },
    },

    data() {
        return {
            error_msg: [],
            ProductFields: {
                id: null,
                name: "",
                type: 0,
                categories: 0,
                costPrice: 0,
                salePrice: 0,
                vendor: 0,
                tax_cat_id: 0,
            },
            vendors: [],
            categories: [],
            tax_cats: [],
            productType: [],
            title: this.$func.__("Product", "erp"),
            isDisabled: false,
            selfOwner: false,
        };
    },

    emits: {
        // Validate submit event
        "options-query": ({query}) => {
            if (query) {
                window.axios
                    .get("vendors", {
                        params: {
                            search: query,
                        },
                    })
                    .then((response) => {
                        if (response.data) {
                            this.vendors = [];
                            for (const i in response.data) {
                                var vendor = response.data[i];
                                var object = {
                                    id: vendor.id,
                                    name:
                                        vendor.first_name +
                                        " " +
                                        vendor.last_name,
                                };
                                this.vendors.push(object);
                            }
                        }
                    });
            }
            return true;
        },
    },
    created() {
        if (this.product) {
            const product = this.product;
            this.ProductFields.name = product.name;
            this.ProductFields.id = product.id;
            this.ProductFields.type = {
                id: product.product_type_id,
                name: product.product_type_name,
            };
            this.ProductFields.categories = {
                id: product.category_id,
                name: product.cat_name,
            };
            this.ProductFields.tax_cat_id = {
                id: product.tax_cat_id,
                name: product.tax_cat_name,
            };
            this.ProductFields.salePrice = product.sale_price;
            this.ProductFields.costPrice = product.cost_price;
            this.isDisabled = true;

            if (product.vendor) {
                this.ProductFields.vendor = {
                    id: product.vendor,
                    name: product.vendor_name,
                };
            } else {
                this.selfOwner = true;
                this.ProductFields.vendor = null;
            }
        }

        this.loaded();
    },

    methods: {
        saveProduct() {
            if (!this.checkForm()) {
                return false;
            }


            var type, url;

            if (!this.product) {
                type = "post";
                url = "products";
            } else {
                type = "put";
                url = "products/" + this.ProductFields.id;
            }

            var data = {
                name: this.ProductFields.name,
                product_type_id: this.ProductFields.type,
                category_id: this.ProductFields.categories,
                tax_cat_id: this.ProductFields.tax_cat_id,
                vendor: null,
                cost_price: this.ProductFields.costPrice,
                sale_price: this.ProductFields.salePrice,
            };

            if (!this.selfOwner) {
                data.vendor = this.ProductFields.vendor;
            }

            window.axios[type](url, data)
                .then((response) => {
                    this.$parent.$emit("close");
                    this.$parent.getProducts();
                    this.resetForm();
                    this.showAlert(
                        "success",
                        type === "put"
                            ? this.$func.__("Product Updated!", "erp")
                            : this.$func.__("Product Created!", "erp")
                    );
                })
                .catch((error) => {
                    this.showAlert("warning", error.response.data.message);
                });
        },

        loaded() {
            this.getVendors();
            this.getCategories();
            this.getTaxCategories();
            this.getProductTypes();
        },

        getVendors() {
            window.axios.get("vendors").then((response) => {
                if (response.data) {
                    for (const i in response.data) {
                        var vendor = response.data[i];
                        var object = {
                            id: vendor.id,
                            name: vendor.first_name + " " + vendor.last_name,
                        };
                        this.vendors.push(object);
                    }
                }
            });
        },

        getCategories() {
            window.axios.get("product-cats").then((response) => {
                this.categories = response.data;
            });
        },

        getTaxCategories() {
            window.axios.get("tax-cats").then((response) => {
                this.tax_cats = response.data;
            });
        },

        getProductTypes() {
            window.axios.get("products/types").then((response) => {
                this.productType = response.data;
            });
        },

        resetForm() {
            this.ProductFields.id = null;
            this.ProductFields.name = "";
            this.ProductFields.type = [];
            this.ProductFields.categories = [];
            this.ProductFields.vendor = [];
            this.ProductFields.costPrice = "";
            this.ProductFields.salePrice = "";
        },

        checkOwner() {
            if (this.selfOwner) {
                return true;
            }

            if (!this.ProductFields.vendor) {
                return false;
            }

            return true;
        },

        checkForm() {
            this.error_msg = [];

            if (
                this.ProductFields.name &&
                this.ProductFields.type &&
                this.checkOwner() &&
                this.ProductFields.salePrice
            ) {
                return true;
            }

            if (!this.ProductFields.name) {
                this.error_msg.push(this.$func.__("Product name is required", "erp"));
            }

            if (!this.ProductFields.type) {
                this.error_msg.push(this.$func.__("Product type is required", "erp"));
            }

            if (this.ProductFields.salePrice <= 0) {
                this.error_msg.push(
                    this.$func.__("Product sale price should be greater than 0", "erp")
                );
            }

            if (!this.selfOwner && !this.ProductFields.vendor) {
                this.error_msg.push(this.$func.__("Vendor is required", "erp"));
            }

            return false;
        },
    },
};
</script>

<style>
#mybizna-product-modal .mybizna-modal-header {
    padding: 30px 20px 20px !important;
}

#mybizna-product-modal .product-owner {
    margin-bottom: 10px;
}
#mybizna-product-modal .product-owner label {
    margin-top: 0;
}

#mybizna-product-modal .modal-close {
    line-height: 1.7;
}
#mybizna-product-modal .modal-close .flaticon-close {
    font-size: inherit;
}

#mybizna-product-modal .errors {
    margin: 0;
    color: #f44336;
}
#mybizna-product-modal .errors li {
    background: #f3f3f3;
    padding: 2px 10px;
}
</style>
