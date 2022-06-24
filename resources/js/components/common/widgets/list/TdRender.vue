<template>
  <td v-if="is_template" :class="class_name">{{ pass_string }}</td>
  <td v-else :class="class_name" v-html="reversedData">
</template>

<script>
/* eslint-disable vue/no-unused-components */
export default {
  components: {
  },
  props: {
    pitem: Object,
    data_field: Object,
    field_list: Array,
    class_name: String,
  },
  data() {
    return {
      pass_template: `<td>{{ pass_string }}</td>`,
      pass_string: `N/A`,
      is_template: false,
      cost: 2000
    };
  },
  created() {
    var t = this;
    var prop_str = t.data_field.prop;

    if (prop_str.indexOf("pitem") != -1) {
      t.is_template = true;
      t.cost = 1000;
      t.pass_template = `<td>${prop_str}</td>`;
    }

  },
  computed: {
    // a computed getter
    reversedData: function () {
      var t = this;
      var data_str;
      var prop_str = t.data_field.prop;
      var has_multiple_fields = false;

      if (prop_str.indexOf("[") != -1) {
        has_multiple_fields = true;
      }

      data_str = this.getDataStr(has_multiple_fields, prop_str);

      if (t.data_field.is_boolean) {
        if (parseInt(data_str)) {
          data_str =
            '<i class="fa fa-check-circle fa-2x" style="color:#4caf50;"></i>';
        } else {
          data_str =
            '<i class="fa fa-times-circle fa-2x" style="color:#ff5252;"></i>';
        }
      }

      if (data_str != "" && t.data_field.is_datetime) {
        let dateparse = new Date(Date.parse(data_str));

        data_str =
          dateparse.getTime() === dateparse.getTime()
            ? this.$moment(data_str).format("D MMM YYYY HH:mm:ss")
            : "";
      }

      if (data_str != "" && t.data_field.is_date) {
        let dateparse = new Date(Date.parse(data_str));
        data_str =
          dateparse.getTime() === dateparse.getTime()
            ? this.$moment(data_str).format("D MMM YYYY")
            : "";
      }

      return data_str;
    },
  },
  methods: {
    htmlToText(html) {
      return html.replace(/</g, "&lt;").replace(/>/g, "&gt;");
    },
    // a computed getter
    getDataStr: function (has_multiple_fields, prop_str) {
      var t = this;
      var data_str = prop_str;

      if (has_multiple_fields) {
        t.field_list.forEach(function (pitem_field) {
          var tmp_data_str = t.getDataFieldContent(pitem_field);

          data_str = data_str.replace(
            "[" + pitem_field + "]",
            tmp_data_str
          );
        });
      } else {
        data_str = t.getDataFieldContent(prop_str);
      }

      return data_str;
    },
    getDataFieldContent: function (prop_str) {
      var t = this;
      var data_str = "";

      if (prop_str.indexOf(".") > 0) {
        var list_error = false;
        var subname_arr = prop_str.split(".");
        var selected_obj = t.pitem;

        subname_arr.forEach(function (subname, index) {
          if (!selected_obj[subname] && selected_obj[subname] !== 0) {
            list_error = true;
          }

          if (!list_error) {
            if (subname_arr.length - 1 === index) {
              data_str = selected_obj[subname];
            }

            selected_obj = selected_obj[subname];
          }
        });
      } else {
        data_str = t.pitem[prop_str];
      }

      return data_str;
    },
  },
};
</script>
