"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_pages_account-settings_AccountSettings_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettings.vue?vue&type=script&lang=js":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettings.vue?vue&type=script&lang=js ***!
  \***************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _mdi_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @mdi/js */ "./node_modules/@mdi/js/mdi.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");
/* harmony import */ var _AccountSettingsAccount_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./AccountSettingsAccount.vue */ "./resources/js/views/pages/account-settings/AccountSettingsAccount.vue");
/* harmony import */ var _AccountSettingsSecurity_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./AccountSettingsSecurity.vue */ "./resources/js/views/pages/account-settings/AccountSettingsSecurity.vue");
/* harmony import */ var _AccountSettingsInfo_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./AccountSettingsInfo.vue */ "./resources/js/views/pages/account-settings/AccountSettingsInfo.vue");

 // demos




/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    AccountSettingsAccount: _AccountSettingsAccount_vue__WEBPACK_IMPORTED_MODULE_1__["default"],
    AccountSettingsSecurity: _AccountSettingsSecurity_vue__WEBPACK_IMPORTED_MODULE_2__["default"],
    AccountSettingsInfo: _AccountSettingsInfo_vue__WEBPACK_IMPORTED_MODULE_3__["default"]
  },
  setup: function setup() {
    var tab = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)(''); // tabs

    var tabs = [{
      title: 'Account',
      icon: _mdi_js__WEBPACK_IMPORTED_MODULE_4__.mdiAccountOutline
    }, {
      title: 'Security',
      icon: _mdi_js__WEBPACK_IMPORTED_MODULE_4__.mdiLockOpenOutline
    }, {
      title: 'Info',
      icon: _mdi_js__WEBPACK_IMPORTED_MODULE_4__.mdiInformationOutline
    }]; // account settings data

    var accountSettingData = {
      account: {
        avatarImg: 'images/avatars/1.png',
        username: 'johnDoe',
        name: 'john Doe',
        email: 'johnDoe@example.com',
        role: 'Admin',
        status: 'Active',
        company: 'Google.inc'
      },
      information: {
        bio: 'The name’s John Deo. I am a tireless seeker of knowledge, occasional purveyor of wisdom and also, coincidentally, a graphic designer. Algolia helps businesses across industries quickly create relevant 😎, scaLabel 😀, and lightning 😍 fast search and discovery experiences.',
        birthday: 'February 22, 1995',
        phone: '954-006-0844',
        website: 'https://themeselection.com/',
        country: 'USA',
        languages: ['English', 'Spanish'],
        gender: 'male'
      }
    };
    return {
      tab: tab,
      tabs: tabs,
      accountSettingData: accountSettingData,
      icons: {
        mdiAccountOutline: _mdi_js__WEBPACK_IMPORTED_MODULE_4__.mdiAccountOutline,
        mdiLockOpenOutline: _mdi_js__WEBPACK_IMPORTED_MODULE_4__.mdiLockOpenOutline,
        mdiInformationOutline: _mdi_js__WEBPACK_IMPORTED_MODULE_4__.mdiInformationOutline
      }
    };
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettingsAccount.vue?vue&type=script&lang=js":
/*!**********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettingsAccount.vue?vue&type=script&lang=js ***!
  \**********************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _mdi_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @mdi/js */ "./node_modules/@mdi/js/mdi.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");


/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    accountData: {
      type: Object,
      "default": function _default() {}
    }
  },
  setup: function setup(props) {
    var status = ['Active', 'Inactive', 'Pending', 'Closed'];
    var accountDataLocale = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)(JSON.parse(JSON.stringify(props.accountData)));

    var resetForm = function resetForm() {
      accountDataLocale.value = JSON.parse(JSON.stringify(props.accountData));
    };

    return {
      status: status,
      accountDataLocale: accountDataLocale,
      resetForm: resetForm,
      icons: {
        mdiAlertOutline: _mdi_js__WEBPACK_IMPORTED_MODULE_1__.mdiAlertOutline,
        mdiCloudUploadOutline: _mdi_js__WEBPACK_IMPORTED_MODULE_1__.mdiCloudUploadOutline
      }
    };
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettingsInfo.vue?vue&type=script&lang=js":
/*!*******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettingsInfo.vue?vue&type=script&lang=js ***!
  \*******************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    informationData: {
      type: Object,
      "default": function _default() {}
    }
  },
  setup: function setup(props) {
    var optionsLocal = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)(JSON.parse(JSON.stringify(props.informationData)));

    var resetForm = function resetForm() {
      optionsLocal.value = JSON.parse(JSON.stringify(props.informationData));
    };

    return {
      optionsLocal: optionsLocal,
      resetForm: resetForm
    };
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettingsSecurity.vue?vue&type=script&lang=js":
/*!***********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettingsSecurity.vue?vue&type=script&lang=js ***!
  \***********************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _mdi_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @mdi/js */ "./node_modules/@mdi/js/mdi.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");
