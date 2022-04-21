  <template>
  <!--**********************************
            Nav header start
        ***********************************-->
  <div class="nav-header">
    <router-link :to="'/'" class="brand-logo">
      <img
        class="m-3 rounded"
        src="image/logo.png"
      />
    </router-link>

    <div class="nav-control" @click="sidebar_show">
      <div class="hamburger">
        <span class="line"></span>
        <span class="line"></span>
        <span class="line"></span>
      </div>
    </div>
  </div>
  <!--**********************************
            Nav header end
        ***********************************-->
</template>

<script>
export default {
  data() {
    return {
      title: "",
    };
  },
  methods: {
    sidebar_show() {
      this.$store.commit(
        "system/sidebar_show",
        !this.$store.state.system.sidebar_show
      );
    },
  },
};
</script>
