// initial state
const state = {
    pro_activated: false
};

const mutations = {
    setProStatus(state, status) {
        state.pro_activated = status;
    }
};


export default {
    namespaced: true,
    state,
    mutations
};
