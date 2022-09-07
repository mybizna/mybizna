<template>
    <customform></customform>
</template>

<script>
export default {
    components: {
        customform: window.$func.fetchComponent(["account", "opening_balance", "form.vue"])
    },
};
</script>
