<template>
  <v-container fluid fill-height>
    <v-layout align-center justify-center row>
      <div class="mr-3 hidden-sm-and-down">
        <img src="/images/apps/elearning_icon.png" alt>
      </div>
      <div class="text-md-center">
        <h1>Redirecting</h1>
        <h2 class="my-3 headline">Redirecting... Please Wait.</h2>
      </div>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  methods: {
    goHome() {
      this.$router.push({ path: "/" });
    }
  }
};
</script>
<style scoped lang="css">
h1 {
  font-size: 150px;
  line-height: 150px;
  font-weight: 700;
  color: #252932;
  text-shadow: rgba(61, 61, 61, 0.3) 1px 1px, rgba(61, 61, 61, 0.2) 2px 2px,
    rgba(61, 61, 61, 0.3) 3px 3px;
}
</style>
