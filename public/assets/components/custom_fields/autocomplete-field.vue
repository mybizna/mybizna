<template>
  <div>
    <input
      type="text"
      :placeholder="schema.placeholder"
      v-model="keywords"
      v-on:keyup="autoComplete"
      class="form-control"
    >
    <input type="hidden" v-model="value">

    <div class="panel-footer" v-if="data_results.length">
      <ul class="list-group">
        <li class="list-group-item" v-for="result in data_results" :key="result.id">{{ result.name }}</li>
      </ul>
    </div>
  </div>
</template>

<script>
import { abstractField } from "vue-form-generator";

export default {
  mixins: [abstractField],
  data: function() {
    return {
      timeout: null,
      keywords: "",
      data_results: []
    };
  },
  methods: {
    autoComplete() {
      this.data_results = [];
      if (this.keywords.length > 2) {
        clearTimeout(this.timeout);

        this.timeout = setTimeout(function() {

          window.axios
            .get("/autocomplete", {
              params: { keywords: this.keywords }
            })
            .then(response => {
              console.log(response);
              this.data_results = response.data;
            });

        }, 1000);
      }
    }
  }
};
</script>