"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_apps_dashboard_pages_Dashboard_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/apps/dashboard/pages/Dashboard.vue?vue&type=script&lang=js":
/*!*************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/apps/dashboard/pages/Dashboard.vue?vue&type=script&lang=js ***!
  \*************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _mdi_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @mdi/js */ "./node_modules/@mdi/js/mdi.js");
/* harmony import */ var _components_statistics_card_StatisticsCardVertical_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @/components/statistics-card/StatisticsCardVertical.vue */ "./resources/js/components/statistics-card/StatisticsCardVertical.vue");
/* harmony import */ var _views_dashboard_DashboardCongratulationJohn_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/views/dashboard/DashboardCongratulationJohn.vue */ "./resources/js/views/dashboard/DashboardCongratulationJohn.vue");
/* harmony import */ var _views_dashboard_DashboardStatisticsCard_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @/views/dashboard/DashboardStatisticsCard.vue */ "./resources/js/views/dashboard/DashboardStatisticsCard.vue");
/* harmony import */ var _views_dashboard_DashboardCardTotalEarning_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @/views/dashboard/DashboardCardTotalEarning.vue */ "./resources/js/views/dashboard/DashboardCardTotalEarning.vue");
/* harmony import */ var _views_dashboard_DashboardCardDepositAndWithdraw_vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @/views/dashboard/DashboardCardDepositAndWithdraw.vue */ "./resources/js/views/dashboard/DashboardCardDepositAndWithdraw.vue");
/* harmony import */ var _views_dashboard_DashboardCardSalesByCountries_vue__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @/views/dashboard/DashboardCardSalesByCountries.vue */ "./resources/js/views/dashboard/DashboardCardSalesByCountries.vue");
/* harmony import */ var _views_dashboard_DashboardWeeklyOverview_vue__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @/views/dashboard/DashboardWeeklyOverview.vue */ "./resources/js/views/dashboard/DashboardWeeklyOverview.vue");
/* harmony import */ var _views_dashboard_DashboardDatatable_vue__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @/views/dashboard/DashboardDatatable.vue */ "./resources/js/views/dashboard/DashboardDatatable.vue");
// eslint-disable-next-line object-curly-newline

 // demos








/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    StatisticsCardVertical: _components_statistics_card_StatisticsCardVertical_vue__WEBPACK_IMPORTED_MODULE_0__["default"],
    DashboardCongratulationJohn: _views_dashboard_DashboardCongratulationJohn_vue__WEBPACK_IMPORTED_MODULE_1__["default"],
    DashboardStatisticsCard: _views_dashboard_DashboardStatisticsCard_vue__WEBPACK_IMPORTED_MODULE_2__["default"],
    DashboardCardTotalEarning: _views_dashboard_DashboardCardTotalEarning_vue__WEBPACK_IMPORTED_MODULE_3__["default"],
    DashboardCardDepositAndWithdraw: _views_dashboard_DashboardCardDepositAndWithdraw_vue__WEBPACK_IMPORTED_MODULE_4__["default"],
    DashboardCardSalesByCountries: _views_dashboard_DashboardCardSalesByCountries_vue__WEBPACK_IMPORTED_MODULE_5__["default"],
    DashboardWeeklyOverview: _views_dashboard_DashboardWeeklyOverview_vue__WEBPACK_IMPORTED_MODULE_6__["default"],
    DashboardDatatable: _views_dashboard_DashboardDatatable_vue__WEBPACK_IMPORTED_MODULE_7__["default"]
  },
  setup: function setup() {
    var totalProfit = {
      statTitle: 'Total Profit',
      icon: _mdi_js__WEBPACK_IMPORTED_MODULE_8__.mdiPoll,
      color: 'success',
      subtitle: 'Weekly Project',
      statistics: '$25.6k',
      change: '+42%'
    };
    var totalSales = {
      statTitle: 'Refunds',
      icon: _mdi_js__WEBPACK_IMPORTED_MODULE_8__.mdiCurrencyUsd,
      color: 'secondary',
      subtitle: 'Past Month',
      statistics: '$78',
      change: '-15%'
    }; // vertical card options

    var newProject = {
      statTitle: 'New Project',
      icon: _mdi_js__WEBPACK_IMPORTED_MODULE_8__.mdiLabelVariantOutline,
      color: 'primary',
      subtitle: 'Yearly Project',
      statistics: '862',
      change: '-18%'
    };
    var salesQueries = {
      statTitle: 'Sales Quries',
      icon: _mdi_js__WEBPACK_IMPORTED_MODULE_8__.mdiHelpCircleOutline,
      color: 'warning',
      subtitle: 'Last week',
      statistics: '15',
      change: '-18%'
    };
    return {
      totalProfit: totalProfit,
      totalSales: totalSales,
      newProject: newProject,
      salesQueries: salesQueries
    };
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/statistics-card/StatisticsCardVertical.vue?vue&type=script&lang=js":
/*!********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/statistics-card/StatisticsCardVertical.vue?vue&type=script&lang=js ***!
  \********************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _mdi_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @mdi/js */ "./node_modules/@mdi/js/mdi.js");

