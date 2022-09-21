<template>
    <div class="p-3">
        <div class="row match-height">
            <div v-for="(item, index) in $store.state.system.menu" :key="index" class="col-6 col-sm-3 col-md-2">
                <image-link :title="item.title" :url="'#'+item.path" :icon="item.icon" :class_str="item.class_str">
                </image-link>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12 col-md-4">
                <dashboard-congratulation-john></dashboard-congratulation-john>
            </div>
            <div class="col-12 col-md-8">

                <div class="card">
                    <div class="card-body p-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="me-3 p-1">Events</h3>
                            <div class="text-xs text--disabled cursor-pointer p-1">
                                View All
                            </div>
                        </div>
                        <div class="py-1">
                            <calendar></calendar>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

};
</script>
