<template>
    <th :class="class">
        <slot></slot>
    </th>
</template>

<script>

export default {
    props: {
        class: String,
    },
    data() {
        return {
        };
    },

};
</script>
