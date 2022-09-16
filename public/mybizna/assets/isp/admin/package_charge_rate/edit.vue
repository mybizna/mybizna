<template>
    <customform></customform>
</template>

<script>
export default {
    components: {
        customform: window.$func.fetchComponent(["isp", "package_charge_rate", "form.vue"])
    },
};
</script>
