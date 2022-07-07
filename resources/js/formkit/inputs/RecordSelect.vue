
<template>
    <FormKit type="select" :name="context.id"  :options="recordlist" :classes="classes" />
</template>

<script>

import Loading from "@/formkit/inputs/Loading";

export default {
    props: {
        context: Object,
    },

    data () {
        return {
            currentComp: Loading,
            is_recordpicker: true,
            recordlist: {
                '': 'Loading List'
            },
            classes:{
                inner:"$reset",
            }
        }
    },

    mounted () {
        console.log(this.context);
        console.log('xxxxxxxxxxxxxxxxxxxxxxxxxxxx');
        console.log('xxxxxxxxxxxxxxxxxxxxxxxxxxxx');
        console.log('this.context');
        console.log(this.context);


    },
}

</script>

