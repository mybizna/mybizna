<template>
    <edit-render v-if="layout_fetched" :path_param="tmp_path_param" :model="model">
        <Vueform :model-value="model" :sync="true">
            <div class="grid grid-cols-12 gap-1">
                <template v-for="(row, rindex)  in layout" :key="rindex">

                    <div :class="row.class">
                        <h4
                            class="text-center text-sm italic font-semibold border-b border-dotted border-gray-100 text-blue-900 my-2 bg-gray-50 p-1">
                            {{ row.label }}</h4>

                        <template v-for="(field, findex)  in row.fields" :key="findex">

                            <TextareaElement v-if="field.html == 'textarea'" :name="field.name" :label="field.label"
                                :id="field.name" :placeholder="field.placeholder" :description="field.description"
                                :info="field.info" />

                            <EditorElement v-else-if="field.html == 'editor'" :name="field.name" :label="field.label"
                                :id="field.name" :placeholder="field.placeholder" :description="field.description"
                                :info="field.info" />

                            <CheckboxElement v-else-if="field.html == 'checkbox'" :name="field.name"
                                :items="field.options" :label="field.label" :id="field.name"
                                :placeholder="field.placeholder" :description="field.description" :info="field.info" />

                            <CheckboxgroupElement v-else-if="field.html == 'checkboxgroup'" :name="field.name"
                                :items="field.options" :label="field.label" :id="field.name"
                                :placeholder="field.placeholder" :description="field.description" :info="field.info" />

                            <RadioElement v-else-if="field.html == 'radio'" :name="field.name" :options="field.options"
                                :label="field.label" :id="field.name" :placeholder="field.placeholder"
                                :description="field.description" :info="field.info" />

                            <RadiogroupElement v-else-if="field.html == 'radiogroup'" :name="field.name"
                                :items="field.options" :label="field.label" :id="field.name"
                                :placeholder="field.placeholder" :description="field.description" :info="field.info" />

                            <ToggleElement v-else-if="field.html == 'toggle' || field.html == 'switch'"
                                :name="field.name" :label="field.label" :id="field.name"
                                :placeholder="field.placeholder" :description="field.description" :info="field.info"
                                :default="field.default" :true-value="1" :false-value="0" />

                            <SelectElement v-else-if="field.html == 'select'" :name="field.name" :items="field.options"
                                :label="field.label" :id="field.name" :placeholder="field.placeholder"
                                :description="field.description" :info="field.info" />

                            <MultiselectElement v-else-if="field.html == 'multiselect'" :name="field.name"
                                :items="field.options" :label="field.label" :id="field.name"
                                :placeholder="field.placeholder" :description="field.description" :info="field.info" />

                            <TagsElement v-else-if="field.html == 'tags'" :name="field.name" :label="field.label"
                                :items="field.options" :id="field.name" :placeholder="field.placeholder"
                                :description="field.description" :info="field.info" />

                            <DateElement v-else-if="field.html == 'datetime'" :name="field.name" :label="field.label"
                                :id="field.name" :placeholder="field.placeholder" :description="field.description"
                                :info="field.info" :date="true" :time="true" />

                            <DateElement v-else-if="field.html == 'date'" :name="field.name" :label="field.label"
                                :id="field.name" :placeholder="field.placeholder" :description="field.description"
                                :info="field.info" :date="true" :time="false" />

                            <DateElement v-else-if="field.html == 'time'" :name="field.name" :label="field.label"
                                :id="field.name" :placeholder="field.placeholder" :description="field.description"
                                :info="field.info" :date="false" :time="true" />

                            <DatesElement v-else-if="field.html == 'dates'" :name="field.name" :label="field.label"
                                :id="field.name" :placeholder="field.placeholder" :description="field.description"
                                :info="field.info" />

                            <SliderElement v-else-if="field.html == 'slider'" :name="field.name" :label="field.label"
                                :id="field.name" :placeholder="field.placeholder" :description="field.description"
                                :info="field.info" />

                            <FileElement v-else-if="field.html == 'file'" :name="field.name" :label="field.label"
                                :id="field.name" :placeholder="field.placeholder" :description="field.description"
                                :info="field.info" />

                            <MultifileElement v-else-if="field.html == 'multifile'" :name="field.name"
                                :label="field.label" :id="field.name" :placeholder="field.placeholder"
                                :description="field.description" :info="field.info" />

                            <LocationElement v-else-if="field.html == 'location'" :name="field.name"
                                :label="field.label" :id="field.name" :placeholder="field.placeholder"
                                :description="field.description" :info="field.info" />

                            <HiddenElement v-else-if="field.html == 'hidden'" :name="field.name" :label="field.label"
                                :id="field.name" :placeholder="field.placeholder" :description="field.description"
                                :info="field.info" />

                            <RecordpickerElement v-else-if="field.html == 'recordpicker'" :name="field.name"
                                :valdata="model[field.name]" :label="field.label" :id="field.name"
                                :placeholder="field.placeholder" :description="field.description" :info="field.info"
                                :setting="field.picker" />

                            <StaticElement v-else-if="field.html == 'static'" :name="field.name" :label="field.label"
                                :id="field.name" :placeholder="field.placeholder" :description="field.description"
                                :info="field.info" />

                            <DropzoneElement v-else-if="field.html == 'dropzone'" :name="field.name"
                                :label="field.label" :id="field.name" :placeholder="field.placeholder"
                                :description="field.description" :info="field.info" />

                            <FaceElement v-else-if="field.html == 'face'" :name="field.name" :label="field.label"
                                :id="field.name" :placeholder="field.placeholder" :description="field.description"
                                :info="field.info" />

                            <MediaElement v-else-if="field.html == 'media'" :name="field.name" :label="field.label"
                                :id="field.name" :placeholder="field.placeholder" :description="field.description"
                                :info="field.info" />

                            <MonthpickerElement v-else-if="field.html == 'monthpicker'" :name="field.name"
                                :label="field.label" :id="field.name" :placeholder="field.placeholder"
                                :description="field.description" :info="field.info" />

                            <RecordselectElement v-else-if="field.html == 'recordselect'" :name="field.name"
                                :label="field.label" :id="field.name" :placeholder="field.placeholder"
                                :description="field.description" :info="field.info" :setting="field.picker" />

                            <WeekpickerElement v-else-if="field.html == 'weekpicker'" :name="field.name"
                                :label="field.label" :id="field.name" :placeholder="field.placeholder"
                                :description="field.description" :info="field.info" />

                            <YearpickerElement v-else-if="field.html == 'yearpicker'" :name="field.name"
                                :label="field.label" :id="field.name" :placeholder="field.placeholder"
                                :description="field.description" :info="field.info" />

                            <TextElement v-else :name="field.name" :label="field.label" :id="field.name"
                                :placeholder="field.placeholder" :description="field.description" :info="field.info" />

                        </template>
                    </div>
                </template>
            </div>

            <HiddenElement name="id" id="id" />

        </Vueform>

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

        var id = this.$route.params.id;

        if (id) {
            this.model['id'] = id;
        }

        window.axios.get("fetch_layout/" + path[0] + "/" + path[1] + "/" + this.$route.meta.form).then((response) => {

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
