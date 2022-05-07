<template>
    <div>
        <div class="categories">
            <div id="col-left">
                <div class="col-wrap">
                    <div class="form-wrap">
                        <h2>{{ this.$func.__("Add new category", "erp") }}</h2>
                        <form id="erp-acct-product-category">
                            <div
                                :class="[
                                    'form-control form-contro-sm form-field term-name-wrap',
                                    { 'form-invalid': error },
                                ]"
                            >
                                <label>{{
                                    this.$func.__("Category Name", "erp")
                                }}</label>
                                <input
                                    type="text"
                                    class="form-control form-contro-sm form-field"
                                    v-model="categoryName"
                                />
                            </div>
                            <div class="form-control form-contro-sm form-field">
                                <label>{{
                                    this.$func.__("Parent Category", "erp")
                                }}</label>
                                <div class="with-multiselect">
                                    <multi-select
                                        v-model="parentCategory"
                                        :options="categories"
                                        :multiple="false"
                                    />
                                    <!-- <i class="flaticon-arrow-down-sign-to-navigate"></i> -->
                                </div>
                            </div>
                            <div class="buttons-wrapper">
                                <input
                                    type="submit"
                                    :value="this.$func.__('Save', 'erp')"
                                    class="btn btn-primary text-left"
                                    @click.prevent="createCategory"
                                />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="col-right" style="margin-top: 12px">
                <div class="col-wrap">
                    <list-table
                        class="table table-striped widefat table2 category-list"
                        action-column="actions"
                        :columns="columns"
                        :rows="categories"
                        :actions="actions"
                        :bulk-actions="bulkActions"
                        :showCb="false"
                        @action:click="onActionClick"
                        @bulk:click="onBulkAction"
                    >
                        >
                        <template
                            slot="name"
                            slot-scope="data"
                            v-if="data.row.isEdit"
                        >
                            <input
                                type="text"
                                class="form-control form-contro-sm form-field"
                                :value="data.row.name"
                                :id="'cat-' + data.row.id"
                            />
                            <!-- <multi-select
                                v-model="data.row.parent"
                                :options="categories"
                                :multiple="false"/>-->
                            <div
                                class="buttons-wrapper text-right"
                                style="margin-top: 10px"
                            >
                                <button
                                    class="btn btn-primary"
                                    @click="updateCategory(data.row)"
                                >
                                    {{ this.$func.__("Update", "erp") }}
                                </button>
                                <button
                                    class="btn btn-default"
                                    @click.prevent="data.row.isEdit = false"
                                >
                                    {{ this.$func.__("Cancel", "erp") }}
                                </button>
                            </div>
                        </template>
                    </list-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    components: {
        ListTable: window.$func.fetchComponent('components/list-table/ListTable.vue'),
        MultiSelect: window.$func.fetchComponent('components/select/MultiSelect.vue'),
    },

    data() {
        return {
            categories: [],
            categoryName: "",
            parentCategory: 0,
            category: null,
            error: false,
            showModal: false,
            columns: {
                name: {
                    label: this.$func.__("Category Name", "erp"),
                    isColPrimary: true,
                },
                actions: {
                    label: this.$func.__("Actions", "erp"),
                },
            },
            actions: [
                { key: "edit", label: this.$func.__("Edit", "erp") },
                { key: "trash", label: this.$func.__("Delete", "erp") },
            ],
            bulkActions: [
                {
                    key: "trash",
                    label: this.$func.__("Move to Trash", "erp"),
                    img:
                        this.$mybizna_var.erp_assets +
                        "/images/trash.png" /* global this.$mybizna_var */,
                },
            ],
        };
    },

    emits: {
        // Validate submit event
        "close": () => {
            this.showModal = false;
            return true;
        },
    },
    created() {
        this.getCategories();
    },
    methods: {
        getCategories() {
            window.axios
                .get("product-cats")
                .then((response) => {
                    const categories = response.data;
                    for (const x in categories) {
                        const category = categories[x];
                        const object = {
                            id: category.id,
                            name: category.name,
                            isEdit: false,
                        };
                        this.categories.push(object);
                    }
                })
                .catch((error) => {
                    throw error;
                });
        },

        onActionClick(action, row, index) {
            if (action === "edit") {
                row.isEdit = true;
                this.category = row;
            } else if (action === "trash") {
                if (confirm(this.$func.__("Are you sure want to delete?", "erp"))) {
                    window.axios
                        .delete("product-cats/" + row.id)
                        .then((response) => {
                            this.$delete(this.categories, index);

                            this.showAlert(
                                "success",
                                this.$func.__("Deleted !", "erp")
                            );
                        })
                        .catch((error) => {
                            throw error;
                        });
                }
            }
        },

        onBulkAction(action, items) {
            if (action === "trash") {
                if (confirm(this.$func.__("Are you sure want to delete?", "erp"))) {

                    window.axios
                        .delete("product-cats/delete/" + items)
                        .then((response) => {
                            const toggleCheckbox =
                                document.getElementsByClassName("column-cb")[0]
                                    .childNodes[0];

                            if (toggleCheckbox.checked) {
                                toggleCheckbox.click();
                            }
                            this.categories = this.categories.filter((item) => {
                                return items.indexOf(item.id) === -1;
                            });
                        })
                        .catch((error) => {
                            throw error;
                        });
                }
            }
        },

        createCategory() {
            if (this.categoryName === "") {
                this.error = true;
                return;
            }

            var data = {
                name: this.categoryName,
                parent: this.parentCategory,
            };
            window.axios
                .post("/product-cats", data)
                .then((response) => {
                    this.categories.push(response.data);
                    this.categoryName = "";
                    this.parentCategory = 0;

                    this.showAlert(
                        "success",
                        this.$func.__("Product category added!", "erp")
                    );
                })
                .catch((error) => {
                    throw error;
                });
        },

        updateCategory(row) {
            var categoryName = document.getElementById("cat-" + row.id).value;
            var categoryId = row.id;

            window.axios
                .put("/product-cats/" + categoryId, { name: categoryName })
                .then((response) => {
                    row.name = categoryName;

                    this.showAlert(
                        "success",
                        this.$func.__("Product category updated!", "erp")
                    );
                })
                .catch((error) => {
                    row.isEdit = false;
                    throw error;
                });
        },
    },
};
</script>

<style>
.categories .category-list {
    background-color: transparent;
}
.categories .category-list th ul,
.categories .category-list th li {
    margin: 0;
}

.categories .category-list th li {
    display: flex;
    align-items: center;
}
.categories .category-list th li img {
    width: 20px;
    padding-right: 5px;
}
.categories .category-list .name {
    width: 80% !important;
}

.categories .category-list .check-column {
    padding: 20px !important;
}

@media (min-width: 783px) {
    .categories .category-list th ul .row-actions,
    .categories .category-list th li .col--actions {
        float: left !important;
    }
    .categories .category-list th ul .row-actions,
    .categories .category-list th li.row-actions {
        text-align: left !important;
    }
}

.categories .category-list .buttons-wrapper .btn {
    margin-left: 0 !important;
}

.categories .category-list .with-multiselect {
    width: 60%;
}
</style>
