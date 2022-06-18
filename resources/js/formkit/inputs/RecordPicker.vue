<template>

    <div class="p-2">
        <button type="button"
            class="mr-4 py-2 px-4 rounded-full border-0 text-sm font-semibold bg-blue-500 text-white hover:bg-blue-800"
            @click="loadcomponent()" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Select Record
        </button>

        John Doe(john@doe.com)

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content shadow-2xl shadow-indigo-500/50">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <component :is="currentComp" :is_recordpicker="is_recordpicker"></component>
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
            is_recordpicker: true
        }
    },

    methods: {
        async loadcomponent () {
            console.log(this.context.attrs.comp_url);
            this.currentComp = await fetchComponent(
                this.context.attrs.comp_url
            )
        },
        recordPicker (id) {

            alert(id+'ddddddddds');
        }
    }

};
</script>

