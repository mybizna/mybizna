"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["backend-dashboard"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/apps/dashboard/pages/Dashboard.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/apps/dashboard/pages/Dashboard.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _components_router_menu_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @/components/router/menu.js */ "./resources/js/components/router/menu.js");
/* harmony import */ var _components_common_widgets_link_ImageLink__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/components/common/widgets/link/ImageLink */ "./resources/js/components/common/widgets/link/ImageLink.vue");
/* harmony import */ var _components_helpers__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @/components/helpers */ "./resources/js/components/helpers.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    ImageLink: _components_common_widgets_link_ImageLink__WEBPACK_IMPORTED_MODULE_1__["default"]
  },
  created: function created() {
    this.user = JSON.parse(localStorage.getItem("user"));
    this.getRankData(this.user.id);
  },
  data: function data() {
    return {
      menus: _components_router_menu_js__WEBPACK_IMPORTED_MODULE_0__["default"],
      selectedTab: "tab-1",
      rank_arr: [{
        value: 100,
        name: "Fetching..."
      }],
      user: {},
      affiliate: {}
    };
  },
  watch: {
    affiliate: function affiliate() {
      var tmp_rank_arr = this.affiliate.ranksData;
      var tmp_rank_str = atob(tmp_rank_arr);
      var tmp_rank_obj = JSON.parse(tmp_rank_str);
      this.rank_arr = tmp_rank_obj;
    }
  },
  methods: {
    getRankData: function getRankData(user_id) {
      var path_param = (0,_components_helpers__WEBPACK_IMPORTED_MODULE_2__.pathParamHelper)(["affiliate", "affiliate"]);
      var schema_fields = ["id", "ranksData"];
      var query_str = "user_id:" + user_id;
      var record = (0,_components_helpers__WEBPACK_IMPORTED_MODULE_2__.fetchRecordHelper)(this, path_param, schema_fields, query_str, "findany_", "affiliate");
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/common/widgets/link/ImageLink.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/common/widgets/link/ImageLink.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    icon: String,
    title: String,
    image: String,
    url: String
  }
});

/***/ }),

/***/ "./resources/js/components/helpers.js":
/*!********************************************!*\
  !*** ./resources/js/components/helpers.js ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "deleteRecordHelper": () => (/* binding */ deleteRecordHelper),
