<template>
    <customform></customform>
</template>

<script>
export default {
    components: {
        customform: window.$func.fetchComponent(["realestate", "building_unit_setup", "form.vue"])
    },
};
</script>
