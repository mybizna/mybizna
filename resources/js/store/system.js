export default {
    namespaced: true,
    state: {
        sidebar_show: true,
        layout: false,
        has_menu: false,
        title: 'Mybizna',
        subtitle: '',
        menu: [],
        active_menu: 'account',
        menu_type: 'sidebar',
        menu_length: 0,
        has_search: false,
        is_list: false,
        is_edit: false,
        loading: true,
        search: [],
        search_fields: [],
        search_path_params: [],
        search_changes: '',
    },
    getters: {
        search: state => state.search,
        search_changes: state => state.search_changes,
    },
    mutations: {
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
        search(state, payload) {
            var tmp_search = state.search;

            if (payload.module in tmp_search) {
                if (payload.table in tmp_search[payload.module]) {
                    tmp_search[payload.module][payload.table] = {
                        ...tmp_search[payload.module][payload.table],
                        ...payload.search
                    };
                } else {
                    tmp_search[payload.module][payload.table] = payload.search;
                }
            } else {
                tmp_search[payload.module] = {};
                tmp_search[payload.module][payload.table] = payload.search;
            }

            state.search = tmp_search;
        },
        search_fields(state, payload) {
            state.search_fields = payload;
        },
        search_path_params(state, payload) {
            state.search_path_params = payload;
        },
        search_changes(state, payload) {
            state.search_changes = payload;
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
        menu_length(state, payload) {
            state.menu_length = payload;
        },
        menu_type(state, payload) {
            state.menu_type = payload;
        },
    },
    actions: {
        async getMenu({
            commit
        }) {

            await window.axios.get("/fetch_menus")
                .then(
                    response => {

                        var counter = 0;

                        if (Array.isArray(response.data)) {
                            counter = response.data.length;
                        } else {
                            counter = Object.keys(response.data).length;
                        }
                        Object.keys(response.data).length;

                        commit('menu_length', counter);
                        commit('menu', response.data);
                        commit('has_menu', true);

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
