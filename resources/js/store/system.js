export default {
    namespaced: true,
    state: {
        applist_show: false,
        sidebar_show: false,
        layout: false,
        has_menu: false,
        title: 'Mybizna',
        subtitle: '',
        subtitle_action: '',
        menu: [],
        active_menu: 'dashboard',
        active_link: '',
        active_subs_1: 'dashboard',
        active_subs_2: '',
        active_subs_3: '',
        menu_type: 'sidebar',
        menu_length: 0,
        has_search: false,
        is_list: false,
        is_edit: false,
        loading: true,
        search: [],
        search_fields: [],
        search_path_params: [],
        path_params: {},
        search_changes: '',
        positions: [],
        has_positions: false,
        positions_length: 0,
        window_width: 0,
    },
    getters: {
        search: state => state.search,
        window_width: state => state.window_width,
        search_changes: state => state.search_changes,
    },
    mutations: {
        applist_show(state, payload) {
            state.applist_show = payload;
        },
        sidebar_show(state, payload) {
            state.sidebar_show = payload;
        },
        loading(state, payload) {
            state.loading = payload;
        },
        layout(state, payload) {
            state.layout = payload;
        },
        menu(state, payload) {
            state.menu = payload;
        },
        has_menu(state, payload) {
            state.has_menu = payload;
        },
        title(state, payload) {
            state.title = payload;
        },
        subtitle(state, payload) {
            state.subtitle = payload;
        },
        subtitle_action(state, payload) {
            state.subtitle_action = payload;
        },
        search(state, payload) {
            var tmp_search = state.search;

            var path_module = payload.path[0];
            var path_table = payload.path[1];

            if (path_module in tmp_search) {
                if (path_table in tmp_search[path_module]) {
                    tmp_search[path_module][path_table] = {
                        ...tmp_search[path_module][path_table],
                        ...payload.search
                    };
                } else {
                    tmp_search[path_module][path_table] = payload.search;
                }
            } else {
                tmp_search[path_module] = {};
                tmp_search[path_module][path_table] = payload.search;
            }

            state.search = tmp_search;
        },
        search_fields(state, payload) {
            state.search_fields = payload;
        },
        search_path_params(state, payload) {
            state.search_path_params = payload;
        },
        path_params(state, payload) {
            state.path_params = payload;
        },
        search_changes(state, payload) {
            state.search_changes = payload;
        },
        window_width(state, payload) {
            state.window_width = payload;
        },
        has_search(state, payload) {
            state.has_search = payload;
        },
        is_list(state, payload) {
            state.is_list = payload;
        },
        is_edit(state, payload) {
            state.is_edit = payload;
        },
        active_menu(state, payload) {
            state.active_menu = payload;
        },
        active_link(state, payload) {
            state.active_link = payload;
        },
        active_subs_1(state, payload) {
            state.active_subs_1 = payload;
        },
        active_subs_2(state, payload) {
            state.active_subs_2 = payload;
        },
        active_subs_3(state, payload) {
            state.active_subs_3 = payload;
        },
        menu_length(state, payload) {
            state.menu_length = payload;
        },
        menu_type(state, payload) {
            state.menu_type = payload;
        },
        positions(state, payload) {
            state.positions = payload;
        },
        has_positions(state, payload) {
            state.has_positions = payload;
        },
        positions_length(state, payload) {
            state.positions_length = payload;
        },
    },
    actions: {
        async getPositions({
            commit
        }) {

            await window.axios.get("/fetch_positions", {
                params: {
                    u: window.mybizna_uniqid,
                }
            })
                .then(
                    response => {

                        var counter = 0;

                        if (Array.isArray(response.data)) {
                            counter = response.data.length;
                        } else {
                            counter = Object.keys(response.data).length;
                        }
                        Object.keys(response.data).length;

                        commit('positions_length', counter);
                        commit('positions', response.data);
                        commit('has_positions', true);

                    })
                .catch(
                    response => {
                        if (response.status === 401) {
                            console.log('Issues Getting Menu');
                        }
                    });
        },
        async getMenu({
            commit
        }) {

            await window.axios.get("/fetch_menus", {
                params: {
                    u: window.mybizna_uniqid,
                }
            })
                .then(
                    response => {

                        var counter = 0;

                        if (Array.isArray(response.data)) {
                            counter = response.data[window.viewside].length;
                        } else {
                            counter = Object.keys(response.data[window.viewside]).length;
                        }

                        commit('menu_length', counter);
                        commit('menu', response.data[window.viewside]);

                    })
                .catch(
                    response => {
                        if (response.status === 401) {
                            console.log('Issues Getting Menu');
                        }
                    });
        },
    },
}
