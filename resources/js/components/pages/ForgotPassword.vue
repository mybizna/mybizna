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
                  <h4 class="text-center mb-4">Forgot Password</h4>
                  <div v-if="is_first">
                    <div class="form-group">
                      <label><strong>Email</strong></label>
                      <input
                        type="email"
                        class="form-control"
                        v-model="email"
                      />
                    </div>
                    <div class="text-center">
                      <button
                        type="submit"
                        class="btn btn-primary btn-block"
                        @click="forgotPasswordCode"
                      >
                        SUBMIT
                      </button>
                    </div>
                  </div>
                  <div v-else>
                    <div class="alert alert-primary">
                      <h3 class="text-center">
                        Password reset code was sent to your email address.<br />
                        Please Complete form shown below.
                      </h3>
                    </div>
                    <div class="form-group">
                      <label><strong>Code</strong></label>
                      <input type="text" class="form-control" v-model="code" />
                    </div>
                    <div class="form-group">
                      <label><strong>Password</strong></label>
                      <input
                        type="password"
                        class="form-control"
                        v-model="password"
                      />
                    </div>
                    <div class="form-group">
                      <label><strong>Password Again</strong></label>
                      <input
                        type="password"
                        class="form-control"
                        v-model="password_again"
                      />
                    </div>

                    <div class="text-center">
                      <button
                        type="submit"
                        class="btn btn-primary btn-block"
                        @click="forgotPassword"
                      >
                        SUBMIT
                      </button>
                    </div>
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
  data: () => ({
    loading: false,
    is_first: true,
    code: "",
    email: "",
    password: "",
    password_again: "",
  }),

  methods: {
    forgotPasswordCode() {
      this.$recaptchaLoaded().then(() => {
        this.$recaptcha("login").then((token) => {
          var tmp_query_str = "?email=" + this.email;

          window.axios
            .get("/user/forgotpasswordcode/" + tmp_query_str)
            .then((res) => {
              if (!res.data.has_error) {
                this.is_first = false;
              } else {
                this.notification("Error:" + res.data.error_message);
              }
            });
        });
      });
    },
    forgotPassword() {
      if (this.password != '' && this.password == this.password_again) {
        this.$recaptchaLoaded().then(() => {
          this.$recaptcha("login").then((token) => {
            var tmp_query_str =
              "?email=" +
              this.email +
              "&password=" +
              this.password +
              "&code=" +
              this.code;

            window.axios
              .get("/user/forgotpassword/" + tmp_query_str)
              .then((res) => {
                if (!res.data.has_error) {
                  this.$router.push("login");
                } else {
                  this.notification("Error:" + res.data.error_message);
                }
              });
          });
        });
      }
    },
    notification(message, type = "error") {
      this.$notify({
        title: type.toUpperCase() + " MESSAGE",
        text: message,
        type: type,
      });
    },
  },
};
</script>
<style scoped lang="css">

</style>