// eslint-disable-next-line object-curly-newline


/* harmony default export */ __webpack_exports__["default"] = ({
  setup: function setup() {
    var isCurrentPasswordVisible = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)(false);
    var isNewPasswordVisible = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)(false);
    var isCPasswordVisible = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)(false);
    var currentPassword = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)("12345678");
    var newPassword = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)("87654321");
    var cPassword = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)("87654321");
    return {
      isCurrentPasswordVisible: isCurrentPasswordVisible,
      isNewPasswordVisible: isNewPasswordVisible,
      currentPassword: currentPassword,
      isCPasswordVisible: isCPasswordVisible,
      newPassword: newPassword,
      cPassword: cPassword,
      icons: {
        mdiKeyOutline: _mdi_js__WEBPACK_IMPORTED_MODULE_1__.mdiKeyOutline,
        mdiLockOpenOutline: _mdi_js__WEBPACK_IMPORTED_MODULE_1__.mdiLockOpenOutline,
        mdiEyeOffOutline: _mdi_js__WEBPACK_IMPORTED_MODULE_1__.mdiEyeOffOutline,
        mdiEyeOutline: _mdi_js__WEBPACK_IMPORTED_MODULE_1__.mdiEyeOutline
      }
    };
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettings.vue?vue&type=template&id=6906222e":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettings.vue?vue&type=template&id=6906222e ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* binding */ render; }
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_v_icon = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-icon");

  var _component_v_tab = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-tab");

  var _component_v_tabs = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-tabs");

  var _component_account_settings_account = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("account-settings-account");

  var _component_v_tab_item = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-tab-item");

  var _component_account_settings_security = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("account-settings-security");

  var _component_account_settings_info = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("account-settings-info");

  var _component_v_tabs_items = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-tabs-items");

  var _component_v_card = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_v_card, {
    id: "account-setting-card"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" tabs "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_tabs, {
        modelValue: $setup.tab,
        "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
          return $setup.tab = $event;
        }),
        "show-arrows": ""
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($setup.tabs, function (tab) {
            return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_v_tab, {
              key: tab.icon
            }, {
              "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_icon, {
                  size: "20",
                  "class": "me-3"
                }, {
                  "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                    return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(tab.icon), 1
                    /* TEXT */
                    )];
                  }),
                  _: 2
                  /* DYNAMIC */

                }, 1024
                /* DYNAMIC_SLOTS */
                ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(tab.title), 1
                /* TEXT */
                )];
              }),
              _: 2
              /* DYNAMIC */

            }, 1024
            /* DYNAMIC_SLOTS */
            );
          }), 128
          /* KEYED_FRAGMENT */
          ))];
        }),
        _: 1
        /* STABLE */

      }, 8
      /* PROPS */
      , ["modelValue"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" tabs item "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_tabs_items, {
        modelValue: $setup.tab,
        "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
          return $setup.tab = $event;
        })
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_tab_item, null, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_account_settings_account, {
                "account-data": $setup.accountSettingData.account
              }, null, 8
              /* PROPS */
              , ["account-data"])];
            }),
            _: 1
            /* STABLE */

          }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_tab_item, null, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_account_settings_security)];
            }),
            _: 1
            /* STABLE */

          }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_tab_item, null, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_account_settings_info, {
                "information-data": $setup.accountSettingData.information
              }, null, 8
              /* PROPS */
              , ["information-data"])];
            }),
            _: 1
            /* STABLE */

          })];
        }),
        _: 1
        /* STABLE */

      }, 8
      /* PROPS */
      , ["modelValue"])];
    }),
    _: 1
    /* STABLE */

  });
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettingsAccount.vue?vue&type=template&id=d8e1fc62":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettingsAccount.vue?vue&type=template&id=d8e1fc62 ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* binding */ render; }
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");


var _hoisted_1 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" mdiCloudUploadOutline ");

var _hoisted_2 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "d-none d-sm-block"
}, "Upload new photo", -1
/* HOISTED */
);

var _hoisted_3 = {
  ref: "refInputEl",
  type: "file",
  accept: ".jpeg,.png,.jpg,GIF",
  hidden: true
};

var _hoisted_4 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Reset ");

var _hoisted_5 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
  "class": "text-sm mt-5"
}, " Allowed JPG, GIF or PNG. Max size of 800K ", -1
/* HOISTED */
);

var _hoisted_6 = {
  "class": "d-flex align-start"
};

var _hoisted_7 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" mdiAlertOutline ");

var _hoisted_8 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "ms-3"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
  "class": "text-base font-weight-medium mb-1"
}, " Your email is not confirmed. Please check your inbox. "), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
  href: "javascript:void(0)",
  "class": "text-decoration-none warning--text"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "text-sm"
}, "Resend Confirmation")])], -1
/* HOISTED */
);

var _hoisted_9 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Save changes ");

