<template>
    <FormKit
        type="select"
        name="small_country"
        :multiple="multiple"
        :options="options"
        :placeholder="placeholder"
        :disabled="disabled"
    />
</template>

<script>
export default {
    props: {
        value: {
            type: null,
            required: true,
        },

        options: {
            type: Array,
            default: () => [],
        },

        multiple: {
            type: Boolean,
            default: false,
        },

        disabled: {
            type: Boolean,
            default: false,
        },

        placeholder: {
            type: String,
            default: this.$func.__("Please search", "erp"),
        },
    },

    data() {
        return {
            noResult: false,
            isLoading: false,
            results: [],
        };
    },

    watch: {
        options() {
            this.results = [];
            this.isLoading = false;
        },
    },

    methods: {
        onSelect(selected) {
            if (this.multiple) {
                this.results.push(selected);
                this.$emit("input", this.results);
            } else {
                this.$emit("input", selected);
            }
        },

        onRemove(removed) {
            this.results = this.results.filter(
                (element) => element.id !== removed.id
            );

            this.$emit("input", this.results);
        },

        onDropdownOpen(id) {
            this.$root.$emit("dropdown-open");
        },

        asyncFind: function (query) {
            // this.isLoading = true;
            this.$root.$emit("options-query", query);
        },
    },
};
</script>

<style>
.multiselect input.multiselect__input {
    display: none;
}
.multiselect .multiselect--active input.multiselect__input {
    display: block;
    width: 97% !important;
}

.with-multiselect .multiselect__input ::placeholder {
    font-size: 15px;
    font-weight: normal;
    color: #dbdbdb;
    opacity: 1;
}

.with-multiselect .multiselect__input:-ms-input-placeholder {
    font-size: 15px;
    font-weight: normal;
    color: #dbdbdb;
}

.with-multiselect .multiselect__input::-ms-input-placeholder {
    font-size: 15px;
    font-weight: normal;
    color: #dbdbdb;
}

.with-multiselect .custom__tag {
    background: #f7f7f7;
    padding: 4px 8px;
    border-radius: 3px;
    display: inline-block;
    margin: 1px 5px 2px 0;
    border: 1px solid #e8eaec;
}
.with-multiselect .custom__tag span {
    color: #72777c;
}

.with-multiselect .custom__tag .custom__remove {
    color: #999;
    font-weight: bold;
}
.with-multiselect .custom__tag .custom__remove:hover {
    color: #333;
    cursor: pointer;
}

.with-multiselect .multiselect__element {
    margin: 0;
}
.with-multiselect .multiselect__element .multiselect__option {
    min-height: 32px;
    line-height: 12px;
}
.with-multiselect .multiselect__element .multiselect__option:after {
    line-height: 35px;
}

.with-multiselect .multiselect__element .multiselect__option span {
    font-size: 15px;
}

.with-multiselect .multiselect__single {
    font-size: 15px;
    color: #555;
    line-height: 2;
    margin: 0;
}

.with-multiselect .multiselect__tags {
    height: auto;
    min-height: 35px;
    border-radius: 3px;
    padding: 2px;
}
.with-multiselect .multiselect__tags .multiselect__spinner {
    height: 32px;
}

.with-multiselect .multiselect__tags .multiselect__input {
    border: 0;
    box-shadow: none;
}

.with-multiselect .multiselect__select {
    height: 33px;
}

.with-multiselect .multiselect__placeholder {
    padding-top: 0;
    margin: 6px 0 0 4px;
}

.with-multiselect .multiselect__option--selected {
    color: rgba(45, 140, 240, 0.9) !important;
    font-weight: normal;
}

.with-multiselect .multiselect__option--highlight {
    background: #f3f3f3 !important;
    color: #515a6e !important;
}
.with-multiselect .multiselect__option--highlight:after {
    content: "";
}

.with-multiselect
    .multiselect__option--selected
    .multiselect__option--highlight:after {
    background: #f3f3f3 !important;
    content: "\f158" !important;
    color: #ff6a6a !important;
    font-family: dashicons !important;
}

.with-multiselect.multiselect__option--selected
    .multiselect__option--highligh:after {
    content: "\f147" !important;
    font-size: 20px !important;
    color: rgba(45, 140, 240, 0.9) !important;
    font-family: dashicons !important;
}

.with-multiselect .multiselect--disabled .multiselect__current,
.with-multiselect .multiselect--disabled .multiselect__select {
    background: none;
}
</style>
