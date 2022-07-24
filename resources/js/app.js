import {
    createApp
} from 'vue';
import router from '@/components/router';
import vuetify from './plugins/vuetify';
import {
    loadFonts
} from './plugins/webfontloader';

import {
    createStore
} from 'vuex';
import moment from 'moment';

import Cookies from "js-cookie";
import createPersistedState from "vuex-persistedstate";
import NProgress from 'nprogress';

import Axios from 'axios';
import VueSweetalert2 from 'vue-sweetalert2';
import {
    plugin,
    defaultConfig,
} from '@formkit/vue';

import '@popperjs/core';
//import "bootstrap/dist/js/bootstrap.js";
import 'bootstrap/dist/js/bootstrap.bundle.js';
import { Modal } from 'bootstrap/dist/js/bootstrap.bundle.js';

import 'bootstrap/dist/css/bootstrap.css';
import "nprogress/nprogress.css";
import 'sweetalert2/dist/sweetalert2.min.css';

import filters from "@/utils/filters";

window.$Modal = Modal;

window.$filters = window.$func = window.$helper = filters;

import autorouter from "@/components/router/autorouter";
import Calendar from "@/components/common/Calendar";

import App from '@/components/App';
import "../css/app.css";


import config from "@/formkit/config";

const app = createApp(App)
    .use(vuetify)
    .use(VueSweetalert2)
    .use(plugin, defaultConfig(config));

loadFonts();

let base_url = window.base_url + '/api';
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxx  App Initializer xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

app.config.globalProperties.$base_url = base_url;
app.config.globalProperties.$male_default_avatar = 'images/avatar.png';
app.config.globalProperties.$female_default_avatar = 'images/avatar2.png';

app.config.globalProperties.$appName = window.appName = 'My App';

app.config.globalProperties.$is_frontend = window.is_frontend = false;
app.config.globalProperties.$is_stockist = window.is_stockist = false;
app.config.globalProperties.$is_backend = window.is_backend = true;

app.config.globalProperties.$in_progress = window.in_progress = true;
app.config.globalProperties.$loading = window.loading = {
    in_progress: true
};
app.config.globalProperties.$moment = window.$moment = moment;

