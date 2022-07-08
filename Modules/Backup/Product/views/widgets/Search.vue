<template>
    <div class="product-search">
        <form @submit.prevent="searchPeople">
            <div class="input-with-addon">
                <input
                    v-model="search"
                    type="search"
                    class="form-control form-contro-sm form-field"
                    :placeholder="this.$func.__('Search Products')"
                />
                <span v-if="search" @click="clearSearch">&#x2716;</span>
            </div>

            <button type="submit" class="btn btn-primary search-btn">
                {{ this.$func.__("Search", "erp") }}
            </button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            search: "",
        };
    },

    methods: {
        searchPeople() {
            this.$emit("input", this.search);
        },

        clearSearch() {
            this.search = "";
            this.searchPeople();
        },
    },
};
</script>

<style>
.product-search {
    display: flex;
    position: absolute;
    width: 20%;
    align-items: center;
    justify-content: flex-end;
    right: 1.25rem;
}

.product-search form {
    display: flex;
}

.product-search h4 {
    margin: 0;
}

@media (max-width: 782px) {
    .product-search {
        right: 0.8rem;
        margin-top: 9px;
    }
}

.product-search .input-with-addon {
    position: relative;
}
@media (max-width: 782px) {
    .product-search .input-with-addon {
        margin-top: 14px;
        height: 29.8px;
        max-height: 29.8px;
    }
}

.product-search .input-with-addon input {
    width: 180px;
    max-height: 25px;
    height: 25px;
    border: 0.3px solid rgb(226, 226, 226);
}
.product-search .input-with-addon input::placeholder {
    color: rgba(0, 0, 0, 0.6) !important;
    font-size: 12px !important;
    font-weight: 400 !important;
}

@media (max-width: 782px) {
    .product-search .input-with-addon input {
        height: 30px;
        min-height: 30px;
    }
}

@media (max-width: 650px) {
    .product-search .input-with-addon input {
        width: 120px;
    }
}

.product-search .input-with-addon span {
    position: absolute;
    right: 7px;
    top: 4px;
    font-size: 15px;
    cursor: pointer;
}

@media (max-width: 782px) {
    .product-search .search-btn {
        margin-top: 14px !important;
    }
}

@media (max-width: 650px) {
    .product-search .search-btn {
        display: none;
    }
}
</style>
