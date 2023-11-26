<template>
    <ElementLayout>
        <template #element>
            <Datepicker :name="id" :disabled="disabled" :validation="validation" :placeholder="placeholder"
                :classes="classes" :auto-position="false" auto-apply v-model="selected" month-picker />
        </template>

        <!-- Default element slots -->
        <template v-for="(component, slot) in elementSlots" #[slot]>
            <slot :name="slot" :el$="el$">
                <component :is="component" :el$="el$" />
            </slot>
        </template>
    </ElementLayout>
</template>
  
<script>
import { defineElement } from '@vueform/vueform'

export default defineElement({
    name: 'MonthpickerElement',
    setup(props, { element }) {
        const { update, value } = element;
    },
    data() {
        return {
            selected: '',
            classes: {
                inner: "$reset",
            }
        }
    },
    mounted() {
        this.selected = this.value.value;
    },
    watch: {
        selected: function (newVal, oldVal) {
            if (newVal !== oldVal) {
                this.update(newVal);
            }
        },
    },
})
</script>

