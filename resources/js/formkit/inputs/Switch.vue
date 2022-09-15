<template>
    <div class="flex justify-start">
        <div class="form-check form-switch">
            <input
                class="form-check-input appearance-none w-9 -ml-10 rounded-full float-left h-5 align-top bg-white bg-no-repeat bg-contain bg-gray-300 focus:outline-none cursor-pointer shadow-sm"
                 v-model="selected" type="checkbox" role="switch" id="flexSwitchCheckDefault">
        </div>
    </div>
</template>


<script>

export default {
    props: {
        context: Object,
    },
    watch: {
        selected: function (newVal, oldVal) {
            this.context.node.input(newVal);
        },

    }, data () {
        return {
            selected: '',
        }
    },
}
</script>

