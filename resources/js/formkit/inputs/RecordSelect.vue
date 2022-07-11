
<template>
    <FormKit type="select" :name="context.id" :options="recordlist" :classes="classes" />
    <button @click="loadResource" type="button" class="" data-bs-dismiss="modal" aria-label="Close">
        <i class="fa-solid fa-circle-xmark text-2xl	text-red"></i>
    </button>
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
            classes: {
                inner: "$reset",
            }
        }
    },

     mounted () {


    },
    methods: {
        async loadResource () {
            console.log(this.context.attrs.comp_url);
            console.log('response');

            await window.axios.get(this.context.attrs.comp_url)
                .then(
                    response => {
                        console.log(response);
                        this.recordlist = response.data;

                    })
                .catch(
                    response => {
                        if (response.status === 401) {
                            console.log('Issues Fetching Data.');
                        }
                    });
        },
    }
}

</script>

