<template>
  <div class="row mt-5">
    <div class="col-6 col-md-3">
      <image-link
        icon="fa fa-users"
        title="Affiliate"
        image="images/apps/affiliate_icon.png"
        url="affiliate/affiliate"
      ></image-link>
    </div>
    <div class="col-6 col-md-3">
      <image-link
        icon="fa fa-phone"
        title="Airtime"
        image="images/apps/airtime_icon.png"
        url="airtime/airtime"
      ></image-link>
    </div>
    <div class="col-6 col-md-3">
      <image-link
        icon="fa fa-server"
        title="Hosting"
        image="images/apps/hosting_icon.png"
        url="hosting/hosting"
      ></image-link>
    </div>
    <div class="col-6 col-md-3">
      <image-link
        icon="fa fa-money"
        title="Payment"
        image="images/apps/payment_icon.png"
        url="payment/payment"
      ></image-link>
    </div>
  </div>
</template>

<script>
import menu from "@/components/router/menu.js";
import ImageLink from "@/components/common/widgets/link/ImageLink";

import { pathParamHelper } from "@/components/helpers";
import { fetchRecordHelper } from "@/components/helpers";

export default {
  components: {
    ImageLink,
  },
  created() {
    this.user = JSON.parse(localStorage.getItem("user"));

    this.getRankData(this.user.id);
  },
  data: () => ({
    menus: menu,
    selectedTab: "tab-1",
    rank_arr: [
      {
        value: 100,
        name: "Fetching...",
      },
    ],
    user: {},
    affiliate: {},
  }),
  watch: {
    affiliate() {
      var tmp_rank_arr = this.affiliate.ranksData;
      var tmp_rank_str = atob(tmp_rank_arr);
      var tmp_rank_obj = JSON.parse(tmp_rank_str);

      this.rank_arr = tmp_rank_obj;
    },
  },
  methods: {
    getRankData(user_id) {
      var path_param = pathParamHelper(["affiliate", "affiliate"]);

      var schema_fields = ["id", "ranksData"];

      var query_str = "user_id:" + user_id;

      var record = fetchRecordHelper(
        this,
        path_param,
        schema_fields,
        query_str,
        "findany_",
        "affiliate"
      );
    },
  },
};
</script>
