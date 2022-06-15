<script setup>
import { ref } from 'vue'

const props = defineProps({
    context: Object,
})

const digits = Number(props.context.digits)
const tmp = ref(props.context.value || '')

</script>

<template>
    <select id="payment_id" data-placeholder="true"
        class="formkit-input form-input rounded border py-2 px-3 focus:border-sky-500 hover:border-sky-500 text-grey-800 h-8 w-full form-select py-0"
        name="select_5" aria-describedby="payment_id-rule_required">
        <option hidden="" disabled="" data-is-placeholder="true" class="formkit-option" value="">Select a planet
        </option>
        <option class="formkit-option" value="Monaco">Monaco</option>
        <option class="formkit-option" value="Vatican City">Vatican City</option>
        <option class="formkit-option" value="Maldives">Maldives</option>
        <option class="formkit-option" value="Tuvalu">Tuvalu</option>
    </select>
</template>
