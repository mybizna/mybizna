<template>
    <customform></customform>
</template>

<script>
export default {
    components: {
        customform: window.$func.fetchComponent(["realestate", "estate", "form.vue"])
    },
};
</script>
