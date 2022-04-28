<template>
    <div class="timepicker">
        <p class="title">{{ window.$func.__("Select Time", "erp") }}</p>

        <div v-timepicker :id="elm" />
        <input :value="value" type="text" style="display: none" />
    </div>
</template>

<script>
import MtrDatepicker from "./mtr-datepicker.min";

export default {
    directives: {
        timepicker: {
            inserted(el, binding, vnode) {
                vnode.context.timepickerObj = new MtrDatepicker({
                    target: el.id,
                    disableAmPm: vnode.context.hideAmPmDisplay,
                    smartHours: true,
                });
            },
        },
    },

    props: {
        value: {
            type: String,
            required: true,
            default: () => "",
        },
        elm: {
            type: String,
            required: true,
            default: () => "",
        },
        hideAmPmDisplay: {
            type: Boolean,
            default: () => false,
        },
    },

    data() {
        return {
            timepickerObj: null,
        };
    },

    mounted() {
        let format = "hh:mm A";

        if (this.hideAmPmDisplay) {
            format = "hh:mm";
        }

        //    this.$emit('input', this.timepickerObj.format(format));

        this.timepickerObj.onChange("all", () => {
            if (this.hideAmPmDisplay) {
                this.$emit("input", this.timepickerObj.format(format));
            } else {
                this.$emit("input", this.timepickerObj.format(format));
            }
        });
    },
};
</script>

<style src="./mtr-datepicker.min.css"></style>
<style src="./mtr-datepicker.default-theme.min.css"></style>

<style>
.timepicker .title {
    padding: 10px 0 0;
    margin: 0;
    text-align: center;
    color: #000;
}

.timepicker .mtr-datepicker .mtr-content .mtr-values .mtr-default-value,
.timepicker .mtr-datepicker .mtr-content.mtr-input,
.timepicker .mtr-datepicker .mtr-content .mtr-datepicker .mtr-content input {
    background: #f5f8fa;
    border: 1px solid #1a9ed4;
    color: #222;
}

.timepicker .mtr-datepicker .mtr-input-radio {
    margin-right: 0 !important;
}
.timepicker .mtr-datepicker .mtr-input-radio form {
    display: grid;
}

.timepicker .mtr-datepicker .mtr-input-radio label span.value {
    color: #222;
}

.timepicker .mtr-datepicker .mtr-input-slider .mtr-content {
    height: 46px !important;
}

.timepicker .mtr-datepicker .mtr-arrow:hover {
    background: none;
}
</style>
