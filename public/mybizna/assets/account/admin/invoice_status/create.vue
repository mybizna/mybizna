<template>
    <customform></customform>
</template>

<script>
export default {
    components: {
        customform: window.$func.fetchComponent(["account", "invoice_status", "form.vue"])
    },
};
</script>
