<template>
    <div
        class="modal modal-open invoice-modal custom-scroll"
        role="dialog"
    >
        <div
            
            v-click-outside="outside"
            @click="inside"
        >
            <div >
                <div >
                    <h4>{{ `${catData.title} this.$func.__('Category')` }}</h4>
                </div>
                <div>
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
                                this.$func.__("Parent Category (optional)", "erp")
                            }}</label>
                            <treeselect
                                v-model="parent"
                                :options="categories"
                                :disable-branch-nodes="true"
                                :show-count="true"
                                :placeholder="
                                    this.$func.__('Please select a category')
                                "
                            />
                        </div>

                        <div class="form-row">
                            <label for="">{{
                                this.$func.__("Name of Category", "erp")
                            }}</label>

                            <input type="text" v-model="category" required />
                        </div>

                        <div class=" pt-0">
                            <div class="buttons-wrapper text-right">
                                <button
                                    class="btn btn-default modal-close"
                                    @click.prevent="outside"
                                >
                                    {{ this.$func.__("Cancel", "erp") }}
                                </button>
                                <button
                                    class="btn btn-rimary"
                                    type="submit"
                                >
                                    <template v-if="catData.node">
                                        {{
                                            isCatSaving
                                                ? this.$func.__("Updating...", "erp")
                                                : this.$func.__("Update", "erp")
                                        }}
                                    </template>
                                    <template v-else>
                                        {{
                                            isCatSaving
                                                ? this.$func.__("Saving...", "erp")
                                                : this.$func.__("Save", "erp")
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
