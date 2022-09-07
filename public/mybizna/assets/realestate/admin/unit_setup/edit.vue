<template>
    <customform></customform>
</template>

<script>
export default {
    components: {
        customform: window.$func.fetchComponent(["realestate", "unit_setup", "form.vue"])
    },
};
</script>
