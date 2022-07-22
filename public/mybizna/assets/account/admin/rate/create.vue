<template>
    <customform></customform>
</template>

<script>
export default {
    components: {
        customform: window.$func.fetchComponent(["account", "rate", "form.vue"])
    },
};
</script>
