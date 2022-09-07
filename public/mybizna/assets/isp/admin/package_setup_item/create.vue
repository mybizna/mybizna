<template>
    <customform></customform>
</template>

<script>
export default {
    components: {
        customform: window.$func.fetchComponent(["isp", "package_setup_item", "form.vue"])
    },
};
</script>
