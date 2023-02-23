<template>
    <th :class="classes">
        <slot></slot>
    </th>
</template>

<script>
export default {
    props: {
        classes: String,
    },

};
</script>
