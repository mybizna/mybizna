<!-- RecordpickerElement.vue -->

<template>
    <ElementLayout>
        <template #element>
            <div>
                <button type="button"
                    class="mr-4 py-2 px-4 rounded-full border-0 text-sm font-semibold bg-blue-500 text-white hover:bg-blue-800"
                    @click="loadcomponent()" data-bs-toggle="modal" :data-bs-target="'#' + id + 'Modal'">
                    {{ button_label }}
                </button>

                {{ message }}

                <!-- Modal -->
                <div class="modal fade" :id="id + 'Modal'" tabindex="-1" :aria-labelledby="id + 'ModalLabel'"
                    aria-hidden="true">
                    <div class="modal-dialog ">
                        <div class="modal-content shadow-2xl shadow-indigo-500/50">
                            <div class="modal-header p-2">
                                <h5 class="modal-title font-semibold" :id="id + 'ModalLabel'">Modal title</h5>
                                <button @click="modalToggle" type="button" class="" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <i class="fa-solid fa-circle-xmark text-2xl	text-red"></i>
                                </button>
                            </div>

                            <div class="modal-body p-0">
                                <list-table :recordPicker="recordPicker" :setting="{ is_recordpicker: is_recordpicker }"
                                    :path_param="setting.path_param" :title="setting.title"></list-table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
import { Modal } from 'bootstrap/dist/js/bootstrap.bundle.js';
import ListTable from "@/components/common/ListTable";

export default defineElement({
    name: 'RecordpickerElement',
    components: {
        ListTable,
    },
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
        },
        valdata: {
            type: String,
            required: true,
            default: ''
        }
    },
    setup(props, { element }) {
        const { update, value } = element;

    },

    data() {
        return {
            selected: '',
            record: {},
            message: '',
            button_label: 'Select Record',
            is_recordpicker: true
        }
    },
    watch: {
        valdata: function (newVal, oldVal) {
            this.loadRecord(newVal);
            this.selected = newVal;
        },
        selected: function (newVal, oldVal) {
            if (newVal !== oldVal) {
                this.update(newVal);
            }
        },
    },
    mounted() {

        const myModalEl = document.getElementById(this.id + 'Modal');

        myModalEl.addEventListener('hidden.bs.modal', event => {
            this.modalToggle();
        });

        if (this.label == '') {
            this.button_label = this.label;
        }

    },

    methods: {
        async loadcomponent() {
            if (this.value.value) {
                this.loadRecord(this.value.value);
            }
        },
        modalToggle() {
            window.$store.commit("system/has_search", false);
            window.$store.commit("system/is_list", false);
            window.$store.commit("system/is_edit", true);
            window.$store.commit("system/is_recordpicker", false);
        },
        recordPicker(id) {
            this.modalToggle();

            Modal.getOrCreateInstance(document.getElementById(this.id + 'Modal')).hide();

            this.update(id);

            this.loadRecord(id);
        },
        loadRecord(id) {
            const getdata = async (t, id) => {
                t.message = t.setting.template;

                var part1 = t.setting.path_param[0];
                var part2 = t.setting.path_param[1];
                var comp_url = part1 + "/admin/" + part2 + "/" + id;
                //var comp_url = part1 + "/admin/" + part2 + "/recordselect";

                await window.axios.get(comp_url, { params: { f: t.setting.fields } })
                    .then(
                        response => {

                            t.record = response.data.record;

                            Object.keys(t.record).forEach(key => {
                                var field = (t.record[key]) ? t.record[key] : '';
                                t.message = t.message.replaceAll('[' + key + ']', field);
                            });
                        })
                    .catch(
                        response => {
                            if (response.status === 401) {
                                console.log('Issues Fetching Data.');
                            }
                        });
            };

            if (id) {
                getdata(this, id);
                this.update(id);
            }

        }
    }

})
</script>