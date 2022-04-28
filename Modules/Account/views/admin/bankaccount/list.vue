<template>
    <div class="app-customers">
        <div class="content-header-section separator">
            <div class="wperp-row wperp-between-xs">
                <div class="wperp-col">
                    <h2 class="content-header__title">
                        {{ this.$func.__("Accounts", "erp") }}
                    </h2>
                    <combo-box
                        :options="pages"
                        :hasUrl="true"
                        :placeholder="__('New Transaction', 'erp')"
                    />
                    <span
                        class="erp-help-tip .erp-tips"
                        :title="
                            this.$func.__(
                                'To edit a bank account, please navigate to the Chart of Accounts.',
                                'erp'
                            )
                        "
                    ></span>
                </div>
            </div>
        </div>

        <div
            class="wperp-transactions-section wperp-section"
            v-if="accounts.length"
        >
            <!-- wperp-accounts-table class is required class for only this component -->
            <div class="table-container">
                <table
                    class="wperp-table table-striped table-dark widefat table2 wperp-accounts-table"
                >
                    <tbody>
                        <!-- keep this empty row if possible -->
                        <tr></tr>
                        <tr :key="index" v-for="(account, index) in accounts">
                            <td class="col--account-infos">
                                <!-- account name -->
                                <div class="account-name">
                                    <h4>{{ account.name }}</h4>
                                </div>
                                <!-- account number -->
                                <div class="account-number-info">
                                    <span class="account-number-label"
                                        >{{
                                            this.$func.__("Account Number", "erp")
                                        }}:</span
                                    >
                                    <span class="account-number">{{
                                        account.code
                                    }}</span>
                                </div>
                                <!-- account balance info -->
                                <div class="account-balance-info">
                                    <!-- available balance -->
                                    <div class="available-balance">
                                        <span class="account-balance-label"
                                            >{{
                                                this.$func.__("Available Balance", "erp")
                                            }}:</span
                                        >
                                        <strong
                                            v-if="undefined === account.balance"
                                            class="account-balance"
                                            >{{ transformBalance(0) }}</strong
                                        >
                                        <strong
                                            v-else
                                            class="account-balance"
                                            >{{
                                                transformBalance(
                                                    account.balance
                                                )
                                            }}</strong
                                        >
                                    </div>
                                </div>
                            </td>
                            <!-- actions column -->
                            <td class="col--actions">
                                <div class="row-actions">
                                    <slot name="row-actions">
                                        <dropdown placement="left-start">
                                            <template slot="button">
                                                <a class="dropdown-trigger"
                                                    ><i
                                                        class="flaticon-menu"
                                                    ></i
                                                ></a>
                                            </template>
                                            <template slot="dropdown">
                                                <ul
                                                    slot="action-items"
                                                    role="menu"
                                                >
                                                    <li
                                                        v-for="action in actions"
                                                        :key="action.key"
                                                        :class="action.key"
                                                    >
                                                        <a
                                                            href="#"
                                                            @click.prevent="
                                                                actionClicked(
                                                                    action.key,
                                                                    account
                                                                )
                                                            "
                                                            ><i
                                                                :class="
                                                                    action.iconClass
                                                                "
                                                            ></i
                                                            >{{
                                                                action.label
                                                            }}</a
                                                        >
                                                    </li>
                                                </ul>
                                            </template>
                                        </dropdown>
                                    </slot>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <p v-else>{{ this.$func.__("No data found.", "erp") }}</p>
    </div>
</template>

<script>
import Dropdown from "assets/components/base/Dropdown.vue";
import ComboBox from "assets/components/select/ComboBox.vue";

export default {
    components: {
        Dropdown,
        ComboBox,
    },

    data() {
        return {
            accounts: [],
            actions: [
                {
                    key: "transfer",
                    label: "Transfer",
                    iconClass: "flaticon-sent-mail",
                },
            ],
            pages: [{ namedRoute: "Transfers", name: "Transfer Money" }],
        };
    },

    created() {
        this.fetchAccounts();
    },

    methods: {
        fetchAccounts() {

            window.axios
                .get("/accounts/bank-accounts")
                .then((response) => {
                    this.accounts = response.data;
                })
                .catch((error) => {
                    throw error;
                });
        },

        transformBalance(val) {
            if (val === "undefined") {
                val = 0;
            }

            if (val < 0) {
                return `Cr. ${this.moneyFormat(Math.abs(val))}`;
            }

            return `Dr. ${this.moneyFormat(val)}`;
        },

        actionClicked(action, account) {
            switch (action) {
                case "transfer":
                    this.$router.push({
                        name: "NewTransfer",
                        params: {
                            ac_id: account.id,
                            ac_name: account.name,
                        },
                    });
                    break;

                default:
                    break;
            }
        },
    },
};
</script>

<style>
.wperp-accounts-table {
    border: 0;
}
.wperp-accounts-table .col--actions {
    vertical-align: top;
    line-height: 20px;
    padding-right: 17px;
}
.wperp-accounts-table td {
    padding-top: 20px;
    padding-bottom: 20px;
}
.account-name h4 {
    font-weight: 500;
    margin-bottom: 13px;
    color: #000;
}
.account-balance {
    font-weight: 500;
    color: #1a9ed4;
    font-size: 14px;
}
.col--account-infos > div {
    line-height: 18px;
}

.col--account-infos > div span {
    color: #525252;
}
.col--account-infos > div span .account-number {
    font-weight: 400;
    color: #000;
}
.account-number-label,
.account-balance-label {
    display: inline-flex;
    min-width: 120px;
}
.account-balance-info {
    margin-top: 9px;
    display: flex;
}
.account-balance-info > div {
    padding-right: 20px;
    margin-right: 20px;
    border-right: 1px solid #d8d8d8;
}
@media (max-width: 782px) {
    .wperp-table tbody tr:not(.inline-edit-row):not(.no-items) td {
        padding-left: 10px;
    }
}

.app-customers .erp-help-tip {
    font-size: 1.9em;
    top: 0.4rem;
}
</style>
