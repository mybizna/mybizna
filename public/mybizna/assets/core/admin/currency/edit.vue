<template>
    <customform></customform>
</template>

<script>
export default {
    components: {
        customform: window.$func.fetchComponent(["core", "currency", "form.vue"])
    },
};
</script>
