<template>
    <customform></customform>
</template>

<script>
export default {
    components: {
        customform: window.$func.fetchComponent(["isp", "billing", "form.vue"])
    },
};
</script>