/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    statTitle: {
      type: String,
      "default": ''
    },
    icon: {
      type: String,
      "default": ''
    },
    color: {
      type: String,
      "default": ''
    },
    subtitle: {
      type: String,
      "default": ''
    },
    statistics: {
      type: String,
      "default": ''
    },
    change: {
      type: String,
      "default": ''
    }
  },
  setup: function setup() {
    var checkChange = function checkChange(value) {
      var firstChar = value.charAt(0);

      if (firstChar === '+') {
        return true;
      }

      return false;
    };

    return {
      mdiDotsVertical: _mdi_js__WEBPACK_IMPORTED_MODULE_0__.mdiDotsVertical,
      checkChange: checkChange
    };
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardCardDepositAndWithdraw.vue?vue&type=script&lang=js":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardCardDepositAndWithdraw.vue?vue&type=script&lang=js ***!
  \******************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  setup: function setup() {
    var deposit = [{
      img: 'images/logos/gumroad.png',
      title: 'Gumroad Account',
      subtitle: 'Sell UI Kit',
      amount: '+$4,650'
    }, {
      img: 'images/logos/master.png',
      title: 'Mastercard',
      subtitle: 'Wallet deposit',
      amount: '+$92,705'
    }, {
      img: 'images/logos/stripe-account.png',
      title: 'Stripe Account',
      subtitle: 'iOS Application',
      amount: '+$957'
    }, {
      img: 'images/logos/american-bank.png',
      title: 'American Bank',
      subtitle: 'Bank Transfer',
      amount: '+$6,837'
    }, {
      img: 'images/logos/bank-account.png',
      title: 'Bank Account',
      subtitle: 'Wallet deposit',
      amount: '+$446'
    }];
    var withdraw = [{
      img: 'images/logos/google.png',
      title: 'Google Adsense',
      subtitle: 'Paypal deposit',
      amount: '-$145'
    }, {
      img: 'images/logos/github.png',
      title: 'Github Enterprise',
      subtitle: 'Security & compliance',
      amount: '-$1870'
    }, {
      img: 'images/logos/slack.png',
      title: 'Upgrade Slack Plan',
      subtitle: 'Debit card deposit',
      amount: '-$450'
    }, {
      img: 'images/logos/digital-ocean-logo.png',
      title: 'Digital Ocean',
      subtitle: 'Cloud Hosting',
      amount: '-$540'
    }, {
      img: 'images/logos/amazon-web-services-logo.png',
      title: 'Bank Account',
      subtitle: 'Choosing a Cloud Platform',
      amount: '-$21'
    }];
    return {
      deposit: deposit,
      withdraw: withdraw
    };
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardCardSalesByCountries.vue?vue&type=script&lang=js":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardCardSalesByCountries.vue?vue&type=script&lang=js ***!
  \****************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _mdi_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @mdi/js */ "./node_modules/@mdi/js/mdi.js");

/* harmony default export */ __webpack_exports__["default"] = ({
  setup: function setup() {
    var salesByCountries = [{
      abbr: "US",
      amount: "$8,656k",
      country: "United states of america",
      change: "+25.8%",
      sales: "894k",
      color: "success"
    }, {
      abbr: "UK",
      amount: "$2,415k",
      country: "United kingdom",
      change: "-6.2%",
      sales: "645k",
      color: "error"
    }, {
      abbr: "IN",
      amount: "$865k",
      country: "India",
      change: "+12.4%",
      sales: "148k",
      color: "warning"
    }, {
      abbr: "JA",
      amount: "$745k",
      country: "Japan",
      change: "-11.9%",
      sales: "86k",
      color: "secondary"
    }, {
      abbr: "KO",
      amount: "$45k",
      country: "Korea",
      change: "+16.2%",
      sales: "42k",
      color: "error"
    }];
    return {
      salesByCountries: salesByCountries,
      icons: {
        mdiDotsVertical: _mdi_js__WEBPACK_IMPORTED_MODULE_0__.mdiDotsVertical,
        mdiChevronUp: _mdi_js__WEBPACK_IMPORTED_MODULE_0__.mdiChevronUp,
        mdiChevronDown: _mdi_js__WEBPACK_IMPORTED_MODULE_0__.mdiChevronDown
      }
    };
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardCardTotalEarning.vue?vue&type=script&lang=js":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardCardTotalEarning.vue?vue&type=script&lang=js ***!
  \************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _mdi_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @mdi/js */ "./node_modules/@mdi/js/mdi.js");

/* harmony default export */ __webpack_exports__["default"] = ({
  setup: function setup() {
    var totalEarning = [{
      avatar: "images/logos/zipcar.png",
      title: "Zipcar",
      subtitle: "Vuejs, React & HTML",
      earning: "$24,895.65",
      progress: "85",
      color: "primary"
    }, {
      avatar: "images/logos/bitbank.png",
      title: "Bitbank",
      subtitle: "Sketch, Figma & XD",
      earning: "$8,6500.20",
      progress: "65",
      color: "info"
    }, {
      avatar: "images/logos/aviato.png",
      title: "Aviato",
      subtitle: "HTML & angular",
      earning: "$1,2450.80",
      progress: "30",
      color: "secondary"
    }];
    return {
      totalEarning: totalEarning,
      icons: {
        mdiDotsVertical: _mdi_js__WEBPACK_IMPORTED_MODULE_0__.mdiDotsVertical,
        mdiMenuUp: _mdi_js__WEBPACK_IMPORTED_MODULE_0__.mdiMenuUp
      }
    };
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardDatatable.vue?vue&type=script&lang=js":
/*!*****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardDatatable.vue?vue&type=script&lang=js ***!
  \*****************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _mdi_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @mdi/js */ "./node_modules/@mdi/js/mdi.js");
/* harmony import */ var _datatable_data__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./datatable-data */ "./resources/js/views/dashboard/datatable-data.js");


/* harmony default export */ __webpack_exports__["default"] = ({
  setup: function setup() {
    var statusColor = {
      /* eslint-disable key-spacing */
      Current: 'primary',
      Professional: 'success',
      Rejected: 'error',
      Resigned: 'warning',
      Applied: 'info'
      /* eslint-enable key-spacing */

    };
    return {
      headers: [{
        text: 'NAME',
        value: 'full_name'
      }, {
        text: 'EMAIL',
        value: 'email'
      }, {
        text: 'DATE',
        value: 'start_date'
      }, {
        text: 'SALARY',
        value: 'salary'
      }, {
        text: 'AGE',
        value: 'age'
      }, {
        text: 'STATUS',
        value: 'status'
      }],
      usreList: _datatable_data__WEBPACK_IMPORTED_MODULE_0__["default"],
      status: {
        1: 'Current',
        2: 'Professional',
        3: 'Rejected',
        4: 'Resigned',
        5: 'Applied'
      },
      statusColor: statusColor,
      // icons
      icons: {
        mdiSquareEditOutline: _mdi_js__WEBPACK_IMPORTED_MODULE_1__.mdiSquareEditOutline,
        mdiDotsVertical: _mdi_js__WEBPACK_IMPORTED_MODULE_1__.mdiDotsVertical
      }
    };
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardStatisticsCard.vue?vue&type=script&lang=js":
/*!**********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardStatisticsCard.vue?vue&type=script&lang=js ***!
  \**********************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _mdi_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @mdi/js */ "./node_modules/@mdi/js/mdi.js");
// eslint-disable-next-line object-curly-newline

/* harmony default export */ __webpack_exports__["default"] = ({
  setup: function setup() {
    var statisticsData = [{
      title: "Sales",
      total: "245k"
    }, {
      title: "Customers",
      total: "12.5k"
    }, {
      title: "Product",
      total: "1.54k"
    }, {
      title: "Revenue",
      total: "$88k"
    }];

    var resolveStatisticsIconVariation = function resolveStatisticsIconVariation(data) {
      if (data === "Sales") return {
        icon: _mdi_js__WEBPACK_IMPORTED_MODULE_0__.mdiTrendingUp,
        color: "primary"
      };
      if (data === "Customers") return {
        icon: _mdi_js__WEBPACK_IMPORTED_MODULE_0__.mdiAccountOutline,
        color: "success"
      };
      if (data === "Product") return {
        icon: _mdi_js__WEBPACK_IMPORTED_MODULE_0__.mdiLabelOutline,
        color: "warning"
      };
      if (data === "Revenue") return {
        icon: _mdi_js__WEBPACK_IMPORTED_MODULE_0__.mdiCurrencyUsd,
        color: "info"
      };
      return {
        icon: _mdi_js__WEBPACK_IMPORTED_MODULE_0__.mdiAccountOutline,
        color: "success"
      };
    };

    return {
      statisticsData: statisticsData,
      resolveStatisticsIconVariation: resolveStatisticsIconVariation,
      // icons
      icons: {
        mdiDotsVertical: _mdi_js__WEBPACK_IMPORTED_MODULE_0__.mdiDotsVertical,
        mdiTrendingUp: _mdi_js__WEBPACK_IMPORTED_MODULE_0__.mdiTrendingUp,
        mdiAccountOutline: _mdi_js__WEBPACK_IMPORTED_MODULE_0__.mdiAccountOutline,
        mdiLabelOutline: _mdi_js__WEBPACK_IMPORTED_MODULE_0__.mdiLabelOutline,
        mdiCurrencyUsd: _mdi_js__WEBPACK_IMPORTED_MODULE_0__.mdiCurrencyUsd
      }
    };
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardWeeklyOverview.vue?vue&type=script&lang=js":
/*!**********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardWeeklyOverview.vue?vue&type=script&lang=js ***!
  \**********************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _mdi_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @mdi/js */ "./node_modules/@mdi/js/mdi.js");
// eslint-disable-next-line object-curly-newline

/* harmony default export */ __webpack_exports__["default"] = ({
  setup: function setup() {
    var customChartColor = "#3b3559";
    var chartOptions = {
      colors: [customChartColor, customChartColor, customChartColor, customChartColor, customChartColor, customChartColor],
      chart: {
        type: "bar",
        toolbar: {
          show: false
        },
        offsetX: -15
      },
      plotOptions: {
        bar: {
          columnWidth: "40%",
          distributed: true,
          borderRadius: 8,
          startingShape: "rounded",
          endingShape: "rounded"
        }
      },
      dataLabels: {
        enabled: false
      },
      legend: {
        show: false
      },
      xaxis: {
        categories: ["S", "M", "T", "W", "T", "F", "S"],
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        tickPlacement: "on",
        labels: {
          show: false,
          style: {
            fontSize: "12px"
          }
        }
      },
      yaxis: {
        show: true,
        tickAmount: 4,
        labels: {
          offsetY: 3,
          formatter: function formatter(value) {
            return "$".concat(value);
          }
        }
      },
      stroke: {
        width: [2, 2]
      },
      grid: {
        strokeDashArray: 12,
        padding: {
          right: 0
        }
      }
    };
    var chartData = [{
      data: [40, 60, 50, 60, 75, 60, 50, 65]
    }];
    return {
      chartOptions: chartOptions,
      chartData: chartData,
      icons: {
        mdiDotsVertical: _mdi_js__WEBPACK_IMPORTED_MODULE_0__.mdiDotsVertical,
        mdiTrendingUp: _mdi_js__WEBPACK_IMPORTED_MODULE_0__.mdiTrendingUp,
        mdiCurrencyUsd: _mdi_js__WEBPACK_IMPORTED_MODULE_0__.mdiCurrencyUsd
      }
    };
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/apps/dashboard/pages/Dashboard.vue?vue&type=template&id=6845148f":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/apps/dashboard/pages/Dashboard.vue?vue&type=template&id=6845148f ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* binding */ render; }
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_dashboard_congratulation_john = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("dashboard-congratulation-john");

  var _component_v_col = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-col");

  var _component_dashboard_statistics_card = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("dashboard-statistics-card");

  var _component_dashboard_weekly_overview = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("dashboard-weekly-overview");

  var _component_dashboard_card_total_earning = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("dashboard-card-total-earning");

  var _component_statistics_card_vertical = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("statistics-card-vertical");

  var _component_v_row = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-row");

  var _component_dashboard_card_sales_by_countries = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("dashboard-card-sales-by-countries");

  var _component_dashboard_card_deposit_and_withdraw = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("dashboard-card-deposit-and-withdraw");

  var _component_dashboard_datatable = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("dashboard-datatable");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_v_row, null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
        cols: "12",
        md: "4"
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_dashboard_congratulation_john)];
        }),
        _: 1
        /* STABLE */

      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
        cols: "12",
        md: "8"
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_dashboard_statistics_card)];
        }),
        _: 1
        /* STABLE */

      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
        cols: "12",
        sm: "6",
        md: "4"
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_dashboard_weekly_overview)];
        }),
        _: 1
        /* STABLE */

      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
        cols: "12",
        md: "4",
        sm: "6"
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_dashboard_card_total_earning)];
        }),
        _: 1
        /* STABLE */

      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
        cols: "12",
        md: "4"
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_row, {
            "class": "match-height"
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
                cols: "12",
                sm: "6"
              }, {
                "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                  return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_statistics_card_vertical, {
                    change: $setup.totalProfit.change,
                    color: $setup.totalProfit.color,
                    icon: $setup.totalProfit.icon,
                    statistics: $setup.totalProfit.statistics,
                    "stat-title": $setup.totalProfit.statTitle,
                    subtitle: $setup.totalProfit.subtitle
                  }, null, 8
                  /* PROPS */
                  , ["change", "color", "icon", "statistics", "stat-title", "subtitle"])];
                }),
                _: 1
                /* STABLE */

              }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
                cols: "12",
                sm: "6"
              }, {
                "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                  return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_statistics_card_vertical, {
                    change: $setup.totalSales.change,
                    color: $setup.totalSales.color,
                    icon: $setup.totalSales.icon,
                    statistics: $setup.totalSales.statistics,
                    "stat-title": $setup.totalSales.statTitle,
                    subtitle: $setup.totalSales.subtitle
                  }, null, 8
                  /* PROPS */
                  , ["change", "color", "icon", "statistics", "stat-title", "subtitle"])];
                }),
                _: 1
                /* STABLE */

              }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
                cols: "12",
                sm: "6"
              }, {
                "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                  return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_statistics_card_vertical, {
                    change: $setup.newProject.change,
                    color: $setup.newProject.color,
                    icon: $setup.newProject.icon,
                    statistics: $setup.newProject.statistics,
                    "stat-title": $setup.newProject.statTitle,
                    subtitle: $setup.newProject.subtitle
                  }, null, 8
                  /* PROPS */
                  , ["change", "color", "icon", "statistics", "stat-title", "subtitle"])];
                }),
                _: 1
                /* STABLE */

              }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
                cols: "12",
                sm: "6"
              }, {
                "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                  return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_statistics_card_vertical, {
                    change: $setup.salesQueries.change,
                    color: $setup.salesQueries.color,
                    icon: $setup.salesQueries.icon,
                    statistics: $setup.salesQueries.statistics,
                    "stat-title": $setup.salesQueries.statTitle,
                    subtitle: $setup.salesQueries.subtitle
                  }, null, 8
                  /* PROPS */
                  , ["change", "color", "icon", "statistics", "stat-title", "subtitle"])];
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

      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
        cols: "12",
        md: "4"
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_dashboard_card_sales_by_countries)];
        }),
        _: 1
        /* STABLE */

      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
        cols: "12",
        md: "8"
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_dashboard_card_deposit_and_withdraw)];
        }),
        _: 1
        /* STABLE */

      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
        cols: "12"
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_dashboard_datatable)];
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/statistics-card/StatisticsCardVertical.vue?vue&type=template&id=0be71a6e&scoped=true":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/statistics-card/StatisticsCardVertical.vue?vue&type=template&id=0be71a6e&scoped=true ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* binding */ render; }
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");


