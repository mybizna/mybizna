<template>
    <div class="form-group invoice-customers with-multiselect">
        <people-modal
            title="Add new vendor"
            type="vendor"
            v-if="showModal"
        ></people-modal>
        <label
            >{{ this.$func.__("Vendor", "erp")
            }}<span class="required-sign">*</span></label
        >
        <multi-select v-model="selected" :options="options" />

        <a href="#" class="add-new-customer" @click="showModal = true">
            <i class="flaticon-add-plus-button"></i
            >{{ this.$func.__("Add new", "erp") }}
        </a>
    </div>
</template>

<script>
export default {
    components: {
        MultiSelect: window.$func.fetchComponent(
            "components/select/MultiSelect.vue"
        ),
        PeopleModal: window.$func.fetchComponent(
            "partner/widgets/PeopleModal.vue"
        ),
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
        options: (state) => state.purchase.vendors,
    }),
    emits: {
        // Validate submit event
        "options-query": ({ query }) => {
            if (query) {
                this.getvendors(query);
            }
            return true;
        },
        "modal-close": () => {
            this.showModal = false;
            this.people = null;
            return true;
        },
        peopleUpdate: () => {
            this.showModal = false;
            return true;
        },
    },
    created() {
        this.$store.dispatch("purchase/fetchVendors");
    },

    methods: {
        getvendors(query) {
            window.axios
                .get("/people", {
                    params: {
                        type: "vendor",
                        search: query,
                    },
                })
                .then((response) => {
                    this.$store.dispatch("purchase/fillVendors", response.data);
                });
        },
    },
};
</script>

<style></style>
