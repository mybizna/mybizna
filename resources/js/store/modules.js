import auth from '@/store/auth';
import system from '@/store/system';

export default {
    auth,
    system,
  }

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