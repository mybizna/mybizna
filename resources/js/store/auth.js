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
        async affiliate({ commit }, { user_id }) {
            let query_str =
                "query { userAffiliates(first:1) { edges {cursor node { id,pk,user{id, firstName, lastName, username, email,dateJoined},matrix{id, title},inviter{id, firstName, lastName, username, email},package{id, title},rank{id, name},status,summary,expiryDate,upgradeDate,lastUpgradeDate,createdAt,createdBy{id,firstName,lastName,email,username},updatedAt,updatedBy{id,firstName,lastName,email,username}, setting }}   pageInfo { hasNextPage, hasPreviousPage, startCursor,endCursor }  }     }";


            window.axios
                .post("/graphql?query=" + query_str)
                .then((response) => {
                    var tmpitems = {};
                    var node_data = JSON.parse(
                        JSON.stringify(
                            response.data.data.userAffiliates.edges[0].node
                        )
                    );

                    for (var prop in node_data) {
                        if (
                            Object.prototype.hasOwnProperty.call(
                                node_data,
                                prop
                            )
                        ) {
                            if (
                                typeof node_data[prop] === "string" &&
                                node_data[prop].charAt(0) === "{"
                            ) {
                                try {
                                    node_data[prop] = JSON.parse(
                                        node_data[prop]
                                    );
                                } catch (e) {
                                    // is not a valid JSON string
                                }
                            }
                        }
                    }

                    commit("affiliate", node_data);
                })
                .catch((response) => {
                });
        },
    },
    getters: {
        loggedIn(state) {
            return state.token !== null;
        },
    },
};
