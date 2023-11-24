<template>
    <edit-render v-if="layout_fetched" :path_param="tmp_path_param" :model="model">

        <div class="grid grid-cols-12 gap-2">
            <template v-for="(row, rindex)  in layout" :key="rindex">
                <div :class="row.class">
                    <h4 class="text-xs italic font-semibold border-b border-dotted border-gray-100 text-blue-900 my-2">{{
                        row.label }}</h4>
                    <template v-for="(field, findex)  in row.fields" :key="findex">

                        <TextareaElement v-if="field.params.type == 'textarea'" :name="field.name"
                            :label="field.params.title" :id="field.name" :placeholder="field.params.title"
                            :description="field.params.description" :info="field.params.info" />

                        <EditorElement v-else-if="field.params.type == 'editor'" :name="field.name"
                            :label="field.params.title" :id="field.name" :placeholder="field.params.title"
                            :description="field.params.description" :info="field.params.info" />

                        <CheckboxElement v-else-if="field.params.type == 'checkbox'" :name="field.name"
                            :label="field.params.title" :id="field.name" :placeholder="field.params.title"
                            :description="field.params.description" :info="field.params.info" />

                        <CheckboxgroupElement v-else-if="field.params.type == 'checkboxgroup'" :name="field.name"
                            :label="field.params.title" :id="field.name" :placeholder="field.params.title"
                            :description="field.params.description" :info="field.params.info" />

                        <RadioElement v-else-if="field.params.type == 'radio'" :name="field.name"
                            :label="field.params.title" :id="field.name" :placeholder="field.params.title"
                            :description="field.params.description" :info="field.params.info" />

                        <RadiogroupElement v-else-if="field.params.type == 'radiogroup'" :name="field.name"
                            :label="field.params.title" :id="field.name" :placeholder="field.params.title"
                            :description="field.params.description" :info="field.params.info" />

                        <ToggleElement v-else-if="field.params.type == 'toggle'" :name="field.name"
                            :label="field.params.title" :id="field.name" :placeholder="field.params.title"
                            :description="field.params.description" :info="field.params.info" />

                        <ToggleElement v-else-if="field.params.type == 'switch'" :name="field.name"
                            :label="field.params.title" :id="field.name" :placeholder="field.params.title"
                            :description="field.params.description" :info="field.params.info" />

                        <SelectElement v-else-if="field.params.type == 'select'" :name="field.name"
                            :label="field.params.title" :id="field.name" :placeholder="field.params.title"
                            :description="field.params.description" :info="field.params.info" />

                        <MultiselectElement v-else-if="field.params.type == 'multiselect'" :name="field.name"
                            :label="field.params.title" :id="field.name" :placeholder="field.params.title"
                            :description="field.params.description" :info="field.params.info" />

                        <TagsElement v-else-if="field.params.type == 'tags'" :name="field.name" :label="field.params.title"
                            :id="field.name" :placeholder="field.params.title" :description="field.params.description"
                            :info="field.params.info" />

                        <DateElement v-else-if="field.params.type == 'date'" :name="field.name" :label="field.params.title"
                            :id="field.name" :placeholder="field.params.title" :description="field.params.description"
                            :info="field.params.info" />

                        <DatesElement v-else-if="field.params.type == 'dates'" :name="field.name"
                            :label="field.params.title" :id="field.name" :placeholder="field.params.title"
                            :description="field.params.description" :info="field.params.info" />

                        <SliderElement v-else-if="field.params.type == 'slider'" :name="field.name"
                            :label="field.params.title" :id="field.name" :placeholder="field.params.title"
                            :description="field.params.description" :info="field.params.info" />

                        <FileElement v-else-if="field.params.type == 'file'" :name="field.name" :label="field.params.title"
                            :id="field.name" :placeholder="field.params.title" :description="field.params.description"
                            :info="field.params.info" />

                        <MultifileElement v-else-if="field.params.type == 'multifile'" :name="field.name"
                            :label="field.params.title" :id="field.name" :placeholder="field.params.title"
                            :description="field.params.description" :info="field.params.info" />

                        <LocationElement v-else-if="field.params.type == 'location'" :name="field.name"
                            :label="field.params.title" :id="field.name" :placeholder="field.params.title"
                            :description="field.params.description" :info="field.params.info" />

                        <HiddenElement v-else-if="field.params.type == 'hidden'" :name="field.name"
                            :label="field.params.title" :id="field.name" :placeholder="field.params.title"
                            :description="field.params.description" :info="field.params.info" />

                        <StaticElement v-else-if="field.params.type == 'static'" :name="field.name"
                            :label="field.params.title" :id="field.name" :placeholder="field.params.title"
                            :description="field.params.description" :info="field.params.info" />

                        <TextElement v-else :name="field.name" :label="field.params.title" :id="field.name"
                            :placeholder="field.params.title" :description="field.params.description"
                            :info="field.params.info" />


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
    },
    created() {
        this.tmp_path_param = (this.path_param.length) ? this.path_param : this.$route.meta.path;

        var path = this.$route.meta.path;

        window.axios.get("fetch_layout/" + path[0] + "/" + path[1] + "/edit").then((response) => {

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
            tmp_path_param: [],
            layout_fetched: false,
            id: null,
            model: {},
            layout: {},
        }
    },
};
</script>