var _hoisted_10 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Cancel ");

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_v_img = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-img");

  var _component_v_avatar = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-avatar");

  var _component_v_icon = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-icon");

  var _component_v_btn = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-btn");

  var _component_v_card_text = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card-text");

  var _component_v_text_field = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-text-field");

  var _component_v_col = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-col");

  var _component_v_select = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-select");

  var _component_v_alert = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-alert");

  var _component_v_row = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-row");

  var _component_v_form = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-form");

  var _component_v_card = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_v_card, {
    flat: "",
    "class": "pa-3 mt-2"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_card_text, {
        "class": "d-flex"
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_avatar, {
            rounded: "",
            size: "120",
            "class": "me-6"
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_img, {
                src: $setup.accountDataLocale.avatarImg
              }, null, 8
              /* PROPS */
              , ["src"])];
            }),
            _: 1
            /* STABLE */

          }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" upload photo "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_btn, {
            color: "primary",
            "class": "me-3 mt-5",
            onClick: _cache[0] || (_cache[0] = function ($event) {
              return _ctx.$refs.refInputEl.click();
            })
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_icon, {
                "class": "d-sm-none"
              }, {
                "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                  return [_hoisted_1];
                }),
                _: 1
                /* STABLE */

              }), _hoisted_2];
            }),
            _: 1
            /* STABLE */

          }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", _hoisted_3, null, 512
          /* NEED_PATCH */
          ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_btn, {
            color: "error",
            outlined: "",
            "class": "mt-5"
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [_hoisted_4];
            }),
            _: 1
            /* STABLE */

          }), _hoisted_5])];
        }),
        _: 1
        /* STABLE */

      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_card_text, null, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_form, {
            "class": "multi-col-validation mt-6"
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_row, null, {
                "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                  return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
                    md: "6",
                    cols: "12"
                  }, {
                    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_text_field, {
                        modelValue: $setup.accountDataLocale.username,
                        "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
                          return $setup.accountDataLocale.username = $event;
                        }),
                        label: "Username",
                        dense: "",
                        outlined: ""
                      }, null, 8
                      /* PROPS */
                      , ["modelValue"])];
                    }),
                    _: 1
                    /* STABLE */

                  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
                    md: "6",
                    cols: "12"
                  }, {
                    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_text_field, {
                        modelValue: $setup.accountDataLocale.name,
                        "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
                          return $setup.accountDataLocale.name = $event;
                        }),
                        label: "Name",
                        dense: "",
                        outlined: ""
                      }, null, 8
                      /* PROPS */
                      , ["modelValue"])];
                    }),
                    _: 1
                    /* STABLE */

                  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
                    cols: "12",
                    md: "6"
                  }, {
                    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_text_field, {
                        modelValue: $setup.accountDataLocale.email,
                        "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
                          return $setup.accountDataLocale.email = $event;
                        }),
                        label: "E-mail",
                        dense: "",
                        outlined: ""
                      }, null, 8
                      /* PROPS */
                      , ["modelValue"])];
                    }),
                    _: 1
                    /* STABLE */

                  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
                    cols: "12",
                    md: "6"
                  }, {
                    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_text_field, {
                        modelValue: $setup.accountDataLocale.role,
                        "onUpdate:modelValue": _cache[4] || (_cache[4] = function ($event) {
                          return $setup.accountDataLocale.role = $event;
                        }),
                        dense: "",
                        label: "Role",
                        outlined: ""
                      }, null, 8
                      /* PROPS */
                      , ["modelValue"])];
                    }),
                    _: 1
                    /* STABLE */

                  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
                    cols: "12",
                    md: "6"
                  }, {
                    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_select, {
                        modelValue: $setup.accountDataLocale.status,
                        "onUpdate:modelValue": _cache[5] || (_cache[5] = function ($event) {
                          return $setup.accountDataLocale.status = $event;
                        }),
                        dense: "",
                        outlined: "",
                        label: "Status",
                        items: $setup.status
                      }, null, 8
                      /* PROPS */
                      , ["modelValue", "items"])];
                    }),
                    _: 1
                    /* STABLE */

                  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
                    cols: "12",
                    md: "6"
                  }, {
                    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_text_field, {
                        modelValue: $setup.accountDataLocale.company,
                        "onUpdate:modelValue": _cache[6] || (_cache[6] = function ($event) {
                          return $setup.accountDataLocale.company = $event;
                        }),
                        dense: "",
                        outlined: "",
                        label: "Company"
                      }, null, 8
                      /* PROPS */
                      , ["modelValue"])];
                    }),
                    _: 1
                    /* STABLE */

                  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" alert "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
                    cols: "12"
                  }, {
                    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_alert, {
                        color: "warning",
                        text: "",
                        "class": "mb-0"
                      }, {
                        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_icon, {
                            color: "warning"
                          }, {
                            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                              return [_hoisted_7];
                            }),
                            _: 1
                            /* STABLE */

                          }), _hoisted_8])];
                        }),
                        _: 1
                        /* STABLE */

                      })];
                    }),
                    _: 1
                    /* STABLE */

                  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
                    cols: "12"
                  }, {
                    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_btn, {
                        color: "primary",
                        "class": "me-3 mt-4"
                      }, {
                        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                          return [_hoisted_9];
                        }),
                        _: 1
                        /* STABLE */

                      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_btn, {
                        color: "secondary",
                        outlined: "",
                        "class": "mt-4",
                        type: "reset",
                        onClick: (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)($setup.resetForm, ["prevent"])
                      }, {
                        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                          return [_hoisted_10];
                        }),
                        _: 1
                        /* STABLE */

                      }, 8
                      /* PROPS */
                      , ["onClick"])];
                    }),
                    _: 1
                    /* STABLE */

                  })];
                }),
                _: 1
                /* STABLE */

              })];
            }),
            _: 1
            /* STABLE */

          })];
        }),
        _: 1
        /* STABLE */

      })];
    }),
    _: 1
    /* STABLE */

  });
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettingsInfo.vue?vue&type=template&id=e773ae08":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettingsInfo.vue?vue&type=template&id=e773ae08 ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* binding */ render; }
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");


