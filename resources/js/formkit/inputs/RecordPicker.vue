<script setup>
import { ref } from 'vue'

const props = defineProps({
    context: Object,
})

const digits = Number(props.context.digits)
const tmp = ref(props.context.value || '')

</script>

<template>
   <div class="p-2">
        <a class="mr-4 py-2 px-4 rounded-full border-0 text-sm font-semibold bg-blue-500 text-white hover:bg-blue-800">
            Select Record
        </a>

        John Doe(john@doe.com)
    </div>
</template>