var _withScopeId = function _withScopeId(n) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.pushScopeId)("data-v-0be71a6e"), n = n(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.popScopeId)(), n;
};

var _hoisted_1 = {
  "class": "font-weight-semibold text-sm mb-1"
};
var _hoisted_2 = {
  "class": "d-flex align-end flex-wrap"
};
var _hoisted_3 = {
  "class": "font-weight-semibold text-2xl me-1 mb-2"
};
var _hoisted_4 = {
  "class": "text-xs text--secondary mb-0"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_v_icon = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-icon");

  var _component_v_avatar = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-avatar");

  var _component_v_spacer = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-spacer");

  var _component_v_btn = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-btn");

  var _component_v_card_title = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card-title");

  var _component_v_card_text = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card-text");

  var _component_v_card = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_v_card, null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_card_title, {
        "class": "align-start"
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_avatar, {
            color: $props.color,
            size: "38",
            "class": "elevation-3"
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_icon, {
                size: "24",
                color: "white",
                "class": "rounded-0"
              }, {
                "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                  return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.icon), 1
                  /* TEXT */
                  )];
                }),
                _: 1
                /* STABLE */

              })];
            }),
            _: 1
            /* STABLE */

          }, 8
          /* PROPS */
          , ["color"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_spacer), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_btn, {
            small: "",
            icon: "",
            "class": "me-n3 mt-n1"
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_icon, null, {
                "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                  return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" mdiDotsVertical " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.mdiDotsVertical), 1
                  /* TEXT */
                  )];
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

      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_card_text, {
        "class": "text-no-wrap text--primary mt-3"
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_1, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.statTitle), 1
          /* TEXT */
          ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_3, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.statistics), 1
          /* TEXT */
          ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
            "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["percentage text-xs mb-2", $setup.checkChange($props.change) ? 'success--text' : 'error--text'])
          }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.change), 3
          /* TEXT, CLASS */
          )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_4, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.subtitle), 1
          /* TEXT */
          )];
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardCardDepositAndWithdraw.vue?vue&type=template&id=70ae0bdd":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardCardDepositAndWithdraw.vue?vue&type=template&id=70ae0bdd ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* binding */ render; }
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "d-flex flex-sm-row flex-column"
};
var _hoisted_2 = {
  "class": "flex-grow-1"
};

var _hoisted_3 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "me-3"
}, "Deposit", -1
/* HOISTED */
);

var _hoisted_4 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "text-xs text--disabled cursor-pointer"
}, "View All", -1
/* HOISTED */
);

var _hoisted_5 = {
  "class": "d-flex align-center flex-grow-1 flex-wrap"
};
var _hoisted_6 = {
  "class": "me-auto pe-2"
};
var _hoisted_7 = {
  "class": "font-weight-semibold"
};
var _hoisted_8 = {
  "class": "text-xs"
};
var _hoisted_9 = {
  "class": "font-weight-semibold success--text"
};
var _hoisted_10 = {
  "class": "flex-grow-1"
};

var _hoisted_11 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "me-3"
}, "Withdraw", -1
/* HOISTED */
);

var _hoisted_12 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "text-xs text--disabled cursor-pointer"
}, "View All", -1
/* HOISTED */
);

var _hoisted_13 = {
  "class": "d-flex align-center flex-grow-1 flex-wrap"
};
var _hoisted_14 = {
  "class": "me-auto pe-2"
};
var _hoisted_15 = {
  "class": "font-weight-semibold"
};
var _hoisted_16 = {
  "class": "text-xs"
};
var _hoisted_17 = {
  "class": "font-weight-semibold error--text"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_v_spacer = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-spacer");

  var _component_v_card_title = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card-title");

  var _component_v_img = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-img");

  var _component_v_list_item = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-list-item");

  var _component_v_list = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-list");

  var _component_v_card_text = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card-text");

  var _component_v_divider = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-divider");

  var _component_v_card = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_v_card, null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_card_title, null, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [_hoisted_3, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_spacer), _hoisted_4];
        }),
        _: 1
        /* STABLE */

      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_card_text, null, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_list, null, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($setup.deposit, function (data, index) {
                return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_v_list_item, {
                  key: index,
                  "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)("d-flex px-0 ".concat(index > 0 ? 'mt-4' : ''))
                }, {
                  "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                    return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_img, {
                      contain: "",
                      "max-height": "30",
                      "max-width": "30",
                      src: data.img,
                      "class": "me-3"
                    }, null, 8
                    /* PROPS */
                    , ["src"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h4", _hoisted_7, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(data.title), 1
                    /* TEXT */
                    ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_8, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(data.subtitle), 1
                    /* TEXT */
                    )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_9, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(data.amount), 1
                    /* TEXT */
                    )])];
                  }),
                  _: 2
                  /* DYNAMIC */

                }, 1032
                /* PROPS, DYNAMIC_SLOTS */
                , ["class"]);
              }), 128
              /* KEYED_FRAGMENT */
              ))];
            }),
            _: 1
            /* STABLE */

          })];
        }),
        _: 1
        /* STABLE */

      })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_divider, {
        "class": "my-sm-5 mx-5"
      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_10, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_card_title, null, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [_hoisted_11, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_spacer), _hoisted_12];
        }),
        _: 1
        /* STABLE */

      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_card_text, null, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_list, null, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($setup.withdraw, function (data, index) {
                return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_v_list_item, {
                  key: index,
                  "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)("d-flex px-0 ".concat(index > 0 ? 'mt-4' : ''))
                }, {
                  "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                    return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_img, {
                      "max-height": "30",
                      "max-width": "30",
                      src: data.img,
                      "class": "me-3"
                    }, null, 8
                    /* PROPS */
                    , ["src"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_13, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_14, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h4", _hoisted_15, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(data.title), 1
                    /* TEXT */
                    ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_16, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(data.subtitle), 1
                    /* TEXT */
                    )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_17, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(data.amount), 1
                    /* TEXT */
                    )])];
                  }),
                  _: 2
                  /* DYNAMIC */

                }, 1032
                /* PROPS, DYNAMIC_SLOTS */
                , ["class"]);
              }), 128
              /* KEYED_FRAGMENT */
              ))];
            }),
            _: 1
            /* STABLE */

          })];
        }),
        _: 1
        /* STABLE */

      })])])];
    }),
    _: 1
    /* STABLE */

  });
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardCardSalesByCountries.vue?vue&type=template&id=c270af6a":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardCardSalesByCountries.vue?vue&type=template&id=c270af6a ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* binding */ render; }
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");