/* harmony export */   "fetchOptionsHelper": () => (/* binding */ fetchOptionsHelper),
/* harmony export */   "fetchRecordHelper": () => (/* binding */ fetchRecordHelper),
/* harmony export */   "fetchRecordsHelper": () => (/* binding */ fetchRecordsHelper),
/* harmony export */   "formInputProcessorHelper": () => (/* binding */ formInputProcessorHelper),
/* harmony export */   "pathParamHelper": () => (/* binding */ pathParamHelper),
/* harmony export */   "saveRecordHelper": () => (/* binding */ saveRecordHelper)
/* harmony export */ });
function pathParamHelper(path_list) {
  var first_ucword = path_list[0].charAt(0).toUpperCase() + path_list[0].slice(1);
  var second_ucword = path_list[1].charAt(0).toUpperCase() + path_list[1].slice(1);
  var side_selector = '';
  var path_side_selector = '';
  var dotted_side_selector = '';
  var underscore_side_selector = '';

  if (!window.is_frontend) {//side_selector = 'user';
    //path_side_selector = side_selector + '/';
    //dotted_side_selector = side_selector + '.';
    //underscore_side_selector = side_selector + '_';
  }

  var side_selector_ucword = side_selector.charAt(0).toUpperCase() + side_selector.slice(1);
  var reqular_const = {
    'path_arr': path_list,
    'path': path_side_selector + path_list[0] + '/' + path_list[1],
    'dotted': dotted_side_selector + path_list[0] + '.' + path_list[1],
    'underscore': underscore_side_selector + path_list[0] + '_' + path_list[1],
    'connected': side_selector_ucword + first_ucword + second_ucword,
    'graphql_name': ''
  };

  if (window.is_frontend) {
    var reqular_graphql_name = second_ucword == first_ucword ? path_list[0] + 's' : path_list[0] + second_ucword + 's';
    reqular_const.graphql_name = 'user' + reqular_graphql_name.charAt(0).toUpperCase() + reqular_graphql_name.slice(1);
  } else {
    reqular_const.graphql_name = second_ucword == first_ucword ? path_list[0] + 's' : path_list[0] + second_ucword + 's';
  }

  console.log(reqular_const.graphql_name);
  console.log('');
  console.log('');
  console.log('');
  console.log('');
  return reqular_const;
}
function formInputProcessorHelper(field, t) {
  var select_name = '';
  var input_field = {};

  if (field.type) {
    var input_fields_arr = ["", "text", "password", "reset", "color", "date", "email", "month", "number", "range", "search", "tel", "time", "url", "week"];

    if (input_fields_arr.indexOf(field.type) > 0) {
      input_field['type'] = "input";
      input_field['inputType'] = field.type;
    } else {
      input_field['type'] = field.type;
    }
  }

  if (field.name) {
    select_name = field.name + '_list';
    var tmp_label = field.name.replace('_id', '').replace('_', ' ').replace(/\w\S*/g, function (word) {
      return word.charAt(0).toUpperCase() + word.substr(1).toLowerCase();
    });
    input_field['id'] = field.name.toLowerCase();
    input_field['label'] = tmp_label;
    input_field['model'] = field.name.toLowerCase();
    input_field['placeholder'] = "Your " + tmp_label;
  }

  if (field.type === 'selectrecord') {
    input_field['type'] = 'select';
    input_field['values'] = [];
  } else if (field.type === 'yesno') {
    input_field['type'] = 'switch';
    input_field['textOn'] = "Yes";
    input_field['textOff'] = "No";
    input_field['valueOn'] = 1;
    input_field['valueOff'] = 0;
  } else if (field.type === 'selectyesno') {
    input_field['type'] = 'select';
    input_field['values'] = [{
      id: 1,
      name: 'Yes'
    }, {
      id: 0,
      name: 'No'
    }];
  }

  if (field.id) {
    input_field['id'] = field.id;
  }

  if (field.label) {
    input_field['label'] = field.label;
  }

  if (field.model) {
    input_field['model'] = field.model;
  }

  if (field.placeholder) {
    input_field['placeholder'] = field.placeholder;
  }

  if (field.styleClasses) {
    input_field['styleClasses'] = field.styleClasses;
  }

  if (field.featured) {
    input_field['featured'] = field.featured;
  }

  if (field.required) {
    input_field['required'] = field.required;
  }

  if (field.readonly) {
    input_field['readonly'] = field.readonly;
  }

  if (field.disabled) {
    input_field['disabled'] = field.disabled;
  }

  if (field.values) {
    input_field['values'] = field.values;
  }

  if (field.visible) {
    var function_str = '(function (model) { \
            return model && ' + field.visible + ';\
        })';
    input_field['visible'] = eval(function_str);
  }

  return input_field;
}
function saveRecordHelper(this_var, path_param, schema_fields, return_url) {
  var t = this_var;
  var input_fields_arr = ["", "id", "created_at", "createdBy{id,name,email,username}", "updated_at", "updatedBy{id,name,email,username}"];
  var save_str = "";
  save_str = "mutation{  create" + path_param.connected + "( ";

  if (t.model.id) {
    save_str = "mutation{  update" + path_param.connected + "(  id:" + t.model.id + ", ";
  }

  schema_fields.forEach(function (single_field) {
    var is_needed = input_fields_arr.indexOf(single_field.name) > 0 ? false : true;

    if (single_field.name && is_needed) {
      var field_name = single_field.name;
      var field_prefix = single_field.prefix;
      var field_suffix = single_field.suffix;
      var field_value = t.model[field_name];
      /*
      if (!field_prefix.length) {
          if (field_value === null || field_value === undefined) {
              field_value = 0;
          }
      }
      */

      if (t.model[field_name] && t.model[field_name] !== null) {
        save_str = save_str + field_name + ':' + field_prefix + field_value + field_suffix + ',';
      }
    }
  });
  save_str = save_str + ' ){ id, } }';
  window.axios.post("/graphql", {
    query: save_str
  }).then(function (response) {
    var tmpitem;

    if (t.model.id) {
      tmpitem = response.data.data['update' + path_param.connected];
    } else {
      tmpitem = response.data.data['create' + path_param.connected];
    }

    if (!t.no_redirect) {
      if (return_url) {
        t.$router.push({
          path: return_url
        });
      } else {
        t.$router.push({
          name: path_param.dotted + ".edit",
          params: {
            id: tmpitem.id
          }
        });
      }
    }
  });
}
function fetchOptionsHelper(this_var, listName, path_param, field_list) {
  var t = this_var;
  t.show_delete_btn = false;
  t.loading_message = "Fetching Data. Please Wait...";
  var query_str = "query { " + path_param.graphql_name + "( first:100 ) { ";
  query_str = query_str + "edges {cursor node  { ";
  field_list.forEach(function (single_field) {
    query_str = query_str + single_field + ',';
  });
  query_str = query_str + "  } } } }";
  window.axios.post("/graphql", {
    query: query_str
  }).then(function (response) {
    if (response.data.data) {
      var returned_data = [];
      var tmpitems_arr = JSON.parse(JSON.stringify(response.data.data[path_param.graphql_name].edges));
      tmpitems_arr.forEach(function (tmptmpitem) {
        var string_name = '';
        var tmpitem = tmptmpitem.node;
        field_list.forEach(function (single_field) {
          if (single_field != 'id') {
            string_name = string_name + tmpitem[single_field] + ': ';
          }
        });
        returned_data.push({
          id: tmpitem['id'],
          name: string_name
        });
      });
      var fiel = this_var.schema.fields.find(function (field) {
        return field.model === listName;
      }); //console.log(fiel);

      fiel.values = returned_data; //t.select_list[listName] = returned_data;
      //t.$set(t.select_list, listName, returned_data);
    } else {
      var message = '';
      response.data.errors.forEach(function (error) {
        message = message + error.message;
      });
    }
  });
}
function fetchRecordHelper(this_var, path_param, schema_fields, query_str, prefix, return_to) {
  var t = this_var;
  t.show_delete_btn = false;
  t.loading_message = "Fetching Data. Please Wait...";
  var tmp_return_to = return_to || false;
  var tmp_prefix = prefix || 'find_';
  var tmp_query_str = query_str || "id: " + t.id;

  if (!t.id && query_str === '') {
    return;
  }

  if (query_str === '') {
    query_str = "query {" + tmp_prefix + path_param.underscore + "( " + tmp_query_str + ") {";
    schema_fields.forEach(function (single_field) {
      query_str = query_str + single_field + ',';
    });
    query_str = query_str + " }  }";
  }

  window.axios.post("/graphql", {
    query: query_str
  }).then(function (response) {
    if (response.data.data) {
      var tmpitem = response.data.data[tmp_prefix + path_param.underscore];

      if (!tmp_return_to) {
        schema_fields.forEach(function (single_field) {
          if (single_field.includes("{")) {
            var str_split = single_field.split('{')[0];
            str_split = str_split.trim();

            if (tmpitem[str_split]) {
              t.model[str_split] = tmpitem[str_split].id;
            }
          } else {
            t.model[single_field] = tmpitem[single_field];
          }
        });
      } else {
        t[tmp_return_to] = tmpitem;
      }
    } else {
      var message = '';
      response.data.errors.forEach(function (error) {
        message = message + error.message;
      });
    }
  });
}
function fetchRecordsHelper(this_var, path_param, query_fields, field_list, target_var, return_raw) {
  var t = this_var;
  t.show_delete_btn = false;
  t.loading_message = "Fetching Data. Please Wait...";
  var tmp_return_raw = return_raw || false;
  var query_str = "query { " + path_param.graphql_name + "(";

  if (t.pagination) {
    query_str = query_str + "first:" + t.pagination.limit + ",";
    query_str = query_str + 'orderBy:"-id",';
  }

  if (Array.isArray(query_fields)) {
    if (!tmp_return_raw) {
      query_fields.forEach(function (single_field) {
        var field_name = single_field.name;
        var field_prefix = single_field.prefix;
        var field_suffix = single_field.suffix;

        if (field_prefix == '"') {
          if (t.model[field_name].length) {
            query_str = query_str + ' ' + field_name + ':' + field_prefix + t.model[field_name] + field_suffix + ",";
          }
        } else {
          if (t.model[field_name]) {
            query_str = query_str + ' ' + field_name + ':' + t.model[field_name] + ",";
          }
        }
      });
    } else {
      query_fields.forEach(function (single_field) {
        query_str = query_str + single_field;
      });
    }
  } else {
    query_str = query_str + query_fields;
  }

  if (!query_str.includes('skip:')) {//query_str = query_str + "skip:10";
  }

  query_str = query_str + ") { ";
  query_str = query_str + "edges {cursor node { ";
  field_list.forEach(function (single_field) {
    query_str = query_str + single_field + ',';
  });
  query_str = query_str + "  }}  ";

  if (t.pagination) {
    query_str = query_str + " pageInfo { hasNextPage, hasPreviousPage, startCursor,endCursor }";
  }

  query_str = query_str + "  } \
    }";
  console.log(query_str);
  window.axios.post("/graphql", {
    query: query_str
  }).then(function (response) {
    if (response.data.data) {
      var tmppagination = "";
      var tmpitems = [];
      var res_tmpitems = response.data.data[path_param.graphql_name].edges;

      if (t.pagination) {
        tmppagination = response.data.data[path_param.graphql_name].pageInfo;
      }

      if (!tmp_return_raw) {
        var semi_tmpitems = JSON.parse(JSON.stringify(res_tmpitems));
        semi_tmpitems.forEach(function (newitem) {
          var node_data = newitem.node;

          for (var prop in node_data) {
            if (Object.prototype.hasOwnProperty.call(node_data, prop)) {
              if (typeof node_data[prop] === 'string' && node_data[prop].charAt(0) === "{") {
                try {
                  node_data[prop] = JSON.parse(node_data[prop]);
                } catch (e) {// is not a valid JSON string
                }
              }
            }
          }

          tmpitems.push(node_data);
        });
        t.items = JSON.parse(JSON.stringify(tmpitems));

        if (t.items.length < 1) {
          t.show_delete_btn = false;
          t.loading_message = "No Data Available.";
        } else {
          if (t.pagination) {
            t.pagination.totalItems = tmppagination.total;
            t.pagination.pages = tmppagination.lastPage;
            t.pagination.page = tmppagination.currentPage;
          }

          t.show_delete_btn = true;
          t.items.forEach(function (i) {
            t.$set(t.expanded, i.id, false);
          });
        }

        t.postProcessing(t, field_list);
      } else {
        t.$set(t, target_var, JSON.parse(JSON.stringify(tmpitems)));
      }
    } else {
      var message = '';
      response.data.errors.forEach(function (error) {
        message = message + error.message;
      });
    }
  });
}
function deleteRecordHelper(this_var, path_param, return_url) {
  var t = this_var;
  var selected_items = JSON.parse(JSON.stringify(t.table.selected));
  var index;

  for (index = selected_items.length - 1; index >= 0; --index) {
    var selected_item = selected_items[index];
    window.axios.post("/graphql", {
      query: 'mutation {  \
          delete' + path_param.connected + '(id: "' + selected_item.id + '"){ \
            id, \
          }  \
        } '
    }).then(function (response) {
      if (response.data.data) {
        var tmpitem = response.data.data['delete' + path_param.connected];

        if (return_url) {
          t.$router.push({
            path: return_url
          });
        } else {
          t.$router.push({
            name: path_param.dotted
          });
        }
      } else {
        var message = '';
        response.data.errors.forEach(function (error) {
          message = message + error.message;
        });
      }
    });
  }
}

