<template>
    <div class="p-1">
        <v-row class="match-height">
            <v-col
                v-for="(item, index) in menuIcons"
                :key="index"
                cols="4"
                sm="3"
                md="2"
            >
                <image-link
                    :title="item.title"
                    :url="item.url"
                    :icon="item.icon"
                    :class_str="item.class_str"
                ></image-link>
            </v-col>
        </v-row>

        <v-row>
            <v-col cols="12" md="4">
                <dashboard-congratulation-john></dashboard-congratulation-john>
            </v-col>
            <v-col cols="12" md="8">
                <dashboard-statistics-card></dashboard-statistics-card>
            </v-col>

            <v-col cols="12" sm="6" md="4">
                <dashboard-weekly-overview></dashboard-weekly-overview>
            </v-col>

            <v-col cols="12" md="4" sm="6">
                <dashboard-card-total-earning></dashboard-card-total-earning>
            </v-col>

            <v-col cols="12" md="4">
                <v-row class="match-height">
                    <v-col cols="12" sm="6">
                        <statistics-card-vertical
                            :change="totalProfit.change"
                            :color="totalProfit.color"
                            :icon="totalProfit.icon"
                            :statistics="totalProfit.statistics"
                            :stat-title="totalProfit.statTitle"
                            :subtitle="totalProfit.subtitle"
                        ></statistics-card-vertical>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <statistics-card-vertical
                            :change="totalSales.change"
                            :color="totalSales.color"
                            :icon="totalSales.icon"
                            :statistics="totalSales.statistics"
                            :stat-title="totalSales.statTitle"
                            :subtitle="totalSales.subtitle"
                        ></statistics-card-vertical>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <statistics-card-vertical
                            :change="newProject.change"
                            :color="newProject.color"
                            :icon="newProject.icon"
                            :statistics="newProject.statistics"
                            :stat-title="newProject.statTitle"
                            :subtitle="newProject.subtitle"
                        ></statistics-card-vertical>
                    </v-col>

                    <v-col cols="12" sm="6">
                        <statistics-card-vertical
                            :change="salesQueries.change"
                            :color="salesQueries.color"
                            :icon="salesQueries.icon"
                            :statistics="salesQueries.statistics"
                            :stat-title="salesQueries.statTitle"
                            :subtitle="salesQueries.subtitle"
                        ></statistics-card-vertical>
                    </v-col>
                </v-row>
            </v-col>

            <v-col cols="12" md="4">
                <dashboard-card-sales-by-countries></dashboard-card-sales-by-countries>
            </v-col>
            <v-col cols="12" md="8">
                <dashboard-card-deposit-and-withdraw></dashboard-card-deposit-and-withdraw>
            </v-col>
            <v-col cols="12">
                <dashboard-datatable></dashboard-datatable>
            </v-col>
        </v-row>
    </div>
</template>

<script>
// eslint-disable-next-line object-curly-newline
import {
    mdiPoll,
    mdiLabelVariantOutline,
    mdiCurrencyUsd,
    mdiHelpCircleOutline,
} from "@mdi/js";

import StatisticsCardVertical from "@/components/statistics-card/StatisticsCardVertical.vue";
import ImageLink from "@/components/common/widgets/link/ImageLink.vue";

// demos
import DashboardCongratulationJohn from "./DashboardCongratulationJohn.vue";
import DashboardStatisticsCard from "./DashboardStatisticsCard.vue";
import DashboardCardTotalEarning from "./DashboardCardTotalEarning.vue";
import DashboardCardDepositAndWithdraw from "./DashboardCardDepositAndWithdraw.vue";
import DashboardCardSalesByCountries from "./DashboardCardSalesByCountries.vue";
import DashboardWeeklyOverview from "./DashboardWeeklyOverview.vue";
import DashboardDatatable from "./DashboardDatatable.vue";

export default {
    components: {
        ImageLink,
        StatisticsCardVertical,
        DashboardCongratulationJohn,
        DashboardStatisticsCard,
        DashboardCardTotalEarning,
        DashboardCardDepositAndWithdraw,
        DashboardCardSalesByCountries,
        DashboardWeeklyOverview,
        DashboardDatatable,
    },
    setup() {
        const totalProfit = {
            statTitle: "Total Profit",
            icon: mdiPoll,
            color: "success",
            subtitle: "Weekly Project",
            statistics: "$25.6k",
            change: "+42%",
        };

        const totalSales = {
            statTitle: "Refunds",
            icon: mdiCurrencyUsd,
            color: "secondary",
            subtitle: "Past Month",
            statistics: "$78",
            change: "-15%",
        };

        // vertical card options
        const newProject = {
            statTitle: "New Project",
            icon: mdiLabelVariantOutline,
            color: "primary",
            subtitle: "Yearly Project",
            statistics: "862",
            change: "-18%",
        };

        const salesQueries = {
            statTitle: "Sales Quries",
            icon: mdiHelpCircleOutline,
            color: "warning",
            subtitle: "Last week",
            statistics: "15",
            change: "-18%",
        };

        const menuIcons = [
            {
                title: "Account",
                icon: "fas fa-funnel-dollar",
                url: "/account",
                class_str: "text-primary border-primary",
            },
            {
                title: "Expenses",
                icon: "fas fa-money-bill",
                url: "/expense",
                class_str: "text-secondary border-secondary",
            },
            {
                title: "Sales",
                icon: "fas fa-receipt",
                url: "/Sales",
                class_str: "text-warning border-warning",
            },
            {
                title: "Products",
                icon: "fas fa-store",
                url: "/products",
                class_str: "text-danger border-danger",
            },
            {
                title: "Payment",
                icon: "fas fa-file-invoice-dollar",
                url: "/account",
                class_str: "text-black border-black",
            },
            {
                title: "Bill",
                icon: "fas fa-hand-holding-usd",
                url: "/expense",
                class_str: "text-success border-success",
            },
        ];

        return {
            menuIcons,
            totalProfit,
            totalSales,
            newProject,
            salesQueries,
        };
    },
};
</script>
