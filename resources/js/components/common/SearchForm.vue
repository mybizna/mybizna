<template>
    <template v-if="$store.state.system.has_search && !$store.state.system.is_recordpicker">

        <div class="pt-1 pr-1">

            <div class="input-group input-group-sm border rounded">
                <input type="text" class="form-control dropdown-toggle border-none focus:shadow-none"
                    placeholder="Search Any Term." aria-label="Text input with dropdown button"
                    data-bs-toggle="dropdown" aria-expanded="false" />
                <div class="dropdown-menu dropdown-menu-end search-dropdown p-2 shadow-lg">
                    <b>Search</b>
                    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-1 match-height">
                        <template v-for="(item, index) in $store.state
                        .system.search_fields" :key="index">
                            <FormKit :label="item.label" :id="item.name" :type="item.type" validation="required" />
                        </template>

                        <template v-if="show_search">
                            <component :is="compSearch"></component>
                        </template>

                        <div>
                            <b> &nbsp; </b>
                            <div class="text-center">
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    Cancel
                                </button>
                                &nbsp;&nbsp;
                                <button type="submit" class="btn bg-primary text-white btn-sm">
                                    Search
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="input-group-append pl-1 pr-1">
                    <i class="fas fa-search leading-7"></i>
                </div>
            </div>



            <a>
                <small style="font-size: 12px">
                    Filter: Empty
                </small>
            </a>
        </div>

    </template>

</template>

<script>

export default {
    created() {
        var meta = window.$router.currentRoute.value.meta;

        if (Object.prototype.hasOwnProperty.call(meta, 'search_path')) {
            var search_path = meta.search_path;

            console.log(search_path);
            if (search_path != '') {
                this.compSearch = window.$func.fetchComponent(search_path);
                this.show_search = true;
            }
        }
    },

    data() {
        return {
            compSearch: '',
            show_search: false
        }
    }
};
</script>

