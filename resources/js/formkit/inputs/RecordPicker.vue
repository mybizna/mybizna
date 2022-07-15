<template>

    <div class="p-2">
        <button type="button"
            class="mr-4 py-2 px-4 rounded-full border-0 text-sm font-semibold bg-blue-500 text-white hover:bg-blue-800"
            @click="loadcomponent()" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Select Record
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
                        <component :is="currentComp" :recordPicker="recordPicker" :is_recordpicker="is_recordpicker">
                        </component>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>



<script>

import Loading from "@/formkit/inputs/Loading";
import fetchComponent from "@/utils/fetchComponent";

export default {
    props: {
        context: Object,
    },

    data () {
        return {
            currentComp: Loading,
            record: {},
            message: '',
            is_recordpicker: true
        }
    },
    mounted () {

        console.log(this.context);
        const myModalEl = document.getElementById(this.context.id + 'Modal');
        myModalEl.addEventListener('hidden.bs.modal', event => {
            // do something...
            alert('sfdsfdsfds');
            this.modalToggle();
        });


    },

    methods: {
        async loadcomponent () {
            this.currentComp = await fetchComponent(
                this.context.attrs.comp_url
            )
        },
        modalToggle () {
            window.$store.commit("system/has_search", false);
            window.$store.commit("system/is_list", false);
            window.$store.commit("system/is_edit", true);
            window.$store.commit("system/is_recordpicker", false);
        },
        recordPicker (id) {
            const myModalEl = document.getElementById(this.context.id + 'Modal');

            myModalEl.hide();
            this.context.node.input(id);
            this.modalToggle();
        },
        async loadRecord (id) {
            var part1 = this.context.attrs.setting.path_param[0];
            var part2 = this.context.attrs.setting.path_param[1];

            if (id) {

                var comp_url = part1 + "/admin/" + part2 + "/" + id;

                await window.axios.get(comp_url, { params: { f: this.context.attrs.setting.fields } })
                    .then(
                        response => {
                            console.log(response);
                            this.record = response.data.record;

                            this.message = this.context.attrs.setting.template;
                            var fields = this.context.attrs.setting.fields;

                            fields.forEach(item => {
                                this.message.replaceAll('[' + item + ']', this.record[item]);
                            })



                        })
                    .catch(
                        response => {
                            if (response.status === 401) {
                                console.log('Issues Fetching Data.');
                            }
                        });

                this.context.node.input(id);
            }

        }
    }

};
</script>

