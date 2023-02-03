<template>
    <div v-if="$store.state.system.menu_length" class="row m-0">
        <div v-for="(item, index) in $store.state.system.menu" class="p-1 border-b text-center " :key="index">

            <a :href="'#' + item.path" :title="item.title" @click="loadModule(item.path, index)"
                :class="'cursor-pointer app-bar-link text-center text-decoration-none' + ($store.state.system.active_menu == index ? 'border-primary' : 'border-light')">
                <h2 class="border rounded-circle m-2 mt-0 text-white">
                    <i :class="item.icon"></i>
                </h2>

                <small class="text-black">
                    {{ item.title }}
                </small>
            </a>
        </div>
    </div>
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
