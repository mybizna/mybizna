import auth from "@/store/auth";
import system from "@/store/system";
import dashboard from "@/store/dashboard";

export default {
    auth,
    system,
    dashboard,
};

/*
  // State
this.$store.state.auth.userdata
// Mutation
this.$store.commit('auth/login', { username: 'logged_user' })
// Action
this.$store.dispatch('auth/authenticate', { username: this.username, password: this.password })
// Getter
this.$store.getters['auth/loggedIn']
  */
