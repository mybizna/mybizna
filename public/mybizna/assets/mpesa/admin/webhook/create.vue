<template>
    <customform></customform>
</template>

<script>
export default {
    components: {
        customform: window.$func.fetchComponent(["mpesa", "webhook", "form.vue"])
    },
};
</script>
