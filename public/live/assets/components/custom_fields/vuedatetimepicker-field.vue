<template>
  <date-picker
    v-model="value"
    type="datetime"
    :show-time-panel="showTimePanel"
    @close="handleOpenChange"
  >
    <template v-slot:footer>
      <button class="mx-btn mx-btn-text" @click="toggleTimePanel">
        {{ showTimePanel ? "select date" : "select time" }}
      </button>
    </template>
  </date-picker>
</template>

<script>
//    :format="{ year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: '2-digit', timeZoneName: 'short' }"
import { abstractField } from "vue-form-generator";
import DatePicker from "vue2-datepicker";

import "vue2-datepicker/index.css";

export default {
  mixins: [abstractField],
  data() {
    return {
      showTimePanel: false,
      showTimeRangePanel: false,
    };
  },
  components: { DatePicker },
  methods: {
    toggleTimePanel() {
      this.showTimePanel = !this.showTimePanel;
    },
    handleOpenChange() {
      this.showTimePanel = false;
    },
  },
};
</script>