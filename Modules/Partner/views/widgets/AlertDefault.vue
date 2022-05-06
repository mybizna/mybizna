<template>
    <div>
        <!-- Modal -->
        <div
            v-if="OpenClose"
            class="modal fade show"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-modal="true"
            role="dialog"
            style="display: block"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button
                            type="button"
                            @click="OpenCloseFun()"
                            class="btn-close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <component :is="newcomponent"></component>
                        <slot></slot>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            @click="OpenCloseFun()"
                            :class="'btn btn-' + variant"
                        >
                            {{ this.$func.__("Close") }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "AlertDefault",
    props: {
        visible: Boolean,
        variant: String,
        newcomponent: String,
    },

    data() {
        return {
            passed_component: { template: "<div>Loading</div>" },
            OpenClose: this.visible,
        };
    },
    methods: {
        OpenCloseFun() {
            this.OpenClose = false;
        },
    },
    watch: {
        newcomponent: function (newVal, oldVal) {
            alert("newcomponent");
            self.passed_component = window.$func.fetchComponent(newVal);
        },
        visible: function (newVal, oldVal) {
            // watch it
            this.OpenClose = newVal;
            console.log("new" + newVal + "==" + oldVal);
        },
    },
};
</script>
