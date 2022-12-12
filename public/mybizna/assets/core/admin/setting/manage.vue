<template>
    <table-edit :path_param="path_param" :model="model" passed_form_url="setting/savedata">

        <div class="d-flex align-items-start">
            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <template v-for="(setting, s_index) in model.settings" v-bind:key="s_index">
                    <button :class="s_index == current_tab ? 'nav-link active' : 'nav-link'"
                        :id="'v-pills-' + s_index + '-tab'" data-bs-toggle="tab"
                        :data-bs-target="'#v-pills-' + + s_index" type="button" role="tab" :aria-controls="s_index"
                        :aria-selected="!s_index ? 'true' : 'false'" @click="current_tab=s_index">
                        {{
                        setting.title
                        }}</button>
                </template>
            </div>
            <div class="tab-content w-3/4" id="v-pills-tabContent">
                <div v-for="(setting, s_index) in model.settings" v-bind:key="s_index"
                    :class="s_index == current_tab ? 'tab-pane fade show active' : 'tab-pane fade'" :id="s_index"
                    role="tabpanel" :aria-labelledby="s_index + '-tab'">
                    <div class="p-2">
                        <div v-for="(subsetting, ss_index) in setting.settings" v-bind:key="ss_index">
                            <h3 class="my-3 border-b-2 border-indigo-200 ">{{ subsetting.title }}</h3>
                            <template v-for="(field, ssl_index) in subsetting.list" v-bind:key="ssl_index">
                                <FormKit v-if="field.params.type == 'recordpicker'" :label="field.params.title"
                                    :id="field.params.name" :type="field.params.type" :comp_url="field.params.comp_url"
                                    :setting="field.params.setting" v-model="field.params.value" />

                                <FormKit v-else :label="field.params.title" :id="field.params.name"  :type="field.params.type"
                                    v-model="field.params.value" />

                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </table-edit>
</template>

<script>
export default {
    components: {
        TableEdit: window.$func.fetchComponent("components/common/TableEdit.vue")
    },
    data () {
        return {
            path_param: ["core", "setting"],
            current_tab: 'core',
            model: { settings: {} }
        }
    },
    created () {
        this.fetchData();
    },

    methods: {
        getNow: function () {

        },
        fetchData () {

            var t = this;
            var comp_url = 'fetch_settings/';

            const getdata = async (t) => {

                await window.axios.get(comp_url)
                    .then(
                        response => {
                            t.model.settings = response.data;
                            console.log(response.data);

                            var arr_tabs = Object.keys(t.model.settings);

                            console.log(' ');
                            console.log(' ');
                            console.log(arr_tabs);
                            console.log(t.model.settings);


                            t.current_tab = arr_tabs[0];
                        });
            };

            getdata(this);
        },
    }
};
</script>
