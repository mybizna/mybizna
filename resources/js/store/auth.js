export default {
    namespaced: true,
    state: {
        affiliate: {},
        userprofile: {},
        token: null,
        user: {}
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
        }
    },
    actions: {
        authenticate({
            commit
        }, {
            username,
            password
        }) {

            let query_str =
                'mutation{tokenAuth(username:"' +
                username +
                '",password:"' +
                password +
                '"){token,refreshExpiresIn}}';

            console.log(query_str);

            window.axios
                .post("/graphql?query=" + query_str)
                .then(
                    response => {
                        commit('login', response.data.data.tokenAuth);
                        window.axios.defaults.headers.common['Authorization'] = 'JWT ' + response.data.data.tokenAuth.token;

                    })
                .catch(
                    response => {
                        console.log(response);
                    });

        },
        getUser({
            commit
        }, {
            that
        }) {

            let query_str = '{me{id, firstName,lastName,email,username,dateJoined,isActive, profile{address, phone,gender,dateOfBirth,country{id, name, code},inviter{id, firstName,lastName,email,username,dateJoined}address, phone, town, location, blocked,image    }}}';

            window.axios.get("/graphql?query=" + query_str)
                .then(
                    response => {

                        var me = response.data.data.me;

                        if (me.profile.image) {
                            me.profile.image = that.$base_url +  me.profile.image;
                        } else {
                            me.profile.image = (me.profile.gender == 'A_1') ? that.$male_default_avatar : that.$female_default_avatar;
                        }

                        commit('user', me);

                        console.log('login');
                        console.log(me);

                        that.$store.dispatch("auth/affiliate", {
                            user_id: me.id
                        });

                    })
                .catch(
                    response => {
                        if (response.status === 401) {
                            commit('logout');
                        }
                    });

        },
        affiliate({
            commit
        }, {
            user_id,
        }) {

            let query_str = 'query { userAffiliates(first:1) { edges {cursor node { id,pk,user{id, firstName, lastName, username, email,dateJoined},matrix{id, title},inviter{id, firstName, lastName, username, email},package{id, title},rank{id, name},status,summary,expiryDate,upgradeDate,lastUpgradeDate,createdAt,createdBy{id,firstName,lastName,email,username},updatedAt,updatedBy{id,firstName,lastName,email,username}, setting }}   pageInfo { hasNextPage, hasPreviousPage, startCursor,endCursor }  }     }';

            console.log(query_str);

            window.axios
                .post("/graphql?query=" + query_str)
                .then(
                    response => {

                        console.log(response);

                        var tmpitems = {};
                        var node_data = JSON.parse(JSON.stringify(response.data.data.userAffiliates.edges[0].node));

                        

                        for (var prop in node_data) {
                            if (Object.prototype.hasOwnProperty.call(node_data, prop)) {
                                if (typeof node_data[prop] === 'string' && node_data[prop].charAt(0) === "{") {
                                    try {
                                        node_data[prop] = JSON.parse(node_data[prop]);
                                    } catch (e) {
                                        // is not a valid JSON string
                                    }
                                }
                            }
                        }

                        commit('affiliate', node_data);
                    })
                .catch(
                    response => {
                        console.log(response);
                    });

        },
    },
    getters: {
        loggedIn(state) {
            return state.token !== null;
        }
    }
}