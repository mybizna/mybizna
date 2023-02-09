<template>

    <div class="dropdown">
        <a id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
            class="inline-block p-1 h-7 w-7 text-center rounded-full hover:border hover:bg-blue-100">
            <i class="fas fa-ellipsis-v text-primary"></i>
        </a>
        <ul class="dropdown-menu m-0 p-0 -mt-9" aria-labelledby="dropdownMenuButton1">
            <template :key="index" v-for="(dropdown_menu, index) in dropdown_menu_list">

                <li v-if="dropdown_menu.title == 'separator'">
                    <hr class="dropdown-divider">
                </li>
                <li v-else>
                    <a v-if="dropdown_menu.type == 'event'" class="dropdown-item"
                        @click="firePassedEvent(dropdown_menu, pitem)" :alt="dropdown_menu.title">
                        <i :class="dropdown_menu.icon + ' text-blue-300'"></i>
                        {{ dropdown_menu.title }}
                    </a>
                    <router-link v-else-if="dropdown_menu.type == 'router' || dropdown_menu.type == 'route'"
                        class="dropdown-item" :to="{ name: dropdown_menu.name, params: pitem }"
                        :alt="dropdown_menu.title">
                        <i :class="dropdown_menu.icon + ' text-blue-300'"></i>
                        {{ dropdown_menu.title }}
                    </router-link>
                    <a v-else class="dropdown-item" :alt="dropdown_menu.title"
                        :href="processLink(dropdown_menu, pitem)">
                        <i :class="dropdown_menu.icon + ' text-blue-300'"></i>
                        {{ dropdown_menu.title }}
                    </a>
                </li>

            </template>
        </ul>
    </div>

</template>

<script>
export default {
    props: {
        pitem: Object,
        dropdown_menu_list: Array,
        field_list: Array,
    },
    data() {
        return {
            generated_url: "",
        };
    },
    methods: {
         firePassedEvent(dropdown_menu, item) {
            var that = this;
            var message = "Are you sure you want to delete this record? <br> <br>";
            var fields = ['first_name', '_lastname', 'name', 'username', 'id', 'title', 'database'];

            for (const [key, value] of Object.entries(item)) {
                if (fields.includes(key)) {
                    message += `<div class="inline-block mx-2 mb-1 bg-gray-50 text-gray-800 text-sm  px-2.5 py-1 rounded dark:bg-gray-900 dark:text-gray-300"><b class="uppercase">${key}:</b> ${value}</div>`;
                }
            }

            message += '<br>';

            this.$confirm(
                {
                    message: message, button: { no: 'No', yes: 'Yes' },
                    callback:  confirm => {
                        if (confirm) {
                            console.log(dropdown_menu);
                            var path = { type: 'router', link: dropdown_menu.return };
                            that.$emitter.emit(dropdown_menu.event, { ids: [item.id], path: path });
                        }
                    }
                }
            )


        },

        processLink(dropdown_menu, item) {
            return dropdown_menu.link;
        },


    },
};
</script>
