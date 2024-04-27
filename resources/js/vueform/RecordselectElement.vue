<template>
    <ElementLayout>
        <template #element>

            <SelectElement :items="recordlist" v-model="selected" />

        </template>

        <!-- Default element slots -->
        <template v-for="(component, slot) in elementSlots" #[slot]>
            <slot :name="slot" :el$="el$">
                <component :is="component" :el$="el$" />
            </slot>
        </template>
    </ElementLayout>
</template>
  
<script>
import { defineElement } from '@vueform/vueform'

export default defineElement({
    name: 'RecordselectElement',
    props: {
        setting: {
            type: Object,
            required: true,
            default: {}
        },
        comp_url: {
            type: String,
            required: true,
            default: ''
        }
    },
    setup(props, { element }) {
        const { update, value } = element;
    },
    watch: {
        selected: function (newVal, oldVal) {
            if (newVal !== oldVal) {
                this.update(newVal);
            }
        },
    },
    data() {
        return {
            selected: '',
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
            var setting = this.setting;

            if (Object.prototype.hasOwnProperty.call(setting, 'url')) {
                url = this.setting.url;
            }

            if (Object.prototype.hasOwnProperty.call(setting, 'params')) {
                params = this.setting.params;
            }

            if (Object.prototype.hasOwnProperty.call(setting, 'filter_field')) {
                params[this.setting.filter_field] = this.filter;
            }

            if (Object.prototype.hasOwnProperty.call(setting, 'fields')) {
                params['f'] = this.setting.fields;
            }

            if (Object.prototype.hasOwnProperty.call(setting, 'fields')) {
                params['template'] = this.setting.template;
            }

            if (url == '' && Object.prototype.hasOwnProperty.call(setting, 'path_param')) {
                var param1 = this.setting.path_param[0];
                var param2 = this.path_param[1];
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
})
</script>

