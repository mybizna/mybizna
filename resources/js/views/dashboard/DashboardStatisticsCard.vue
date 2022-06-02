<template>
    <v-card>
        <v-card-title class="align-start">
            <span class="font-weight-semibold">Statistics Card</span>
            <v-spacer></v-spacer>
            <v-btn icon small class="me-n3 mt-n2">
                <i :class="'fas fa-cog fa-lg'"></i>
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
                    v-for="data in $store.state.dashboard.dashboard_data"
                    :key="data.title"
                    cols="6"
                    md="3"
                    class="d-flex align-center"
                >
                    <v-avatar
                        size="44"
                        :color="data.color"
                        rounded
                        class="elevation-1"
                    >
                        <i
                            class="text-white dashboard-card-icon"
                            :class="data.icon"
                        ></i>
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

import { useStore } from "vuex";

export default {
    setup() {
        const store = useStore();

        if (!store.state.system.has_dashboard_data) {
            store.dispatch("dashboard/getDashboardData");
        }

        return {};
    },
};
</script>

<style scoped>
.dashboard-card-icon {
    font-size: 18px;
}
</style>
