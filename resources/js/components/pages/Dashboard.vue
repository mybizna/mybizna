<template>
    <dashboard></dashboard>
</template>

<script>

// demos

export default {
    components: {
        Dashboard: window.$func.fetchComponent(
            "base/manage/dashboard/list.vue"
        )
    },
};
</script>
