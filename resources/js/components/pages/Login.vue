<template>
  <div class="row justify-content-center h-100 align-items-center h-screen">
    <div class="col-md-6">
      <div class="authincation-content border rounded shadow bg-white">
        <div class="m-3">
          <div class="auth-form">
            <div class="text-center mb-3">
              <img :src="this.$assets_url + 'images/logos/logo.png'" alt="" style="margin: 0 auto; max-width:120px;" />
            </div>
            <h4 class="text-center my-4">Login to your account</h4>
            <div>
              <div class="form-group mt-2 w-96 max-w-full" style="margin: 0 auto;">
                <label class="mb-1"><strong>Email</strong></label>
                <input type="text" class="form-control" v-model="model.username" />
              </div>
              <div class="form-group mt-2 w-96 max-w-full" style="margin: 0 auto;">
                <label class="mb-1"><strong>Password</strong></label>
                <input type="password" class="form-control" v-model="model.password" />
              </div>
              <div class="form-row d-flex justify-content-between mt-4 mb-2 w-96 max-w-full" style="margin: 0 auto;">
                <div class="form-group">
                  <div class="custom-control custom-checkbox ml-1">
                    <input type="checkbox" class="custom-control-input" id="basic_checkbox_1" />
                    <label class="custom-control-label" for="basic_checkbox_1">Remember my preference</label>
                  </div>
                </div>
                <div class="form-group">
                  <router-link to="/forgotpassword">Forgot Password?</router-link>
                </div>
              </div>
              <div class="text-center mt-2">
                <button type="submit" class="btn  text-white bg-blue-600" @click="login" :loading="loading">
                  LOGIN
                </button>
              </div>
            </div>
            <div class="new-account mt-5" v-if="has_register">
              <p>
                Don't have an account? <br />
                <b-button variant="success">
                  <router-link to="/register" class="text-white">CREATE ACCOUNT</router-link>
                </b-button>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  watch: {
    "$store.state.auth.token": {
      immediate: true,
      handler() {
        // update locally relevant data
        if (this.$store.getters["auth/loggedIn"]) {
          this.$store.dispatch("auth/getUser", { that: this });

          if (window.is_frontend) {
            this.$router.push("/dashboard");
          } else {
            this.$router.push("/manage/dashboard");
          }
        }
      },
    },
  },
  created() {
    if (window.autologin) {
      this.$store.dispatch("auth/autologin", { that: this });
    }
  },
  data: () => ({
    loading: false,
    has_register: false,
    model: {
      username: "",
      password: "",
    },
  }),

  methods: {
    login() {
      let data = {
        username: this.model.username,
        password: this.model.password,
        that: this,
      };

      this.$store.dispatch("auth/authenticate", data);
    },
  },
};
</script>
<style scoped lang="css">
#main-wrapper {
  overflow: scroll;
  overflow-x: hidden;
}

#login {
  height: 50%;
  width: 100%;
  position: absolute;
  top: 0;
  left: 0;
  content: "";
  z-index: 0;
}
</style>
