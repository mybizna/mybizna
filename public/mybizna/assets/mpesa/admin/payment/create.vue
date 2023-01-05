<template>
    <customform></customform>
</template>

<script>
export default {
    components: {
        customform: window.$func.fetchComponent(["mpesa", "payment", "form.vue"])
    },
};
</script>
