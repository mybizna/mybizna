<template>
  <div class="card greeting-card">
    <div class="card-body">
      <div class="row ma-0 pa-0">

        <div class="col-8">
          <h2>
            Welcome Back {{ $store.state.auth.user.name }}! 🥳
          </h2>
          <small class="card-subtitle text-no-wrap ps-2">
            Keep improving the sales.
          </small>
          <div class="card-text d-flex align-center mt-2 pb-2 ps-2">
            <div>
              <button class="btn btn-primary" href="#/account/admin/invoice">
                View Invoices
              </button>
            </div>
          </div>
        </div>

        <div class="col-4 greeting-card-trophy-wrapper">
          <img height="108px" style="max-width:83px;" class="greeting-card-trophy"
            :src="this.$assets_url + '/images/misc/trophy.png'" />
        </div>

      </div>
    </div>
  </div>
</template>

<style >
.greeting-card-trophy-wrapper {
  background-image: url('images/misc/triangle-light.png');
  background-repeat: no-repeat;
  background-position: right;
  background-size: cover;
}

.greeting-card {
  position: relative;
}

.greeting-card .greeting-card-bg {
  position: absolute;
  bottom: 0;
  right: 0;
}

.greeting-card.greeting-card-trophy {
  position: absolute;
  bottom: 10%;
  right: 8%;
}

.v-application .v-application--is-rtl .greeting-card-bg {
  right: initial;
  left: 0;
  transform: rotateY(180deg);
}

.v-application .v-application--is-rtl .greeting-card-trophy {
  left: 8%;
  right: initial;
}
</style>
