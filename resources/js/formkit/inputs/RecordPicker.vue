<template>
    <div>
        <button type="button"
            class="mr-4 py-2 px-4 rounded-full border-0 text-sm font-semibold bg-blue-500 text-white hover:bg-blue-800"
            @click="loadcomponent()" data-bs-toggle="modal" :data-bs-target="'#' + context.id + 'Modal'">
            {{ button_label }}
        </button>

        {{ message }}

        <!-- Modal -->
        <div class="modal fade" :id="context.id + 'Modal'" tabindex="-1" :aria-labelledby="context.id + 'ModalLabel'"
            aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content shadow-2xl shadow-indigo-500/50">
                    <div class="modal-header p-2">
                        <h5 class="modal-title font-semibold" :id="context.id + 'ModalLabel'">Modal title</h5>
                        <button @click="modalToggle" type="button" class="" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa-solid fa-circle-xmark text-2xl	text-red"></i>
                        </button>
                    </div>

                    <div class="modal-body p-0">
                        <component :is="currentComp" :recordPicker="recordPicker"
                            :setting="{ is_recordpicker: is_recordpicker }">
                        </component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>



<script>
import { Modal } from 'bootstrap/dist/js/bootstrap.bundle.js';
import Loading from "@/formkit/inputs/Loading";
import fetchComponent from "@/utils/fetchComponent";

export default {
    props: {
        context: Object,
    },

    data() {
        return {
            selected: '',
            currentComp: Loading,
            record: {},
            message: '',
            button_label: 'Select Record',
            is_recordpicker: true
        }
    },
    watch: {
        'context.value': function (newVal, oldVal) {
            if (newVal != oldVal) {
                this.selected = newVal;

                this.loadRecord(newVal);
            }
        },
        selected: function (newVal, oldVal) {
            if (newVal !== oldVal) {
                this.context.node.input(newVal);
            }
        },
    },
    mounted() {
        const myModalEl = document.getElementById(this.context.id + 'Modal');

        myModalEl.addEventListener('hidden.bs.modal', event => {
            this.modalToggle();
        });

        if (this.context.attrs.button_label == '') {
            this.button_label = this.context.attrs.button_label;
        }
    },

    methods: {
        async loadcomponent() {
            this.currentComp = await fetchComponent(
                this.context.attrs.comp_url
            )
        },
        modalToggle() {
            window.$store.commit("system/has_search", false);
            window.$store.commit("system/is_list", false);
            window.$store.commit("system/is_edit", true);
            window.$store.commit("system/is_recordpicker", false);
        },
        recordPicker(id) {
            this.modalToggle();

            Modal.getOrCreateInstance(document.getElementById(this.context.id + 'Modal')).hide();

            this.context.node.input(id);

            //this.loadRecord(id);
        },
        loadRecord(id) {
            const getdata = async (t, id) => {
                t.message = t.context.attrs.setting.template;

                var part1 = t.context.attrs.setting.path_param[0];
                var part2 = t.context.attrs.setting.path_param[1];
                var comp_url = part1 + "/admin/" + part2 + "/" + id;

                console.log(comp_url);

                await window.axios.get(comp_url, { params: { f: t.context.attrs.setting.fields } })
                    .then(
                        response => {

                            t.record = response.data.record;

                            console.log( t.record);

                            var fields = t.context.attrs.setting.fields;

                            Object.keys(t.record).forEach(key => {
                                t.message = t.message.replaceAll('[' + key + ']', t.record[key]);
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
                this.context.node.input(id);
            }

        }
    }

};
</script>

