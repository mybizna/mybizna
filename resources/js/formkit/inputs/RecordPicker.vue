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
                        <component :is="currentComp"></component>
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
        }
    },

    methods: {
        async loadcomponent () {
            console.log('start');
            console.log(Loading);

          /*  this.currentComp = await fetchComponent(
                "isp/admin/billing/list.vue"
            );*/

            console.log('end');
        }
    }
};
</script>

