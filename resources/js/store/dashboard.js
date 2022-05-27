export default {
    namespaced: true,
    state: {
        has_dashboard_data: false,
        dashboard_data: [],
    },
    mutations: {
        dashboard_data(state, payload) {
            state.dashboard_data = payload;
        },
        has_dashboard_data(state, payload) {
            state.has_dashboard_data = payload;
        },
    },
    actions: {
        async getDashboardData({
            commit
        }) {

            await window.axios.get("/dashboard_data")
                .then(
                    response => {
                        commit('dashboard_data', response.data);
                        commit('has_dashboard_data', true);

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
