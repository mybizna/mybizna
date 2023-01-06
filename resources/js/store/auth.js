export default {
    namespaced: true,
    state: {
        affiliate: {},
        userprofile: {},
        token: null,
        user: {},
    },
    mutations: {
        affiliate(state, payload) {
            state.affiliate = payload;
        },

        login(state, payload) {
            state.token = payload;
        },
        user(state, payload) {
            state.user = payload;
        },
        logout(state) {
            state.token = null;
            state.affiliate = {};
            state.userprofile = {};
            state.user = {};
        },
    },
    actions: {
        async authenticate({ commit }, { username, password }) {
            /* await window.axios.get("/sanctum/csrf-cookie")
                .then(response => {
                }); */

            await window.axios
                .post("/login", {
                    email: username,
                    password: password,
                })
                .then((response) => {
                    commit("login", response.data.token);
                    commit("user", response.data.user);

                    window.axios.defaults.headers.common["Authorization"] =
                        "Bearer " + response.data.token;
                })
                .catch((response) => {
                });
        },
        async autologin({ commit }, { that }) {
            /* await window.axios.get("/sanctum/csrf-cookie")
                .then(response => {
                }); */

            alert('autologin');

            await window.axios
                .get("/autologin")
                .then((response) => {
                    commit("login", response.data.token);
                    commit("user", response.data.user);

                    window.axios.defaults.headers.common["Authorization"] =
                        "Bearer " + response.data.token;

                    that.$router.push("/manage/dashboard");
                })
                .catch((response) => {
                });
        },
        async getUser({ commit }, { that }) {
            window.axios
                .get("/profile")
                .then((response) => {
                    var user = response.data;

                    if (user.profile.image) {
                        user.profile.image =
                            that.$base_url + user.profile.image;
                    } else {
                        user.profile.image =
                            user.profile.gender == "A_1"
                                ? that.$male_default_avatar
                                : that.$female_default_avatar;
                    }

                    commit("user", user);

                    /*that.$store.dispatch("auth/affiliate", {
                            user_id: user.id
                        });*/
                })
                .catch((response) => {
                    if (response.status === 401) {
                        commit("logout");
                    }
                });
        },

    },
    getters: {
        loggedIn(state) {
            return state.token !== null;
        },
    },
};
