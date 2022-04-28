<template>
    <div>
        <h2 class="view-doc">
            <span>{{ window.$func.__("Accounting Help", "erp") }}</span>
            <a
                href="https://mybizna.com/docs/accounting/getting-started/"
                class="mybizna-btn"
                >{{ window.$func.__("View all documentation", "erp") }}</a
            >
        </h2>

        <div class="acoounting-docs-wrap">
            <div id="dashboard-widgets" class="metabox-holder">
                <div
                    class="erp-help-section postbox-container"
                    :key="index"
                    v-for="(doc, index) in docs"
                >
                    <div class="metabox-holder">
                        <div class="meta-box-sortables">
                            <div class="postbox">
                                <h2 class="hndle">{{ doc.title }}</h2>

                                <div class="erp-help-questions">
                                    <ul
                                        :key="queInx"
                                        v-for="(que, queInx) in doc.ques"
                                    >
                                        <li>
                                            <a
                                                :href="que.url"
                                                target="_blank"
                                                >{{ que.label }}</a
                                            >
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- .erp-help-section -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            docs: [
                {
                    title: window.$func.__("General", "erp"),
                    ques: [
                        {
                            label: window.$func.__(
                                "How to set Financial Years?",
                                "erp"
                            ),
                            url: "https://mybizna.com/docs/accounting/getting-started/setting-financial-year/",
                        },
                        {
                            label: window.$func.__("What is Opening Balance?", "erp"),
                            url: "https://mybizna.com/docs/accounting/getting-started/opening-balance/",
                        },
                        {
                            label: window.$func.__("How to Set Currency?", "erp"),
                            url: "https://mybizna.com/docs/erp-core/global-settings/",
                        },
                        {
                            label: window.$func.__(
                                "What are the basic transaction types?",
                                "erp"
                            ),
                            url: "https://mybizna.com/docs/accounting/sales-transactions/basic-of-transaction-types/",
                        },
                        {
                            label: window.$func.__(
                                "How to create a Journal Entry?",
                                "erp"
                            ),
                            url: "https://mybizna.com/docs/accounting/journal-entry/",
                        },
                    ],
                },

                {
                    title: window.$func.__("Users", "erp"),
                    ques: [
                        {
                            label: window.$func.__("How to create customer?", "erp"),
                            url: "https://mybizna.com/docs/accounting/users/creating-a-customer/",
                        },
                        {
                            label: window.$func.__("How to create vendors?", "erp"),
                            url: "https://mybizna.com/docs/accounting/users/creating-a-vendor/",
                        },
                    ],
                },

                {
                    title: window.$func.__("Sales Transactions", "erp"),
                    ques: [
                        {
                            label: window.$func.__(
                                "How to create an invoice?",
                                "erp"
                            ),
                            url: "https://mybizna.com/docs/accounting/sales-transactions/creating-your-first-invoice/",
                        },
                        {
                            label: window.$func.__(
                                "How to receive payment from invoices?",
                                "erp"
                            ),
                            url: "https://mybizna.com/docs/accounting/sales-transactions/adding-invoice-payments/",
                        },
                        {
                            label: window.$func.__(
                                "How can I delete an invoice?",
                                "erp"
                            ),
                            url: "https://mybizna.com/docs/accounting/sales-transactions/creating-your-first-invoice/",
                        },
                    ],
                },

                {
                    title: window.$func.__("Expense Transactions", "erp"),
                    ques: [
                        {
                            label: window.$func.__("How to create a bill?", "erp"),
                            url: "https://mybizna.com/docs/accounting/expense-transactions/creating-bill-new/",
                        },
                        {
                            label: window.$func.__(
                                "How to create payments for bills?",
                                "erp"
                            ),
                            url: "https://mybizna.com/docs/accounting/expense-transactions/creating-bill-new/",
                        },
                        {
                            label: window.$func.__(
                                "How to create an expense?",
                                "erp"
                            ),
                            url: "https://mybizna.com/docs/accounting/expense-transactions/creating-expense-new/",
                        },
                        {
                            label: window.$func.__(
                                "How to create a check payment?",
                                "erp"
                            ),
                            url: "https://mybizna.com/docs/accounting/expense-transactions/creating-inventory-check-new/",
                        },
                    ],
                },

                {
                    title: window.$func.__("Purchase Transactions", "erp"),
                    ques: [
                        {
                            label: window.$func.__(
                                "How to create purchase quotation?",
                                "erp"
                            ),
                            url: "https://mybizna.com/docs/accounting/purchase-transactions-2/create-purchase/",
                        },
                        {
                            label: window.$func.__(
                                "How to create payments for purchase quotations?",
                                "erp"
                            ),
                            url: "https://mybizna.com/docs/accounting/purchase-transactions-2/pay-purchase/",
                        },
                    ],
                },

                {
                    title: window.$func.__("Bank Accounts", "erp"),
                    ques: [
                        {
                            label: window.$func.__(
                                "Can I create a bank account in Accounting?",
                                "erp"
                            ),
                            url: "https://mybizna.com/docs/accounting/chart-of-accounts/creating-a-new-chart/",
                        },
                        {
                            label: window.$func.__(
                                "How can I receive, spend transfer between bank accounts?",
                                "erp"
                            ),
                            url: "https://mybizna.com/docs/accounting/bank-accounts/transferring-between-accounts/",
                        },
                    ],
                },

                {
                    title: window.$func.__("Products", "erp"),
                    ques: [
                        {
                            label: window.$func.__(
                                "Can I create products / services / product categoty?",
                                "erp"
                            ),
                            url: "https://mybizna.com/docs/accounting/adding-products/",
                        },
                    ],
                },

                {
                    title: window.$func.__("Tax", "erp"),
                    ques: [
                        {
                            label: window.$func.__("What is Tax Zone?", "erp"),
                            url: "https://mybizna.com/docs/accounting/tax/",
                        },
                        {
                            label: window.$func.__("What is Tax Category?", "erp"),
                            url: "https://mybizna.com/docs/accounting/tax/",
                        },
                        {
                            label: window.$func.__("What is Tax Agency?", "erp"),
                            url: "https://mybizna.com/docs/accounting/tax/",
                        },
                    ],
                },

                {
                    title: window.$func.__("Reports", "erp"),
                    ques: [
                        {
                            label: window.$func.__(
                                "How to produce different types of reports in Accounting?",
                                "erp"
                            ),
                            url: "https://mybizna.com/docs/accounting/reporting/",
                        },
                    ],
                },
            ],
        };
    },
};
</script>

<style>
.view-doc {
    margin-top: 15px;
    align-items: center;
    display: flex;
}
.view-doc span {
    font-size: 18px;
    font-weight: bold;
}

.view-doc a {
    background: #1a9ed4;
    border-radius: 3px;
    color: #fff;
    font-size: 12px;
    height: 29px;
    line-height: 29px;
    margin-left: 13px;
    text-align: center;
    text-decoration: none;
    width: 160px;
}

.view-doc a:hover {
    color: #fff;
}
.erp-help-questions ul {
    margin-bottom: 0;
}

.erp-help-questions li {
    margin: 0;
    border-bottom: 1px solid #eee;
}

.erp-help-questions li a {
    padding: 10px 15px;
    display: block;
}

.erp-help-questions li a:hover {
    background-color: #f5f5f5;
}

.erp-help-questions li:last-child {
    border-bottom: none;
}

.erp-help-questions li .dashicons {
    float: right;
    color: #ccc;
    margin-top: -3px;
}

@media screen and (min-width: 960px) {
    .erp-help-section .postbox-container {
        width: 100% !important;
    }

    .erp-help-section:nth-child(odd) {
        clear: both !important;
    }
}
</style>