var _hoisted_1 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
  "class": "text--primary mt-n3 mb-2"
}, " Gender ", -1
/* HOISTED */
);

var _hoisted_2 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Save changes ");

var _hoisted_3 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Cancel ");

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_v_textarea = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-textarea");

  var _component_v_col = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-col");

  var _component_v_text_field = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-text-field");

  var _component_v_select = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-select");

  var _component_v_radio = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-radio");

  var _component_v_radio_group = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-radio-group");

  var _component_v_row = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-row");

  var _component_v_card_text = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card-text");

  var _component_v_btn = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-btn");

  var _component_v_form = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-form");

  var _component_v_card = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_v_card, {
    flat: "",
    "class": "pa-3 mt-2"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_form, {
        "class": "multi-col-validation"
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_card_text, {
            "class": "pt-5"
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_row, null, {
                "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                  return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
                    cols: "12"
                  }, {
                    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_textarea, {
                        modelValue: $setup.optionsLocal.bio,
                        "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
                          return $setup.optionsLocal.bio = $event;
                        }),
                        outlined: "",
                        rows: "3",
                        label: "Bio"
                      }, null, 8
                      /* PROPS */
                      , ["modelValue"])];
                    }),
                    _: 1
                    /* STABLE */

                  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
                    cols: "12",
                    md: "6"
                  }, {
                    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_text_field, {
                        modelValue: $setup.optionsLocal.birthday,
                        "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
                          return $setup.optionsLocal.birthday = $event;
                        }),
                        outlined: "",
                        dense: "",
                        label: "Birthday"
                      }, null, 8
                      /* PROPS */
                      , ["modelValue"])];
                    }),
                    _: 1
                    /* STABLE */

                  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
                    cols: "12",
                    md: "6"
                  }, {
                    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_text_field, {
                        modelValue: $setup.optionsLocal.phone,
                        "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
                          return $setup.optionsLocal.phone = $event;
                        }),
                        outlined: "",
                        dense: "",
                        label: "Phone"
                      }, null, 8
                      /* PROPS */
                      , ["modelValue"])];
                    }),
                    _: 1
                    /* STABLE */

                  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
                    cols: "12",
                    md: "6"
                  }, {
                    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_text_field, {
                        modelValue: $setup.optionsLocal.website,
                        "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
                          return $setup.optionsLocal.website = $event;
                        }),
                        outlined: "",
                        dense: "",
                        label: "Website"
                      }, null, 8
                      /* PROPS */
                      , ["modelValue"])];
                    }),
                    _: 1
                    /* STABLE */

                  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
                    cols: "12",
                    md: "6"
                  }, {
                    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_select, {
                        modelValue: $setup.optionsLocal.country,
                        "onUpdate:modelValue": _cache[4] || (_cache[4] = function ($event) {
                          return $setup.optionsLocal.country = $event;
                        }),
                        outlined: "",
                        dense: "",
                        label: "Country",
                        items: ['USA', 'UK', 'AUSTRALIA', 'BRAZIL']
                      }, null, 8
                      /* PROPS */
                      , ["modelValue"])];
                    }),
                    _: 1
                    /* STABLE */

                  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
                    cols: "12",
                    md: "6"
                  }, {
                    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_select, {
                        modelValue: $setup.optionsLocal.languages,
                        "onUpdate:modelValue": _cache[5] || (_cache[5] = function ($event) {
                          return $setup.optionsLocal.languages = $event;
                        }),
                        outlined: "",
                        dense: "",
                        multiple: "",
                        chips: "",
                        "small-chips": "",
                        label: "Languages",
                        items: ['English', 'Spanish', 'French', 'German']
                      }, null, 8
                      /* PROPS */
                      , ["modelValue"])];
                    }),
                    _: 1
                    /* STABLE */

                  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
                    cols: "12",
                    md: "6"
                  }, {
                    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                      return [_hoisted_1, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_radio_group, {
                        modelValue: $setup.optionsLocal.gender,
                        "onUpdate:modelValue": _cache[6] || (_cache[6] = function ($event) {
                          return $setup.optionsLocal.gender = $event;
                        }),
                        row: "",
                        "class": "mt-0",
                        "hide-details": ""
                      }, {
                        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_radio, {
                            value: "male",
                            label: "Male"
                          }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_radio, {
                            value: "female",
                            label: "Female"
                          }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_radio, {
                            value: "other",
                            label: "Other"
                          })];
                        }),
                        _: 1
                        /* STABLE */

                      }, 8
                      /* PROPS */
                      , ["modelValue"])];
                    }),
                    _: 1
                    /* STABLE */

                  })];
                }),
                _: 1
                /* STABLE */

              })];
            }),
            _: 1
            /* STABLE */

          }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_card_text, null, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_btn, {
                color: "primary",
                "class": "me-3 mt-3"
              }, {
                "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                  return [_hoisted_2];
                }),
                _: 1
                /* STABLE */

              }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_btn, {
                outlined: "",
                "class": "mt-3",
                color: "secondary",
                type: "reset",
                onClick: (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)($setup.resetForm, ["prevent"])
              }, {
                "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                  return [_hoisted_3];
                }),
                _: 1
                /* STABLE */

              }, 8
              /* PROPS */
              , ["onClick"])];
            }),
            _: 1
            /* STABLE */

          })];
        }),
        _: 1
        /* STABLE */

      })];
    }),
    _: 1
    /* STABLE */

  });
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettingsSecurity.vue?vue&type=template&id=5fdf50e4&scoped=true":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettingsSecurity.vue?vue&type=template&id=5fdf50e4&scoped=true ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* binding */ render; }
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");


