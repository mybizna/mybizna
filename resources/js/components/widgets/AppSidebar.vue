<template>
    <div class="overflow-y-auto">

        <div class="flex pt-1">
            <div class="flex-none p-3">
                <img class="w-8 h-8 rounded-full" src="images/avatars/1.png" alt="">
            </div>
            <div class="flex-auto">
                <h5 class="mb-0 fs-16 text-black "><span class="font-w400">{{ $store.state.auth.user.name }},</span>
                    ({{ $store.state.auth.user.username }})</h5>
                <p class="mb-0 fs-14 font-w400">{{ $store.state.auth.user.email }}</p>
            </div>
        </div>

        <ul>
            <li class="text-gray-600 hover:text-gray-800 cursor-pointer">
                <a :class="($store.state.system.active_subs_1 == '-1') ? 'bg-white' : ''"
                    class="flex justify-between p-1 cursor-pointer text-base font-normal rounded-lg dark:text-white hover:bg-white dark:hover:bg-gray-700"
                    :href="'#/'" @click="toggleSideMenu('-1')">
                    <div class="inline-block w-6 h-6 rounded-full align-middle">
                        <i class="fas fa-home text-lg"></i>
                    </div>
                    <span class="ml-1 grow leading-7 text-gray-800 hover:text-blue-800">
                        Dashboard
                    </span>
                </a>
            </li>
            <template v-for="(item, m_index) in $store.state.system.menu" :key="m_index">
                <li class="text-gray-600 hover:text-gray-800 cursor-pointer">
                    <a :class="($store.state.system.active_subs_1 == m_index) ? 'bg-white' : ''"
                        class="flex justify-between p-1 cursor-pointer text-base font-normal rounded-lg dark:text-white hover:bg-white dark:hover:bg-gray-700"
                        @click="toggleSideMenu(m_index, 'main')">
                        <div class="inline-block w-6 h-6 rounded-full align-middle">
                            <i :class="item.icon + ' text-lg'"></i>
                        </div>
                        <span class="ml-1 grow leading-7 text-gray-800 hover:text-blue-800">
                            {{ item.title }}
                        </span>
                        <i class="fas fa-angle-down leading-7"></i>
                    </a>
                </li>

                <ul :id="'menu-' + m_index + '-main-list'" :aria-labelledby="'menu-' + m_index + '-main'"
                    :class="(menu[m_index]) ? '' : 'hidden'" class="py-1 ">

                    <template v-for="(subitem, t_index) in item.menus" :key="t_index">

                        <template v-if="subitem.list.length">
                            <li>
                                <a :class="($store.state.system.active_subs_1 == m_index && $store.state.system.active_subs_2 == t_index) ? 'bg-white' : ''"
                                    class="flex justify-between py-1 pl-4 pr-2 cursor-point text-base font-normal  rounded-lg dark:text-white hover:bg-white dark:hover:bg-gray-700"
                                    @click="toggleSideMenu(m_index, t_index)">
                                    <i class="fas fa-circle fs-6 mr-1 leading-8"></i>
                                    <span class="ml-1 grow leading-8 text-gray-900">
                                        {{ subitem.title }}
                                    </span>
                                    <i class="fas fa-angle-down leading-8"></i>
                                </a>
                            </li>

                            <ul :id="'menu-' + m_index + '-' + t_index + '-list'"
                                :aria-labelledby="'menu-' + m_index + '-' + t_index"
                                :class="(menu[m_index] && menu[m_index][t_index]) ? '' : 'hidden'" class="py-1 ">

                                <template v-for="(subitemmenu, s_index) in subitem.list" :key="s_index">
                                    <li v-if="subitemmenu.title == ''" class="pl-7 pr-2">
                                        <hr class="border-dotted border-blue-700" />
                                    </li>
                                    <li v-else>
                                        <a :href="'#' + subitemmenu.path"
                                            :class="($store.state.system.active_subs_1 == m_index && $store.state.system.active_subs_2 == t_index && $store.state.system.active_subs_3 == s_index) ? 'bg-white' : ''"
                                            class="flex items-center w-full p-1 pl-7 text-base font-normal transition duration-75 rounded-lg group hover:bg-white dark:text-white dark:hover:bg-gray-700"
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
                                :class="($store.state.system.active_subs_1 == m_index && $store.state.system.active_subs_2 == t_index) ? 'bg-white' : ''"
                                class="flex items-center w-full p-1 pl-4 text-base font-normal transition duration-75 rounded-lg group hover:bg-white dark:text-white dark:hover:bg-gray-700">
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
    created() {

        this.menu = {};

        var active_subs_1 = this.$store.state.system.active_subs_1;
        var active_subs_2 = this.$store.state.system.active_subs_2;

        if (active_subs_1 != '') {
            this.menu[active_subs_1] = {};
        }

        if (active_subs_2 != '') {
            this.menu[active_subs_1][active_subs_2] = true;
        }

        console.log(this.menu);
    },
    data() {
        return {
            menu: {},
            isOpen: true,
        }
    },
    methods: {
        updateSidebarShow() {
            if (window.innerWidth < this.$responsive_point) {
                this.$store.commit("system/sidebar_show", false);
            }
        },
        toggleSideMenu(m_index = '', t_index = '', s_index = '') {

            this.$store.commit("system/active_subs_1", '');
            this.$store.commit("system/active_subs_2", '');
            this.$store.commit("system/active_subs_3", '');

            console.log(m_index);
            console.log(t_index);

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
