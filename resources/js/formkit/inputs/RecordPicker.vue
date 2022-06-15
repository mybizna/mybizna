<script setup>
import { ref } from 'vue'

const props = defineProps({
    context: Object,
})

const digits = Number(props.context.digits)
const tmp = ref(props.context.value || '')

</script>

<template>
    record picker
</template>
