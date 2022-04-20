<template>
  <b-dropdown class="dropdown-dropup" dropup variant="outline-primary" no-caret>
    <template #button-content>
      <i class="fa fa-cogs text-primary"></i>
    </template>
    <template v-for="(dropdown_menu, index) in dropdown_menu_list">
      <b-dropdown-divider
        :key="index"
        v-if="dropdown_menu.title == 'separator'"
      ></b-dropdown-divider>
      <b-dropdown-item
        v-else
        :key="index"
        :href="dropdown_menu.link"
        :alt="dropdown_menu.title"
        class="text-primary p-0"
      >
        {{ dropdown_menu.title }}
      </b-dropdown-item>
    </template>
  </b-dropdown>
</template>

<script>
export default {
  props: {
    prop_item: Object,
    dropdown_menu_list: Array,
    field_list: Array,
  },
  created() {
    this.prepareMenuLinks();
  },
  data() {
    return {
      generated_url: "",
      dropdown_menu: [],
    };
  },
  methods: {
    prepareMenuLinks() {
      var t = this;

      t.dropdown_menu_list.forEach(function (dropdown_menu_single) {
        var generated_url = "";
        var url_obj = "";

        if (dropdown_menu_single.param && dropdown_menu_single.param.length) {
          var param_list = dropdown_menu_single.param;
          var param = {};

          param_list.forEach(function (param_single) {
            param[param_single] = t.prop_item[param_single];
          });

          url_obj = t.$router.resolve({
            name: dropdown_menu_single.name,
            params: param,
          });

          dropdown_menu_single["link"] = url_obj.href;
        } else {
          url_obj = t.$router.resolve({
            name: dropdown_menu_single.name,
          });

          dropdown_menu_single["link"] = url_obj.href;
        }

        t.dropdown_menu = dropdown_menu_single;
      });
    },
  },
};
</script>
