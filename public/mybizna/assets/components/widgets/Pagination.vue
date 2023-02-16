<template>
    <nav v-if="pagination.pages" class="text-center my-2" aria-label="Pagination">

        <!-- Current: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" -->
        <template v-if="pagination.pages <= 5">
            <a v-for="index in getNumbers(1, pagination.pages)" :key="index"
                :aria-current="index == pagination.page ? 'page' : ''"
                :class="[(index == pagination.page ? 'bg-blue-400 border-blue-600 text-gray-50' : ' border-gray-500 text-gray-600 bg-gray-50')]"
                class="inline-block cursor-pointer h-7 w-7 leading-6 border text-sm font-medium rounded-full m-0.5"
                @click="loadPage(index)">
                {{ index }} </a>
        </template>

        <template v-else>
            <a class="inline-block cursor-pointer bg-gray-50 border-gray-500 text-gray-600 h-7 w-7 leading-6 border text-sm font-medium rounded-full m-0.5"
                @click="loadPage(1)">
                <i class="fa-solid fa-caret-left"></i>
            </a>

            <template v-if="pagination.page <= 5">
                <a v-for="index in getNumbers(1, 6)" :key="index" :aria-current="index == pagination.page ? 'page' : ''"
                    :class="[(index == pagination.page ? 'bg-blue-400 border-blue-600 text-gray-50' : 'bg-gray-50 border-gray-500 text-gray-600')]"
                    class="cursor-pointer inline-block h-7 w-7 leading-6 border text-sm font-medium rounded-full m-0.5"
                    @click="loadPage(index)">
                    {{ index }} </a>

                <div class="inline-block mx-1 text-sm text-gray-700">
                    ...
                </div>

            </template>
            <template v-else-if="pagination.page > 5">
                <div class="inline-block mx-1 text-sm text-gray-700">
                    ...
                </div>

                <a v-for="index in getNumbers(pagination.page - 3, pagination.page + 3)" :key="index"
                    :aria-current="index == pagination.page ? 'page' : ''"
                    :class="[(index == pagination.page ? 'bg-blue-400 border-blue-600 text-gray-50' : 'bg-gray-50 border-gray-500 text-gray-600')]"
                    class="cursor-pointer inline-block h-7 w-7 leading-6 border text-sm font-medium rounded-full m-0.5"
                    @click="loadPage(index)">
                    {{ index }} </a>

                <div v-if="(pagination.page + 3) < pagination.pages" class="inline-block mx-1 text-sm text-gray-700">
                    ...
                </div>
            </template>

            <a :class="[(index == pagination.page ? 'bg-blue-400 border-blue-600 text-gray-50' : 'bg-gray-50 border-gray-500 text-gray-600')]"
                class="cursor-pointer inline-block h-7 w-7 leading-6 border text-sm font-medium rounded-full m-0.5"
                @click="loadPage(pagination.pages)">
                <i class="fa-solid fa-caret-right"></i>
            </a>

            <div class="inline-block mx-3 text-sm text-gray-700 mt-2 sm:mt-0">
                <span class="text-xs">Page:</span>
                <input id="pagination_page" v-model="pagination.page" type="text" name="pagination_page"
                    :max="pagination.pages"
                    class="text-gray-700 inline-block w-6 bg-white border border-solid border-blue-400 rounded">
                    /{{ pagination.pages }}
                <a @click="loadPage(pagination.page)"
                    class="uppercase cursor-point text-white  bg-blue-700 font-medium text-center px-2 py-1 rounded ml-2">GO</a>

            </div>
        </template>
    </nav>
</template>

<script>
/* eslint-disable vue/no-unused-components */
export default {
    components: {
    },
    props: {
        loadPage: Object,
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

        getNumbers: function (start, stop) {

            if (start > (this.pagination.pages - 6) && this.pagination.pages > 6) {
                start = this.pagination.pages - 6;
            }

            if (stop > this.pagination.pages) {
                stop = this.pagination.pages;
            }

            var tmp_array = new Array(stop - start).fill(start).map((n, i) => n + i);
            tmp_array.push(stop);

            return tmp_array;
        },
    },
};
</script>
