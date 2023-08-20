<template>
    <edit-render :path_param="tmp_path_param" :model="model">

        <div class="grid grid-cols-12 gap-1">
            <template v-for="(row, rindex)  in layout" :key="rindex">
                <div :class="row.class">
                    <h4 class="text-xs italic font-semibold border-b border-dotted border-gray-100 text-blue-900 my-2">{{
                        row.label }}</h4>
                    <template v-for="(field, findex)  in row.fields" :key="findex">
                        <FormKit v-if="field.html == 'recordpicker'" :label="field.label" :button_label="field.button_label"
                            :id="field.name" type="recordpicker" :setting="field.picker" v-model="model[field.name]"
                            inner-class="$reset formkit-inner" wrapper-class="$reset formkit-wrapper" />
                        <FormKit v-else-if="field.html == 'select' || field.html == 'radio' || field.html == 'checkbox'"
                            v-model="model[field.name]" :options="field.options" :label="field.label" :id="field.name"
                            :type="field.html" />
                        <FormKit v-else v-model="model[field.name]" :label="field.label" :id="field.name"
                            :type="field.html" />
                    </template>
                </div>
            </template>
        </div>

    </edit-render>
</template>

<script>
//generate sample form
export default {
    props: {
        path_param: { type: Array, default: () => [], },
        title: { type: String, default: 'Creating', },
    },
    created() {
        this.tmp_path_param = (this.path_param.length) ? this.path_param : this.$route.meta.path;

        var path = this.$route.meta.path;

        window.axios.get("fetch_layout/" + path[0] + "/" + path[1] + "/create").then((response) => {

            this.layout = response.data.layout;

            response.data.fields.forEach(field => {
                this.model[field] = '';
            });

            this.layout_fetched = true;

        }).catch((error) => {
            console.log(error);
        });
    },
    data: function () {
        return {
            id: '',
            tmp_path_param: [],
            layout_fetched: false,
            model: {},
            layout: {},
        }
    },
};
</script>