var _hoisted_1 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, "Sales by Countries", -1
/* HOISTED */
);

var _hoisted_2 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" mdiDotsVertical ");

var _hoisted_3 = {
  "class": "text-base"
};
var _hoisted_4 = {
  "class": "d-flex align-center flex-grow-1 flex-wrap"
};
var _hoisted_5 = {
  "class": "me-2"
};
var _hoisted_6 = {
  "class": "font-weight-semibold"
};
var _hoisted_7 = {
  "class": "text--primary text-base me-1"
};
var _hoisted_8 = {
  "class": "font-weight-semibold"
};

var _hoisted_9 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "text-xs"
}, "Sales", -1
/* HOISTED */
);

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_v_spacer = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-spacer");

  var _component_v_icon = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-icon");

  var _component_v_btn = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-btn");

  var _component_v_card_title = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card-title");

  var _component_v_avatar = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-avatar");

  var _component_v_list_item_subtitle = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-list-item-subtitle");

  var _component_v_list_item = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-list-item");

  var _component_v_list = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-list");

  var _component_v_card_text = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card-text");

  var _component_v_card = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_v_card, null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_card_title, {
        "class": "align-start"
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [_hoisted_1, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_spacer), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_btn, {
            icon: "",
            small: "",
            "class": "me-n3 mt-n2"
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_icon, null, {
                "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                  return [_hoisted_2];
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
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_list, {
            "class": "pb-0"
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($setup.salesByCountries, function (data, index) {
                return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_v_list_item, {
                  key: data.country,
                  "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)("d-flex align-center px-0 ".concat(index > 0 ? 'mt-4' : ''))
                }, {
                  "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                    return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_avatar, {
                      color: data.color,
                      size: "40",
                      "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)("".concat(data.color, " white--text font-weight-medium me-3"))
                    }, {
                      "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                        return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_3, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(data.abbr), 1
                        /* TEXT */
                        )];
                      }),
                      _: 2
                      /* DYNAMIC */

                    }, 1032
                    /* PROPS, DYNAMIC_SLOTS */
                    , ["color", "class"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_7, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(data.amount), 1
                    /* TEXT */
                    ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_icon, {
                      size: "20",
                      color: data.change.charAt(0) === '+' ? 'success' : 'error'
                    }, {
                      "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                        return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(data.change.charAt(0) === "+" ? _ctx.mdiChevronUp : _ctx.mdiChevronDown), 1
                        /* TEXT */
                        )];
                      }),
                      _: 2
                      /* DYNAMIC */

                    }, 1032
                    /* PROPS, DYNAMIC_SLOTS */
                    , ["color"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
                      "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)("text-xs ".concat(data.change.charAt(0) === '+' ? 'success--text' : 'error--text'))
                    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(data.change.slice(1)), 3
                    /* TEXT, CLASS */
                    )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_list_item_subtitle, {
                      "class": "text-xs"
                    }, {
                      "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                        return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(data.country), 1
                        /* TEXT */
                        )];
                      }),
                      _: 2
                      /* DYNAMIC */

                    }, 1024
                    /* DYNAMIC_SLOTS */
                    )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_spacer), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h4", _hoisted_8, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(data.sales), 1
                    /* TEXT */
                    ), _hoisted_9])])];
                  }),
                  _: 2
                  /* DYNAMIC */

                }, 1032
                /* PROPS, DYNAMIC_SLOTS */
                , ["class"]);
              }), 128
              /* KEYED_FRAGMENT */
              ))];
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardCardTotalEarning.vue?vue&type=template&id=15902480":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardCardTotalEarning.vue?vue&type=template&id=15902480 ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* binding */ render; }
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");


var _hoisted_1 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, "Total Earning", -1
/* HOISTED */
);

var _hoisted_2 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" mdiDotsVertical ");

var _hoisted_3 = {
  "class": "d-flex align-center"
};

var _hoisted_4 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h1", {
  "class": "text-4xl font-weight-semibold"
}, "$24,895", -1
/* HOISTED */
);

var _hoisted_5 = {
  "class": "d-flex align-center mb-n3"
};

var _hoisted_6 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" mdiMenuUp ");

var _hoisted_7 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "text-base font-weight-medium success--text ms-n2"
}, "10%", -1
/* HOISTED */
);

var _hoisted_8 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h4", {
  "class": "mt-2 font-weight-medium"
}, " Compared to $84,325 last year ", -1
/* HOISTED */
);

var _hoisted_9 = {
  "class": "d-flex align-center flex-grow-1 flex-wrap"
};
var _hoisted_10 = {
  "class": "font-weight-medium"
};
var _hoisted_11 = {
  "class": "text-xs text-no-wrap"
};
var _hoisted_12 = {
  "class": "ms-1"
};
var _hoisted_13 = {
  "class": "text--primary font-weight-medium mb-1"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_v_spacer = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-spacer");

  var _component_v_icon = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-icon");

  var _component_v_btn = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-btn");

  var _component_v_card_title = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card-title");

  var _component_v_card_text = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card-text");

  var _component_v_img = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-img");

  var _component_v_avatar = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-avatar");

  var _component_v_progress_linear = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-progress-linear");

  var _component_v_card = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_v_card, null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_card_title, {
        "class": "align-start"
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [_hoisted_1, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_spacer), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_btn, {
            icon: "",
            small: "",
            "class": "me-n3 mt-n2"
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_icon, null, {
                "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                  return [_hoisted_2];
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

      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_card_text, {
        "class": "my-7"
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [_hoisted_4, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_icon, {
            size: "40",
            color: "success"
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [_hoisted_6];
            }),
            _: 1
            /* STABLE */

          }), _hoisted_7])]), _hoisted_8];
        }),
        _: 1
        /* STABLE */

      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_card_text, null, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($setup.totalEarning, function (earning, index) {
            return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
              key: index,
              "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)("d-flex align-start ".concat(index > 0 ? 'mt-8' : ''))
            }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_avatar, {
              rounded: "",
              size: "38",
              color: "#5e56690a",
              "class": "me-4"
            }, {
              "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_img, {
                  contain: "",
                  src: index,
                  height: "20"
                }, null, 8
                /* PROPS */
                , ["src"])];
              }),
              _: 2
              /* DYNAMIC */

            }, 1024
            /* DYNAMIC_SLOTS */
            ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_9, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h4", _hoisted_10, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(earning.title), 1
            /* TEXT */
            ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_11, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(earning.subtitle), 1
            /* TEXT */
            )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_spacer), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_12, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_13, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(earning.earning), 1
            /* TEXT */
            ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_progress_linear, {
              value: earning.progress,
              color: earning.color
            }, null, 8
            /* PROPS */
            , ["value", "color"])])])], 2
            /* CLASS */
            );
          }), 128
          /* KEYED_FRAGMENT */
          ))];
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardCongratulationJohn.vue?vue&type=template&id=742bbf9a&scoped=true":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardCongratulationJohn.vue?vue&type=template&id=742bbf9a&scoped=true ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* binding */ render; }
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");


var _withScopeId = function _withScopeId(n) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.pushScopeId)("data-v-742bbf9a"), n = n(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.popScopeId)(), n;
};

var _hoisted_1 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Congratulations John! 🥳 ");

var _hoisted_2 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" You have won Trophy ");

var _hoisted_3 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
    "class": "text-xl font-weight-semibold primary--text mb-2"
  }, " $42.8k ", -1
  /* HOISTED */
  );
});

var _hoisted_4 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" View Sales ");

function render(_ctx, _cache) {
  var _component_v_card_title = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card-title");

  var _component_v_card_subtitle = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card-subtitle");

  var _component_v_btn = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-btn");

  var _component_v_card_text = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card-text");

  var _component_v_col = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-col");

  var _component_v_img = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-img");

  var _component_v_row = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-row");

  var _component_v_card = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_v_card, {
    "class": "greeting-card"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_row, {
        "class": "ma-0 pa-0"
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
            cols: "8"
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_card_title, {
                "class": "text-no-wrap pt-1 ps-2"
              }, {
                "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                  return [_hoisted_1];
                }),
                _: 1
                /* STABLE */

              }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_card_subtitle, {
                "class": "text-no-wrap ps-2"
              }, {
                "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                  return [_hoisted_2];
                }),
                _: 1
                /* STABLE */

              }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_card_text, {
                "class": "d-flex align-center mt-2 pb-2 ps-2"
              }, {
                "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                  return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [_hoisted_3, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_btn, {
                    small: "",
                    color: "primary"
                  }, {
                    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                      return [_hoisted_4];
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

          }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_col, {
            cols: "4"
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_img, {
                contain: "",
                height: "180",
                width: "159",
                src: "images/misc/triangle-light.png",
                "class": "greeting-card-bg"
              }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_img, {
                contain: "",
                height: "108",
                "max-width": "83",
                "class": "greeting-card-trophy",
                src: "images/misc/trophy.png"
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardDatatable.vue?vue&type=template&id=215602ac":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardDatatable.vue?vue&type=template&id=215602ac ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* binding */ render; }
/* harmony export */ });
/* harmony import */ var _var_www_html_php_laravel_laravelerp_node_modules_babel_runtime_helpers_esm_defineProperty_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./node_modules/@babel/runtime/helpers/esm/defineProperty.js */ "./node_modules/@babel/runtime/helpers/esm/defineProperty.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");


