<template>
  <div :class="classes">
    <div class="form-head mb-1 d-flex flex-wrap align-items-center">
      <h2 class="font-w600 mr-auto">{{ title }}</h2>

      <b-button v-if="has_save" variant="success" size="sm" @click="saveRecord" class="text-white mr-1">
        <i class="fa fa-save"></i> Save
      </b-button>

      <b-button v-if="has_cancel" variant="danger" size="sm" :to="cancelUrl">
        <i class="fa fa-times"></i> Cancel
      </b-button>
    </div>

    <b-card>
      <form>
        <vue-form-generator
          :schema="schema"
          :model="model"
          :options="formOptions"
          class="row table-edit"
        ></vue-form-generator>

        <div class="text-center"></div>
      </form>
    </b-card>
  </div>
</template>

<script>
/*eslint no-undef: 2*/
/* eslint-disable vue/no-unused-components */
import { formInputProcessorHelper } from "@/components/helpers";
import { fetchOptionsHelper } from "@/components/helpers";
import { fetchRecordHelper } from "@/components/helpers";
import { saveRecordHelper } from "@/components/helpers";
import { pathParamHelper } from "@/components/helpers";

export default {
  props: {
    title: String,
    model: Object,
    passed_return_url: String,
    main_column_css: {
      type: String,
      default: "flex col-md-6  main-group",
    },
    no_redirect: { type: Boolean, default: false },
    has_modified: { type: Boolean, default: true },
    has_save: { type: Boolean, default: true },
    has_cancel: { type: Boolean, default: true },
    path_param: { type: Array, default: () => [] },
    form_fields: { type: Array, default: () => [] },
    form_groups: { type: Array, default: () => [] },
    schema_fields: { type: Array, default: () => [] },
  },
  created() {
    this.preparePathParam();
    this.addGeneralFields();
    this.processFormFields();

    var path_part = this.path_param[0] + "/" + this.path_param[1];

    if (this.$route.path.indexOf(path_part) !== -1) {
      this.id = this.$route.params.id;
    }

    if (this.id) {
      this.fetchRecord(this.id);
    }
  },
  data() {
    return {
      id: null,
      group_list: [],
      processed_path_param: {},
      select_list: {},
      schema: {
        groups: [],
      },
      formOptions: {
        validateAfterLoad: true,
        validateAfterChanged: true,
        fieldIdPrefix: "user-",
      },
    };
  },
  methods: {
    preparePathParam() {
      this.processed_path_param = pathParamHelper(this.path_param);
    },
    addGeneralFields() {
      var t = this;

      if (t.has_modified && t.id) {
        t.form_fields.push(
          {
            type: "label",
            group: "modification",
            label: "No Modification Details for New Records.",
            visible: "model.id == ''",
            styleClasses: "text-xs-left",
          },
          {
            type: "text",
            name: "id",
            group: "modification",
            visible: "model.id != ''",
            prefix: '"',
            suffix: '"',
            readonly: true,
            disabled: true,
          },
          {
            type: "user",
            name: "created_by",
            group: "modification",
            visible: "model.id != ''",
            prefix: '"',
            suffix: '"',
          },

          {
            type: "user",
            name: "updated_by",
            group: "modification",
            visible: "model.id != ''",
            prefix: '"',
            suffix: '"',
          },
          {
            type: "text",
            name: "created_at",
            group: "modification",
            visible: "model.id != ''",
            prefix: '"',
            suffix: '"',
            styleClasses: "col-md-6  main-group",
          },
          {
            type: "text",
            name: "updated_at",
            group: "modification",
            visible: "model.id != ''",
            prefix: '"',
            suffix: '"',
            styleClasses: "col-md-6  main-group",
          }
        );
      }
    },
    processFormFields() {
      var t = this;
      var groups = [];

      groups = this.beforeFormFields(groups);
      groups = this.mainFormFields(groups);

      t.form_groups.forEach(function (form_group) {
        t.group_list.push(form_group.name);
        groups[form_group.name] = {
          legend: form_group.legend,
          styleClasses: form_group.styleClasses,
          fields: [],
        };
      });
      groups = this.afterFormFields(groups);

      t.form_fields.forEach(function (form_field) {
        var group_name = groups[form_field.group] ? form_field.group : "main";

        groups[group_name].fields.push(formInputProcessorHelper(form_field, t));

        if (form_field.type === "selectrecord") {
          var select_name = form_field.name + "_list";

          t.$set(t.select_list, select_name, []);

          t.getSelectList(t, select_name, form_field.source);
        }
      });

      t.group_list.forEach(function (group_name) {
        var tmp_group = groups[group_name];
        t.schema.groups.push(tmp_group);
      });
    },
    getSelectList(t, select_name, field_source) {
      var path_param_obj = pathParamHelper(field_source.path_param);

      fetchOptionsHelper(t, select_name, path_param_obj, field_source.fields);
    },
    beforeFormFields(groups) {
      var t = this;
      //To be developed if needed
      return groups;
    },
    mainFormFields(groups) {
      var t = this;

      groups["main"] = {
        legend: "Main Details",
        styleClasses: t.main_column_css,
        fields: [],
      };

      t.group_list.push("main");

      return groups;
    },
    afterFormFields(groups) {
      var t = this;

      if (t.has_modified && t.id) {
        groups["modification"] = {
          legend: "Modification Records",
          styleClasses: "col-sm-6  modification-group",
          fields: [],
        };

        t.group_list.push("modification");
      }
      return groups;
    },
    fetchRecord(id) {
      fetchRecordHelper(this, this.processed_path_param, this.schema_fields);
    },

    saveRecord() {
      saveRecordHelper(
        this,
        this.processed_path_param,
        this.form_fields,
        this.returnUrl
      );
    },
  },
  computed: {
    cancelUrl: function () {
      var t = this;
      var side_selector = "/";

      if (!window.is_frontend) {
        side_selector = side_selector + "manage/";
      }

      return side_selector + t.path_param[0] + "/" + t.path_param[1];
    },
    returnUrl: function () {
      var t = this;

      if (t.passed_return_url) {
        return t.passed_return_url;
      }

      return false;
    },
    hasCancel: function () {
      var t = this;

      if (t.has_cancel) {
        return t.has_cancel;
      }

      return false;
    },
    hasSave: function () {
      var t = this;

      if (t.has_save) {
        return t.has_save;
      }

      return false;
    },
  },
};
</script>