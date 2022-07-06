
<template>
    <FormKit type="select" name="state"  :options="recordlist" />


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

