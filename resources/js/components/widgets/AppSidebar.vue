<template>
    <div v-if="$store.state.system.applist_show"
        class="absolute overflow-y-auto inset-y-0 top-10 z-10 bg-gray-50 shadow-lg rounded-l w-full h-full">

        <div class=" text-center mt-3 mb-2">
            <img class="inline-block w-8" :src="$assets_url + 'images/logos/logo-sm.png'" alt="">
            APPs
        </div>

        <div class="text-center sm:w-3/4 sm:mx-auto">
            <template v-for="(item, m_index) in $store.state.system.menu" :key="m_index">
                <div class="inline-block cursor-pointer w-28 my-3 mb-3 mx-2 sm:mx-5 sm:mx-7" @click="selectApp(m_index)">

                    <div :class="($store.state.system.active_subs_1 == m_index) ? 'bg-white' : ''"
                        class=" shadow-lg rounded-l-lg bg-white p-3">

                        <div :class="($store.state.system.active_subs_1 == m_index) ? 'bg-indigo-200' : ''"
                            class="inline-block w-16 h-16 rounded-full align-middle text-indigo-500 bg-indigo-50 hover:bg-indigo-200 text-center pt-3">
                            <i :class="item.icon + ' text-4xl'"></i>
                        </div>
                    </div>

                    <div class="mt-1">
                        {{ item.title }}
                        <span v-if="countObjectKeys(item.menus)" class="text-xs"> &#10148; </span>
                    </div>

                </div>
            </template>
        </div>

    </div>


    <div v-if="$store.state.system.sidebar_show" :style="'height:' + (windowHeight - 55) + 'px;'"
        :class="windowWidth < $responsive_point ? 'absolute' : ''"
        class="overflow-y-auto inset-y-0 top-10 z-10 bg-white w-52 h-full">

        <ul class="pl-0 mt-5">
            <template v-for="(item, m_index) in $store.state.system.menu" :key="m_index">
                <li class="text-gray-600 hover:text-gray-800 cursor-pointer"
                    :class="($store.state.system.active_subs_1 == m_index) ? '' : 'hidden'">
                    <a
                        class="no-underline flex justify-between p-1 cursor-pointer text-base font-normal rounded-lg dark:text-white hover:bg-white dark:hover:bg-gray-700">
                        <span class="ml-1 grow leading-7 text-gray-800 hover:text-blue-800">
                            {{ item.title }}
                        </span>
                    </a>
                </li>

                <ul :id="'menu-' + m_index + '-main-list'" :aria-labelledby="'menu-' + m_index + '-main'"
                    :class="($store.state.system.active_subs_1 == m_index) ? '' : 'hidden'" class="py-1 ">

                    <template v-for="(subitem, t_index) in item.menus" :key="t_index">

                        <template v-if="subitem.list.length">
                            <li>
                                <a
                                    class="no-underline flex justify-between py-1 pl-4 pr-2 cursor-point text-base font-normal  rounded-lg dark:text-white hover:bg-white dark:hover:bg-gray-700">
                                    <i class="fas fa-circle fs-6 mr-1 leading-8"></i>
                                    <span class="ml-1 grow leading-8 text-gray-900">
                                        {{ subitem.title }}
                                    </span>
                                    <i class="fas fa-angle-down text-sm leading-8"></i>
                                </a>
                            </li>

                            <ul :id="'menu-' + m_index + '-' + t_index + '-list'"
                                :aria-labelledby="'menu-' + m_index + '-' + t_index"
                                class="py-1  border-b border-b-blue-300">

                                <template v-for="(subitemmenu, s_index) in subitem.list" :key="s_index">
                                    <li v-if="subitemmenu.title == ''" class="pl-7 pr-2">
                                        <hr class="border-dotted border-blue-700" />
                                    </li>
                                    <li v-else>
                                        <a :href="'#' + subitemmenu.path"
                                            class="no-underline flex items-center w-full p-1 pl-7 text-base font-normal transition duration-75 rounded-lg group hover:bg-white dark:text-white dark:hover:bg-gray-700"
                                            @click="updateSidebarShow()">
                                            <i class="fas fa-caret-right fs-8 mr-1 leading-8"></i>
                                            {{ subitemmenu.title }}
                                        </a>
                                    </li>
                                </template>

                            </ul>

                        </template>
                        <li v-else>
                            <a :href="'#' + subitem.path" @click="updateSidebarShow()"
                                class="no-underline flex items-center w-full p-1 pl-4 text-base font-normal transition duration-75 rounded-lg group hover:bg-white dark:text-white dark:hover:bg-gray-700">
                                <i class="fas fa-circle fs-6 mr-1 leading-8"></i>
                                {{ subitem.title }}
                            </a>
                        </li>
                    </template>

                </ul>
            </template>
        </ul>
    </div>
</template>

<script>

export default {
    setup() {
        return {};
    },
    props: {
        windowWidth: { type: String, default: window.innerWidth },
        windowHeight: { type: String, default: window.innerHeight },
    },
    created() {

        this.menu = {};

        var active_subs_1 = this.$store.state.system.active_subs_1;
        var active_subs_2 = this.$store.state.system.active_subs_2;

        if (active_subs_1 != '') {
            this.menu[active_subs_1] = {};
        }

        if (active_subs_2 != '' && active_subs_2 != 'main') {   
            this.menu[active_subs_1][active_subs_2] = true;
        }
    },
    data() {
        return {
            menu: {},
            isOpen: false,
        }
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

        selectApp(passkey) {

            var item = this.$store.state.system.menu[passkey];
            console.log(item.path);

            var app = item.key;
            var path = item.path;

            if (this.$store.state.system.active_subs_1 == passkey) {
                this.isOpen = !this.isOpen;
            } else {
                this.isOpen = true;
            }

            if (app != '') {
                this.$store.commit("system/active_subs_1", passkey);

                this.$store.commit("system/sidebar_show", true);
                this.$store.commit("system/applist_show", false);

                // split path by /
                var path_arr = path.split('/');

                var appname = path_arr.shift();
                var modelname = path_arr.pop();

                if (appname == '') {
                    appname = path_arr.shift();
                }

                this.showMenu(appname, modelname);

                this.$router.push(path)

            }
        },
        toggleSideMenu(m_index = '', t_index = '', s_index = '') {

            if (this.$store.state.system.active_subs_1 == m_index) {
                this.isOpen = !this.isOpen;
            } else {
                this.isOpen = true;
            }

            this.$store.commit("system/active_subs_1", '');
            this.$store.commit("system/active_subs_2", '');
            this.$store.commit("system/active_subs_3", '');

            if (m_index != '') {
                this.$store.commit("system/active_subs_1", m_index);
            }

            if (t_index != '') {
                this.$store.commit("system/active_subs_2", t_index);
            }

            if (s_index != '') {
                this.$store.commit("system/active_subs_3", s_index);
            }

            this.menu = {};

            if (!Object.prototype.hasOwnProperty.call(this.menu, m_index)) {
                this.menu[m_index] = {};
            }

            this.menu[m_index][t_index] = !this.menu[m_index][t_index];

        },
        showMenu(module, table) {

            if (window.innerWidth < this.$responsive_point) {
                window.$store.commit("system/sidebar_show", false);
            }

            this.$store.commit("system/active_menu", module);
            this.$store.commit("system/active_submenu", table);
        }
    }
};
</script>