var _withScopeId = function _withScopeId(n) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.pushScopeId)("data-v-5fdf50e4"), n = n(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.popScopeId)(), n;
};

var _hoisted_1 = {
  "class": "px-3"
};
var _hoisted_2 = {
  "class": "pa-3"
};

var _hoisted_3 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" mdiKeyOutline ");

var _hoisted_4 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "text-break"
  }, "Two-factor authentication", -1
  /* HOISTED */
  );
});

var _hoisted_5 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" mdiLockOpenOutline ");

var _hoisted_6 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
    "class": "text-base text--primary font-weight-semibold"
  }, " Two factor authentication is not enabled yet. ", -1
  /* HOISTED */
  );
});

var _hoisted_7 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
    "class": "text-sm text--primary"
  }, " Two-factor authentication adds an additional layer of security to your account by requiring more than just a password to log in. Learn more. ", -1
  /* HOISTED */
  );
});

var _hoisted_8 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Save changes ");

var _hoisted_9 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Cancel ");

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_v_text_field = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-text-field");

  var _component_v_col = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-col");

  var _component_v_img = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-img");

  var _component_v_row = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-row");

  var _component_v_card_text = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card-text");

  var _component_v_divider = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-divider");

  var _component_v_icon = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-icon");

  var _component_v_card_title = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card-title");

  var _component_v_avatar = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-avatar");

  var _component_v_btn = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-btn");

  var _component_v_form = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-form");

  var _component_v_card = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_v_card, {
    flat: "",
    "class": "mt-5"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_form, null, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_card_text, {
            "class": "pt-5"
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_row, null, {
                "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                  return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
                    cols: "12",
                    sm: "8",
                    md: "6"
                  }, {
                    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" current password "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_text_field, {
                        modelValue: $setup.currentPassword,
                        "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
                          return $setup.currentPassword = $event;
                        }),
                        type: $setup.isCurrentPasswordVisible ? 'text' : 'password',
                        "append-icon": $setup.isCurrentPasswordVisible ? 'mdiEyeOffOutline' : 'mdiEyeOutline',
                        label: "Current Password",
                        outlined: "",
                        dense: "",
                        "onClick:append": _cache[1] || (_cache[1] = function ($event) {
                          return $setup.isCurrentPasswordVisible = !$setup.isCurrentPasswordVisible;
                        })
                      }, null, 8
                      /* PROPS */
                      , ["modelValue", "type", "append-icon"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" new password "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_text_field, {
                        modelValue: $setup.newPassword,
                        "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
                          return $setup.newPassword = $event;
                        }),
                        type: $setup.isNewPasswordVisible ? 'text' : 'password',
                        "append-icon": $setup.isNewPasswordVisible ? _ctx.mdiEyeOffOutline : _ctx.mdiEyeOutline,
                        label: "New Password",
                        outlined: "",
                        dense: "",
                        hint: "Make sure it's at least 8 characters.",
                        "persistent-hint": "",
                        "onClick:append": _cache[3] || (_cache[3] = function ($event) {
                          return $setup.isNewPasswordVisible = !$setup.isNewPasswordVisible;
                        })
                      }, null, 8
                      /* PROPS */
                      , ["modelValue", "type", "append-icon"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" confirm password "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_text_field, {
                        modelValue: $setup.cPassword,
                        "onUpdate:modelValue": _cache[4] || (_cache[4] = function ($event) {
                          return $setup.cPassword = $event;
                        }),
                        type: $setup.isCPasswordVisible ? 'text' : 'password',
                        "append-icon": $setup.isCPasswordVisible ? _ctx.mdiEyeOffOutline : _ctx.mdiEyeOutline,
                        label: "Confirm New Password",
                        outlined: "",
                        dense: "",
                        "class": "mt-3",
                        "onClick:append": _cache[5] || (_cache[5] = function ($event) {
                          return $setup.isCPasswordVisible = !$setup.isCPasswordVisible;
                        })
                      }, null, 8
                      /* PROPS */
                      , ["modelValue", "type", "append-icon"])];
                    }),
                    _: 1
                    /* STABLE */

                  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
                    cols: "12",
                    sm: "4",
                    md: "6",
                    "class": "d-none d-sm-flex justify-center position-relative"
                  }, {
                    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_img, {
                        contain: "",
                        "max-width": "170",
                        src: "images/3d-characters/pose-m-1.png",
                        "class": "security-character"
                      })];
                    }),
                    _: 1
                    /* STABLE */

                  })];
                }),
                _: 1
                /* STABLE */

              })];
            }),
            _: 1
            /* STABLE */

          })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" divider "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_divider), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_card_title, {
            "class": "flex-nowrap"
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_icon, {
                "class": "text--primary me-3"
              }, {
                "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                  return [_hoisted_3];
                }),
                _: 1
                /* STABLE */

              }), _hoisted_4];
            }),
            _: 1
            /* STABLE */

          }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_card_text, {
            "class": "two-factor-auth text-center mx-auto"
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_avatar, {
                color: "primary",
                "class": "primary mb-4",
                rounded: ""
              }, {
                "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                  return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_icon, {
                    size: "25",
                    color: "white"
                  }, {
                    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                      return [_hoisted_5];
                    }),
                    _: 1
                    /* STABLE */

                  })];
                }),
                _: 1
                /* STABLE */

              }), _hoisted_6, _hoisted_7];
            }),
            _: 1
            /* STABLE */

          }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" action buttons "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_card_text, null, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_btn, {
                color: "primary",
                "class": "me-3 mt-3"
              }, {
                "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                  return [_hoisted_8];
                }),
                _: 1
                /* STABLE */

              }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_btn, {
                color: "secondary",
                outlined: "",
                "class": "mt-3"
              }, {
                "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                  return [_hoisted_9];
                }),
                _: 1
                /* STABLE */

              })];
            }),
            _: 1
            /* STABLE */

          })])];
        }),
        _: 1
        /* STABLE */

      })];
    }),
    _: 1
    /* STABLE */

  });
}

