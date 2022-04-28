<template>
    <div class="wperp-form-group invoice-customers with-multiselect">
        <people-modal
            v-if="showModal"
            title="Add new customer"
            type="customer"
        ></people-modal>
        <label
            >{{ this.$func.__("Customer", "erp")
            }}<span class="wperp-required-sign">*</span></label
        >
        <multi-select v-model="selected" :options="options" />

        <a href="#" class="add-new-customer" @click="showModal = true">
            <i class="flaticon-add-plus-button"></i>{{ this.$func.__("Add new", "erp") }}
        </a>
    </div>
</template>

<script>
import { mapState } from "vuex";

import MultiSelect from "assets/components/select/MultiSelect.vue";
import PeopleModal from "assets/partner/widgets/PeopleModal.vue";

export default {
    components: {
        MultiSelect,
        PeopleModal,
    },

    props: {
        value: {
            type: [String, Object, Array],
            default: "",
        },

        reset: {
            type: Boolean,
            default: false,
        },
    },

    data() {
        return {
            selected: null,
            showModal: false,
        };
    },

    watch: {
        value(newVal) {
            this.selected = newVal;
        },

        selected() {
            this.$emit("input", this.selected);
        },

        reset() {
            this.selected = [];
        },
    },

    computed: mapState({
        options: (state) => state.sales.customers,
    }),

    created() {
        this.$store.dispatch("sales/fetchCustomers");

        this.$root.$on("options-query", (query) => {
            if (query) {
                this.getCustomers(query);
            }
        });

        this.$on("modal-close", () => {
            this.showModal = false;
            this.people = null;
        });

        this.$root.$on("peopleUpdate", () => {
            this.showModal = false;
        });
    },

    methods: {
        getCustomers(query) {
            window.axios
                .get("/people", {
                    params: {
                        type: "customer",
                        search: query,
                    },
                })
                .then((response) => {
                    this.$store.dispatch("sales/fillCustomers", response.data);
                });
        },
    },
};
</script>

<style>
.invoice-customers.with-multiselect .multiselect__input,
.invoice-customers.with-multiselect .multiselect__single {
    min-height: 30px;
    line-height: 30px;
    margin-bottom: 0;
}

.invoice-customers.with-multiselect .multiselect__placeholder {
    margin: 4px 0 0 7px !important;
}
</style>