var _hoisted_1 = {
  "class": "d-flex flex-column"
};
var _hoisted_2 = {
  "class": "d-block font-weight-semibold text--primary text-truncate"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_v_chip = (0,vue__WEBPACK_IMPORTED_MODULE_1__.resolveComponent)("v-chip");

  var _component_v_data_table = (0,vue__WEBPACK_IMPORTED_MODULE_1__.resolveComponent)("v-data-table");

  var _component_v_card = (0,vue__WEBPACK_IMPORTED_MODULE_1__.resolveComponent)("v-card");

  return (0,vue__WEBPACK_IMPORTED_MODULE_1__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_1__.createBlock)(_component_v_card, null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_1__.withCtx)(function () {
      var _createVNode2;

      return [(0,vue__WEBPACK_IMPORTED_MODULE_1__.createVNode)(_component_v_data_table, {
        headers: $setup.headers,
        items: $setup.usreList,
        "item-key": "full_name",
        "class": "table-rounded",
        "hide-default-footer": "",
        "disable-sort": ""
      }, (_createVNode2 = {}, (0,_var_www_html_php_laravel_laravelerp_node_modules_babel_runtime_helpers_esm_defineProperty_js__WEBPACK_IMPORTED_MODULE_0__["default"])(_createVNode2, "item.full_name", (0,vue__WEBPACK_IMPORTED_MODULE_1__.withCtx)(function (_ref) {
        var item = _ref.item;
        return [(0,vue__WEBPACK_IMPORTED_MODULE_1__.createElementVNode)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_1__.createElementVNode)("span", _hoisted_2, (0,vue__WEBPACK_IMPORTED_MODULE_1__.toDisplayString)(item.full_name), 1
        /* TEXT */
        ), (0,vue__WEBPACK_IMPORTED_MODULE_1__.createElementVNode)("small", null, (0,vue__WEBPACK_IMPORTED_MODULE_1__.toDisplayString)(item.post), 1
        /* TEXT */
        )])];
      })), (0,_var_www_html_php_laravel_laravelerp_node_modules_babel_runtime_helpers_esm_defineProperty_js__WEBPACK_IMPORTED_MODULE_0__["default"])(_createVNode2, "item.salary", (0,vue__WEBPACK_IMPORTED_MODULE_1__.withCtx)(function (_ref2) {
        var item = _ref2.item;
        return [(0,vue__WEBPACK_IMPORTED_MODULE_1__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_1__.toDisplayString)("$".concat(item.salary)), 1
        /* TEXT */
        )];
      })), (0,_var_www_html_php_laravel_laravelerp_node_modules_babel_runtime_helpers_esm_defineProperty_js__WEBPACK_IMPORTED_MODULE_0__["default"])(_createVNode2, "item.status", (0,vue__WEBPACK_IMPORTED_MODULE_1__.withCtx)(function (_ref3) {
        var item = _ref3.item;
        return [(0,vue__WEBPACK_IMPORTED_MODULE_1__.createVNode)(_component_v_chip, {
          small: "",
          color: $setup.statusColor[$setup.status[item.status]],
          "class": "font-weight-medium"
        }, {
          "default": (0,vue__WEBPACK_IMPORTED_MODULE_1__.withCtx)(function () {
            return [(0,vue__WEBPACK_IMPORTED_MODULE_1__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_1__.toDisplayString)($setup.status[item.status]), 1
            /* TEXT */
            )];
          }),
          _: 2
          /* DYNAMIC */

        }, 1032
        /* PROPS, DYNAMIC_SLOTS */
        , ["color"])];
      })), (0,_var_www_html_php_laravel_laravelerp_node_modules_babel_runtime_helpers_esm_defineProperty_js__WEBPACK_IMPORTED_MODULE_0__["default"])(_createVNode2, "_", 2), _createVNode2), 1032
      /* PROPS, DYNAMIC_SLOTS */
      , ["headers", "items"])];
    }),
    _: 1
    /* STABLE */

  });
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardStatisticsCard.vue?vue&type=template&id=91cb2606":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardStatisticsCard.vue?vue&type=template&id=91cb2606 ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* binding */ render; }
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");


var _hoisted_1 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "font-weight-semibold"
}, "Statistics Card", -1
/* HOISTED */
);

var _hoisted_2 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" mdiDotsVertical ");

var _hoisted_3 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "font-weight-semibold text--primary me-1"
}, "Total 48.5% Growth", -1
/* HOISTED */
);

var _hoisted_4 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, "😎 this month", -1
/* HOISTED */
);

var _hoisted_5 = {
  "class": "ms-3"
};
var _hoisted_6 = {
  "class": "text-xs mb-0"
};
var _hoisted_7 = {
  "class": "text-xl font-weight-semibold"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_v_spacer = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-spacer");

  var _component_v_icon = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-icon");

  var _component_v_btn = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-btn");

  var _component_v_card_title = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card-title");

  var _component_v_card_subtitle = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card-subtitle");

  var _component_v_avatar = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-avatar");

  var _component_v_col = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-col");

  var _component_v_row = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-row");

  var _component_v_card_text = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card-text");

  var _component_v_card = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_v_card, null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_card_title, {
        "class": "align-start"
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [_hoisted_1, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_spacer), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_btn, {
            icon: "",
            small: "",
            "class": "me-n3 mt-n2"
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_icon, null, {
                "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                  return [_hoisted_2];
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

      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_card_subtitle, {
        "class": "mb-8 mt-n5"
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [_hoisted_3, _hoisted_4];
        }),
        _: 1
        /* STABLE */

      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_card_text, null, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_row, null, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($setup.statisticsData, function (data) {
                return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_v_col, {
                  key: data.title,
                  cols: "6",
                  md: "3",
                  "class": "d-flex align-center"
                }, {
                  "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                    return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_avatar, {
                      size: "44",
                      color: $setup.resolveStatisticsIconVariation(data.title).color,
                      rounded: "",
                      "class": "elevation-1"
                    }, {
                      "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                        return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_icon, {
                          dark: "",
                          color: "white",
                          size: "30"
                        }, {
                          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                            return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.resolveStatisticsIconVariation(data.title).icon), 1
                            /* TEXT */
                            )];
                          }),
                          _: 2
                          /* DYNAMIC */

                        }, 1024
                        /* DYNAMIC_SLOTS */
                        )];
                      }),
                      _: 2
                      /* DYNAMIC */

                    }, 1032
                    /* PROPS, DYNAMIC_SLOTS */
                    , ["color"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_6, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(data.title), 1
                    /* TEXT */
                    ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", _hoisted_7, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(data.total), 1
                    /* TEXT */
                    )])];
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardWeeklyOverview.vue?vue&type=template&id=96594878":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardWeeklyOverview.vue?vue&type=template&id=96594878 ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* binding */ render; }
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");


var _hoisted_1 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, "Weekly Overview", -1
/* HOISTED */
);

var _hoisted_2 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" mdiDotsVertical ");

var _hoisted_3 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "d-flex align-center"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", {
  "class": "text-2xl font-weight-semibold me-4"
}, "45%"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, "Your sales perfomance in 45% 🤩 better compare to last month")], -1
/* HOISTED */
);