app.config.devtools = true;
app.config.globalProperties.$mybizna_var = {

    "user_id": "1",
    "site_url": window.base_url,
    "logout_url": window.base_url,
    "assets": window.base_url,
    "mybizna_assets": window.base_url,
    "menus": {

    },
    "url": window.base_url,
    "tut_url": window.base_url,
    "admin_url": window.base_url,
    "decimal_separator": ".",
    "thousand_separator": ",",
    "currency_format": "%s%v",
    "symbol": "$",
    "debug_mode": "0",
    "current_date": "2022-04-30",
    "fy_lower_range": "2022-01-01",
    "fy_upper_range": "2022-12-31",
    "ledgers": [{
            "id": "2",
            "chart_id": "1",
            "category_id": null,
            "name": "Inventory",
            "slug": "inventory",
            "code": "140",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "3",
            "chart_id": "1",
            "category_id": null,
            "name": "Office Equipment",
            "slug": "office_equipment",
            "code": "150",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "4",
            "chart_id": "1",
            "category_id": null,
            "name": "Less Accumulated Depreciation on Office Equipment",
            "slug": "less_accumulated_depreciation_on_office_equipment",
            "code": "151",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "5",
            "chart_id": "1",
            "category_id": null,
            "name": "Computer Equipment",
            "slug": "computer_equipment",
            "code": "160",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "6",
            "chart_id": "1",
            "category_id": null,
            "name": "Less Accumulated Depreciation on Computer Equipment",
            "slug": "less_accumulated_depreciation_on_computer_equipment",
            "code": "161",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "7",
            "chart_id": "1",
            "category_id": null,
            "name": "Cash",
            "slug": "cash",
            "code": "90",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "9",
            "chart_id": "2",
            "category_id": null,
            "name": "Accruals",
            "slug": "accruals",
            "code": "205",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "10",
            "chart_id": "2",
            "category_id": null,
            "name": "Unpaid Expense Claims",
            "slug": "unpaid_expense_claims",
            "code": "210",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "11",
            "chart_id": "2",
            "category_id": null,
            "name": "Wages Payable",
            "slug": "wages_payable",
            "code": "215",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "12",
            "chart_id": "2",
            "category_id": null,
            "name": "Wages Payable - Payroll",
            "slug": "wages_payable_payroll",
            "code": "216",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "13",
            "chart_id": "2",
            "category_id": null,
            "name": "Sales Tax",
            "slug": "sales_tax",
            "code": "220",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "14",
            "chart_id": "2",
            "category_id": null,
            "name": "Employee Tax Payable",
            "slug": "employee_tax_payable",
            "code": "230",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "15",
            "chart_id": "2",
            "category_id": null,
            "name": "Employee Benefits Payable",
            "slug": "employee_benefits_payable",
            "code": "235",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "16",
            "chart_id": "2",
            "category_id": null,
            "name": "Employee Deductions payable",
            "slug": "employee_deductions_payable",
            "code": "236",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "17",
            "chart_id": "2",
            "category_id": null,
            "name": "Income Tax Payable",
            "slug": "income_tax_payable",
            "code": "240",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "18",
            "chart_id": "2",
            "category_id": null,
            "name": "Suspense",
            "slug": "suspense",
            "code": "250",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "19",
            "chart_id": "2",
            "category_id": null,
            "name": "Historical Adjustments",
            "slug": "historical_adjustments",
            "code": "255",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "20",
            "chart_id": "2",
            "category_id": null,
            "name": "Rounding",
            "slug": "rounding",
            "code": "260",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "21",
            "chart_id": "2",
            "category_id": null,
            "name": "Revenue Received in Advance",
            "slug": "revenue_received_in_advance",
            "code": "835",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "22",
            "chart_id": "2",
            "category_id": null,
            "name": "Clearing Account",
            "slug": "clearing_account",
            "code": "855",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "23",
            "chart_id": "2",
            "category_id": null,
            "name": "Loan",
            "slug": "loan",
            "code": "290",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "24",
            "chart_id": "5",
            "category_id": null,
            "name": "Costs of Goods Sold",
            "slug": "costs_of_goods_sold",
            "code": "500",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "25",
            "chart_id": "5",
            "category_id": null,
            "name": "Advertising",
            "slug": "advertising",
            "code": "600",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "26",
            "chart_id": "5",
            "category_id": null,
            "name": "Bank Service Charges",
            "slug": "bank_service_charges",
            "code": "605",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "27",
            "chart_id": "5",
            "category_id": null,
            "name": "Bank Transaction Charge",
            "slug": "bank_transaction_charge",
            "code": "606",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "28",
            "chart_id": "5",
            "category_id": null,
            "name": "Sales Return",
            "slug": "sales_return",
            "code": "607",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "29",
            "chart_id": "5",
            "category_id": null,
            "name": "Janitorial Expenses",
            "slug": "janitorial_expenses",
            "code": "610",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "30",
            "chart_id": "5",
            "category_id": null,
            "name": "Consulting & Accounting",
            "slug": "consulting_accounting",
            "code": "615",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "31",
            "chart_id": "5",
            "category_id": null,
            "name": "Entertainment",
            "slug": "entertainment",
            "code": "620",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "32",
            "chart_id": "5",
            "category_id": null,
            "name": "Postage & Delivary",
            "slug": "postage_delivary",
            "code": "624",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "33",
            "chart_id": "5",
            "category_id": null,
            "name": "General Expenses",
            "slug": "general_expenses",
            "code": "628",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "34",
            "chart_id": "5",
            "category_id": null,
            "name": "Insurance",
            "slug": "insurance",
            "code": "632",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "35",
            "chart_id": "5",
            "category_id": null,
            "name": "Legal Expenses",
            "slug": "legal_expenses",
            "code": "636",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "36",
            "chart_id": "5",
            "category_id": null,
            "name": "Utilities",
            "slug": "utilities",
            "code": "640",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "37",
            "chart_id": "5",
            "category_id": null,
            "name": "Automobile Expenses",
            "slug": "automobile_expenses",
            "code": "644",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "38",
            "chart_id": "5",
            "category_id": null,
            "name": "Office Expenses",
            "slug": "office_expenses",
            "code": "648",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "39",
            "chart_id": "5",
            "category_id": null,
            "name": "Printing & Stationary",
            "slug": "printing_stationary",
            "code": "652",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "40",
            "chart_id": "5",
            "category_id": null,
            "name": "Rent",
            "slug": "rent",
            "code": "656",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "41",
            "chart_id": "5",
            "category_id": null,
            "name": "Repairs & Maintenance",
            "slug": "repairs_maintenance",
            "code": "660",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "42",
            "chart_id": "5",
            "category_id": null,
            "name": "Wages & Salaries",
            "slug": "wages_salaries",
            "code": "664",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "43",
            "chart_id": "5",
            "category_id": null,
            "name": "Payroll Tax Expense",
            "slug": "payroll_tax_expense",
            "code": "668",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "44",
            "chart_id": "5",
            "category_id": null,
            "name": "Dues & Subscriptions",
            "slug": "dues_subscriptions",
            "code": "672",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "45",
            "chart_id": "5",
            "category_id": null,
            "name": "Telephone & Internet",
            "slug": "telephone_internet",
            "code": "676",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "46",
            "chart_id": "5",
            "category_id": null,
            "name": "Travel",
            "slug": "travel",
            "code": "680",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "47",
            "chart_id": "5",
            "category_id": null,
            "name": "Bad Debts",
            "slug": "bad_debts",
            "code": "684",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "48",
            "chart_id": "5",
            "category_id": null,
            "name": "Depreciation",
            "slug": "depreciation",
            "code": "700",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "49",
            "chart_id": "5",
            "category_id": null,
            "name": "Income Tax Expense",
            "slug": "income_tax_expense",
            "code": "710",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "50",
            "chart_id": "5",
            "category_id": null,
            "name": "Employee Benefits Expense",
            "slug": "employee_benefits_expense",
            "code": "715",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "51",
            "chart_id": "5",
            "category_id": null,
            "name": "Interest Expense",
            "slug": "interest_expense",
            "code": "800",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "52",
            "chart_id": "5",
            "category_id": null,
            "name": "Bank Revaluations",
            "slug": "bank_revaluations",
            "code": "810",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "53",
            "chart_id": "5",
            "category_id": null,
            "name": "Unrealized Currency Gains",
            "slug": "unrealized_currency_gains",
            "code": "815",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "54",
            "chart_id": "5",
            "category_id": null,
            "name": "Realized Currency Gains",
            "slug": "realized_currency_gains",
            "code": "820",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "55",
            "chart_id": "5",
            "category_id": null,
            "name": "Sales Discount",
            "slug": "sales_discount",
            "code": "825",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "56",
            "chart_id": "4",
            "category_id": null,
            "name": "Sales",
            "slug": "sales",
            "code": "400",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "57",
            "chart_id": "4",
            "category_id": null,
            "name": "Interest Income",
            "slug": "interest_income",
            "code": "460",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "58",
            "chart_id": "4",
            "category_id": null,
            "name": "Other Revenue",
            "slug": "other_revenue",
            "code": "470",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "59",
            "chart_id": "4",
            "category_id": null,
            "name": "Purchase Discount",
            "slug": "purchase_discount",
            "code": "475",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "60",
            "chart_id": "3",
            "category_id": null,
            "name": "Owners Contribution",
            "slug": "owners_contribution",
            "code": "300",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "61",
            "chart_id": "3",
            "category_id": null,
            "name": "Owners Draw",
            "slug": "owners_draw",
            "code": "310",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "62",
            "chart_id": "3",
            "category_id": null,
            "name": "Retained Earnings",
            "slug": "retained_earnings",
            "code": "320",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "63",
            "chart_id": "3",
            "category_id": null,
            "name": "Common Stock",
            "slug": "common_stock",
            "code": "330",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "64",
            "chart_id": "1",
            "category_id": null,
            "name": "Savings Account",
            "slug": "savings_account",
            "code": "92",
            "system": "0",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "65",
            "chart_id": "2",
            "category_id": null,
            "name": "Shipment Tax",
            "slug": "shipment_tax",
            "code": "221",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "66",
            "chart_id": "1",
            "category_id": null,
            "name": "Allowance for Doubtful Accounts",
            "slug": "allowance_for_doubtful_accounts",
            "code": "1001",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "67",
            "chart_id": "1",
            "category_id": null,
            "name": "Interest Receivable",
            "slug": "interest_receivable",
            "code": "1002",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "68",
            "chart_id": "1",
            "category_id": null,
            "name": "Supplies",
            "slug": "supplies",
            "code": "1003",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "69",
            "chart_id": "1",
            "category_id": null,
            "name": "Prepaid Insurance",
            "slug": "prepaid_insurance",
            "code": "1004",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "70",
            "chart_id": "1",
            "category_id": null,
            "name": "Prepaid Rent",
            "slug": "prepaid_rent",
            "code": "1005",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "71",
            "chart_id": "1",
            "category_id": null,
            "name": "Prepaid Salary",
            "slug": "prepaid_salary",
            "code": "1006",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "72",
            "chart_id": "1",
            "category_id": null,
            "name": "Land",
            "slug": "land",
            "code": "1007",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "73",
            "chart_id": "1",
            "category_id": null,
            "name": "Furniture & Fixture",
            "slug": "furniture_fixture",
            "code": "1008",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "74",
            "chart_id": "1",
            "category_id": null,
            "name": "Buildings",
            "slug": "buildings",
            "code": "1009",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "75",
            "chart_id": "1",
            "category_id": null,
            "name": "Copyrights",
            "slug": "copyrights",
            "code": "1010",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "76",
            "chart_id": "1",
            "category_id": null,
            "name": "Goodwill",
            "slug": "goodwill",
            "code": "1011",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "77",
            "chart_id": "1",
            "category_id": null,
            "name": "Patents",
            "slug": "patents",
            "code": "1012",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "78",
            "chart_id": "1",
            "category_id": null,
            "name": "Accoumulated Depreciation- Buildings",
            "slug": "accoumulated_depreciation_buildings",
            "code": "1013",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "79",
            "chart_id": "1",
            "category_id": null,
            "name": "Accoumulated Depreciation- Furniture & Fixtures",
            "slug": "accoumulated_depreciation_furniture_fixtures",
            "code": "1014",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "80",
            "chart_id": "2",
            "category_id": null,
            "name": "Notes Payable",
            "slug": "notes_payable",
            "code": "1201",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "81",
            "chart_id": "2",
            "category_id": null,
            "name": "Salaries and Wages Payable",
            "slug": "salaries_and_wages_payable",
            "code": "1202",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "82",
            "chart_id": "2",
            "category_id": null,
            "name": "Unearned Rent Revenue",
            "slug": "unearned_rent_revenue",
            "code": "1203",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "83",
            "chart_id": "2",
            "category_id": null,
            "name": "Interest Payable",
            "slug": "interest_payable",
            "code": "1204",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "84",
            "chart_id": "2",
            "category_id": null,
            "name": "Dividends Payable",
            "slug": "dividends_payable",
            "code": "1205",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "85",
            "chart_id": "2",
            "category_id": null,
            "name": "Bonds Payable",
            "slug": "bonds_payable",
            "code": "1206",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "86",
            "chart_id": "2",
            "category_id": null,
            "name": "Discount on Bonds Payable",
            "slug": "discount_on_bonds_payable",
            "code": "1207",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "87",
            "chart_id": "2",
            "category_id": null,
            "name": "Premium on Bonds Payable",
            "slug": "premium_on_bonds_payable",
            "code": "1208",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "88",
            "chart_id": "2",
            "category_id": null,
            "name": "Mortgage Payable",
            "slug": "mortgage_payable",
            "code": "1209",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "89",
            "chart_id": "3",
            "category_id": null,
            "name": "Owner's Equity",
            "slug": "owner_s_equity",
            "code": "1301",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "90",
            "chart_id": "3",
            "category_id": null,
            "name": "Paid-in Capital in Excess of Par- Common Stock",
            "slug": "paid_in_capital_in_excess_of_par_common_stock",
            "code": "1302",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "91",
            "chart_id": "3",
            "category_id": null,
            "name": "Paid-in Capital in Excess of Par- Preferred Stock",
            "slug": "paid_in_capital_in_excess_of_par_preferred_stock",
            "code": "1303",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "92",
            "chart_id": "3",
            "category_id": null,
            "name": "Preferred Stock",
            "slug": "preferred_stock",
            "code": "1304",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "93",
            "chart_id": "3",
            "category_id": null,
            "name": "Treasury Stock",
            "slug": "treasury_stock",
            "code": "1305",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "94",
            "chart_id": "3",
            "category_id": null,
            "name": "Dividends",
            "slug": "dividends",
            "code": "1306",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "95",
            "chart_id": "3",
            "category_id": null,
            "name": "Income Summary",
            "slug": "income_summary",
            "code": "1307",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "96",
            "chart_id": "4",
            "category_id": null,
            "name": "Service Revenue",
            "slug": "service_revenue",
            "code": "1401",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "97",
            "chart_id": "4",
            "category_id": null,
            "name": "Sales Revenue",
            "slug": "sales_revenue",
            "code": "1402",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "98",
            "chart_id": "4",
            "category_id": null,
            "name": "Shipment",
            "slug": "shipment",
            "code": "1411",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "99",
            "chart_id": "4",
            "category_id": null,
            "name": "Gain on Disposal of Plant Assets",
            "slug": "gain_on_disposal_of_plant_assets",
            "code": "1404",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "100",
            "chart_id": "4",
            "category_id": null,
            "name": "Asset Sales",
            "slug": "asset_sales",
            "code": "1405",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "101",
            "chart_id": "4",
            "category_id": null,
            "name": "Sales Return Discount",
            "slug": "sales_return_discount",
            "code": "1406",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "102",
            "chart_id": "4",
            "category_id": null,
            "name": "Sales Return Tax",
            "slug": "sales_return_tax",
            "code": "1407",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "103",
            "chart_id": "4",
            "category_id": null,
            "name": "Purchase Return",
            "slug": "purchase_return",
            "code": "1408",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "104",
            "chart_id": "4",
            "category_id": null,
            "name": "Purchase Return VAT",
            "slug": "purchase_return_vat",
            "code": "1409",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "105",
            "chart_id": "5",
            "category_id": null,
            "name": "Amortization Expense",
            "slug": "amortization_expense",
            "code": "1501",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "106",
            "chart_id": "5",
            "category_id": null,
            "name": "Freight-Out",
            "slug": "freight_out",
            "code": "1502",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "107",
            "chart_id": "5",
            "category_id": null,
            "name": "Insurance Expense",
            "slug": "insurance_expense",
            "code": "1503",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "108",
            "chart_id": "5",
            "category_id": null,
            "name": "Loss on Disposal of Plant Assets",
            "slug": "loss_on_disposal_of_plant_assets",
            "code": "1504",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "109",
            "chart_id": "5",
            "category_id": null,
            "name": "Maintenance and Repairs Expense",
            "slug": "maintenance_and_repairs_expense",
            "code": "1505",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "110",
            "chart_id": "5",
            "category_id": null,
            "name": "Purchase",
            "slug": "purchase",
            "code": "1506",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "111",
            "chart_id": "5",
            "category_id": null,
            "name": "Asset Purchase",
            "slug": "asset_purchase",
            "code": "1507",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "112",
            "chart_id": "5",
            "category_id": null,
            "name": "Purchase VAT",
            "slug": "purchase_vat",
            "code": "1509",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "113",
            "chart_id": "5",
            "category_id": null,
            "name": "Sales Returns and Allowance",
            "slug": "sales_returns_and_allowance",
            "code": "1403",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "114",
            "chart_id": "5",
            "category_id": null,
            "name": "Purchase Return Discount",
            "slug": "purchase_return_discount",
            "code": "1410",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        },
        {
            "id": "115",
            "chart_id": "5",
            "category_id": null,
            "name": "Bank Transaction Charge",
            "slug": "bank_transaction_charge",
            "code": "1508",
            "system": "1",
            "trn_count": 0,
            "balance": 0
        }
    ],
    "trn_statuses": [{
            "id": "1",
            "name": "Draft",
            "slug": "draft"
        },
        {
            "id": "2",
            "name": "Awaiting Payment",
            "slug": "awaiting_payment"
        },
        {
            "id": "3",
            "name": "Pending",
            "slug": "pending"
        },
        {
            "id": "4",
            "name": "Paid",
            "slug": "paid"
        },
        {
            "id": "5",
            "name": "Partially Paid",
            "slug": "partially_paid"
        },
        {
            "id": "6",
            "name": "Approved",
            "slug": "approved"
        },
        {
            "id": "7",
            "name": "Closed",
            "slug": "closed"
        },
        {
            "id": "8",
            "name": "Void",
            "slug": "void"
        },
        {
            "id": "9",
            "name": "Returned",
            "slug": "returned"
        },
        {
            "id": "10",
            "name": "Partially Returned",
            "slug": "partially_returned"
        }
    ],
    "pdf_plugin_active": "1",
    "link_copy_success": "Link has been successfully copied.",
    "link_copy_error": "Failed to copy the link.",
    "date_format": "Y-m-d",
    "fields": {
        "contact": {
            "required_fields": [
                "first_name",
                "email"
            ],
            "fields": [
                "first_name",
                "last_name",
                "email",
                "phone",
                "mobile",
                "other",
                "website",
                "fax",
                "notes",
                "street_1",
                "street_2",
                "city",
                "state",
                "postal_code",
                "country",
                "currency"
            ]
        },
        "company": {
            "required_fields": [
                "email",
                "company"
            ],
            "fields": [
                "email",
                "company",
                "phone",
                "mobile",
                "other",
                "website",
                "fax",
                "notes",
                "street_1",
                "street_2",
                "city",
                "state",
                "postal_code",
                "country",
                "currency"
            ]
        },
        "employee": {
            "required_fields": [
                "first_name",
                "last_name",
                "user_email"
            ],
            "fields": [
                "first_name",
                "middle_name",
                "last_name",
                "user_email",
                "designation",
                "department",
                "location",
                "hiring_source",
                "hiring_date",
                "date_of_birth",
                "reporting_to",
                "pay_rate",
                "pay_type",
                "type",
                "status",
                "other_email",
                "phone",
                "work_phone",
                "mobile",
                "address",
                "gender",
                "marital_status",
                "nationality",
                "driving_license",
                "hobbies",
                "user_url",
                "description",
                "street_1",
                "street_2",
                "city",
                "country",
                "state",
                "postal_code"
            ]
        },
        "vendor": {
            "required_fields": [
                "first_name",
                "last_name",
                "email"
            ],
            "fields": [
                "first_name",
                "last_name",
                "email",
                "phone",
                "company",
                "mobile",
                "fax",
                "website",
                "notes",
                "street_1",
                "street_2",
                "city",
                "country",
                "state",
                "postal_code"
            ]
        },
        "customer": {
            "required_fields": [
                "first_name",
                "last_name",
                "email"
            ],
            "fields": [
                "first_name",
                "last_name",
                "email",
                "phone",
                "company",
                "mobile",
                "fax",
                "website",
                "notes",
                "street_1",
                "street_2",
                "city",
                "country",
                "state",
                "postal_code"
            ]
        },
        "product": {
            "required_fields": [
                "name",
                "product_type_id",
                "category_id",
                "sale_price",
                "vendor"
            ],
            "fields": [
                "name",
                "product_type_id",
                "category_id",
                "cost_price",
                "sale_price",
                "vendor",
                "tax_cat_id"
            ]
        }
    },
    "export_import_nonce": "54a7e51079",
    "banner_dimension": {
        "width": 600,
        "height": 600,
        "flex-width": true,
        "flex-height": true
    },
    "rest": {
        "root": window.base_url + "/php/wordpressisp/wp-json/",
        "nonce": "8c27af5d3c",
        "version": "erp/v1"
    }
};

