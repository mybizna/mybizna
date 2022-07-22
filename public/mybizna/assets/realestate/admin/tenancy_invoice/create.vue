<template>
    <customform></customform>
</template>

<script>
export default {
    components: {
        customform: window.$func.fetchComponent(["realestate", "tenancy_invoice", "form.vue"])
    },
};
</script>
