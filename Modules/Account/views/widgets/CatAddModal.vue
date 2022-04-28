<template>
    <div
        class="mybizna-modal mybizna-modal-open mybizna-invoice-modal mybizna-custom-scroll"
        role="dialog"
    >
        <div
            class="mybizna-modal-dialog"
            v-click-outside="outside"
            @click="inside"
        >
            <div class="mybizna-modal-content">
                <div class="mybizna-modal-header">
                    <h4>{{ `${catData.title} window.$func.__('Category', 'erp')` }}</h4>
                </div>
                <div class="mybizna-modal-body">
                    <form
                        action=""
                        class="ledger-cat-form"
                        @submit.prevent="saveCategory"
                    >
                        <div class="form-row" v-if="error">
                            <p class="error-message">{{ error }}</p>
                        </div>

                        <div class="form-row">
                            <label for="">{{
                                window.$func.__("Parent Category (optional)", "erp")
                            }}</label>
                            <treeselect
                                v-model="parent"
                                :options="categories"
                                :disable-branch-nodes="true"
                                :show-count="true"
                                :placeholder="
                                    window.$func.__('Please select a category', 'erp')
                                "
                            />
                        </div>

                        <div class="form-row">
                            <label for="">{{
                                window.$func.__("Name of Category", "erp")
                            }}</label>

                            <input type="text" v-model="category" required />
                        </div>

                        <div class="mybizna-modal-footer pt-0">
                            <div class="buttons-wrapper text-right">
                                <button
                                    class="mybizna-btn btn--default modal-close"
                                    @click.prevent="outside"
                                >
                                    {{ window.$func.__("Cancel", "erp") }}
                                </button>
                                <button
                                    class="mybizna-btn btn--primary"
                                    type="submit"
                                >
                                    <template v-if="catData.node">
                                        {{
                                            isCatSaving
                                                ? window.$func.__("Updating...", "erp")
                                                : window.$func.__("Update", "erp")
                                        }}
                                    </template>
                                    <template v-else>
                                        {{
                                            isCatSaving
                                                ? window.$func.__("Saving...", "erp")
                                                : window.$func.__("Save", "erp")
                                        }}
                                    </template>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Treeselect from "@riophae/vue-treeselect";

export default {
    data() {
        return {
            error: false,
            parent: null,
            category: "",
            isCatSaving: false,
        };
    },

    props: {
        categories: {
            type: Array,
        },

        catData: {
            type: Object,
        },
    },

    components: {
        Treeselect,
    },

    created() {
        if (this.catData.node) {
            if (this.catData.node.ancestors.length) {
                this.parent = this.catData.node.ancestors[0].id;
            }
            this.category = this.catData.node.label;
        }
    },

    methods: {
        inside() {},

        outside() {
            this.$root.$emit("cat-modal-close");
        },

        saveCategory() {
            this.error = false;
            this.isCatSaving = true;

            // Optimize later
            if (this.catData.node) {
                // Updating
                window.axios
                    .put(`/ledgers/categories/${this.catData.node.id}`, {
                        parent: this.parent,
                        name: this.category,
                    })
                    .then((response) => {
                        this.parent = null;
                        this.category = "";

                        this.$root.$emit("category-created");
                    })
                    .catch((err) => {

                        this.category = "";
                        this.isCatSaving = false;
                        // Error message
                        this.error = err.response.data.message;
                    })
                    .then(() => {
                        this.isCatSaving = false;
                    });
            } else {
                // Creating
                window.axios
                    .post("/ledgers/categories", {
                        parent: this.parent,
                        name: this.category,
                    })
                    .then((response) => {
                        this.parent = null;
                        this.category = "";

                        this.$root.$emit("category-created");
                    })
                    .catch((err) => {
                        this.category = "";
                        this.isCatSaving = false;
                        // Error message
                        this.error = err.response.data.message;
                    })
                    .then(() => {
                        this.isCatSaving = false;
                    });
            }
        },
    },
};
</script>

<style>
.ledger-cat-form {
    padding-top: 20px;
    min-height: 300px;
}
.ledger-cat-form .form-row {
    padding-bottom: 20px;
}

.ledger-cat-form .buttons-wrapper {
    padding-top: 20px;
}
</style>
