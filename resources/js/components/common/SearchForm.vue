<template>
    <template v-if="$store.state.system.has_search && !$store.state.system.is_recordpicker">
        <div class="d-none d-md-block mt-1 mx-1">
            <div class="input-group input-group-sm">
                <input type="text" class="form-control" aria-label="Text input with dropdown button" />
                <button class="btn btn-outline-primary" type="button" aria-expanded="false">
                    <v-icon size="12" icon="fas fa-search"></v-icon>
                    Search
                </button>
                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">Advanced</button>

                <div class="dropdown-menu dropdown-menu-end search-dropdown p-2 shadow-lg">
                    <b>Search</b>
                    <div class="row">
                        <div v-for="(item, index) in $store.state
                        .system.search" :key="index" class="col-sm-6 col-md-4 col-lg-2">
                            <FormKit :label="item.label" :id="item.name" :type="item.type" validation="required" />
                        </div>
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
            </div>
            <a>
                <small style="font-size: 12px">
                    Advanced:Empty
                </small>
            </a>
        </div>

        <div class="d-block d-md-none  m-2 text-right">
            <button class="btn btn-outline-primary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <v-icon size="12" icon="fas fa-search"></v-icon>
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
    </template>

</template>

<script>
export default {
     setup () {
     }
};
</script>

