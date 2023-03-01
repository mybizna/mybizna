<template>
    <div class="flex justify-start" @click="selection">
        <div class="form-check form-switch">

            <label for="toggleTwo" class="flex cursor-pointer select-none items-center">
                <div class="relative">
                    <input type="checkbox" id="toggleTwo" class="sr-only" />
                    <div class="block h-6 w-10 rounded-full bg-[#E5E7EB]"></div>
                    <div :class="selected ? 'bg-blue-800 right-1 ' : 'bg-white left-1 '"
                        class="dot absolute top-1 h-4 w-4 rounded-full  transition"></div>
                </div>
            </label>

        </div>
    </div>
</template>

<script>

export default {
    props: {
        context: Object,
    },
    watch: {
        'context.value': function (newVal, oldVal) {
            if (this.selected != newVal) {
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
        }
    },
    methods: {
        selection(e) {
            e.preventDefault();

            this.selected = !this.selected;
        }
    }
}
</script>

