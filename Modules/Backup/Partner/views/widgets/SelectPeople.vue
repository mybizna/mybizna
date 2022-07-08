<template>
    <div class="form-group expense-people with-multiselect">
        <people-modal
            v-if="showModal"
            title="Add new people"
            type="all"
        ></people-modal>
        <label>{{ label }}<span class="required-sign">*</span></label>
        <multi-select
            :disabled="isDisabled"
            v-model="selected"
            :options="options"
        />

        <!--<a href="#" class="add-new-people" @click="showModal = true"><i class="flaticon-add-plus-button"></i>Add new</a>-->
    </div>
</template>

<script>
export default {
    components: {
        PeopleModal: window.$func.fetchComponent(
            "partner/widgets/PeopleModal.vue"
        ),
        MultiSelect: window.$func.fetchComponent(
            "components/select/MultiSelect.vue"
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

        label: {
            type: String,
            default: "Pay to",
        },

        isDisabled: {
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
        options: (state) => state.expense.people,
    }),

    emits: {
        // Validate submit event
        "options-query": ({ query }) => {
            if (query) {
                this.getPeople(query);
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
        this.$store.dispatch("expense/fetchPeople");

    },

    methods: {
        getPeople(query) {
            window.axios
                .get("/people", {
                    params: {
                        type: [],
                        search: query,
                    },
                })
                .then((response) => {
                    this.$store.dispatch("expense/fillPeople", response.data);
                });
        },
    },
};
</script>

<style>
.expense-people.with-multiselect .multiselect__input,
.expense-people.with-multiselect .multiselect__single {
    min-height: 30px;
    line-height: 30px;
    margin-bottom: 0;
}

.expense-people.with-multiselect .multiselect__placeholder {
    margin: 4px 0 0 7px !important;
}
</style>
