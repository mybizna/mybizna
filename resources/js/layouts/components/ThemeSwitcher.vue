<template>
    <v-fade-transition mode="out-in">
        <v-icon icon="fas fa-plus"> mdiWeatherunny </v-icon>
    </v-fade-transition>
</template>

<script>
import { mdiWeatherNight, mdiWeatherSunny } from "@mdi/js";

import { ref } from "vue";

export default {
    setup() {
        const theme = ref("light");
        return {
            icons: {
                mdiWeatherNight,
                mdiWeatherSunny,
            },
        };
    },
};
</script>

<style></style>
