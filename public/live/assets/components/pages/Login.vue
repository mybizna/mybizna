<template>
  <div class="authincation h-100">
    <div class="container h-100">
      <div class="row justify-content-center h-100 align-items-center">
        <div class="col-md-6">
          <div class="authincation-content">
            <div class="row no-gutters">
              <div class="col-xl-12">
                <div class="auth-form">
                  <div class="text-center mb-3">
                    <img src="images/logo.jpg" alt="" />
                  </div>
                  <h4 class="text-center mb-4">Login to your account</h4>
                  <div>
                    <div class="form-group">
                      <label class="mb-1"><strong>Email</strong></label>
                      <input
                        type="email"
                        class="form-control"
                        v-model="model.username"
                      />
                    </div>
                    <div class="form-group">
                      <label class="mb-1"><strong>Password</strong></label>
                      <input
                        type="password"
                        class="form-control"
                        v-model="model.password"
                      />
                    </div>
                    <div
                      class="form-row d-flex justify-content-between mt-4 mb-2"
                    >
                      <div class="form-group">
                        <div class="custom-control custom-checkbox ml-1">
                          <input
                            type="checkbox"
                            class="custom-control-input"
                            id="basic_checkbox_1"
                          />
                          <label
                            class="custom-control-label"
                            for="basic_checkbox_1"
                            >Remember my preference</label
                          >
                        </div>
                      </div>
                      <div class="form-group">
                        <router-link to="/forgotpassword"
                          >Forgot Password?</router-link
                        >
                      </div>
                    </div>
                    <div class="text-center">
                      <button
                        type="submit"
                        class="btn btn-primary btn-block"
                        @click="login"
                        :loading="loading"
                      >
                        LOGIN
                      </button>
                    </div>
                  </div>
                  <div class="new-account mt-5">
                    <p>
                      Don't have an account? <br />
                      <b-button variant="success">
                        <router-link to="/register" class="text-white"
                          >CREATE ACCOUNT</router-link
                        >
                      </b-button>
                    </p>
                  </div>
                </div>
              </div>
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
          this.$store.dispatch("auth/getUser",{that: this});

          if (window.is_frontend) {
            this.$router.push("/dashboard");
          } else {
            this.$router.push("/manage/dashboard");
          }
        }
      },
    },
  },
  data: () => ({
    loading: false,
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
