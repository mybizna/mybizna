<template>
    <div id="themeSetting">
        <v-tabs color="cyan" dark slider-color="yellow">
            <v-tab href="#tab-1"> <v-icon icon="fas fa-plus">list</v-icon>Links </v-tab>

            <v-tab href="#tab-2"> <v-icon icon="fas fa-plus">build</v-icon>Theme </v-tab>

            <v-tab-item value="tab-1">
                <v-card flat>
                    <v-card-text>
                        <ul class="sidebar-menu">
                            <li class="treeview">
                                <b style="padding: 7px 0; display: block"
                                    >Subscription</b
                                >
                                <ul class="menu-open">
                                    <li style="padding: 5px 0">
                                        <router-link
                                            :to="{
                                                name: 'manage.affiliate.affiliate',
                                            }"
                                            >All Members</router-link
                                        >
                                    </li>
                                    <li style="padding: 5px 0">
                                        <router-link
                                            :to="{
                                                name: 'manage.affiliate.affiliate',
                                                query: { status: 1 },
                                            }"
                                            >Pro Members</router-link
                                        >
                                    </li>
                                    <li style="padding: 5px 0">
                                        <router-link
                                            :to="{
                                                name: 'manage.affiliate.affiliate',
                                                query: {
                                                    status: 0,
                                                    placement: 1,
                                                },
                                            }"
                                            >Expired Members</router-link
                                        >
                                    </li>
                                    <li style="padding: 5px 0">
                                        <router-link
                                            :to="{
                                                name: 'manage.affiliate.affiliate',
                                                query: {
                                                    status: 0,
                                                    placement: 0,
                                                },
                                            }"
                                            >Free Members</router-link
                                        >
                                    </li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <b style="padding: 7px 0; display: block"
                                    >Finance</b
                                >
                                <ul>
                                    <li style="padding: 5px 0">
                                        <router-link
                                            :to="{ name: 'manage.token.token' }"
                                            >Tokens</router-link
                                        >
                                    </li>
                                    <li style="padding: 5px 0">
                                        <router-link
                                            :to="{
                                                name: 'manage.transaction.transaction',
                                                params: { is_profitshare: 1 },
                                            }"
                                            >Commission History</router-link
                                        >
                                    </li>
                                    <li style="padding: 5px 0">
                                        <router-link
                                            :to="{
                                                name: 'manage.transaction.transaction',
                                            }"
                                            >Transaction History</router-link
                                        >
                                    </li>
                                    <li style="padding: 5px 0">
                                        <router-link
                                            :to="{
                                                name: 'manage.withdraw.withdraw',
                                            }"
                                            >Members Withdrawal</router-link
                                        >
                                    </li>
                                    <li style="padding: 5px 0">
                                        <router-link
                                            :to="{
                                                name: 'manage.payment.payment',
                                            }"
                                            >Member Payments</router-link
                                        >
                                    </li>
                                    <li style="padding: 5px 0">
                                        <router-link
                                            :to="{
                                                name: 'manage.payment.gateway',
                                            }"
                                            >Payment Gateways</router-link
                                        >
                                    </li>
                                    <li style="padding: 5px 0">
                                        <router-link
                                            :to="{
                                                name: 'manage.withdraw.masspay',
                                            }"
                                            >Mass Pay</router-link
                                        >
                                    </li>
                                    <li>
                                        <a
                                            href="/generatemasspay"
                                            target="_blank"
                                            >Generate MassPay</a
                                        >
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <b style="padding: 7px 0; display: block"
                                    >Email Notifications</b
                                >
                                <ul>
                                    <li style="padding: 5px 0">
                                        <router-link
                                            :to="{
                                                name: 'manage.newsletter.autoresponder',
                                            }"
                                            >Newsletter
                                            Autoresponder</router-link
                                        >
                                    </li>
                                    <li style="padding: 5px 0">
                                        <router-link
                                            :to="{
                                                name: 'manage.newsletter.category',
                                            }"
                                            >Newsletter Category</router-link
                                        >
                                    </li>
                                    <li style="padding: 5px 0">
                                        <router-link
                                            :to="{
                                                name: 'manage.newsletter.newsletter',
                                            }"
                                            >Newsletter</router-link
                                        >
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </v-card-text>
                </v-card>
            </v-tab-item>

            <v-tab-item value="tab-2">
                <v-card flat>
                    <v-card-text>
                        <v-toolbar color="blue" dark>
                            <v-toolbar-title>Theme Settings</v-toolbar-title>
                        </v-toolbar>
                        <v-container>
                            <v-layout column>
                                <v-flex>
                                    <v-subheader class="px-1 my-2"
                                        >Color Option</v-subheader
                                    >
                                    <div class="color-option">
                                        <v-layout wrap>
                                            <label
                                                class="color-option--label flex xs6 pa-1"
                                                v-for="(
                                                    option, index
                                                ) in themeColorOptions"
                                                :key="index"
                                            >
                                                <input
                                                    type="radio"
                                                    name="color"
                                                    v-bind:value="option.key"
                                                    v-model="themeColor"
                                                />
                                                <span
                                                    class="color-option--item bg"
                                                >
                                                    <span class="overlay">
                                                        <span
                                                            class="material-icons"
                                                            >check</span
                                                        >
                                                    </span>
                                                    <span
                                                        class="color-option--item--header sideNav"
                                                        :class="
                                                            option.value.sideNav
                                                        "
                                                    ></span>
                                                    <span
                                                        class="color-option--item--header mainNav"
                                                        :class="
                                                            option.value.mainNav
                                                        "
                                                    ></span>
                                                    <span
                                                        class="sideMenu"
                                                        :class="
                                                            option.value
                                                                .sideManu
                                                        "
                                                    ></span>
                                                </span>
                                            </label>
                                        </v-layout>
                                    </div>
                                    <div class="theme-options">
                                        <v-subheader class="px-1 my-2"
                                            >Sidebar Option</v-subheader
                                        >
                                        <v-divider></v-divider>
                                        <div class="my-3">
                                            <v-btn-toggle
                                                v-model="sideBarOption"
                                            >
                                                <v-btn flat value="dark"
                                                    >Dark</v-btn
                                                >
                                                <v-btn flat value="light"
                                                    >Light</v-btn
                                                >
                                            </v-btn-toggle>
                                        </div>
                                    </div>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card-text>
                </v-card>
            </v-tab-item>
        </v-tabs>
    </div>
