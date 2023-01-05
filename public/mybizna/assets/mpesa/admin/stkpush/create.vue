<template>
    <customform></customform>
</template>

<script>
export default {
    components: {
        customform: window.$func.fetchComponent(["mpesa", "stkpush", "form.vue"])
    },
};
</script>
