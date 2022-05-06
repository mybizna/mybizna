<template>
    <div class="people-search">
        <form @submit.prevent="searchPeople">
            <div class="input-with-addon">
                <input
                    v-model="search"
                    type="search"
                    class="form-control form-contro-sm form-field"
                    :placeholder="this.$func.__('Search People', 'erp')"
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
.people-search {
    display: flex;
    position: absolute;
    width: 20%;
    align-items: center;
    justify-content: flex-end;
    right: 1.25rem;
}
.people-search form {
    display: flex;
}

.people-search h4 {
    margin: 0;
}

@media (max-width: 782px) {
    .people-search {
        right: 0.8rem;
        margin-top: 9px;
    }
    .people-search .input-with-addon {
        margin-top: 14px;
        height: 29.8px;
        max-height: 29.8px;
    }
}

.people-search .input-with-addon {
    position: relative;
}

.people-search .input-with-addon input {
    width: 180px;
    max-height: 25px;
    height: 25px;
    border: 0.3px solid rgb(226, 226, 226);
}
.people-search .input-with-addon input::placeholder {
    color: rgba(0, 0, 0, 0.6) !important;
    font-size: 12px !important;
    font-weight: 400 !important;
}

@media (max-width: 782px) {
    .people-search .input-with-addon input {
        height: 30px;
        min-height: 30px;
    }
}

@media (max-width: 650px) {
    .people-search .input-with-addon input {
        width: 120px;
    }
}

.people-search .input-with-addon span {
    position: absolute;
    right: 5px;
    top: 10px;
    font-size: 10px;
    cursor: pointer;
}

@media (max-width: 782px) {
    .people-search .search-btn {
        margin-top: 14px !important;
    }

    @media (max-width: 650px) {
        .people-search .search-btn {
            display: none;
        }
    }
}
</style>
