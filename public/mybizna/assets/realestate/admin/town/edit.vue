<template>
    <customform></customform>
</template>

<script>
export default {
    components: {
        customform: window.$func.fetchComponent(["realestate", "town", "form.vue"])
    },
};
</script>
