<template>
    <customform></customform>
</template>

<script>
export default {
    components: {
        customform: window.$func.fetchComponent(["account", "chart_of_account", "form.vue"])
    },
};
</script>
