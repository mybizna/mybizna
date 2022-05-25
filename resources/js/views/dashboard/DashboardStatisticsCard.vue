<template>
    <v-card>
        <v-card-title class="align-start">
            <span class="font-weight-semibold">Statistics Card</span>
            <v-spacer></v-spacer>
            <v-btn icon small class="me-n3 mt-n2">
                <v-icon icon="fas fa-plus"> mdiDotsVertical </v-icon>
            </v-btn>
        </v-card-title>

        <v-card-subtitle class="mb-8 mt-n5">
            <span class="font-weight-semibold text--primary me-1"
                >Total sales 48.5%</span
            >
            <span>😎 so far</span>
        </v-card-subtitle>

        <v-card-text>
            <v-row>
                <v-col
                    v-for="data in statisticsData"
                    :key="data.title"
                    cols="6"
                    md="3"
                    class="d-flex align-center"
                >
                    <v-avatar
                        size="44"
                        :color="
                            resolveStatisticsIconVariation(data.title).color
                        "
                        rounded
                        class="elevation-1"
                    >
                        <v-icon dark color="white" size="30" icon="fas fa-plus">
                            {{
                                resolveStatisticsIconVariation(data.title).icon
                            }}
                        </v-icon>
                    </v-avatar>
                    <div class="ms-3">
                        <p class="text-xs mb-0">
                            {{ data.title }}
                        </p>
                        <h3 class="text-xl font-weight-semibold">
                            {{ data.total }}
                        </h3>
                    </div>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script>
// eslint-disable-next-line object-curly-newline
import {
    mdiAccountOutline,
    mdiCurrencyUsd,
    mdiTrendingUp,
    mdiDotsVertical,
    mdiLabelOutline,
} from "@mdi/js";

import { computed } from "vue";
import { useStore } from "vuex";

export default {
    setup() {
        const store = useStore();

        if (!store.state.system.has_dashboard_data) {
            store.dispatch("dashboard/getDashboardData");
        }

        let dashboard_data = computed(function () {
            return store.state.dashboard.dashboard_data;
        });

        const statisticsData = [
            {
                title: "Sales",
                total: dashboard_data.value['sale'] + "k",
            },
            {
                title: "Customers",
                total: dashboard_data.value['customer'] + "k",
            },
            {
                title: "Product",
                total: dashboard_data.value['product'] + "k",
            },
            {
                title: "Revenue",
                total: "$" + dashboard_data.value['revenue'] + "00k",
            },
        ];

        const resolveStatisticsIconVariation = (data) => {
            if (data === "Sales")
                return { icon: mdiTrendingUp, color: "primary" };
            if (data === "Customers")
                return { icon: mdiAccountOutline, color: "success" };
            if (data === "Product")
                return { icon: mdiLabelOutline, color: "warning" };
            if (data === "Revenue")
                return { icon: mdiCurrencyUsd, color: "info" };

            return { icon: mdiAccountOutline, color: "success" };
        };

        return {
            dashboard_data,
            statisticsData,
            resolveStatisticsIconVariation,

            // icons
            icons: {
                mdiDotsVertical,
                mdiTrendingUp,
                mdiAccountOutline,
                mdiLabelOutline,
                mdiCurrencyUsd,
            },
        };
    },
};
</script>
