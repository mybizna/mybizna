<template>
    <table-render :path_param="$route.meta.path" :title="$route.meta.path_title" :table_fields="table_fields"
        :setting="{ hide_delete_button: true }">

        <template #header>
            <th-render v-for="column in columns" :key="column.name">
                {{ column.label }}
            </th-render>
        </template>

        <template #body="{ item }">

            <td v-for="column in columns" :key="column.name">
                <template v-if="column.type == 'amount'">
                    <div v-if="item[column.name] < 0" class="text-red-700"></div>
                    <div v-else class="text-green-700"></div>
                </template>
                <template v-else-if="column.type == 'select'">
                    {{ item[column.name] }}
                </template>
                <template v-else-if="column.type == 'checkbox'">
                    {{ item[column.name] }}
                </template>
                <template v-else-if="column.type == 'radio'">
                    {{ item[column.name] }}
                </template>
                <template v-else-if="column.type == 'image'">
                    {{ item[column.name] }}
                </template>
                <template v-else-if="column.type == 'file'">
                    {{ item[column.name] }}
                </template>
                <template v-else-if="column.type == 'currency'">
                    {{ item[column.name] }}
                </template>
                <template v-else-if="column.type == 'number'">
                    {{ item[column.name] }}
                </template>
                <template v-else-if="column.type == 'email'">
                    {{ item[column.name] }}
                </template>
                <template v-else-if="column.type == 'phone'">
                    {{ item[column.name] }}
                </template>
                <template v-else-if="column.type == 'url'">
                    {{ item[column.name] }}
                </template>
                <template v-else-if="column.type == 'password'">
                    {{ item[column.name] }}
                </template>
                <template v-else-if="column.type == 'color'">
                    {{ item[column.name] }}
                </template>
                <template v-else-if="column.type == 'text'">
                    {{ item[column.name] }}
                </template>
                <template v-else-if="column.type == 'textarea'">
                    {{ item[column.name] }}
                </template>
                <template v-else-if="column.type == 'html'">
                    {{ item[column.name] }}
                </template>
                <template v-else-if="column.type == 'json'">
                    {{ item[column.name] }}
                </template>
                <template v-else-if="column.type == 'markdown'">
                    {{ item[column.name] }}
                </template>
                <template v-else-if="column.type == 'wysiwyg'">
                    {{ item[column.name] }}
                </template>
                <template v-else-if="column.type == 'tags'">
                    {{ item[column.name] }}
                </template>
                <template v-else-if="column.type == 'rating'">
                    {{ item[column.name] }}
                </template>
                <template v-else-if="column.type == 'stars'">
                    {{ item[column.name] }}
                </template>
                <template v-else-if="column.type == 'icon'">
                    {{ item[column.name] }}
                </template>
                <template v-else-if="column.type == 'button'">
                    {{ item[column.name] }}
                </template>
                <template v-else-if="column.type == 'link'">
                    {{ item[column.name] }}
                </template>
                <template v-else-if="column.type == 'progress'">
                    {{ item[column.name] }}
                </template>
                <template v-else-if="column.type == 'bar'">
                    {{ item[column.name] }}
                </template>
                <template v-else-if="column.type == 'badge'">
                    {{ item[column.name] }}
                </template>
                <template v-else-if="column.type == 'status'">
                    <span v-if="item[column.name] && column['color'][item[column.name]]"
                        :class="'bg-' + column['color'][item[column.name]] + '-100 text-' + column['color'][item[column.name]] + '-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded'">
                        {{ item[column.name] }}
                    </span>
                </template>
                <template v-else-if="column.type == 'switch'">
                    <div class="text-center">
                        <btn-status :status="item.status"></btn-status>
                    </div>
                </template>
                <template v-else>
                    {{ item[column.name] }}
                </template>

            </td>
        </template>

    </table-render>
</template>

<script>
// generate sample code
export default {
    created() {
        console.log('created');
        console.log(this.$route.meta.path);

        var path = this.$route.meta.path;

        window.axios.get("fetch_layout/" + path[0] + "/" + path[1] + "/list").then((response) => {
            console.log(response.data);

            this.columns = response.data.layout;
        }).catch((error) => {
            console.log(error);
        });


    },
    data: function () {
        return {
            columns: [
                { name: 'id', label: 'ID' },
            ],

        }
    }
};
</script>