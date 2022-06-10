<template>
    <div>
        <FormKit
            label="Username"
            type="text"
            help="Pick a new username"
            validation="required|matches:/^@[a-zA-Z]+$/|length:5"
            value="@useFormKit"
            inner-class=""

        />
        <FormKit
            label="Name"
            type="text"
            help="Pick a new username"
            validation="required|matches:/^@[a-zA-Z]+$/|length:5"
            value="@useFormKit"
        />
    </div>
</template>

<script>
/*eslint no-undef: 2*/
/* eslint-disable vue/no-unused-components */

export default {
    props: {
        fields: { type: Array, default: () => [] },
    },
    data() {
        return {
            models: [],
        };
    },
};
</script>
