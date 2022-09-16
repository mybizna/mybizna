<template>
    <customform></customform>
</template>

<script>
export default {
    components: {
        customform: window.$func.fetchComponent(["account", "gateway", "form.vue"])
    },
};
</script>
