<template>
    <edit-render :path_param="$route.meta.path" title="Chart of Account" :model="model">

        <div class="grid grid-cols-12 gap-1">
            <template v-for="(row, rindex)  in layout" :key="rindex">
                <div :class="row.class">
                    <h4 class="text-xs italic font-semibold border-b border-dotted border-gray-100 text-blue-900 my-2">{{
                        row.label }}</h4>
                    <template v-for="(field, findex)  in row.fields" :key="findex">
                        <FormKit v-model="model[field.name]" :label="field.label" :id="field.name" :type="field.html" />
                    </template>
                </div>
            </template>
        </div>

    </edit-render>
</template>

<script>
//generate sample form
export default {

    created() {
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
            layout_fetched: false,
            model: {},
            layout: {},

        }
    },
};
</script>