</template>

<script>
import colors from "vuetify/es5/util/colors";
import { ref } from "vue";
export default {
    data() {
        return {
            themeColor: "indigo",
            sideBarOption: "light",
            colors: colors,
        };
    },
    computed: {
        themeColorOptions() {
            return [
                {
                    key: "blue",
                    value: {
                        sideNav: "blue",
                        mainNav: "blue",
                        sideManu: "white",
                    },
                },
                // {
                //   key: 'lightBlue',
                //   value: {
                //     sideNav: 'blue',
                //     mainNav: 'white',
                //     sideManu: 'blue lighten-1'
                //   }
                // },
                {
                    key: "teal",
                    value: {
                        sideNav: "teal",
                        mainNav: "teal",
                        sideManu: "white",
                    },
                },
                {
                    key: "red",
                    value: {
                        sideNav: "red",
                        mainNav: "red",
                        sideManu: "white",
                    },
                },
                {
                    key: "orange",
                    value: {
                        sideNav: "orange",
                        mainNav: "orange",
                        sideManu: "white",
                    },
                },
                {
                    key: "purple",
                    value: {
                        sideNav: "purple",
                        mainNav: "purple",
                        sideManu: "white",
                    },
                },
                {
                    key: "indigo",
                    value: {
                        sideNav: "indigo",
                        mainNav: "indigo",
                        sideManu: "white",
                    },
                },
                {
                    key: "cyan",
                    value: {
                        sideNav: "cyan",
                        mainNav: "cyan",
                        sideManu: "white",
                    },
                },
                {
                    key: "pink",
                    value: {
                        sideNav: "pink",
                        mainNav: "pink",
                        sideManu: "white",
                    },
                },
                {
                    key: "green",
                    value: {
                        sideNav: "green",
                        mainNav: "green",
                        sideManu: "white",
                    },
                },
            ];
        },
    },
    watch: {
        themeColor: {
            handler(val) {
                const theme = ref("light");
                theme.primary = this.colors[val].base;
            },
            immediate: true,
        },
        sideBarOption: {
            handler(val) {
                theme.dark = val === "dark";
            },
            immediate: true,
        },
    },
};
</script>
<style lang="stylus" scoped>
.color-option {
  &--label {
    position: relative;
    display: block;
    cursor: pointer;

    & input[type='radio'] {
      display: none;

      &+span {
        position: relative;

        &>.overlay {
          display: none;
          position: absolute;
          top: 0;
          bottom: 0;
          right: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background-color: rgba(0, 0, 0, 0.3);
          text-align: center;
          line-height: 30px;
          color: #fff;
        }
      }

      &:checked+span>.overlay {
        display: block;
      }
    }

    & .bg {
      background-color: #f1f1f1;
    }
  }

  &--item {
    overflow: hidden;
    display: block;
    box-shadow: 0 0 2px rgba(0, 0, 0, 0.1);
    margin-bottom: 15px;

    &--header {
      height: 10px;
    }

    &>span {
      display: block;
      float: left;
      width: 50%;
      height: 20px;
    }
  }
}
</style>
