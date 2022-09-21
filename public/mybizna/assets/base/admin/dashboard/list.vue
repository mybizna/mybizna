<template>
    <div class="p-3">
        <v-row class="match-height">
            <v-col v-for="(item, index) in $store.state.system.menu" :key="index" cols="6" sm="3" md="2">
                <image-link :title="item.title" :url="'#'+item.path" :icon="item.icon" :class_str="item.class_str">
                </image-link>
            </v-col>
        </v-row>

        <v-row>
            <v-col cols="12" md="4">
                <dashboard-congratulation-john></dashboard-congratulation-john>
            </v-col>
            <v-col cols="12" md="8">
                <v-card class="mt-3">
                    <div class="d-flex flex-sm-row flex-column">
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between">
                                <div class="me-3 p-1">Events</div>
                                <div class="text-xs text--disabled cursor-pointer p-1">
                                    View All
                                </div>
                            </div>

                            <div class="py-1">
                                <calendar></calendar>
                            </div>
                        </div>
                    </div>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>

<script>

// demos

export default {
    components: {
        ImageLink: window.$func.fetchComponent(
            "components/common/widgets/link/ImageLink.vue"
        ),
        DashboardCongratulationJohn: window.$func.fetchComponent(
            "base/admin/dashboard/DashboardCongratulationJohn.vue"
        )
    },
    updated () {
        alert('updated sdfsdfdsfdsf');
    },
    mounted () {
        alert('mounted sdfsdfdsfdsf');
    },
};
</script>
