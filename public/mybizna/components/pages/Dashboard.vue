<template>
    <dashboard></dashboard>
</template>

<script>

// demos

export default {
    components: {
        Dashboard: window.$func.fetchComponent(
            "base/admin/dashboard/list.vue"
        )
    },
};
</script>