var _hoisted_4 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Details ");

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_v_spacer = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-spacer");

  var _component_v_icon = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-icon");

  var _component_v_btn = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-btn");

  var _component_v_card_title = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card-title");

  var _component_v_card_text = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card-text");

  var _component_v_card = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("v-card");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_v_card, null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_card_title, {
        "class": "align-start"
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [_hoisted_1, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_spacer), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_btn, {
            icon: "",
            small: "",
            "class": "mt-n2 me-n3"
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_icon, {
                size: "22"
              }, {
                "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                  return [_hoisted_2];
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
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Chart "), _hoisted_3, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_v_btn, {
            block: "",
            color: "primary",
            "class": "mt-6",
            outlined: ""
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [_hoisted_4];
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

/***/ "./resources/js/views/dashboard/datatable-data.js":
/*!********************************************************!*\
  !*** ./resources/js/views/dashboard/datatable-data.js ***!
  \********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
var data = [{
  responsive_id: '',
  id: 95,
  full_name: 'Edwina Ebsworth',
  post: 'Human Resources Assistant',
  email: 'eebsworth2m@sbwire.com',
  city: 'Puzi',
  start_date: '09/27/2018',
  salary: 19586.23,
  age: '27',
  experience: '2 Years',
  status: 1
}, {
  responsive_id: '',
  id: 1,
  full_name: "Korrie O'Crevy",
  post: 'Nuclear Power Engineer',
  email: 'kocrevy0@thetimes.co.uk',
  city: 'Krasnosilka',
  start_date: '09/23/2016',
  salary: 23896.35,
  age: '61',
  experience: '1 Year',
  status: 2
}, {
  responsive_id: '',
  id: 7,
  full_name: 'Eileen Diehn',
  post: 'Environmental Specialist',
  email: 'ediehn6@163.com',
  city: 'Lampuyang',
  start_date: '10/15/2017',
  salary: 18991.67,
  age: '59',
  experience: '9 Years',
  status: 3
}, {
  responsive_id: '',
  id: 11,
  full_name: 'De Falloon',
  post: 'Sales Representative',
  email: 'dfalloona@ifeng.com',
  city: 'Colima',
  start_date: '06/12/2018',
  salary: 19252.12,
  age: '30',
  experience: '0 Year',
  status: 4
}, {
  responsive_id: '',
  id: 3,
  full_name: 'Stella Ganderton',
  post: 'Operator',
  email: 'sganderton2@tuttocitta.it',
  city: 'Golcowa',
  start_date: '03/24/2018',
  salary: 13076.28,
  age: '66',
  experience: '6 Years',
  status: 5
}, {
  responsive_id: '',
  id: 5,
  full_name: 'Harmonia Nisius',
  post: 'Senior Cost Accountant',
  email: 'hnisius4@gnu.org',
  city: 'Lucan',
  start_date: '08/25/2017',
  salary: 10909.52,
  age: '33',
  experience: '3 Years',
  status: 2
}, {
  responsive_id: '',
  id: 6,
  full_name: 'Genevra Honeywood',
  post: 'Geologist',
  email: 'ghoneywood5@narod.ru',
  city: 'Maofan',
  start_date: '06/01/2017',
  salary: 17803.8,
  age: '61',
  experience: '1 Year',
  status: 1
}, {
  responsive_id: '',
  id: 4,
  full_name: 'Dorolice Crossman',
  post: 'Cost Accountant',
  email: 'dcrossman3@google.co.jp',
  city: 'Paquera',
  start_date: '12/03/2017',
  salary: 12336.17,
  age: '22',
  experience: '2 Years',
  status: 2
}];
/* harmony default export */ __webpack_exports__["default"] = (data);

/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/statistics-card/StatisticsCardVertical.vue?vue&type=style&index=0&id=0be71a6e&lang=scss&scoped=true":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/statistics-card/StatisticsCardVertical.vue?vue&type=style&index=0&id=0be71a6e&lang=scss&scoped=true ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ (function(module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js */ "./node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, ".percentage[data-v-0be71a6e] {\n  top: -8px;\n  position: relative;\n}", ""]);
// Exports
/* harmony default export */ __webpack_exports__["default"] = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardCongratulationJohn.vue?vue&type=style&index=0&id=742bbf9a&lang=scss&scoped=true":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardCongratulationJohn.vue?vue&type=style&index=0&id=742bbf9a&lang=scss&scoped=true ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ (function(module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js */ "./node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, ".greeting-card[data-v-742bbf9a] {\n  position: relative;\n}\n.greeting-card .greeting-card-bg[data-v-742bbf9a] {\n  position: absolute;\n  bottom: 0;\n  right: 0;\n}\n.greeting-card .greeting-card-trophy[data-v-742bbf9a] {\n  position: absolute;\n  bottom: 10%;\n  right: 8%;\n}\n.v-application.v-application--is-rtl .greeting-card-bg[data-v-742bbf9a] {\n  right: initial;\n  left: 0;\n  transform: rotateY(180deg);\n}\n.v-application.v-application--is-rtl .greeting-card-trophy[data-v-742bbf9a] {\n  left: 8%;\n  right: initial;\n}", ""]);
// Exports
/* harmony default export */ __webpack_exports__["default"] = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/statistics-card/StatisticsCardVertical.vue?vue&type=style&index=0&id=0be71a6e&lang=scss&scoped=true":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/statistics-card/StatisticsCardVertical.vue?vue&type=style&index=0&id=0be71a6e&lang=scss&scoped=true ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../node_modules/laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_use_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_StatisticsCardVertical_vue_vue_type_style_index_0_id_0be71a6e_lang_scss_scoped_true__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./StatisticsCardVertical.vue?vue&type=style&index=0&id=0be71a6e&lang=scss&scoped=true */ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/statistics-card/StatisticsCardVertical.vue?vue&type=style&index=0&id=0be71a6e&lang=scss&scoped=true");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_use_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_StatisticsCardVertical_vue_vue_type_style_index_0_id_0be71a6e_lang_scss_scoped_true__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ __webpack_exports__["default"] = (_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_use_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_StatisticsCardVertical_vue_vue_type_style_index_0_id_0be71a6e_lang_scss_scoped_true__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardCongratulationJohn.vue?vue&type=style&index=0&id=742bbf9a&lang=scss&scoped=true":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardCongratulationJohn.vue?vue&type=style&index=0&id=742bbf9a&lang=scss&scoped=true ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../node_modules/laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/laravel-mix/node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_use_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardCongratulationJohn_vue_vue_type_style_index_0_id_742bbf9a_lang_scss_scoped_true__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./DashboardCongratulationJohn.vue?vue&type=style&index=0&id=742bbf9a&lang=scss&scoped=true */ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardCongratulationJohn.vue?vue&type=style&index=0&id=742bbf9a&lang=scss&scoped=true");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_laravel_mix_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_use_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardCongratulationJohn_vue_vue_type_style_index_0_id_742bbf9a_lang_scss_scoped_true__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ __webpack_exports__["default"] = (_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_use_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardCongratulationJohn_vue_vue_type_style_index_0_id_742bbf9a_lang_scss_scoped_true__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./resources/js/apps/dashboard/pages/Dashboard.vue":
/*!*********************************************************!*\
  !*** ./resources/js/apps/dashboard/pages/Dashboard.vue ***!
  \*********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Dashboard_vue_vue_type_template_id_6845148f__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Dashboard.vue?vue&type=template&id=6845148f */ "./resources/js/apps/dashboard/pages/Dashboard.vue?vue&type=template&id=6845148f");
/* harmony import */ var _Dashboard_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Dashboard.vue?vue&type=script&lang=js */ "./resources/js/apps/dashboard/pages/Dashboard.vue?vue&type=script&lang=js");
/* harmony import */ var _var_www_html_php_laravel_laravelerp_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_var_www_html_php_laravel_laravelerp_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Dashboard_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Dashboard_vue_vue_type_template_id_6845148f__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/apps/dashboard/pages/Dashboard.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ __webpack_exports__["default"] = (__exports__);

/***/ }),

/***/ "./resources/js/components/statistics-card/StatisticsCardVertical.vue":
/*!****************************************************************************!*\
  !*** ./resources/js/components/statistics-card/StatisticsCardVertical.vue ***!
  \****************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _StatisticsCardVertical_vue_vue_type_template_id_0be71a6e_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./StatisticsCardVertical.vue?vue&type=template&id=0be71a6e&scoped=true */ "./resources/js/components/statistics-card/StatisticsCardVertical.vue?vue&type=template&id=0be71a6e&scoped=true");
/* harmony import */ var _StatisticsCardVertical_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./StatisticsCardVertical.vue?vue&type=script&lang=js */ "./resources/js/components/statistics-card/StatisticsCardVertical.vue?vue&type=script&lang=js");
/* harmony import */ var _StatisticsCardVertical_vue_vue_type_style_index_0_id_0be71a6e_lang_scss_scoped_true__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./StatisticsCardVertical.vue?vue&type=style&index=0&id=0be71a6e&lang=scss&scoped=true */ "./resources/js/components/statistics-card/StatisticsCardVertical.vue?vue&type=style&index=0&id=0be71a6e&lang=scss&scoped=true");
/* harmony import */ var _var_www_html_php_laravel_laravelerp_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;


const __exports__ = /*#__PURE__*/(0,_var_www_html_php_laravel_laravelerp_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__["default"])(_StatisticsCardVertical_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_StatisticsCardVertical_vue_vue_type_template_id_0be71a6e_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render],['__scopeId',"data-v-0be71a6e"],['__file',"resources/js/components/statistics-card/StatisticsCardVertical.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ __webpack_exports__["default"] = (__exports__);

/***/ }),

/***/ "./resources/js/views/dashboard/DashboardCardDepositAndWithdraw.vue":
/*!**************************************************************************!*\
  !*** ./resources/js/views/dashboard/DashboardCardDepositAndWithdraw.vue ***!
  \**************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _DashboardCardDepositAndWithdraw_vue_vue_type_template_id_70ae0bdd__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./DashboardCardDepositAndWithdraw.vue?vue&type=template&id=70ae0bdd */ "./resources/js/views/dashboard/DashboardCardDepositAndWithdraw.vue?vue&type=template&id=70ae0bdd");
