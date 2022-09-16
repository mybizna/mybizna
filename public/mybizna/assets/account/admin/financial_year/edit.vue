<template>
    <customform></customform>
</template>

<script>
export default {
    components: {
        customform: window.$func.fetchComponent(["account", "financial_year", "form.vue"])
    },
};
</script>
