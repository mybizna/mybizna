export default {
    namespaced: true,
    state: {
        sidebar_show: false,
        layout: false,
        has_menu: false,
        menu: [],
    },
    mutations: {
        sidebar_show(state, payload) {
            state.sidebar_show = payload;
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
    },
    actions: {
        async getMenu({
            commit
        }) {

            await window.axios.get("/fetch_menus")
                .then(
                    response => {

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
