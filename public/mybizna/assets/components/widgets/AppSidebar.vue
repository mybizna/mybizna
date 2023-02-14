<template>
    <div class="overflow-y-auto">

        <div class="flex pt-1">
            <div class="flex-none p-3">
                <img class="w-8 h-8 rounded-full" src="images/avatars/1.png" alt="">
            </div>
            <div class="flex-auto">
                <h5 class="mb-0 fs-16 text-black "><span class="font-w400">John Doe,</span>
                    (newgif)</h5>
                <p class="mb-0 fs-14 font-w400">newgif@newgif.com</p>
            </div>
        </div>

        <ul>
            <li class="text-gray-600 hover:text-gray-800 cursor-pointer">
                <a class="flex justify-between p-1 cursor-pointer text-base font-normal  rounded-lg dark:text-white hover:bg-white dark:hover:bg-gray-700"
                    :href="'#/'" @click="toggleSideMenu">
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
                    <a class="flex justify-between p-1 cursor-pointer text-base font-normal  rounded-lg dark:text-white hover:bg-white dark:hover:bg-gray-700"
                        @click="showMenu(m_index, 'main')">
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
                    :class="(menu[m_index] && menu[m_index]['main']) ? '' : 'hidden'" class="py-1 ">

                    <template v-for="(subitem, t_index) in item.menus" :key="t_index">

                        <template v-if="subitem.list.length">
                            <li>
                                <a class="flex justify-between py-1 pl-4 pr-2 cursor-point text-base font-normal  rounded-lg dark:text-white hover:bg-white dark:hover:bg-gray-700"
                                    @click="showMenu(m_index, t_index)">
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

                                <template v-for="(subitemmenu, t_index) in subitem.list" :key="t_index">
                                    <li v-if="subitemmenu.title == ''" class="pl-7 pr-2">
                                        <hr class="border-dotted border-blue-700" />
                                    </li>
                                    <li v-else>
                                        <a :href="'#' + subitemmenu.path"  @click="toggleSideMenu"
                                            class="flex items-center w-full p-1 pl-7 text-base font-normal transition duration-75 rounded-lg group hover:bg-white dark:text-white dark:hover:bg-gray-700">
                                            <i class="fas fa-caret-right fs-8 mr-1 leading-8"></i>
                                            {{ subitemmenu.title }}
                                        </a>
                                    </li>
                                </template>

                            </ul>

                        </template>
                        <li v-else>
                            <a :href="'#' + subitem.path"  @click="toggleSideMenu"
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
    data() {
        return {
            menu: {},
            isOpen: true,
        }
    },
    methods: {
        toggleSideMenu() {
            if (window.innerWidth < 640) {
                window.$store.commit("system/sidebar_show", false);
            }
        },
        showMenu(module, table) {
            if (!Object.prototype.hasOwnProperty.call(this.menu, module)) {
                this.menu[module] = {};
            }
            this.menu[module][table] = !this.menu[module][table];
        }
    }
};
</script>
