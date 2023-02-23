<template>
    <template v-if="$store.state.system.has_search && !$store.state.system.is_recordpicker">

        <div class="pt-1 pr-1">

            <div class="input-group input-group-sm border rounded">
                <input type="text" class="form-control dropdown-toggle border-none focus:shadow-none"
                    placeholder="Search Any Term." aria-label="Text input with dropdown button" data-bs-toggle="dropdown"
                    aria-expanded="false" />
                <div class="dropdown-menu dropdown-menu-end search-dropdown p-2 shadow-lg" :class="widthClass">
                    <b>Search</b>
                    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-1 match-height">
                        <template v-for="(item, index) in $store.state
                            .system.search_fields" :key="index">
                            <FormKit v-model="model[item.name]" :label="item.label" :id="item.name" :type="item.type"
                                validation="required" />
                        </template>

                        <template v-if="show_search">
                            <component :is="compSearch"></component>
                        </template>

                        <div>
                            <b> {{ "\xA0" }} </b>
                            <div class="text-center">
                                <button type="submit" class="pr-1 btn btn-outline-danger btn-sm mr-1">
                                    Cancel
                                </button>
                                <button type="submit" @click="search()" class="btn bg-primary text-white btn-sm ml-1">
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
                    Filter: {{ JSON.stringify(model) }}
                </small>
            </a>

        </div>

    </template>
</template>

<script>

export default {
    watch: {
        model: {
            handler: function (newVal) {
                this.changed_here = true;

                var path_params = this.$store.state.system.search_path_params;
                this.$emitter.emit("system-search", { module: path_params[0], table: path_params[1], search: this.model });

                this.changed_here = false;
            },
            deep: true
        },
    },

    created() {
        var path_params = this.$store.state.system.search_path_params;

        //Preset System Search
        this.$store.commit('system/search', { module: path_params[0], table: path_params[1], search: this.model });

        //Check if Search Path is set.
        var meta = window.$router.currentRoute.value.meta;
        if (Object.prototype.hasOwnProperty.call(meta, 'search_path')) {
            var search_path = meta.search_path;

            if (search_path != '') {
                this.compSearch = window.$func.fetchComponent(search_path);
                this.show_search = true;
            }
        }
    },
    mounted() {

        this.$emitter.on('system-set-store', (data) => {
            this.$store.commit('system/search_path_params', [data.module, data.table]);

            data['search_fields'].forEach(field => {
                this.model[field.name] = '';
            });
        });

        this.$emitter.on('system-search', (newmodal) => {

            var search = this.$store.state.system.search;
            var model = newmodal;

            if (Object.prototype.hasOwnProperty.call(search, newmodal.module) &&
                Object.prototype.hasOwnProperty.call(search, newmodal.table)) {
                var oldmodel = search[newmodal.module][newmodal.table];

                var oldmodel_str = JSON.stringify(oldmodel)
                var oldmodel_obj = JSON.parse(oldmodel_str);

                model = { ...oldmodel_obj.search, ...newmodal.search };
            }


            this.$store.commit('system/search', { module: newmodal.module, table: newmodal.table, search: model });

            if (!this.changed_here) {
                this.model = model;
            }
        });

    },
    data() {
        return {
            model: {},
            compSearch: '',
            changed_here: false,
            show_search: false,
            search_filter: '',
        }
    },
    computed: {
        widthClass() {
            var window_width = this.$store.state.system.window_width;

            var window_width_flr = Math.floor(this.$store.state.system.window_width / 100) * 100;
            var window_width_new = window_width_flr;

            if (window_width - window_width_flr > 50) {
                window_width_new = window_width_flr + 50;
            }

            if (window_width_new > 1600) {
                window_width_new = 1600;
            }

            return `m-w-${window_width_new}`;
        }
    },
    methods: {
        search() {
            this.$emitter.emit('search-records', true);
        },
        searchFilter() {

        }
    },

};
</script>

