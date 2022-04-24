export default {
    namespaced: true,
    state: {
        sidebar_show: false,
        layout: false,
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
    },
    actions: {
        getMenu({
            commit
        }) {

            window.axios.get("/fetch_menus")
                .then(
                    response => {

                        console.log(response);

                        commit('menu', response.data);

                    })
                .catch(
                    response => {
                        if (response.status === 401) {
                            console.log('Issues Getting Menu');
                        }
                    });

        },
    },
    getters: {
        getters: {
            hasMenu(state) {
                return (state.menu.length) ? true : false;
            }
        }
    }
}
