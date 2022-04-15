<template>
  <div>
    <div class="offset-sm-2 offset-lg-3 col-sm-8 col-lg-6">
      <div class="card mt-5">
        <div class="card-body">
          <h1 class="display-3 text-center">Thank You!</h1>

          <p class="lead text-center">
            <strong
              >Please enter code that was sent to your email address
            </strong>
          </p>

          <div class="text-center">
            <p>Enter Code:</p>
          </div>

          <div class="text-center">
            <input
              class="form-control d-inline-block"
              id="id_code"
              max="999999"
              min="100000"
              name="code"
              placeholder="code"
              required=""
              title=""
              type="number"
              v-model="code"
              style="max-width: 350px"
            />
          </div>

          <div class="text-center mt-3">
            <button class="btn btn-secondary btn-sm mb-3" @click="validation">
              VALIDATE
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: () => ({
    code: "",
  }),
  methods: {
    goHome() {
      //this.$router.push({ path: "/" });
    },
    validation() {
      this.$recaptchaLoaded().then(() => {
        console.log("recaptcha loaded");
        this.$recaptcha("login").then((token) => {
          var tmp_query_str = "?code=" + this.code;

          window.axios
            .get("/user/validate_account/" + tmp_query_str)
            .then((res) => {
              if (!res.data.has_error) {
                this.$router.push("login");
              } else {
                this.notification("Error:" + res.data.error_message);
              }
            });
        });
      });
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
h1 {
  color: #252932;
  text-shadow: rgba(61, 61, 61, 0.3) 1px 1px, rgba(61, 61, 61, 0.2) 2px 2px,
    rgba(61, 61, 61, 0.3) 3px 3px;
}
</style>
