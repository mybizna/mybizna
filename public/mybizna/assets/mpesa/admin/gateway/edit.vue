<template>
    <customform></customform>
</template>

<script>
export default {
    components: {
        customform: window.$func.fetchComponent(["mpesa", "gateway", "form.vue"])
    },
};
</script>
