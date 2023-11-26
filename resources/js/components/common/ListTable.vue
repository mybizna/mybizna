<template>
    <table-render v-if="layout_fetched" :recordPicker="recordPicker" :path_param="tmp_path_param"
        :table_fields="table_fields" :setting="{ hide_delete_button: true }">

        <template #header>
            <th-render v-for="column in columns" :key="column.name">
                {{ column.label }}
            </th-render>
        </template>

        <template #body="{ item }">

            <td v-for="column in columns" :key="column.name">

                <template v-if="column.html == 'amount'">
                    <div v-if="renderField(item, column) < 0" class="text-red-800 text-right font-bold">
                        {{ renderField(item, column) }}
                    </div>
                    <div v-else class="text-green-800 text-right font-bold">
                        {{ renderField(item, column) }}
                    </div>
                </template>

                <template v-else-if="column.color">
                    <span v-if="renderField(item, column) && column['color'] && column['color'][renderField(item, column)]"
                        :class="'bg-' + column['color'][renderField(item, column)] + '-100 text-' + column['color'][renderField(item, column)] + '-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded'">
                        {{ renderField(item, column) }}
                    </span>
                    <span v-else>
                        {{ renderField(item, column) }}
                    </span>
                </template>

                <template v-else-if="column.html == 'switch'">
                    <div class="text-center">
                        <btn-status :status="item[column.name]"></btn-status>
                    </div>
                </template>

                <template v-else-if="column.foreign_fields">
                    <a class="text-blue-900 font-medium" :href="'#' + getLink(item, column)">
                        {{ renderField(item, column) }}
                    </a>
                </template>

                <template v-else-if="column.html == 'select'">
                    {{ renderField(item, column) }}
                </template>

                <template v-else-if="column.html == 'checkbox'">
                    {{ renderField(item, column) }}
                </template>

                <template v-else-if="column.html == 'radio'">
                    {{ renderField(item, column) }}
                </template>

                <template v-else-if="column.html == 'image'">
                    {{ renderField(item, column) }}
                </template>

                <template v-else-if="column.html == 'file'">
                    {{ renderField(item, column) }}
                </template>

                <template v-else-if="column.html == 'currency'">
                    {{ renderField(item, column) }}
                </template>

                <template v-else-if="column.html == 'number'">
                    {{ renderField(item, column) }}
                </template>

                <template v-else-if="column.html == 'email'">
                    {{ renderField(item, column) }}
                </template>

                <template v-else-if="column.html == 'phone'">
                    {{ renderField(item, column) }}
                </template>

                <template v-else-if="column.html == 'url'">
                    {{ renderField(item, column) }}
                </template>

                <template v-else-if="column.html == 'password'">
                    {{ renderField(item, column) }}
                </template>

                <template v-else-if="column.html == 'color'">
                    {{ renderField(item, column) }}
                </template>

                <template v-else-if="column.html == 'text'">
                    {{ renderField(item, column) }}
                </template>

                <template v-else-if="column.html == 'textarea'">
                    {{ renderField(item, column) }}
                </template>

                <template v-else-if="column.html == 'html'">
                    {{ renderField(item, column) }}
                </template>

                <template v-else-if="column.html == 'json'">
                    {{ renderField(item, column) }}
                </template>

                <template v-else-if="column.html == 'markdown'">
                    {{ renderField(item, column) }}
                </template>

                <template v-else-if="column.html == 'wysiwyg'">
                    {{ renderField(item, column) }}
                </template>

                <template v-else-if="column.html == 'tags'">
                    {{ renderField(item, column) }}
                </template>

                <template v-else-if="column.html == 'rating'">
                    {{ renderField(item, column) }}
                </template>

                <template v-else-if="column.html == 'stars'">
                    {{ renderField(item, column) }}
                </template>

                <template v-else-if="column.html == 'icon'">
                    {{ renderField(item, column) }}
                </template>

                <template v-else-if="column.html == 'button'">
                    {{ renderField(item, column) }}
                </template>

                <template v-else-if="column.html == 'link'">
                    {{ renderField(item, column) }}
                </template>

                <template v-else-if="column.html == 'progress'">
                    {{ renderField(item, column) }}
                </template>

                <template v-else-if="column.html == 'bar'">
                    {{ renderField(item, column) }}
                </template>

                <template v-else-if="column.html == 'badge'">
                    {{ renderField(item, column) }}
                </template>

                <template v-else>
                    {{ renderField(item, column) }}
                </template>

            </td>
        </template>

    </table-render>
</template>

<script>


// generate sample code
export default {
    props: {
        classes: { type: String, default: "", },
        passed_return_url: { type: String, default: "", },
        dropdown_menu: { type: Array, default: () => [] },
        title: { type: String, default: "Listing", },
        path_param: { type: Array, default: () => [], },
        recordPicker: { type: Object, default: () => { } },
        mass_actions: { type: Array, default: () => [] },
    },
    created() {
        this.tmp_path_param = (this.path_param.length) ? this.path_param : this.$route.meta.path;

        var path = this.tmp_path_param;

        window.axios.get("fetch_layout/" + path[0] + "/" + path[1] + "/list").then((response) => {

            this.columns = response.data.layout;

            // this.columns is an object loop through it keys and push to table_fields

            for (const column_name in this.columns) {

                var column = this.columns[column_name];

                this.table_fields.push(column.name);

                if (column.foreign_fields) {
                    column.foreign_fields.forEach((foreign_field, foreign_field_index) => {
                        this.table_fields.push(foreign_field);
                    });
                }
            }

            this.layout_fetched = true;

        }).catch((error) => {
            console.log(error);
        });


    },
    data: function () {
        return {
            tmp_path_param: [],
            layout_fetched: false,
            table_fields: ['id'],
            columns: [
                { name: 'id', label: 'ID' },
            ],

        }
    },
    methods: {
        getLink(item, column) {

            if (column.relation.length == 1) {
                return column.relation[0] + '/admin/' + column.relation[0];
            } else if (column.relation.length == 2) {
                return column.relation[0] + '/admin/' + column.relation[1] + '/edit/' + item[column.name];
            }



        },
        renderField(item, column) {
            var rendered = '';

            if (column.foreign_fields) {
                column.foreign_fields.forEach((foreign_field, foreign_field_index) => {
                    if (item[foreign_field]) {
                        rendered += ' ' + item[foreign_field];
                    }
                });
            } else if (column.html == 'amount') {
                var formatter = new Intl.NumberFormat("en-US", {
                    style: "currency",
                    currency: "KES",
                    minimumFractionDigits: 2,
                });
                rendered = formatter.format(item[column.name]);

            } else {

                rendered = item[column.name];
            }


            return rendered;
        },
        log(log) {
            console.log(log);
        }
    }

};
</script>