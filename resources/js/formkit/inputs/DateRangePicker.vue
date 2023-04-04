
<template>
    <Datepicker :name="context.id" :disabled="context.disabled" :validation="context.validation"
        :placeholder="context.placeholder" :classes="classes" :auto-position="false" auto-apply
        v-model="selected"  range multi-calendars/>
    {{ context.errors }}
</template>

<script>


export default {
    props: {
        context: Object,
    },
    watch: {
        'context.value': function (newVal, oldVal) {
            if (newVal != oldVal) {
                this.selected = newVal;
            }
        },
        selected: function (newVal, oldVal) {
            if (newVal !== oldVal) {
                this.context.node.input(newVal);
            }
        },
    },
    data() {
        return {
            selected: '',
            classes: {
                inner: "$reset",
            }
        }
    },
}

</script>

