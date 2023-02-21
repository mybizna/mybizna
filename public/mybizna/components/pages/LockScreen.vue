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
                    <img src="images/logo-full.png" alt="" />
                  </div>
                  <h4 class="text-center mb-4">Account Locked</h4>
                  <form action="index.html">
                    <div class="form-group">
                      <label><strong>Password</strong></label>
                      <input
                        type="password"
                        class="form-control"
                        value="Password"
                      />
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-primary btn-block">
                        Unlock
                      </button>
                    </div>
                  </form>
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
      };

      window.axios
        .post("/api/login", data)
        .then(({ data }) => {
          window.auth.login(data.token, data.user);

          if (window.is_frontend) {
            this.$router.push("/dashboard");
          } else {
            this.$router.push("/manage/dashboard");
          }
        })
        .catch(({ response }) => {
          alert(response.data.message);
        });
    },
  },
};
</script>
<style scoped lang="css">
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
