<template>
    <nav v-if="pagination.pages" class="text-center my-2" aria-label="Pagination">

        <!-- Current: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" -->

        <template v-if="pagination.pages <= 5">
            <a v-for="index in getNumbers(1, pagination.pages)" :key="index"
                :aria-current="index == pagination.page ? 'page' : ''"
                :class="[(index == pagination.page ? 'bg-gray-500 text-gray-50' : '')]"
                class="inline-block cursor-pointer bg-gray-50 border-gray-500 text-gray-600 h-7 w-7 leading-6 border text-sm font-medium rounded-full m-0.5"
                @click="loadPage(index)">
                {{ index }} </a>
        </template>

        <template v-else>
            <a class="inline-block cursor-pointer bg-gray-50 border-gray-500 text-gray-600 h-7 w-7 leading-6 border text-sm font-medium rounded-full m-0.5"
                @click="loadPage(1)">
                <i class="fa-solid fa-caret-left"></i>
            </a>
            <a v-for="index in getNumbers(1, 2)" :key="index" :aria-current="index == pagination.page ? 'page' : ''"
                :class="[(index == pagination.page ? 'bg-gray-500 text-gray-50' : '')]"
                class="cursor-pointer inline-block bg-gray-50 border-gray-500 text-gray-600 h-7 w-7 leading-6 border text-sm font-medium rounded-full m-0.5"
                @click="loadPage(index)">
                {{ index }} </a>
            <span class="text-sm text-gray-700">
                <span class="font-medium">{{ pagination.page }}</span>
                /
                <span class="font-medium">{{ pagination.pages }}</span>

            </span>
            <a v-for="index in getNumbers(pagination.pages - 2, pagination.pages)" :key="index"
                :aria-current="index == pagination.page ? 'page' : ''"
                :class="[(index == pagination.page ? 'bg-gray-500 text-gray-50' : '')]"
                class="cursor-pointer inline-block bg-gray-50 border-gray-500 text-gray-600 h-7 w-7 leading-6 border text-sm font-medium rounded-full m-0.5"
                @click="loadPage(index)">
                {{ index }} </a>
            <a :class="[(index == pagination.page ? 'bg-gray-500 text-gray-50' : '')]"
                class="cursor-pointer inline-block bg-gray-50 border-gray-500 text-gray-600 h-7 w-7 leading-6 border text-sm font-medium rounded-full m-0.5"
                @click="loadPage(pagination.pages)">
                <i class="fa-solid fa-caret-right"></i>
            </a>
        </template>
    </nav>
</template>

<script>
/* eslint-disable vue/no-unused-components */
export default {
    components: {
    },
    props: {
        pagination: Object,
    },
    data() {
        return {
        };
    },
    created() {
        var t = this;
        console.log(t.pagination);
    },
    methods: {
        loadPage: function (page) {

            if (page < 1) {
                page = 1;
            } else if (page > this.pagination.pages) {
                page = this.pagination.pages;
            }

            this.pagination.page = page;

            this.fetchRecords();
        },
        getNumbers: function (start, stop) {

            console.log('---------------------------');
            console.log(this.pagination.page);
            console.log(start);

            if (this.pagination.page != start) {
                start = this.pagination.page;
                stop = this.pagination.page + 1;
            }
            var tmp_array = new Array(stop - start).fill(start).map((n, i) => n + i);
            tmp_array.push(stop);
            return tmp_array;
        },
    },
};
</script>