/* harmony import */ var _DashboardCardDepositAndWithdraw_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./DashboardCardDepositAndWithdraw.vue?vue&type=script&lang=js */ "./resources/js/views/dashboard/DashboardCardDepositAndWithdraw.vue?vue&type=script&lang=js");
/* harmony import */ var _var_www_html_php_laravel_laravelerp_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_var_www_html_php_laravel_laravelerp_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_DashboardCardDepositAndWithdraw_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_DashboardCardDepositAndWithdraw_vue_vue_type_template_id_70ae0bdd__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/views/dashboard/DashboardCardDepositAndWithdraw.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ __webpack_exports__["default"] = (__exports__);

/***/ }),

/***/ "./resources/js/views/dashboard/DashboardCardSalesByCountries.vue":
/*!************************************************************************!*\
  !*** ./resources/js/views/dashboard/DashboardCardSalesByCountries.vue ***!
  \************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _DashboardCardSalesByCountries_vue_vue_type_template_id_c270af6a__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./DashboardCardSalesByCountries.vue?vue&type=template&id=c270af6a */ "./resources/js/views/dashboard/DashboardCardSalesByCountries.vue?vue&type=template&id=c270af6a");
/* harmony import */ var _DashboardCardSalesByCountries_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./DashboardCardSalesByCountries.vue?vue&type=script&lang=js */ "./resources/js/views/dashboard/DashboardCardSalesByCountries.vue?vue&type=script&lang=js");
/* harmony import */ var _var_www_html_php_laravel_laravelerp_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_var_www_html_php_laravel_laravelerp_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_DashboardCardSalesByCountries_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_DashboardCardSalesByCountries_vue_vue_type_template_id_c270af6a__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/views/dashboard/DashboardCardSalesByCountries.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ __webpack_exports__["default"] = (__exports__);

/***/ }),

/***/ "./resources/js/views/dashboard/DashboardCardTotalEarning.vue":
/*!********************************************************************!*\
  !*** ./resources/js/views/dashboard/DashboardCardTotalEarning.vue ***!
  \********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _DashboardCardTotalEarning_vue_vue_type_template_id_15902480__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./DashboardCardTotalEarning.vue?vue&type=template&id=15902480 */ "./resources/js/views/dashboard/DashboardCardTotalEarning.vue?vue&type=template&id=15902480");
/* harmony import */ var _DashboardCardTotalEarning_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./DashboardCardTotalEarning.vue?vue&type=script&lang=js */ "./resources/js/views/dashboard/DashboardCardTotalEarning.vue?vue&type=script&lang=js");
/* harmony import */ var _var_www_html_php_laravel_laravelerp_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_var_www_html_php_laravel_laravelerp_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_DashboardCardTotalEarning_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_DashboardCardTotalEarning_vue_vue_type_template_id_15902480__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/views/dashboard/DashboardCardTotalEarning.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ __webpack_exports__["default"] = (__exports__);

/***/ }),

/***/ "./resources/js/views/dashboard/DashboardCongratulationJohn.vue":
/*!**********************************************************************!*\
  !*** ./resources/js/views/dashboard/DashboardCongratulationJohn.vue ***!
  \**********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _DashboardCongratulationJohn_vue_vue_type_template_id_742bbf9a_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./DashboardCongratulationJohn.vue?vue&type=template&id=742bbf9a&scoped=true */ "./resources/js/views/dashboard/DashboardCongratulationJohn.vue?vue&type=template&id=742bbf9a&scoped=true");
/* harmony import */ var _DashboardCongratulationJohn_vue_vue_type_style_index_0_id_742bbf9a_lang_scss_scoped_true__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./DashboardCongratulationJohn.vue?vue&type=style&index=0&id=742bbf9a&lang=scss&scoped=true */ "./resources/js/views/dashboard/DashboardCongratulationJohn.vue?vue&type=style&index=0&id=742bbf9a&lang=scss&scoped=true");
/* harmony import */ var _var_www_html_php_laravel_laravelerp_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");

const script = {}

;


const __exports__ = /*#__PURE__*/(0,_var_www_html_php_laravel_laravelerp_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(script, [['render',_DashboardCongratulationJohn_vue_vue_type_template_id_742bbf9a_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render],['__scopeId',"data-v-742bbf9a"],['__file',"resources/js/views/dashboard/DashboardCongratulationJohn.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ __webpack_exports__["default"] = (__exports__);

/***/ }),

/***/ "./resources/js/views/dashboard/DashboardDatatable.vue":
/*!*************************************************************!*\
  !*** ./resources/js/views/dashboard/DashboardDatatable.vue ***!
  \*************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _DashboardDatatable_vue_vue_type_template_id_215602ac__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./DashboardDatatable.vue?vue&type=template&id=215602ac */ "./resources/js/views/dashboard/DashboardDatatable.vue?vue&type=template&id=215602ac");
/* harmony import */ var _DashboardDatatable_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./DashboardDatatable.vue?vue&type=script&lang=js */ "./resources/js/views/dashboard/DashboardDatatable.vue?vue&type=script&lang=js");
/* harmony import */ var _var_www_html_php_laravel_laravelerp_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_var_www_html_php_laravel_laravelerp_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_DashboardDatatable_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_DashboardDatatable_vue_vue_type_template_id_215602ac__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/views/dashboard/DashboardDatatable.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ __webpack_exports__["default"] = (__exports__);

/***/ }),

/***/ "./resources/js/views/dashboard/DashboardStatisticsCard.vue":
/*!******************************************************************!*\
  !*** ./resources/js/views/dashboard/DashboardStatisticsCard.vue ***!
  \******************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _DashboardStatisticsCard_vue_vue_type_template_id_91cb2606__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./DashboardStatisticsCard.vue?vue&type=template&id=91cb2606 */ "./resources/js/views/dashboard/DashboardStatisticsCard.vue?vue&type=template&id=91cb2606");
/* harmony import */ var _DashboardStatisticsCard_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./DashboardStatisticsCard.vue?vue&type=script&lang=js */ "./resources/js/views/dashboard/DashboardStatisticsCard.vue?vue&type=script&lang=js");
/* harmony import */ var _var_www_html_php_laravel_laravelerp_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_var_www_html_php_laravel_laravelerp_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_DashboardStatisticsCard_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_DashboardStatisticsCard_vue_vue_type_template_id_91cb2606__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/views/dashboard/DashboardStatisticsCard.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ __webpack_exports__["default"] = (__exports__);

/***/ }),

/***/ "./resources/js/views/dashboard/DashboardWeeklyOverview.vue":
/*!******************************************************************!*\
  !*** ./resources/js/views/dashboard/DashboardWeeklyOverview.vue ***!
  \******************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _DashboardWeeklyOverview_vue_vue_type_template_id_96594878__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./DashboardWeeklyOverview.vue?vue&type=template&id=96594878 */ "./resources/js/views/dashboard/DashboardWeeklyOverview.vue?vue&type=template&id=96594878");
/* harmony import */ var _DashboardWeeklyOverview_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./DashboardWeeklyOverview.vue?vue&type=script&lang=js */ "./resources/js/views/dashboard/DashboardWeeklyOverview.vue?vue&type=script&lang=js");
/* harmony import */ var _var_www_html_php_laravel_laravelerp_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_var_www_html_php_laravel_laravelerp_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_DashboardWeeklyOverview_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_DashboardWeeklyOverview_vue_vue_type_template_id_96594878__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/views/dashboard/DashboardWeeklyOverview.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ __webpack_exports__["default"] = (__exports__);

/***/ }),

