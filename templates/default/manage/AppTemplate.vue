<template>
    <template v-if="$store.getters['auth/loggedIn']">

        <div v-if="!is_wordpress" class="w-full z-10 shadow-lg bg-white">

            <div class="flex border-b border-gray-100 py-1">
                <div v-if="sidebar_show" class="flex-none w-48 "> </div>

                <div class="flex-none w-20">
                    <div class="flex justify-start pt-1 pl-1 mr-2 space-x-4 cursor-pointer text-indigo-900">

                        <a @click="drawer" class="w-15">
                            <i :class="$store.state.system.applist ? 'text-blue-500' : ' text-blue-900'"
                                class="fab fa-microsoft text-2xl "></i>

                            <div :class="$store.state.system.applist ? 'text-blue-500' : 'text-indigo-900'"
                                class="inline-block text-sm font-bold  pl-1">
                                APP
                            </div>


                            <span
                                class="absolute inline-flex items-center justify-center w-4 h-4 leading-3 font-bold text-white bg-indigo-900 border border-white rounded-full top dark:border-gray-900 "
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

        <div class="overflow-x-hidden">
            <div class="flex">
                <div v-if="sidebar_show && !is_wordpress" class="flex-none w-48 bg-white shadow-lg text-indigo-900">
                    <template v-for="(item, m_index) in $store.state.system.backendmenu" :key="m_index">

                        <div class="flex cursor-pointer p-2 pb-0" @click="showMenu(item, 'main')">
                            <div class="flex-auto w-2 text-2xl font-semibold">
                                <i :class="item.icon"></i>
                            </div>
                            <div class="flex-auto text-sm font-semibold pt-1">
                                {{ item.title }}
                            </div>
                            <div class="flex-auto text-right text-xs pt-1">
                                <i v-if="item.opened" class="fas fa-caret-down"></i>
                                <i v-else class="fas fa-caret-down"></i>
                            </div>
                        </div>

                        <template v-for="(subitem, t_index) in item.menus" :key="t_index">

                            <template v-if="item.opened">
                                <div v-if="countObjectKeys(subitem.list)" class="flex flex-col">
                                    <div class="flex cursor-pointer p-2 pl-3" @click="showMenu(subitem, 'sub')">
                                        <div class="flex-none w-4 text-xs">
                                            <i class="fas fa-hand-point-right"></i>
                                        </div>
                                        <div class="flex-auto text-sm font-semibold">
                                            {{ subitem.title }}
                                        </div>
                                        <div v-if="subitem.list.length" class="flex-auto text-right text-xs">
                                            <i v-if="subitem.opened" class="fas fa-caret-up"></i>
                                            <i v-else class="fas fa-caret-down"></i>
                                        </div>
                                    </div>
                                </div>
                                <div v-else class="flex flex-col">
                                    <a :href="'#' + subitem.path">
                                        <div class="flex cursor-pointer p-2 pl-3">
                                            <div class="flex-none w-4 text-xs">
                                                <i class="fas fa-circle" style="font-size:7px;"></i>
                                            </div>
                                            <div class="flex-auto text-sm font-semibold">
                                                {{ subitem.title }} 
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </template>

                            <template v-for="(lastitem, t_index) in subitem.list" :key="t_index">
                                <template v-if="subitem.opened">
                                    <a v-if="lastitem.title != ''" :href="'#' + lastitem.path">
                                        <div class="flex flex-col">
                                            <div class="flex cursor-pointer p-2 pl-4">
                                                <div class="flex-none w-4 text-xs" style="font-size: 8px;">
                                                    <i class="fas fa-circle" style="font-size:7px;"></i>
                                                </div>
                                                <div class="flex-auto text-sm font-semibold">
                                                    {{ lastitem.title }}
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <hr v-else class="pb-1 mt-1 mx-1 ml-6 border-b-gray-50 border-dotted">
                                </template>
                            </template>
                        </template>
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
    created(){
        this.is_wordpress= window.$is_wordpress;

        this.$store.dispatch("system/getPositions");
    },
    components: {
        AppSidebar: window.$filters.fetchComponent('templates/manage/AppSidebar.vue'),
        AppTopbarActions: window.$filters.fetchComponent('templates/manage/AppTopbarActions.vue'),
        AppTopbarIconAvatar: window.$filters.fetchComponent('templates/manage/AppTopbarIconAvatar.vue'),
        AppTopbarIconOthers: window.$filters.fetchComponent('templates/manage/AppTopbarIconOthers.vue'),
    },
    props: {
        windowWidth: { type: Number, default: window.innerWidth },
        windowHeight: { type: Number, default: window.innerHeight },
    },
    data() {
        return {
            sidebar_show: true,
            main_opened: null,
            sub_opened: null,
            is_wordpress: false,
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

        selectApp(passkey) { },
        drawer() {
            this.sidebar_show = !this.sidebar_show;
        },
        showMenu(item, level) {

            console.log(item);


            if (level == 'main') {
                if (item.menus.length == 0) {
                    return;
                }

                if (this.main_opened != null) {
                    this.main_opened.opened = false;
                }

                this.main_opened = item;

                this.main_opened.opened = true;
            }

            if (level == 'sub') {
                if (item.list.length == 0) {
                    return;
                }

                if (this.sub_opened != null) {
                    this.sub_opened.opened = false;
                }

                this.sub_opened = item;

                this.sub_opened.opened = true;
            }



        },


    }
};
</script>
