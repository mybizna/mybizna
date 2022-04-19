<template>
    <v-fade-transition mode="out-in">
        <v-icon> mdi-weather-sunny </v-icon>
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
