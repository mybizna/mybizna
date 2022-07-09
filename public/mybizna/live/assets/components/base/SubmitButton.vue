<template>
    <button
        type="submit"
        class="mybizna-btn btn--primary acct-button"
        :class="{ working: working }"
    >
        {{ text }}
    </button>
</template>

<script>
export default {
    props: {
        text: {
            type: String,
            default: this.$func.__("Submit", "erp"),
        },

        working: {
            type: Boolean,
            default: false,
        },
    },
};
</script>

<style>
.acct-button {
    background: #1a9ed4;
    color: #fff;
    border: 0;
    border-radius: 3px;
    padding: 6px 30px;
    margin: 20px 0 15px;
    cursor: pointer;
    position: relative;
    outline: 0;
    float: right;
}
.acct-button .disabled {
    background: #b3e5fc;
    cursor: default;
}

.acct-button:hover :not(.disabled) {
    background: #039be5;
}

.acct-button:not(.disabled)::before {
    content: "";
    position: absolute;
    right: 8px;
    top: 50%;
    margin-top: -11px;
    width: 20px;
    height: 20px;
    border: 4px solid #84ffff;
    border-left-color: transparent;
    border-radius: 50%;
    filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=0);
    opacity: 0;
    -moz-animation-duration: 1s;
    -webkit-animation-duration: 1s;
    animation-duration: 1s;
    -moz-animation-iteration-count: infinite;
    -webkit-animation-iteration-count: infinite;
    animation-iteration-count: infinite;
    -moz-animation-name: rotate;
    -webkit-animation-name: rotate;
    animation-name: rotate;
    -moz-animation-timing-function: linear;
    -webkit-animation-timing-function: linear;
    animation-timing-function: linear;
}

.acct-button:not(.disabled):after {
    content: "";
    display: inline-block;
    height: 100%;
    width: 0px;
}

.acct-button:not(.disabled) .working {
    pointer-events: none;
    cursor: not-allowed;
}
.acct-button:not(.disabled) .working:not(.expand) {
    text-align: left;
}

.acct-button:not(.disabled) .working:before {
    filter: progid:DXImageTransform.Microsoft.Alpha(enabled=false);
    opacity: 1;
}

.acct-button:not(.disabled) .working:after {
    width: 20px;
}

@keyframes rotate {
    0% {
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100% {
        -moz-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        -webkit-transform: rotate(360deg);
        transform: rotate(360deg);
    }
}
</style>