/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettingsSecurity.vue?vue&type=style&index=0&id=5fdf50e4&lang=scss&scoped=true":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettingsSecurity.vue?vue&type=style&index=0&id=5fdf50e4&lang=scss&scoped=true ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ (function(module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js */ "./node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, ".two-factor-auth[data-v-5fdf50e4] {\n  max-width: 25rem;\n}\n.security-character[data-v-5fdf50e4] {\n  position: absolute;\n  bottom: -0.5rem;\n}", ""]);
// Exports
/* harmony default export */ __webpack_exports__["default"] = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettingsSecurity.vue?vue&type=style&index=0&id=5fdf50e4&lang=scss&scoped=true":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettingsSecurity.vue?vue&type=style&index=0&id=5fdf50e4&lang=scss&scoped=true ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_use_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_AccountSettingsSecurity_vue_vue_type_style_index_0_id_5fdf50e4_lang_scss_scoped_true__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!../../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!../../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./AccountSettingsSecurity.vue?vue&type=style&index=0&id=5fdf50e4&lang=scss&scoped=true */ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettingsSecurity.vue?vue&type=style&index=0&id=5fdf50e4&lang=scss&scoped=true");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_use_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_AccountSettingsSecurity_vue_vue_type_style_index_0_id_5fdf50e4_lang_scss_scoped_true__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ __webpack_exports__["default"] = (_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_use_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_AccountSettingsSecurity_vue_vue_type_style_index_0_id_5fdf50e4_lang_scss_scoped_true__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./resources/js/views/pages/account-settings/AccountSettings.vue":
/*!***********************************************************************!*\
  !*** ./resources/js/views/pages/account-settings/AccountSettings.vue ***!
  \***********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _AccountSettings_vue_vue_type_template_id_6906222e__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./AccountSettings.vue?vue&type=template&id=6906222e */ "./resources/js/views/pages/account-settings/AccountSettings.vue?vue&type=template&id=6906222e");