/***/ "./resources/js/apps/dashboard/pages/Dashboard.vue?vue&type=script&lang=js":
/*!*********************************************************************************!*\
  !*** ./resources/js/apps/dashboard/pages/Dashboard.vue?vue&type=script&lang=js ***!
  \*********************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Dashboard_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Dashboard_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Dashboard.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/apps/dashboard/pages/Dashboard.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/statistics-card/StatisticsCardVertical.vue?vue&type=script&lang=js":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/statistics-card/StatisticsCardVertical.vue?vue&type=script&lang=js ***!
  \****************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_StatisticsCardVertical_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_StatisticsCardVertical_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./StatisticsCardVertical.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/statistics-card/StatisticsCardVertical.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/views/dashboard/DashboardCardDepositAndWithdraw.vue?vue&type=script&lang=js":
/*!**************************************************************************************************!*\
  !*** ./resources/js/views/dashboard/DashboardCardDepositAndWithdraw.vue?vue&type=script&lang=js ***!
  \**************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardCardDepositAndWithdraw_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardCardDepositAndWithdraw_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./DashboardCardDepositAndWithdraw.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardCardDepositAndWithdraw.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/views/dashboard/DashboardCardSalesByCountries.vue?vue&type=script&lang=js":
/*!************************************************************************************************!*\
  !*** ./resources/js/views/dashboard/DashboardCardSalesByCountries.vue?vue&type=script&lang=js ***!
  \************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardCardSalesByCountries_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardCardSalesByCountries_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./DashboardCardSalesByCountries.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardCardSalesByCountries.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/views/dashboard/DashboardCardTotalEarning.vue?vue&type=script&lang=js":
/*!********************************************************************************************!*\
  !*** ./resources/js/views/dashboard/DashboardCardTotalEarning.vue?vue&type=script&lang=js ***!
  \********************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardCardTotalEarning_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardCardTotalEarning_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./DashboardCardTotalEarning.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardCardTotalEarning.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/views/dashboard/DashboardDatatable.vue?vue&type=script&lang=js":
/*!*************************************************************************************!*\
  !*** ./resources/js/views/dashboard/DashboardDatatable.vue?vue&type=script&lang=js ***!
  \*************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardDatatable_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardDatatable_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./DashboardDatatable.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardDatatable.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/views/dashboard/DashboardStatisticsCard.vue?vue&type=script&lang=js":
/*!******************************************************************************************!*\
  !*** ./resources/js/views/dashboard/DashboardStatisticsCard.vue?vue&type=script&lang=js ***!
  \******************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardStatisticsCard_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardStatisticsCard_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./DashboardStatisticsCard.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardStatisticsCard.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/views/dashboard/DashboardWeeklyOverview.vue?vue&type=script&lang=js":
/*!******************************************************************************************!*\
  !*** ./resources/js/views/dashboard/DashboardWeeklyOverview.vue?vue&type=script&lang=js ***!
  \******************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardWeeklyOverview_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardWeeklyOverview_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./DashboardWeeklyOverview.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardWeeklyOverview.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/apps/dashboard/pages/Dashboard.vue?vue&type=template&id=6845148f":
/*!***************************************************************************************!*\
  !*** ./resources/js/apps/dashboard/pages/Dashboard.vue?vue&type=template&id=6845148f ***!
  \***************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Dashboard_vue_vue_type_template_id_6845148f__WEBPACK_IMPORTED_MODULE_0__.render; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Dashboard_vue_vue_type_template_id_6845148f__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Dashboard.vue?vue&type=template&id=6845148f */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/apps/dashboard/pages/Dashboard.vue?vue&type=template&id=6845148f");


/***/ }),

/***/ "./resources/js/components/statistics-card/StatisticsCardVertical.vue?vue&type=template&id=0be71a6e&scoped=true":
/*!**********************************************************************************************************************!*\
  !*** ./resources/js/components/statistics-card/StatisticsCardVertical.vue?vue&type=template&id=0be71a6e&scoped=true ***!
  \**********************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_StatisticsCardVertical_vue_vue_type_template_id_0be71a6e_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_StatisticsCardVertical_vue_vue_type_template_id_0be71a6e_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./StatisticsCardVertical.vue?vue&type=template&id=0be71a6e&scoped=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/statistics-card/StatisticsCardVertical.vue?vue&type=template&id=0be71a6e&scoped=true");


/***/ }),

/***/ "./resources/js/views/dashboard/DashboardCardDepositAndWithdraw.vue?vue&type=template&id=70ae0bdd":
/*!********************************************************************************************************!*\
  !*** ./resources/js/views/dashboard/DashboardCardDepositAndWithdraw.vue?vue&type=template&id=70ae0bdd ***!
  \********************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardCardDepositAndWithdraw_vue_vue_type_template_id_70ae0bdd__WEBPACK_IMPORTED_MODULE_0__.render; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardCardDepositAndWithdraw_vue_vue_type_template_id_70ae0bdd__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./DashboardCardDepositAndWithdraw.vue?vue&type=template&id=70ae0bdd */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardCardDepositAndWithdraw.vue?vue&type=template&id=70ae0bdd");


/***/ }),

/***/ "./resources/js/views/dashboard/DashboardCardSalesByCountries.vue?vue&type=template&id=c270af6a":
/*!******************************************************************************************************!*\
  !*** ./resources/js/views/dashboard/DashboardCardSalesByCountries.vue?vue&type=template&id=c270af6a ***!
  \******************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardCardSalesByCountries_vue_vue_type_template_id_c270af6a__WEBPACK_IMPORTED_MODULE_0__.render; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardCardSalesByCountries_vue_vue_type_template_id_c270af6a__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./DashboardCardSalesByCountries.vue?vue&type=template&id=c270af6a */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardCardSalesByCountries.vue?vue&type=template&id=c270af6a");


/***/ }),

/***/ "./resources/js/views/dashboard/DashboardCardTotalEarning.vue?vue&type=template&id=15902480":
/*!**************************************************************************************************!*\
  !*** ./resources/js/views/dashboard/DashboardCardTotalEarning.vue?vue&type=template&id=15902480 ***!
  \**************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardCardTotalEarning_vue_vue_type_template_id_15902480__WEBPACK_IMPORTED_MODULE_0__.render; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardCardTotalEarning_vue_vue_type_template_id_15902480__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./DashboardCardTotalEarning.vue?vue&type=template&id=15902480 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardCardTotalEarning.vue?vue&type=template&id=15902480");


/***/ }),

/***/ "./resources/js/views/dashboard/DashboardCongratulationJohn.vue?vue&type=template&id=742bbf9a&scoped=true":
/*!****************************************************************************************************************!*\
  !*** ./resources/js/views/dashboard/DashboardCongratulationJohn.vue?vue&type=template&id=742bbf9a&scoped=true ***!
  \****************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardCongratulationJohn_vue_vue_type_template_id_742bbf9a_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardCongratulationJohn_vue_vue_type_template_id_742bbf9a_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./DashboardCongratulationJohn.vue?vue&type=template&id=742bbf9a&scoped=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardCongratulationJohn.vue?vue&type=template&id=742bbf9a&scoped=true");


/***/ }),

/***/ "./resources/js/views/dashboard/DashboardDatatable.vue?vue&type=template&id=215602ac":
/*!*******************************************************************************************!*\
  !*** ./resources/js/views/dashboard/DashboardDatatable.vue?vue&type=template&id=215602ac ***!
  \*******************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardDatatable_vue_vue_type_template_id_215602ac__WEBPACK_IMPORTED_MODULE_0__.render; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardDatatable_vue_vue_type_template_id_215602ac__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./DashboardDatatable.vue?vue&type=template&id=215602ac */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardDatatable.vue?vue&type=template&id=215602ac");


/***/ }),

/***/ "./resources/js/views/dashboard/DashboardStatisticsCard.vue?vue&type=template&id=91cb2606":
/*!************************************************************************************************!*\
  !*** ./resources/js/views/dashboard/DashboardStatisticsCard.vue?vue&type=template&id=91cb2606 ***!
  \************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardStatisticsCard_vue_vue_type_template_id_91cb2606__WEBPACK_IMPORTED_MODULE_0__.render; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardStatisticsCard_vue_vue_type_template_id_91cb2606__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./DashboardStatisticsCard.vue?vue&type=template&id=91cb2606 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardStatisticsCard.vue?vue&type=template&id=91cb2606");


/***/ }),

/***/ "./resources/js/views/dashboard/DashboardWeeklyOverview.vue?vue&type=template&id=96594878":
/*!************************************************************************************************!*\
  !*** ./resources/js/views/dashboard/DashboardWeeklyOverview.vue?vue&type=template&id=96594878 ***!
  \************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": function() { return /* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardWeeklyOverview_vue_vue_type_template_id_96594878__WEBPACK_IMPORTED_MODULE_0__.render; }
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardWeeklyOverview_vue_vue_type_template_id_96594878__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./DashboardWeeklyOverview.vue?vue&type=template&id=96594878 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardWeeklyOverview.vue?vue&type=template&id=96594878");


/***/ }),

/***/ "./resources/js/components/statistics-card/StatisticsCardVertical.vue?vue&type=style&index=0&id=0be71a6e&lang=scss&scoped=true":
/*!*************************************************************************************************************************************!*\
  !*** ./resources/js/components/statistics-card/StatisticsCardVertical.vue?vue&type=style&index=0&id=0be71a6e&lang=scss&scoped=true ***!
  \*************************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_style_loader_dist_cjs_js_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_use_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_StatisticsCardVertical_vue_vue_type_style_index_0_id_0be71a6e_lang_scss_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./StatisticsCardVertical.vue?vue&type=style&index=0&id=0be71a6e&lang=scss&scoped=true */ "./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/statistics-card/StatisticsCardVertical.vue?vue&type=style&index=0&id=0be71a6e&lang=scss&scoped=true");


/***/ }),

/***/ "./resources/js/views/dashboard/DashboardCongratulationJohn.vue?vue&type=style&index=0&id=742bbf9a&lang=scss&scoped=true":
/*!*******************************************************************************************************************************!*\
  !*** ./resources/js/views/dashboard/DashboardCongratulationJohn.vue?vue&type=style&index=0&id=742bbf9a&lang=scss&scoped=true ***!
  \*******************************************************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_style_loader_dist_cjs_js_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_use_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DashboardCongratulationJohn_vue_vue_type_style_index_0_id_742bbf9a_lang_scss_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./DashboardCongratulationJohn.vue?vue&type=style&index=0&id=742bbf9a&lang=scss&scoped=true */ "./node_modules/laravel-mix/node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/dashboard/DashboardCongratulationJohn.vue?vue&type=style&index=0&id=742bbf9a&lang=scss&scoped=true");


/***/ })

}]);