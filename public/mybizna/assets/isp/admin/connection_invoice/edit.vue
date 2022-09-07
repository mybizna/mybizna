<template>
    <customform></customform>
</template>

<script>
export default {
    components: {
        customform: window.$func.fetchComponent(["isp", "connection_invoice", "form.vue"])
    },
};
</script>
