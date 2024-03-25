<template>
    <template v-if="$store.getters['auth/loggedIn']">

        <div class="w-full z-10 shadow-lg bg-white">

            <div class="flex border-b border-gray-100 py-1">
                <div v-if="sidebar_show" class="flex-none w-48 "> </div>

                <div class="flex-none w-20">
                    <div class="flex justify-start pt-1 pl-1 mr-2 space-x-4 cursor-pointer text-blue-500">

                        <a @click="drawer" class="w-15">
                            <i :class="$store.state.system.applist ? 'text-cyan-200' : ' text-blue-500'"
                                class="fab fa-microsoft text-2xl "></i>

                            <div :class="$store.state.system.applist ? 'text-cyan-200' : 'text-blue-500'"
                                class="inline-block text-sm font-bold  pl-1">
                                APP
                            </div>


                            <span
                                class="absolute inline-flex items-center justify-center w-4 h-4 leading-3 font-bold text-white bg-blue-500 border border-white rounded-full top dark:border-gray-900 "
                                style="margin-left:-10px; font-size: 9px !important;">
                                {{ $store.state.system.backendmenu_length - 1 }}
                            </span>
                        </a>

                    </div>
                </div>

                <div class="flex-auto text-right">
                    <div class="flex justify-end pt-1 pr-1 pb-1 mr-2 space-x-2 cursor-pointer">
                        <app-topbar-icon-others></app-topbar-icon-others>
                        <app-topbar-icon-avatar></app-topbar-icon-avatar>
                    </div>
                </div>
            </div>
        </div>

        <app-topbar :windowWidth="windowWidth"></app-topbar>

        <div class="overflow-x-hidden">
            <div class="flex">
                <div v-if="sidebar_show" class="flex-none w-48 bg-white">
                    <template v-for="(item, m_index) in $store.state.system.backendmenu" :key="m_index">
                        <div class="flex cursor-pointer p-2"
                            @click="selectApp(m_index)">

                            <div class="flex-auto">
                                {{ item.title }}
                            </div>
                            <div class="flex-auto text-right">
                                <i class="fas fa-caret-down"></i>
                            </div>

                        </div>
                    </template>
                </div>
                <div class="flex-auto">

                    <app-topbar-actions></app-topbar-actions>

                    <main class="p-0">
                        <div class="app-content-container boxed-container">
                            <router-view :key="$route.fullPath"></router-view>
                        </div>
                    </main>
                </div>
            </div>
        </div>

    </template>
    <template v-else>
        <div class="overflow-x-hidden">
            <main class="p-0">
                <router-view :key="$route.fullPath"></router-view>
            </main>
        </div>
    </template>

    <footer v-if="$store.getters[' auth/loggedIn']" app inset color="transparent" absolute height="56"
        class="footer mt-auto py-3 bg-light">
        <div class="container">
            <div class="text-muted text-center">
                <span> &copy; 2022 - {{ currentYear }}
                    <a href="https://mybizna.com" class="text-decoration-none" target="_blank">Mybizna</a></span>
            </div>
        </div>
    </footer>
</template>

<script>


export default {
    components: {
        AppSidebar: window.$filters.fetchComponent('templates/default/manage/AppSidebar.vue'),
        AppTopbarActions: window.$filters.fetchComponent('templates/default/manage/AppTopbarActions.vue'),
        AppTopbarIconAvatar: window.$filters.fetchComponent('templates/default/manage/AppTopbarIconAvatar.vue'),
        AppTopbarIconOthers: window.$filters.fetchComponent('templates/default/manage/AppTopbarIconOthers.vue'),
    },
    props: {
        windowWidth: { type: Number, default: window.innerWidth },
        windowHeight: { type: Number, default: window.innerHeight },
    },
    data() {
        return {
            sidebar_show: true,
            currentYear: new Date().getFullYear(),
        };
    },
    methods: {
        countObjectKeys(obj) {
            return Object.keys(obj).length;
        },
        updateSidebarShow() {
            window.scrollTo(0, 0);
            if (window.innerWidth < this.$responsive_point) {
                this.$store.commit("system/sidebar_show", false);
            }
        },

        selectApp(passkey) { }
    }
};
</script>
