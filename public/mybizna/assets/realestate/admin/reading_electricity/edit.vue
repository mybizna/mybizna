<template>
    <customform></customform>
</template>

<script>
export default {
    components: {
        customform: window.$func.fetchComponent(["realestate", "reading_electricity", "form.vue"])
    },
};
</script>
