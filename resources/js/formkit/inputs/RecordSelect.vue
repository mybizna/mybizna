
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
            var url = '';
            var filter = '';
            var setting = this.context.attrs.setting;

            if (Object.prototype.hasOwnProperty.call(setting, 'url')) {
                url = this.context.attrs.setting.url;
            }

            if (Object.prototype.hasOwnProperty.call(setting, 'filter')) {
                filter = this.context.attrs.setting.filter;
            }

            if (Object.prototype.hasOwnProperty.call(setting, 'filter_field')) {
                filter = this.context.attrs.setting.filter_name + '=' + filter;
            }

            if (url == '' && Object.prototype.hasOwnProperty.call(setting, 'path_param')) {
                var param1 = this.context.attrs.setting.path_param[0];
                var param2 = this.context.attrs.setting.path_param[1];
                url = param1 + '/admin/' + param2 + 'recordselect';
            }


            if (filter) {
                url = url + filter;
            }

            if (url == '') {
                await window.axios.get(url)
                    .then(
                        response => {
                            console.log(response);
                            this.recordlist = response.data.records;

                        })
                    .catch(
                        response => {
                            if (response.status === 401) {
                                console.log('Issues Fetching Data.');
                            }
                        });
            }
        },
    }
}

</script>

