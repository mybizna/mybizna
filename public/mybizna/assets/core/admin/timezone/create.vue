<template>
    <customform></customform>
</template>

<script>
export default {
    components: {
        customform: window.$func.fetchComponent(["core", "timezone", "form.vue"])
    },
};
</script>
