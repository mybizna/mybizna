<template>
    <div class="p-3">
        <v-row class="match-height">
            <v-col
                v-for="(item, index) in menuIcons"
                :key="index"
                cols="6"
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
                <dashboard-weekly-overview></dashboard-weekly-overview>
            </v-col>
            <v-col cols="12" md="8">
                <dashboard-statistics-card></dashboard-statistics-card>
                <v-card class="mt-3">
                    <div class="d-flex flex-sm-row flex-column">
                        <div class="flex-grow-1">
                            <v-card-title>
                                <span class="me-3">Deposit</span>
                                <v-spacer></v-spacer>
                                <span
                                    class="text-xs text--disabled cursor-pointer"
                                    >View All</span
                                >
                            </v-card-title>

                            <v-card-text> <calendar></calendar> </v-card-text>
                        </div>
                    </div>
                </v-card>
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

import ImageLink from "@/components/common/widgets/link/ImageLink.vue";

// demos
import DashboardCongratulationJohn from "./DashboardCongratulationJohn.vue";
import DashboardStatisticsCard from "./DashboardStatisticsCard.vue";
import DashboardWeeklyOverview from "./DashboardWeeklyOverview.vue";

export default {
    components: {
        ImageLink,
        DashboardCongratulationJohn,
        DashboardStatisticsCard,
        DashboardWeeklyOverview,
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
