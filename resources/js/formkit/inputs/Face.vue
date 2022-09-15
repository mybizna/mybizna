<script setup>
import { ref } from 'vue'

const props = defineProps({
    context: Object,
})

const digits = Number(props.context.digits)
const tmp = ref(props.context.value || '')


</script>

<template>
    <div class="flex items-center space-x-6">
        <div class="shrink-0">
            <img class="h-16 w-16 object-cover rounded-full"
                src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1361&q=80"
                alt="Current profile photo" />
        </div>
        <label class="block">
            <span class="sr-only">Choose profile photo</span>
            <input type="file" class="block w-full text-sm text-slate-500
        file:mr-4 file:py-2 file:px-4
        file:rounded-full file:border-0
        file:text-sm file:font-semibold
        file:bg-violet-50 file:text-violet-700
        hover:file:bg-violet-100
      " />
        </label>
    </div>
</template>