/***/ }),

/***/ "./resources/js/apps/dashboard/pages/Dashboard.vue":
/*!*********************************************************!*\
  !*** ./resources/js/apps/dashboard/pages/Dashboard.vue ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Dashboard_vue_vue_type_template_id_6845148f___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Dashboard.vue?vue&type=template&id=6845148f& */ "./resources/js/apps/dashboard/pages/Dashboard.vue?vue&type=template&id=6845148f&");
/* harmony import */ var _Dashboard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Dashboard.vue?vue&type=script&lang=js& */ "./resources/js/apps/dashboard/pages/Dashboard.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Dashboard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Dashboard_vue_vue_type_template_id_6845148f___WEBPACK_IMPORTED_MODULE_0__.render,
  _Dashboard_vue_vue_type_template_id_6845148f___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/apps/dashboard/pages/Dashboard.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/common/widgets/link/ImageLink.vue":
/*!*******************************************************************!*\
  !*** ./resources/js/components/common/widgets/link/ImageLink.vue ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _ImageLink_vue_vue_type_template_id_20a4cbc9___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ImageLink.vue?vue&type=template&id=20a4cbc9& */ "./resources/js/components/common/widgets/link/ImageLink.vue?vue&type=template&id=20a4cbc9&");
/* harmony import */ var _ImageLink_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ImageLink.vue?vue&type=script&lang=js& */ "./resources/js/components/common/widgets/link/ImageLink.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ImageLink_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ImageLink_vue_vue_type_template_id_20a4cbc9___WEBPACK_IMPORTED_MODULE_0__.render,
  _ImageLink_vue_vue_type_template_id_20a4cbc9___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/common/widgets/link/ImageLink.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/apps/dashboard/pages/Dashboard.vue?vue&type=script&lang=js&":
