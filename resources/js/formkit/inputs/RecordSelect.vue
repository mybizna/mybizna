
<template>
    <FormKit type="select" :name="context.id" :options="recordlist" :classes="classes" v-model="selected" />
</template>

<script>

import Loading from "@/formkit/inputs/Loading";

export default {
    props: {
        context: Object,
    },
    watch: {
        'context.attrs.filter': function (newVal, oldVal) {
            this.loadResource();
        },
        selected: function (newVal, oldVal) {
            this.context.node.input(newVal);
        },

    },
    data () {
        return {
            selected: '',
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
        this.loadResource();
    },
    methods: {
        async loadResource () {
            var comp_url = this.context.attrs.comp_url
            var filter = this.context.attrs.filter;

            if (filter) {
                comp_url = comp_url + filter;
            }

            await window.axios.get(comp_url)
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

