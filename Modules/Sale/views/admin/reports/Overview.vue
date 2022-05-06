<template>
    <div class="sales-tax-reports">
        <h2 class="title-container">
            <span>{{ this.$func.__("Sales Tax Reports", "erp") }}</span>

            <router-link
                class="btn btn-primary"
                :to="{ name: 'ReportsOverview' }"
            >
                {{ this.$func.__("Back", "erp") }}
            </router-link>
        </h2>

        <ul class="reports-overview">
            <li>
                <h3>{{ this.$func.__("Agency Based", "erp") }}</h3>
                <p>
                    {{
                        this.$func.__(
                            "It generates sales tax report based on agencies",
                            "erp"
                        )
                    }}.
                </p>

                <router-link
                    class="btn btn-primary"
                    :to="{ name: 'SalesTaxReportAgencyBased' }"
                >
                    {{ this.$func.__("View Report", "erp") }}
                </router-link>
            </li>

            <li>
                <h3>{{ this.$func.__("Transaction Based", "erp") }}</h3>
                <p>
                    {{
                        this.$func.__(
                            "It generates sales tax report based on transactions",
                            "erp"
                        )
                    }}.
                </p>

                <router-link
                    class="btn btn-primary"
                    :to="{ name: 'SalesTaxReportTransactionBased' }"
                >
                    {{ this.$func.__("View Report", "erp") }}
                </router-link>
            </li>

            <li>
                <h3>{{ this.$func.__("Customer Based", "erp") }}</h3>
                <p>
                    {{
                        this.$func.__(
                            "It generates sales tax report based on customers",
                            "erp"
                        )
                    }}.
                </p>

                <router-link
                    class="btn btn-primary"
                    :to="{ name: 'SalesTaxReportCustomerBased' }"
                >
                    {{ this.$func.__("View Report", "erp") }}
                </router-link>
            </li>

            <li>
                <h3>{{ this.$func.__("Category Based", "erp") }}</h3>
                <p>
                    {{
                        this.$func.__(
                            "It generates sales tax report based on categories",
                            "erp"
                        )
                    }}.
                </p>

                <router-link
                    class="btn btn-primary"
                    :to="{ name: 'SalesTaxReportCategoryBased' }"
                >
                    {{ this.$func.__("View Report", "erp") }}
                </router-link>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "SalesTaxReportsOverview",

    data() {
        return {
            report: [],
        };
    },
};
</script>

<style>
.reports-overview {
    margin: 0;
    padding: 10px;
    display: flex;
    flex-wrap: wrap;
}

.reports-overview .reports-overview li {
    font-size: 20px;
    background: #fff;
    margin-bottom: 1px;
    padding: 15px;
    width: 48%;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.04);
    margin: 10px;
    border-radius: 3px;
}
.reports-overview .reports-overview li h3 {
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    padding-bottom: 10px;
    font-weight: normal;
    color: #263238;
}

.reports-overview .reports-overview li p {
    font-size: 15px;
    color: #525252;
}

.title-container {
    margin-top: 15px;
    align-items: center;
    display: flex;
}
.title-container span {
    font-size: 18px;
    font-weight: bold;
}

.title-container a {
    background: #1a9ed4;
    border-radius: 3px;
    color: #fff;
    font-size: 12px;
    height: 29px;
    line-height: 29px;
    margin-left: 13px;
    text-align: center;
    text-decoration: none;
    width: 135px;
}

.sales-tax-report h2 {
    padding-top: 15px;
}

.sales-tax-report .query-options {
    padding: 20px 0;
}

.sales-tax-report .with-multiselect {
    width: 220px;
    float: left;
    margin-right: 30px;
}

.sales-tax-report .add-line-trigger {
    line-height: 1.9 !important;
}

.sales-tax-report .report-header {
    width: 420px;
    padding: 10px 0 0 0;
}
.sales-tax-report .report-header li {
    display: flex;
    justify-content: space-between;
}

.sales-tax-report .sales-tax-table tbody tr td:last-child {
    text-align: left !important;
}

@media print {
    .erp-nav-container {
        display: none;
    }

    .no-print,
    .no-print * {
        display: none !important;
    }

    .sales-tax-report .table.sales-tax-table th.trn_date,
    .sales-tax-report .table.sales-tax-tableth.created_at {
        min-width: 120px;
    }

    .sales-tax-report .table.sales-tax-table th.trn_no {
        min-width: 100px;
    }

    .sales-tax-report .table.sales-tax-table td,
    .sales-tax-report .table.sales-tax-table th {
        padding: 3px !important;
    }

    .sales-tax-report .table.sales-tax-table tr th:first-child,
    tr td:last-child {
        padding-left: 5px;
    }

    .sales-tax-report .table.sales-tax-table tr th:last-child,
    .sales-tax-report .table.sales-tax-table tr td:last-child {
        padding-right: 5px;
    }

    .sales-tax-report .table.sales-tax-table thead tr th {
        font-weight: bold;
    }
    .sales-tax-report .table.sales-tax-table thead tr th:nth-child(5),
    .sales-tax-report .table.sales-tax-table thead tr th:nth-child(6),
    .sales-tax-report .table.sales-tax-table thead tr th:nth-child(7) {
        text-align: right;
    }
}

.sales-tax-report .table.sales-tax-table tbody tr td:nth-child(5),
.sales-tax-report .table.sales-tax-table tbody tr td:nth-child(6),
.sales-tax-report .table.sales-tax-table tbody tr td:nth-child(7) {
    text-align: right !important;
}

.sales-tax-report .table.sales-tax-table tfoot td:nth-child(3),
.sales-tax-report .table.sales-tax-table tfoot td:nth-child(4) {
    text-align: right !important;
}
</style>
