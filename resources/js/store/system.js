export default {
    namespaced: true,
    state: {
        sidebar_show: false,
        layout: false,
    },
    mutations: {
        sidebar_show(state, payload) {
            state.sidebar_show = payload;
        },

        layout(state, payload) {
            state.layout = payload;
        },
    },
    actions: {
      
    },
    getters: {
        
    }
}