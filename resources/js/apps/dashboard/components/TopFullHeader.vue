  <template>
  <div class="header">
    <div class="header-content">
      <nav class="navbar navbar-expand">
        <div class="collapse navbar-collapse justify-content-between">
          <div class="header-left d-none d-sm-flex">
            Welcome to GIF 🎉 🎉 🏆 
          </div>
          <ul class="navbar-nav header-right main-notification">
            <li class="nav-item dropdown header-profile">
              <a class="btn btn-sm btn-primary" href="#" @click="logout">Logout</a>
              <b-dropdown
                size="lg"
                variant="link"
                toggle-class="text-decoration-none"
                no-caret
                class="nav-link"
                style="display: flex"
              >
                <template #button-content>
                  <img
                    class="rounded-circle"
                    src="@/assets/avatar.png"
                    width="20"
                    alt=""
                  />
                  <div class="header-info pl-2">
                    <span class="text-white d-block text-left"
                      >{{ $store.state.auth.user.firstName }}
                      {{ $store.state.auth.user.lastName }}</span
                    >
                    <small class="text-white d-block text-left"
                      >({{ $store.state.auth.user.username }})
                      {{
                        $store.state.auth.affiliate.summary.money_total
                          | toCurrency
                      }}</small
                    >
                  </div>
                </template>
                <b-dropdown-item href="#"> Profile</b-dropdown-item>
                <b-dropdown-divider></b-dropdown-divider>
                <b-dropdown-item href="#"> All Members</b-dropdown-item>
                <b-dropdown-item href="#">Pro Members</b-dropdown-item>
                <b-dropdown-item href="#">Expired Members</b-dropdown-item>
                <b-dropdown-item href="#">Free Members</b-dropdown-item>
                <b-dropdown-divider></b-dropdown-divider>
                <b-dropdown-item href="#">Mass Pay</b-dropdown-item>
                <b-dropdown-item href="#">Generate MassPay</b-dropdown-item>
                <b-dropdown-divider></b-dropdown-divider>
                <b-dropdown-item href="#">Tokens</b-dropdown-item>
                <b-dropdown-item href="#">Transaction History</b-dropdown-item>
                <b-dropdown-item href="#">Members Withdrawal</b-dropdown-item>
                <b-dropdown-item href="#">Member Payments</b-dropdown-item>
                <b-dropdown-divider></b-dropdown-divider>
                <b-dropdown-item href="#">Email Notifications</b-dropdown-item>
                <b-dropdown-item href="#">Newsletter</b-dropdown-item>
                <b-dropdown-item href="#">Auto Newsletter</b-dropdown-item>
                <b-dropdown-item href="#">Subscriber</b-dropdown-item>
                <b-dropdown-divider></b-dropdown-divider>
              </b-dropdown>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      title: "",
    };
  },

  methods: {
    logout() {
      this.$store.commit("auth/logout");
      this.$router.push("/login");
    },
  },
};
</script>
