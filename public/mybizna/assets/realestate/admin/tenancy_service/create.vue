<template>
    <customform></customform>
</template>

<script>
export default {
    components: {
        customform: window.$func.fetchComponent(["realestate", "tenancy_service", "form.vue"])
    },
};
</script>
