<template>
    <slot name="before"></slot>

    <i v-if="!status" class="fa fa-check-circle text-xl text-red-600"></i>
    <i v-else class="fa fa-times-circle text-xl text-green-600"></i>

    <slot name="after"></slot>
</template>

<script>
export default {
    props: {
        status: Boolean,
    },

};
</script>
