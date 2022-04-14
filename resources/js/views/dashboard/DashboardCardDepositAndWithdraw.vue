<template>
  <v-card>
    <div class="d-flex flex-sm-row flex-column">
      <div class="flex-grow-1">
        <v-card-title>
          <span class="me-3">Deposit</span>
          <v-spacer></v-spacer>
          <span class="text-xs text--disabled cursor-pointer">View All</span>
        </v-card-title>

        <v-card-text>
          <v-list>
            <v-list-item
              v-for="(data,index) in deposit"
              :key="index"
              :class="`d-flex px-0 ${index > 0 ? 'mt-4':''}`"
            >
              <v-img
                contain
                max-height="30"
                max-width="30"
                :src="data.img"
                class="me-3"
              ></v-img>

              <div class="d-flex align-center flex-grow-1 flex-wrap">
                <div class="me-auto pe-2">
                  <h4 class="font-weight-semibold">
                    {{ data.title }}
                  </h4>
                  <span class="text-xs">{{ data.subtitle }}</span>
                </div>

                <span class="font-weight-semibold success--text">{{ data.amount }}</span>
              </div>
            </v-list-item>
          </v-list>
        </v-card-text>
      </div>

      <v-divider
        class="my-sm-5 mx-5"
        :vertical="$vuetify.breakpoint.smAndUp"
      ></v-divider>

      <div class="flex-grow-1">
        <v-card-title>
          <span class="me-3">Withdraw</span>
          <v-spacer></v-spacer>
          <span class="text-xs text--disabled cursor-pointer">View All</span>
        </v-card-title>

        <v-card-text>
          <v-list>
            <v-list-item
              v-for="(data,index) in withdraw"
              :key="index"
              :class="`d-flex px-0 ${index > 0 ? 'mt-4':''}`"
            >
              <v-img
                max-height="30"
                max-width="30"
                :src="data.img"
                class="me-3"
              ></v-img>

              <div class="d-flex align-center flex-grow-1 flex-wrap">
                <div class="me-auto pe-2">
                  <h4 class="font-weight-semibold">
                    {{ data.title }}
                  </h4>
                  <span class="text-xs">{{ data.subtitle }}</span>
                </div>

                <span class="font-weight-semibold error--text">{{ data.amount }}</span>
              </div>
            </v-list-item>
          </v-list>
        </v-card-text>
      </div>
    </div>
  </v-card>
</template>

<script>
export default {
  setup() {
    const deposit = [
      {
        img: 'images/logos/gumroad.png',
        title: 'Gumroad Account',
        subtitle: 'Sell UI Kit',
        amount: '+$4,650',
      },
      {
        img: 'images/logos/master.png',
        title: 'Mastercard',
        subtitle: 'Wallet deposit',
        amount: '+$92,705',
      },
      {
        img: 'images/logos/stripe-account.png',
        title: 'Stripe Account',
        subtitle: 'iOS Application',
        amount: '+$957',
      },
      {
        img: 'images/logos/american-bank.png',
        title: 'American Bank',
        subtitle: 'Bank Transfer',
        amount: '+$6,837',
      },
      {
        img: 'images/logos/bank-account.png',
        title: 'Bank Account',
        subtitle: 'Wallet deposit',
        amount: '+$446',
      },
    ]
    const withdraw = [
      {
        img: 'images/logos/google.png',
        title: 'Google Adsense',
        subtitle: 'Paypal deposit',
        amount: '-$145',
      },
      {
        img: 'images/logos/github.png',
        title: 'Github Enterprise',
        subtitle: 'Security & compliance',
        amount: '-$1870',
      },
      {
        img: 'images/logos/slack.png',
        title: 'Upgrade Slack Plan',
        subtitle: 'Debit card deposit',
        amount: '-$450',
      },
      {
        img: 'images/logos/digital-ocean-logo.png',
        title: 'Digital Ocean',
        subtitle: 'Cloud Hosting',
        amount: '-$540',
      },
      {
        img: 'images/logos/amazon-web-services-logo.png',
        title: 'Bank Account',
        subtitle: 'Choosing a Cloud Platform',
        amount: '-$21',
      },
    ]

    return {
      deposit,
      withdraw,
    }
  },
}
</script>
