import Cookies from "js-cookie";

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
            Cookies.set(`auth_token_${window.mybizna_uniqid}`, payload, { expires: 7 });
        },
        user(state, payload) {
            state.user = payload;
            Cookies.set(`auth_user_${window.mybizna_uniqid}`, payload, { expires: 7 });
        },
        logout(state) {
            state.token = null;
            state.affiliate = {};
            state.userprofile = {};
            state.user = {};

            Cookies.remove(`auth_token_${window.mybizna_uniqid}`);
            Cookies.remove(`auth_user_${window.mybizna_uniqid}`);
        },
    },
    actions: {
        async authenticate({ commit }, { username, password }) {
            /* await window.axios.get("/sanctum/csrf-cookie")
                .then(response => {
                }); */

            await window.axios
                .post("/login", {
                    username: username,
                    password: password,
                    u: window.mybizna_uniqid,
                })
                .then((response) => {
                    if (response.data.status) {
                        commit("login", response.data.token);
                        commit("user", response.data.user);

                        window.axios.defaults.headers.common["Authorization"] =
                            "Bearer " + response.data.token;
                    } else {
                        alert('Error: '.response.data.message);
                    }



                })
                .catch((response) => {
                });
        },
        async autologin({ commit }, { that }) {
            /* await window.axios.get("/sanctum/csrf-cookie")
                .then(response => {
                }); */

            await window.axios
                .get("/autologin", {
                    params: {
                        u: window.mybizna_uniqid,
                    }
                })
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
                .get("/profile", {
                    params: {
                        u: window.mybizna_uniqid,
                    }
                })
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

            let token = Cookies.get(`auth_token_${window.mybizna_uniqid}`);

            if (token) {
                state.token = token;
            }else {
                token = state.token;
            }

            return token !== null;
        },
    },
};
