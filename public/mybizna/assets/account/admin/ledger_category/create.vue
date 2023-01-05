<template>
    <customform></customform>
</template>

<script>
export default {
    components: {
        customform: window.$func.fetchComponent(["account", "ledger_category", "form.vue"])
    },
};
</script>