/*!**********************************************************************************!*\
  !*** ./resources/js/apps/dashboard/pages/Dashboard.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Dashboard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Dashboard.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/apps/dashboard/pages/Dashboard.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Dashboard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/common/widgets/link/ImageLink.vue?vue&type=script&lang=js&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/common/widgets/link/ImageLink.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageLink_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ImageLink.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/common/widgets/link/ImageLink.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageLink_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/apps/dashboard/pages/Dashboard.vue?vue&type=template&id=6845148f&":
/*!****************************************************************************************!*\
  !*** ./resources/js/apps/dashboard/pages/Dashboard.vue?vue&type=template&id=6845148f& ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Dashboard_vue_vue_type_template_id_6845148f___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Dashboard_vue_vue_type_template_id_6845148f___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Dashboard_vue_vue_type_template_id_6845148f___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Dashboard.vue?vue&type=template&id=6845148f& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/apps/dashboard/pages/Dashboard.vue?vue&type=template&id=6845148f&");


/***/ }),

/***/ "./resources/js/components/common/widgets/link/ImageLink.vue?vue&type=template&id=20a4cbc9&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/common/widgets/link/ImageLink.vue?vue&type=template&id=20a4cbc9& ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageLink_vue_vue_type_template_id_20a4cbc9___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageLink_vue_vue_type_template_id_20a4cbc9___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageLink_vue_vue_type_template_id_20a4cbc9___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ImageLink.vue?vue&type=template&id=20a4cbc9& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/common/widgets/link/ImageLink.vue?vue&type=template&id=20a4cbc9&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/apps/dashboard/pages/Dashboard.vue?vue&type=template&id=6845148f&":
/*!*******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/apps/dashboard/pages/Dashboard.vue?vue&type=template&id=6845148f& ***!
  \*******************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "row mt-5" }, [
    _c(
      "div",
      { staticClass: "col-6 col-md-3" },
      [
        _c("image-link", {
          attrs: {
            icon: "fa fa-users",
            title: "Affiliate",
            image: "images/apps/affiliate_icon.png",
            url: "affiliate/affiliate",
          },
        }),
      ],
      1
    ),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "col-6 col-md-3" },
      [
        _c("image-link", {
          attrs: {
            icon: "fa fa-phone",
            title: "Airtime",
            image: "images/apps/airtime_icon.png",
            url: "airtime/airtime",
          },
        }),
      ],
      1
    ),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "col-6 col-md-3" },
      [
        _c("image-link", {
          attrs: {
            icon: "fa fa-server",
            title: "Hosting",
            image: "images/apps/hosting_icon.png",
            url: "hosting/hosting",
          },
        }),
      ],
      1
    ),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "col-6 col-md-3" },
      [
        _c("image-link", {
          attrs: {
            icon: "fa fa-money",
            title: "Payment",
            image: "images/apps/payment_icon.png",
            url: "payment/payment",
          },
        }),
      ],
      1
    ),
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/common/widgets/link/ImageLink.vue?vue&type=template&id=20a4cbc9&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/common/widgets/link/ImageLink.vue?vue&type=template&id=20a4cbc9& ***!
  \*****************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "card card-coin" }, [
    _c(
      "div",
      { staticClass: "card-body text-center" },
      [
        _c("router-link", { attrs: { to: _vm.url, title: _vm.title } }, [
          _c(
            "svg",
            {
              staticClass: "mb-3 currency-icon",
              attrs: {
                width: "80",
                height: "80",
                viewBox: "0 0 80 80",
                fill: "none",
                xmlns: "http://www.w3.org/2000/svg",
              },
            },
            [
              _c("circle", {
                attrs: { cx: "40", cy: "40", r: "40", fill: "white" },
              }),
              _vm._v(" "),
              _c("path", {
                attrs: {
                  d: "M40.725 0.00669178C18.6241 -0.393325 0.406678 17.1907 0.00666126 39.275C-0.393355 61.3592 17.1907 79.5933 39.2749 79.9933C61.3592 80.3933 79.5933 62.8093 79.9933 40.7084C80.3933 18.6241 62.8092 0.390041 40.725 0.00669178ZM39.4083 72.493C21.4909 72.1597 7.17362 57.3257 7.50697 39.4083C7.82365 21.4909 22.6576 7.17365 40.575 7.49033C58.5091 7.82368 72.8096 22.6576 72.493 40.575C72.1763 58.4924 57.3257 72.8097 39.4083 72.493Z",
                  fill: "#00ADA3",
                },
              }),
              _vm._v(" "),
              _c("path", {
                attrs: {
                  d: "M40.5283 10.8305C24.4443 10.5471 11.1271 23.3976 10.8438 39.4816C10.5438 55.549 23.3943 68.8662 39.4783 69.1662C55.5623 69.4495 68.8795 56.599 69.1628 40.5317C69.4462 24.4477 56.6123 11.1305 40.5283 10.8305ZM40.0033 19.1441L49.272 35.6798L40.8133 30.973C40.3083 30.693 39.6966 30.693 39.1916 30.973L30.7329 35.6798L40.0033 19.1441ZM40.0033 60.8509L30.7329 44.3152L39.1916 49.022C39.4433 49.162 39.7233 49.232 40.0016 49.232C40.28 49.232 40.56 49.162 40.8117 49.022L49.2703 44.3152L40.0033 60.8509ZM40.0033 45.6569L29.8296 39.9967L40.0033 34.3364L50.1754 39.9967L40.0033 45.6569Z",
                  fill: "#00ADA3",
                },
              }),
            ]
          ),
          _vm._v(" "),
          _c("h2", { staticClass: "text-black mb-2 font-w600" }, [
            _c("i", { class: _vm.icon }),
            _vm._v(" " + _vm._s(_vm.title) + "\n      "),
          ]),
        ]),
      ],
      1
    ),
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);