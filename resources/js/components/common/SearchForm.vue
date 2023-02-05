<template>
    <template v-if="$store.state.system.has_search && !$store.state.system.is_recordpicker">

        <div class="pt-1 pr-1">

            <div class="input-group input-group-sm border rounded">
                <input type="text" class="form-control dropdown-toggle border-none focus:shadow-none"
                    placeholder="Search Any Term." aria-label="Text input with dropdown button"
                    data-bs-toggle="dropdown" aria-expanded="false" />
                <div class="dropdown-menu dropdown-menu-end search-dropdown p-2 shadow-lg">
                    <b>Search</b>
                    <div class="row">
                        <div v-for="(item, index) in $store.state
                        .system.search" :key="index" class="col-sm-6 col-md-4 col-lg-2">
                            <FormKit :label="item.label" :id="item.name" :type="item.type" validation="required" />
                        </div>

                        <template v-if="show_search">
                            <component :is="compSearch"></component>
                        </template>

                        <div class="col-sm-6 col-md-4 col-lg-2">
                            <b> &nbsp; </b>
                            <div class="text-center">
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    Cancel
                                </button>
                                &nbsp;&nbsp;
                                <button type="submit" class="btn bg-green text-white btn-sm">
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

            <!--
                <button class="btn btn-outline-primary" type="button" aria-expanded="false">
                  
                </button>
                
                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">All</button>
                -->



            <a>
                <small style="font-size: 12px">
                    Filter: Empty
                </small>
            </a>
        </div>

        <!--
        <div class="d-block d-md-none  m-2 text-right">
            <button class="btn btn-outline-primary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-search"></i>
                Search
            </button>
            <div class="dropdown-menu dropdown-menu-end mobile-dropdown search-dropdown p-2">
                <div class="row">
                    <div class="col-4">
                        <b>Search</b>
                    </div>
                    <div class="col-8">
                        <div class="text-center">
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                Cancel
                            </button>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn bg-green text-white btn-sm">
                                Search
                            </button>
                        </div>
                    </div>
                    <div v-for="(item, index) in $store.state.system
                    .search" :key="index" class="col-sm-6 col-md-4 col-lg-2">
                        <FormKit :label="item.label" :id="item.name" :type="item.type" validation="required" />
                    </div>
                </div>
                <a>
                    <small style="font-size: 12px">
                        Advanced:Empty
                    </small>
                </a>
            </div>
        </div>
        -->

    </template>

</template>

<script>

export default {
    setup() {
        var search_path = window.$router.currentRoute.meta.search_path;

        if (search_path != '') {
            this.compSearch = window.$func.fetchComponent(search_path);
            this.show_search = true;
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

