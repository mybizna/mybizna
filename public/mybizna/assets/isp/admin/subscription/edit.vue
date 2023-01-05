<template>
    <customform></customform>
</template>

<script>
export default {
    components: {
        customform: window.$func.fetchComponent(["isp", "subscription", "form.vue"])
    },
};
</script>
