export default {
    namespaced: true,
    state: {
        sidebar_show: false,
        layout: false,
        has_menu: false,
        subtitle: '',
        menu: [],
        active_menu: 'account',
        menu_length: 0,
        has_search: false,
        is_list: false,
        is_edit: false,
        loading: true,
        search: [],
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
        subtitle(state, payload) {
            state.subtitle = payload;
        },
        search(state, payload) {
            state.search = payload;
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
                        }else{
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
    getters: {}
}
