  <template>
  <!--**********************************
            Sidebar start
        ***********************************-->
  <div class="deznav">
    <div class="deznav-scroll">
      <ul class="metismenu" id="menu">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library   class="mm-active" -->

        <li
          v-for="(menu, index) in menus"
          :key="index"
          :class="[menu.active ? 'mm-active' : '']"
        >
          <a
            class="has-arrow ai-icon"
            aria-expanded="false"
            @click="toggleCollapsed(index)"
          >
            <i class="flaticon-144-layout"></i>
            <span class="nav-text">{{ menu.title }}</span>
          </a>
          <ul
            aria-expanded="false"
            :class="[!menu.active ? 'mm-collapse' : '']"
          >
            <li v-for="(child, tindex) in menu.children" :key="tindex">
              <router-link
                :class="[
                  pathRouteParse($route.path) == child.url ? 'mm-active' : '',
                ]"
                :to="child.url"
              >
                {{ child.title }}
              </router-link>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
  <!--**********************************
            Sidebar end
        ***********************************-->
</template>

<script>
export default {
  created() {
    this.loadFirst();
  },
  watch: {
    $route(to, from) {
      this.routeListener(to.path);
    },
  },
  data() {
    return {
      title: "",
      menus: [
        {
          title: "Userprofile",
          active: true,
          children: [
            { title: "Userprofile", url: "/manage/user/user" },
            { title: "Group", url: "/manage/user/group" },
          ],
        },
        {
          title: "Affiliate",
          active: false,
          children: [
            { title: "Affiliate", url: "/manage/affiliate/affiliate" },
            {
              title: "Matrix",
              url: "/manage/affiliate/matrix",
            },
            {
              title: "Package",
              url: "/manage/affiliate/package",
            },
            {
              title: "Penalty",
              url: "/manage/affiliate/penalty",
            },
            {
              title: "Profitshare",
              url: "/manage/affiliate/profitshare",
            },
            { title: "Rank", url: "/manage/affiliate/rank" },
            {
              title: "Agreement",
              url: "/manage/affiliate/agreement",
            },
            {
              title: "Matrix Passup Gap",
              url: "/manage/affiliate/matrixpassupgap",
            },
          ],
        },
        {
          title: "Subscription",
          active: false,
          children: [
            { title: "Subscription", url: "/manage/subscription/subscription" },
            { title: "Package", url: "/manage/subscription/package" },
          ],
        },
        {
          title: "Hosting",
          active: false,
          children: [
            { title: "Hosting", url: "/manage/hosting/hosting" },
            { title: "Server", url: "/manage/hosting/server" },
            { title: "Package", url: "/manage/hosting/package" },
          ],
        },
        {
          title: "Domain",
          active: false,
          children: [
            { title: "Domain", url: "/manage/domain/domain" },
            { title: "Registrar", url: "/manage/domain/registrar" },
            { title: "Price", url: "/manage/domain/price" },
          ],
        },
        {
          title: "Airtime",
          active: false,
          children: [
            { title: "Airtime", url: "/manage/airtime/airtime" },
            { title: "Number", url: "/manage/airtime/number" },
            { title: "Provider", url: "/manage/airtime/provider" },
            { title: "Prefix", url: "/manage/airtime/prefix" },
          ],
        },
        {
          title: "Withdraw",
          active: false,
          children: [
            { title: "Withdraw", url: "/manage/withdraw/withdraw" },
            { title: "Gateway", url: "/manage/withdraw/gateway" },
            { title: "Masspay", url: "/manage/withdraw/masspay" },
            { title: "Setting", url: "/manage/withdraw/setting" },
            { title: "Blacklist", url: "/manage/withdraw/blacklist" },
            { title: "Whitelist", url: "/manage/withdraw/whitelist" },
            { title: "Allowedin", url: "/manage/withdraw/allowedin" },
            { title: "Disallowedin", url: "/manage/withdraw/disallowedin" },
          ],
        },
        {
          title: "Newsletter",
          active: false,
          children: [
            { title: "Newsletter", url: "/manage/newsletter/newsletter" },
            { title: "Autoresponder", url: "/manage/newsletter/autoresponder" },
            { title: "Group", url: "/manage/newsletter/group" },
            { title: "Subscriber", url: "/manage/newsletter/subscriber" },
            { title: "Blacklist", url: "/manage/newsletter/blacklist" },
            { title: "Whitelist", url: "/manage/newsletter/whitelist" },
            { title: "User Email", url: "/manage/newsletter/template" },
            { title: "Theme Template", url: "/manage/newsletter/theme" },
            { title: "Regular Queue", url: "/manage/newsletter/queue" },
          ],
        },
        {
          title: "Payment",
          active: false,
          children: [
            { title: "Payment", url: "/manage/payment/payment" },
            { title: "Transaction", url: "/manage/payment/payment" },
            { title: "Wallet", url: "/manage/payment/wallet" },
            { title: "Coupon", url: "/manage/payment/coupon" },
            { title: "Gateway", url: "/manage/payment/gateway" },
            {
              title: "Gateway Allowedin",
              url: "/manage/payment/gatewayallowedin",
            },
            {
              title: "Gateway Disallowedin",
              url: "/manage/payment/gatewaydisallowedin",
            },
            { title: "Payment Coupon", url: "/manage/payment/paymentcoupon" },
            { title: "Payment Item", url: "/manage/payment/paymentitem" },
            { title: "Payment Rate", url: "/manage/payment/paymentrate" },
            { title: "Payment Source", url: "/manage/payment/source" },
            { title: "Rate", url: "/manage/payment/rate" },
            { title: "Rate Allowedin", url: "/manage/payment/rateallowedin" },
            {
              title: "Rate Disallowedin",
              url: "/manage/payment/ratedisallowedin",
            },
            { title: "Rate File", url: "/manage/payment/ratefile" },
            { title: "Token", url: "/manage/payment/token" },
            { title: "Token Category", url: "/manage/payment/tokencategory" },
          ],
        },
        {
          title: "Kopokopo",
          active: false,
          children: [
            {
              title: "Transaction",
              url: "/manage/paymentkopokopo/transaction",
            },
          ],
        },
        {
          title: "Business",
          active: false,
          children: [
            { title: "Business", url: "/manage/business/business" },
            { title: "Category", url: "/manage/business/category" },
          ],
        },
        {
          title: "Campaign",
          active: false,
          children: [
            { title: "Email", url: "/manage/campaign/email" },
            { title: "Landing Page", url: "/manage/campaign/landingpage" },
            {
              title: "Template Banner",
              url: "/manage/campaign/templatebanner",
            },
            { title: "Template Email", url: "/manage/campaign/templateemail" },
            { title: "Template SMS", url: "/manage/campaign/templatesms" },
            { title: "Template Tweet", url: "/manage/campaign/templatetweet" },
          ],
        },

        {
          title: "Ticket",
          active: false,
          children: [
            { title: "Ticket", url: "/manage/ticket/ticket" },
            { title: "Category", url: "/manage/ticket/category" },
            { title: "Team", url: "/manage/ticket/team" },
            { title: "Department", url: "/manage/ticket/department" },
          ],
        },
        {
          title: "Product",
          active: false,
          children: [
            { title: "Product", url: "/manage/product/product" },
            { title: "Category", url: "/manage/product/category" },
          ],
        },
        {
          title: "Transfer",
          active: false,
          children: [
            { title: "Transfer", url: "/manage/transfer/transfer" },
            { title: "Blacklist", url: "/manage/transfer/blacklist" },
            { title: "Whitelist", url: "/manage/transfer/whitelist" },
            { title: "Allowedin", url: "/manage/transfer/allowedin" },
            { title: "Disallowedin", url: "/manage/transfer/disallowedin" },
          ],
        },
        {
          title: "Setup",
          active: false,
          children: [
            { title: "Currency", url: "/manage/setup/currency" },
            { title: "Country", url: "/manage/setup/country" },
            { title: "Dataset", url: "/manage/setup/dataset" },
            { title: "Cron", url: "/manage/setup/cron" },
            { title: "Location", url: "/manage/setup/location" },
          ],
        },
        {
          title: "Product",
          active: false,
          children: [
            { title: "Product", url: "/manage/product/product" },
            { title: "Category", url: "/manage/product/category" },
          ],
        },
      ],
    };
  },
  methods: {
    loadFirst: function () {
      this.clearMenu();
      this.menus[0].active = true;
    },
    routeListener: function (to) {
      this.menus.forEach((main, index) => {
        main.active = false;

        main.children.forEach((child) => {
          if (child.url == this.pathRouteParse(to)) {
            main.active = true;
          }
        });
      });
    },
    toggleCollapsed: function (i) {
      this.clearMenu();
      this.menus[i].active = !this.menus[i].active;
    },
    clearMenu: function () {
      this.menus.forEach((main, index) => {
        main.active = false;
      });
    },
    pathRouteParse: function (path_str) {
      if (path_str.indexOf("/edit") !== -1) {
        let new_path_arr = path_str.split("/edit");
        path_str = new_path_arr[0];
      }

      if (path_str.indexOf("/delete") !== -1) {
        let new_path_arr = path_str.split("/delete");
        path_str = new_path_arr[0];
      }
      console.log(path_str);

      return path_str;
    },
  },
};
</script>