app.config.globalProperties.$loader_template = window.loader_template = '<div class="block-screen"><b>Please wait...</b></div>';

Axios.defaults.baseURL = base_url;

//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxx  Filter xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

app.config.globalProperties.$filters = filters;
app.config.globalProperties.$func = filters;


//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxx  Axios Loader xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

Axios.defaults.baseURL = base_url;
Axios.defaults.withCredentials = true;


Axios.defaults.timeout = 10000;
Axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';

// Add a request interceptor
Axios.interceptors.request.use(function (config) {

    app.config.globalProperties.$loading = {
        in_progress: true
    }

    // Do something before request is sent
    NProgress.start();
    return config;
}, function (error) {

    app.config.globalProperties.$loading = {
        in_progress: false
    }

    // Do something with request error
    console.log(error);
    return Promise.reject(error);
});

// Add a response interceptor
Axios.interceptors.response.use(function (response) {

    app.config.globalProperties.$loading = {
        in_progress: false
    };

    if (Object.prototype.hasOwnProperty.call(response.data, 'errors') && response.data.errors[0].message == "Signature has expired") {
        store.commit('auth/logout');
    }

    // Do something with response data
    NProgress.done();
    return response;
}, function (error) {

    app.config.globalProperties.$loading = {
        in_progress: false
    };

    // Do something with response error
    console.log(error);
    return Promise.reject(error);
});


