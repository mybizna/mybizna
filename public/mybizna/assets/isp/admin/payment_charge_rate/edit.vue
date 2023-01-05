<template>
    <customform></customform>
</template>

<script>
export default {
    components: {
        customform: window.$func.fetchComponent(["isp", "payment_charge_rate", "form.vue"])
    },
};
</script>
