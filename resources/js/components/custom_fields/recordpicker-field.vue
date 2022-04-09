<template>
  <div class="row">
    <div class="col-sm-8">
      <input
        class="form-control"
        type="text"
        v-model="value"
        :placeholder="schema.placeholder"
      />
    </div>
    <div class="col-sm-4">
      <a @click="show = true" class="btn btn-primary btn-sm text-white">
        Picker
      </a>
    </div>

    <b-modal
      :id="modal_name"
      v-model="show"
      title="Modal Variants"
      size="xl"
      hide-footer
      >RecordPicker</b-modal>
  </div>
</template>

<script>

import { abstractField } from "vue-form-generator";

export default {
  /*components: {
    AffiliateList,
  },*/
  mixins: [abstractField],
  data: function () {
    return {
      is_recordpicker: true,
      modal_name: "modal_name",
      show: false,
      headerBgVariant: "info",
      headerTextVariant: "light",
    };
  },
  methods: {
    recordPicker(pk) {
      this.show = false;
      this.value = pk;
    },
  },
};
</script>