/* harmony import */ var _AccountSettings_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./AccountSettings.vue?vue&type=script&lang=js */ "./resources/js/views/pages/account-settings/AccountSettings.vue?vue&type=script&lang=js");
/* harmony import */ var _var_www_html_php_laravel_laravelerp_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_var_www_html_php_laravel_laravelerp_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_AccountSettings_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_AccountSettings_vue_vue_type_template_id_6906222e__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/views/pages/account-settings/AccountSettings.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ __webpack_exports__["default"] = (__exports__);

/***/ }),

/***/ "./resources/js/views/pages/account-settings/AccountSettingsAccount.vue":
/*!******************************************************************************!*\
  !*** ./resources/js/views/pages/account-settings/AccountSettingsAccount.vue ***!
  \******************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _AccountSettingsAccount_vue_vue_type_template_id_d8e1fc62__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./AccountSettingsAccount.vue?vue&type=template&id=d8e1fc62 */ "./resources/js/views/pages/account-settings/AccountSettingsAccount.vue?vue&type=template&id=d8e1fc62");
/* harmony import */ var _AccountSettingsAccount_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./AccountSettingsAccount.vue?vue&type=script&lang=js */ "./resources/js/views/pages/account-settings/AccountSettingsAccount.vue?vue&type=script&lang=js");
/* harmony import */ var _var_www_html_php_laravel_laravelerp_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_var_www_html_php_laravel_laravelerp_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_AccountSettingsAccount_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_AccountSettingsAccount_vue_vue_type_template_id_d8e1fc62__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/views/pages/account-settings/AccountSettingsAccount.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ __webpack_exports__["default"] = (__exports__);

/***/ }),

/***/ "./resources/js/views/pages/account-settings/AccountSettingsInfo.vue":
/*!***************************************************************************!*\
  !*** ./resources/js/views/pages/account-settings/AccountSettingsInfo.vue ***!
  \***************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _AccountSettingsInfo_vue_vue_type_template_id_e773ae08__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./AccountSettingsInfo.vue?vue&type=template&id=e773ae08 */ "./resources/js/views/pages/account-settings/AccountSettingsInfo.vue?vue&type=template&id=e773ae08");
/* harmony import */ var _AccountSettingsInfo_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./AccountSettingsInfo.vue?vue&type=script&lang=js */ "./resources/js/views/pages/account-settings/AccountSettingsInfo.vue?vue&type=script&lang=js");
/* harmony import */ var _var_www_html_php_laravel_laravelerp_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_var_www_html_php_laravel_laravelerp_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_AccountSettingsInfo_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_AccountSettingsInfo_vue_vue_type_template_id_e773ae08__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/views/pages/account-settings/AccountSettingsInfo.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ __webpack_exports__["default"] = (__exports__);

/***/ }),

/***/ "./resources/js/views/pages/account-settings/AccountSettingsSecurity.vue":
/*!*******************************************************************************!*\
  !*** ./resources/js/views/pages/account-settings/AccountSettingsSecurity.vue ***!
  \*******************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _AccountSettingsSecurity_vue_vue_type_template_id_5fdf50e4_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./AccountSettingsSecurity.vue?vue&type=template&id=5fdf50e4&scoped=true */ "./resources/js/views/pages/account-settings/AccountSettingsSecurity.vue?vue&type=template&id=5fdf50e4&scoped=true");
/* harmony import */ var _AccountSettingsSecurity_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./AccountSettingsSecurity.vue?vue&type=script&lang=js */ "./resources/js/views/pages/account-settings/AccountSettingsSecurity.vue?vue&type=script&lang=js");
/* harmony import */ var _AccountSettingsSecurity_vue_vue_type_style_index_0_id_5fdf50e4_lang_scss_scoped_true__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./AccountSettingsSecurity.vue?vue&type=style&index=0&id=5fdf50e4&lang=scss&scoped=true */ "./resources/js/views/pages/account-settings/AccountSettingsSecurity.vue?vue&type=style&index=0&id=5fdf50e4&lang=scss&scoped=true");
/* harmony import */ var _var_www_html_php_laravel_laravelerp_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;


const __exports__ = /*#__PURE__*/(0,_var_www_html_php_laravel_laravelerp_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__["default"])(_AccountSettingsSecurity_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_AccountSettingsSecurity_vue_vue_type_template_id_5fdf50e4_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render],['__scopeId',"data-v-5fdf50e4"],['__file',"resources/js/views/pages/account-settings/AccountSettingsSecurity.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ __webpack_exports__["default"] = (__exports__);

/***/ }),

