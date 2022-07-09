<template>
    <div class="products">
        <div class="products-header">
            <h2 class="add-new-product">
                <span>{{ this.$func.__("Products", "erp") }}</span>
                <a
                    href=""
                    id="erp-product-new"
                    @click.prevent="showModal = true"
                    >{{ this.$func.__("Add New", "erp") }}</a
                >
            </h2>

            <div class="erp-btn-group">
                <button @click.prevent="showImportModal = true">
                    {{ this.$func.__("Import", "erp") }}
                </button>
                <button @click.prevent="showExportModal = true">
                    {{ this.$func.__("Export", "erp") }}
                </button>
            </div>

            <!-- top search bar -->
            <product-search v-model="search" />
        </div>

        <product-modal v-if="showModal" :product.sync="product" />

        <export-modal v-if="showExportModal" />

        <import-modal v-if="showImportModal" />

        <list-table
            tableClass="table table-sm table-striped widefat table2 product-list"
            action-column="actions"
            :columns="columns"
            :rows="products"
            :bulk-actions="bulkActions"
            @action:click="onActionClick"
            @bulk:click="onBulkAction"
            :total-items="paginationData.totalItems"
            :total-pages="paginationData.totalPages"
            :per-page="paginationData.perPage"
            :current-page="paginationData.currentPage"
            @pagination="goToPage"
            :actions="[
                { key: 'edit', label: this.$func.__('Edit') },
                { key: 'trash', label: this.$func.__('Delete') },
            ]"
        >
        </list-table>
    </div>
</template>

<script>
export default {
    components: {
        ListTable: window.$func.fetchComponent(
            "components/common/ListTable.vue"
        ),
        ProductModal: window.$func.fetchComponent(
            "components/ProductModal.vue"
        ),
        ExportModal: window.$func.fetchComponent("components/Search.vue"),
        ImportModal: window.$func.fetchComponent("components/ExportModal.vue"),
        ProductSearch: window.$func.fetchComponent(
            "components/ImportModal.vue"
        ),
    },

    data() {
        return {
            products: [],
            product: null,
            search: "",
            showModal: false,
            columns: {
                name: {
                    label: this.$func.__("Product Name", "erp"),
                    isColPrimary: true,
                },
                sale_price: {
                    label: this.$func.__("Sale Price", "erp"),
                },
                cost_price: {
                    label: this.$func.__("Cost Price", "erp"),
                },
                cat_name: {
                    label: this.$func.__("Product Category", "erp"),
                },
                tax_cat_name: {
                    label: this.$func.__("Tax Category", "erp"),
                },
                product_type_name: {
                    label: this.$func.__("Product Type", "erp"),
                },
                vendor_name: {
                    label: this.$func.__("Vendor", "erp"),
                },
                actions: {
                    label: this.$func.__("Actions", "erp"),
                },
            },
            bulkActions: [
                {
                    key: "trash",
                    label: this.$func.__("Move to Trash", "erp"),
                    img:
                        this.$mybizna_var.assets +
                        "/images/trash.png" /* global this.$mybizna_var */,
                },
            ],
            paginationData: {
                totalItems: 0,
                totalPages: 0,
                perPage: 20,
                currentPage:
                    this.$route.params.page === undefined
                        ? 1
                        : parseInt(this.$route.params.page),
            },
            showExportModal: false,
            showImportModal: false,
        };
    },

    emits: {
        // Validate submit event
        close: () => {
            this.showModal = false;
            this.showImportModal = false;
            this.showExportModal = false;
            this.product = null;
            return true;
        },
        "imported-products": () => {
            this.showImportModal = false;
            this.getProducts();
            return true;
        },
    },
    created() {
        this.getProducts();


    watch: {
        search(newVal, oldVal) {
            this.getProducts();
        },
    },

    methods: {
        getProducts() {
            this.products = [];

            window.axios
                .get("/products", {
                    params: {
                        per_page: this.paginationData.perPage,
                        page:
                            this.$route.params.page === undefined
                                ? this.paginationData.currentPage
                                : this.$route.params.page,
                        s: this.search,
                    },
                })
                .then((response) => {
                    this.products = response.data;

                    this.paginationData.totalItems = parseInt(
                        response.headers["x-wp-total"]
                    );
                    this.paginationData.totalPages = parseInt(
                        response.headers["x-wp-totalpages"]
                    );
                })
                .catch((error) => {
                    throw error;
                });
        },

        onActionClick(action, row, index) {
            if (action === "edit") {
                this.showModal = true;
                this.product = row;
            } else if (action === "trash") {
                if (
                    confirm(
                        this.$func.__("Are you sure want to delete?", "erp")
                    )
                ) {
                    window.axios
                        .delete("products/" + row.id)
                        .then((response) => {
                            this.$delete(this.products, index);
                            this.getProducts();
                        })
                        .catch((error) => {
                            throw error;
                        });
                }
            }
        },

        onBulkAction(action, items) {
            if (action === "trash") {
                if (
                    confirm(
                        this.$func.__("Are you sure want to delete?", "erp")
                    )
                ) {
                    window.axios
                        .delete("products/delete/" + items)
                        .then((response) => {
                            const toggleCheckbox =
                                document.getElementsByClassName("column-cb")[0]
                                    .childNodes[0];

                            if (toggleCheckbox.checked) {
                                toggleCheckbox.click();
                            }
                            this.getProducts();
                        })
                        .catch((error) => {
                            throw error;
                        });
                }
            }
        },

        goToPage(page) {
            const queries = Object.assign({}, this.$route.query);
            this.paginationData.currentPage = page;
            this.$router.push({
                name: "PaginateProducts",
                params: { page: page },
                query: queries,
            });

            this.getProducts();
        },
    },
};
</script>

<style>
.products .products-header {
    display: flex;
    align-items: center;
}
.products .products-header .add-new-product {
    margin-top: 15px;
    align-items: center;
    display: flex;
}
.products .products-header .add-new-product span {
    font-size: 18px;
    font-weight: bold;
}

.products .products-header .add-new-product a {
    background: #1a9ed4;
    border-radius: 3px;
    color: #fff;
    font-size: 12px;
    height: 29px;
    line-height: 29px;
    margin-left: 13px;
    text-align: center;
    text-decoration: none;
    width: 80px !important;
}
@media (max-width: 782px) and (min-width: 768px) {
    .products .products-header .add-new-product a {
        margin-right: 18rem;
        margin-bottom: 3px;
        max-width: 120px;
    }
}

@media (max-width: 767px) and (min-width: 707px) {
    .products .products-header .add-new-product a {
        margin-right: 16rem;
        margin-bottom: 3px;
    }
}

@media (max-width: 706px) and (min-width: 651px) {
    .products .products-header .add-new-product a {
        margin-right: 14rem;
        margin-bottom: 3px;
    }
}

@media (max-width: 650px) {
    .products .products-header .add-new-product a {
        margin-right: 12rem;
        margin-bottom: 3px;
    }
}

.products .products-header .check-column {
    padding: 20px !important;
}

@media (min-width: 783px) {
    .products .products-header .product-list .col--actions {
        float: left !important;
    }
    .products .products-header .product-list .row-actions {
        text-align: left !important;
    }
}

@media (max-width: 650px) {
    .search-btn {
        display: none;
    }
}

@media (max-width: 479px) {
    .people-search {
        margin-top: 20px;
    }
}
</style>
