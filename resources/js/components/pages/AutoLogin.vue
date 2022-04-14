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
                  <h4 class="text-center mb-4">Auto Login to your account</h4>
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
  mounted: function () {
    if (!this.$store.state.token) {
      this.$store.dispatch("auth/getUser", { that: this });
    }
  },
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