/***/ "./resources/js/views/pages/account-settings/AccountSettings.vue?vue&type=script&lang=js":
/*!***********************************************************************************************!*\
  !*** ./resources/js/views/pages/account-settings/AccountSettings.vue?vue&type=script&lang=js ***!
  \***********************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_AccountSettings_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_AccountSettings_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./AccountSettings.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettings.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/views/pages/account-settings/AccountSettingsAccount.vue?vue&type=script&lang=js":
/*!******************************************************************************************************!*\
  !*** ./resources/js/views/pages/account-settings/AccountSettingsAccount.vue?vue&type=script&lang=js ***!
  \******************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_AccountSettingsAccount_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_AccountSettingsAccount_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./AccountSettingsAccount.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettingsAccount.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/views/pages/account-settings/AccountSettingsInfo.vue?vue&type=script&lang=js":
/*!***************************************************************************************************!*\
  !*** ./resources/js/views/pages/account-settings/AccountSettingsInfo.vue?vue&type=script&lang=js ***!
  \***************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_AccountSettingsInfo_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_AccountSettingsInfo_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./AccountSettingsInfo.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettingsInfo.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/views/pages/account-settings/AccountSettingsSecurity.vue?vue&type=script&lang=js":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/views/pages/account-settings/AccountSettingsSecurity.vue?vue&type=script&lang=js ***!
  \*******************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_AccountSettingsSecurity_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_AccountSettingsSecurity_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./AccountSettingsSecurity.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettingsSecurity.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/views/pages/account-settings/AccountSettings.vue?vue&type=template&id=6906222e":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/views/pages/account-settings/AccountSettings.vue?vue&type=template&id=6906222e ***!
  \*****************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_AccountSettings_vue_vue_type_template_id_6906222e__WEBPACK_IMPORTED_MODULE_0__.render; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_AccountSettings_vue_vue_type_template_id_6906222e__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./AccountSettings.vue?vue&type=template&id=6906222e */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettings.vue?vue&type=template&id=6906222e");


/***/ }),

/***/ "./resources/js/views/pages/account-settings/AccountSettingsAccount.vue?vue&type=template&id=d8e1fc62":
/*!************************************************************************************************************!*\
  !*** ./resources/js/views/pages/account-settings/AccountSettingsAccount.vue?vue&type=template&id=d8e1fc62 ***!
  \************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_AccountSettingsAccount_vue_vue_type_template_id_d8e1fc62__WEBPACK_IMPORTED_MODULE_0__.render; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_AccountSettingsAccount_vue_vue_type_template_id_d8e1fc62__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./AccountSettingsAccount.vue?vue&type=template&id=d8e1fc62 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettingsAccount.vue?vue&type=template&id=d8e1fc62");


/***/ }),

/***/ "./resources/js/views/pages/account-settings/AccountSettingsInfo.vue?vue&type=template&id=e773ae08":
/*!*********************************************************************************************************!*\
  !*** ./resources/js/views/pages/account-settings/AccountSettingsInfo.vue?vue&type=template&id=e773ae08 ***!
  \*********************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_AccountSettingsInfo_vue_vue_type_template_id_e773ae08__WEBPACK_IMPORTED_MODULE_0__.render; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_AccountSettingsInfo_vue_vue_type_template_id_e773ae08__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./AccountSettingsInfo.vue?vue&type=template&id=e773ae08 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettingsInfo.vue?vue&type=template&id=e773ae08");


/***/ }),

/***/ "./resources/js/views/pages/account-settings/AccountSettingsSecurity.vue?vue&type=template&id=5fdf50e4&scoped=true":
/*!*************************************************************************************************************************!*\
  !*** ./resources/js/views/pages/account-settings/AccountSettingsSecurity.vue?vue&type=template&id=5fdf50e4&scoped=true ***!
  \*************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_AccountSettingsSecurity_vue_vue_type_template_id_5fdf50e4_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_AccountSettingsSecurity_vue_vue_type_template_id_5fdf50e4_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./AccountSettingsSecurity.vue?vue&type=template&id=5fdf50e4&scoped=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettingsSecurity.vue?vue&type=template&id=5fdf50e4&scoped=true");


/***/ }),

/***/ "./resources/js/views/pages/account-settings/AccountSettingsSecurity.vue?vue&type=style&index=0&id=5fdf50e4&lang=scss&scoped=true":
/*!****************************************************************************************************************************************!*\
  !*** ./resources/js/views/pages/account-settings/AccountSettingsSecurity.vue?vue&type=style&index=0&id=5fdf50e4&lang=scss&scoped=true ***!
  \****************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_style_loader_dist_cjs_js_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_use_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_AccountSettingsSecurity_vue_vue_type_style_index_0_id_5fdf50e4_lang_scss_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!../../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!../../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./AccountSettingsSecurity.vue?vue&type=style&index=0&id=5fdf50e4&lang=scss&scoped=true */ "./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/pages/account-settings/AccountSettingsSecurity.vue?vue&type=style&index=0&id=5fdf50e4&lang=scss&scoped=true");


/***/ })

}]);