app.config.globalProperties.$http = app.config.globalProperties.$axios = window.axios = Axios;


// Create axios instance with base url and credentials support
window.axios.interceptors.request.use(function (config) {


    // If http method is `post | put | delete` and XSRF-TOKEN cookie is
    // not present, call '/sanctum/csrf-cookie' to set CSRF token, then
    // proceed with the initial response

    const tmp_config = async (config) => {

        if ((
                config.method == 'patch' ||
                config.method == 'post' ||
                config.method == 'put' ||
                config.method == 'delete'
                /* other methods you want to add here */
            ) && !Cookies.get('XSRF-TOKEN')) {


            await window.axios.get(window.base_url + '/sanctum/csrf-cookie')
                .then(function (response) {
                    //console.log(response);
                });

            return await window.axios.get(window.base_url + '/sanctum/csrf-cookie')
                .then(response => config);
        }

        return config;
    };

    return tmp_config(config);

}, function (error) {
    return Promise.reject(error);
});


//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxx  Vuex Store xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
import modules from '@/store/modules';


const store = createStore({
    modules: modules,
    plugins: [createPersistedState({
        storage: {
            getItem: (key) => Cookies.get(key),
            // Please see https://github.com/js-cookie/js-cookie#json, on how to handle JSON.
            setItem: (key, value) =>
                Cookies.set(key, value, {
                    expires: 3,
                    secure: true
                }),
            removeItem: (key) => Cookies.remove(key),
        },
    })],
});


if (store.state.auth.token) {
    window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + store.state.auth.token;
}

app.use(store);



//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx  Ruotes  xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx


router.beforeEach((to, from, next) => {

    app.config.globalProperties.$loading = {
        in_progress: true
    };

    NProgress.start();

    if (to.meta.middlewareAuth) {
        if (!store.getters["auth/loggedIn"]) {
            next({
                path: "/login",
                query: {
                    redirect: to.fullPath,
                },
            });

            return;
        }
    }


    if (to.matched.some((record) => record.meta.middlewareAuth)) {
        if (!store.getters["auth/loggedIn"]) {
            next({
                path: "/login",
                query: {
                    redirect: to.fullPath,
                },
            });

            return;
        }
    }

    next();
});

router.afterEach((to, from) => {
    // ...
    app.config.globalProperties.$loading = {
        in_progress: false
    };

    NProgress.done();
});


app.component('calendar', Calendar);


(async () => {

    await autorouter(router);

    app.config.globalProperties.$router = window.$router = router;

    app.use(router);

    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx  Mount App  xxxxxxxxxxxxxxxxxxxxxxxxxxxx
    //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    app.mount('#app');

})();
