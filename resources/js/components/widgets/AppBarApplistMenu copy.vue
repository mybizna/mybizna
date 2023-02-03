<template>
    <template v-if="$store.state.system.menu_length">
        <div v-for="(item, index) in $store.state.system.menu" class="p-1 border-b border-blue-400 text-center" :key="index">

            <a :href="'#' + item.path" :title="item.title" @click="loadModule(item.path, index)"
                :class="'cursor-pointer text-center text-decoration-none' + ($store.state.system.active_menu == index ? 'border-primary' : 'border-light')"
                >
                <h2 class="w-9 h-9 border rounded-circle text-white text-center">
                    <i :class="item.icon + ' text-2xl leading-8'"></i>
                </h2>

                <small class="block text-white text-ellipsis  overflow-hidden" style="font-size:9px;">
                    {{ item.title }}
                </small>
            </a>
        </div>
    </template>
</template>

<script>
export default {

    data: () => ({
        fav: true,
        menu: false,
        message: false,
        hints: true,
    }),
    methods: {
        loadModule(path, app) {
            this.$store.commit("system/active_menu", app);
            this.$router.push(path);
        },
    },
};
</script>
