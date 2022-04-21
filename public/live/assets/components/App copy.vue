<template>
  <div
    v-if="login"
    data-typography="poppins"
    data-theme-version="light"
    data-layout="vertical"
    data-nav-headerbg="color_14"
    data-headerbg="color_14"
    :data-sidebar-style="$store.state.system.layout"
    data-sibebarbg="color_1"
    data-sidebar-position="fixed"
    data-header-position="fixed"
    data-container="wide"
    direction="ltr"
    data-primary="color_1"
  >
    <div
      id="main-wrapper"
      :class="[$store.state.system.sidebar_show ? 'show menu-toggle' : 'show']"
    >
      <top-chat></top-chat>
      <top-header></top-header>
      <top-full-header></top-full-header>
      <sidebar></sidebar>
      <notifications position="top center" duration="4000"/>


      <!--**********************************
            Content body start
        ***********************************-->
      <div class="content-body">
        <div class="container-fluid">
          <router-view />
        </div>
      </div>

      <!--**********************************
            Content body end
        ***********************************-->

      <!--**********************************
            Footer start
        ***********************************-->
      <div class="footer">
        <div class="copyright">
          <p>
            Copyright ©
            <a href="http://globalinternetfortunes.com/" target="_blank"
              >Global Internet Fortunes Ltd</a
            >
            2012 - 2021
          </p>
        </div>
      </div>
      <!--**********************************
            Footer end
        ***********************************-->
    </div>
  </div>
  <div
    v-else
    data-typography="poppins"
    data-theme-version="light"
    data-layout="vertical"
    data-nav-headerbg="color_14"
    data-headerbg="color_14"
    :data-sidebar-style="$store.state.system.layout"
    data-sibebarbg="color_1"
    data-sidebar-position="fixed"
    data-header-position="fixed"
    data-container="wide"
    direction="ltr"
    data-primary="color_1"
    class="vh-100"
  >

    <notifications width="50%" position="top right"/>

    <div
      id="main-wrapper"
      :class="[$store.state.system.sidebar_show ? 'show menu-toggle' : 'show']"
    >
      <!--**********************************
            Content body start
        ***********************************-->
      <router-view />

      <!--**********************************
            Content body end
        ***********************************-->
    </div>
  </div>
</template>

<script>
import TopChat from "@/components/common/theme/TopChat";
import TopHeader from "@/components/common/theme/TopHeader";
import TopFullHeader from "@/apps/dashboard/components/TopFullHeader";
import Sidebar from "@/apps/dashboard/components/Sidebar";

export default {
  components: {
    TopChat,
    TopHeader,
    TopFullHeader,
    Sidebar,
  },

  data() {
    return {
      width: 1400,
      sidebar: {
        style: "mini",
      },
    };
  },
  computed: {
    login() {
      return this.$store.getters["auth/loggedIn"];
    },
  },
  created() {
    this.$store.commit("system/layout", "mini");
    this.width = window.innerWidth;
    window.addEventListener("resize", this.myEventHandler);

    this.setMenuStyle();
  },
  destroyed() {
    window.removeEventListener("resize", this.myEventHandler);
  },
  methods: {
    myEventHandler(e) {
      this.width = window.innerWidth;
      this.setMenuStyle();
      // your code for handling resize...
    },

    setMenuStyle: function () {
      console.log(this.width);

      if (this.width > 1024) {
        this.$store.commit("system/layout", "full");
      } else {
        this.$store.commit("system/layout", "overlay");
      }
    },
  },
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

#nav {
  padding: 30px;
}

#nav a {
  font-weight: bold;
  color: #2c3e50;
}

#nav a.router-link-exact-active {
  color: #42b983;
}
</style>
