<template>
  <datetime
    input-class="form-control"
    type="datetime"
    v-model="value"
    format="yyyy-MM-dd HH:mm:ss"
    value-zone="America/New_York"
    zone="Asia/Shanghai"
    :phrases="{ok: 'Continue', cancel: 'Exit'}"
    :hour-step="2"
    :minute-step="15"
    :week-start="7"
    use12-hour
    auto
  ></datetime>
</template>

<script>
//    :format="{ year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: '2-digit', timeZoneName: 'short' }"
import { abstractField } from "vue-form-generator";
import { Datetime } from "vue-datetime";

export default {
  mixins: [abstractField],
  components: {
    datetime: Datetime,
  },
  data() {
    return {
      auto: true,
      date: new Date(),
      options: {
        format: "DD/MM/YYYY",
        useCurrent: false,
      },
    };
  },
};
</script>