<template>
    <customform></customform>
</template>

<script>
export default {
    components: {
        customform: window.$func.fetchComponent(["partner", "partner", "form.vue"])
    },
};
</script>
