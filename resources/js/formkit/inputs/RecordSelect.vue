
<template>
    <FormKit type="select" :name="context.id" :disabled="context.disabled" :validation="context.validation"
        :help="context.help" :errors="context.errors" :placeholder="context.placeholder" :options="recordlist"
        :classes="classes" v-model="selected" />
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

        'context.value': function (newVal, oldVal) {
            if (newVal != oldVal) {
                this.selected = newVal;
            }
        },
        selected: function (newVal, oldVal) {
            if (newVal !== oldVal) {
                this.context.node.input(newVal);
            }
        },

    },
    data() {
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
    mounted() {
        this.loadResource();
    },
    methods: {
        async loadResource() {
            var url = '';
            var filter = '';
            var params = {};
            var setting = this.context.attrs.setting;

            if (Object.prototype.hasOwnProperty.call(setting, 'url')) {
                url = this.context.attrs.setting.url;
            }

            if (Object.prototype.hasOwnProperty.call(setting, 'params')) {
                params = this.context.attrs.setting.params;
            }

            if (Object.prototype.hasOwnProperty.call(setting, 'filter_field')) {
                params[this.context.attrs.setting.filter_field] = this.context.attrs.filter;
            }

            if (Object.prototype.hasOwnProperty.call(setting, 'fields')) {
                params['f'] = this.context.attrs.setting.fields;
            }

            if (Object.prototype.hasOwnProperty.call(setting, 'fields')) {
                params['template'] = this.context.attrs.setting.template;
            }

            if (url == '' && Object.prototype.hasOwnProperty.call(setting, 'path_param')) {
                var param1 = this.context.attrs.setting.path_param[0];
                var param2 = this.context.attrs.setting.path_param[1];
                url = param1 + '/admin/' + param2 + '/recordselect';
            }


            if (filter) {
                url = url + filter;
            }

            if (Object.prototype.hasOwnProperty.call(setting, 'fields')) {

                url = url + filter;
            }

            if (url !== '') {
                await window.axios.get(url, { params: params })
                    .then(
                        response => {
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

