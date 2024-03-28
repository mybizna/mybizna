<template>
  <login></login>
</template>

<script>

// demos

export default {
  components: {
    Login: window.$func.fetchComponent(
      "base/guest/Login.vue"
    )
  },
};
</script>
