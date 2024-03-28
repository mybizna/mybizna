<template>
  <register></register>
</template>

<script>

// demos

export default {
  components: {
    Register: window.$func.fetchComponent(
      "base/guest/Register.vue"
    )
  },
};
</script>
