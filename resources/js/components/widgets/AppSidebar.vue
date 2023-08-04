<template>
    <div class="overflow-y-auto text-center">
        <a class="text-center block my-2">
            <img class="inline-block w-10 h-10 rounded-full" :src="$assets_url + 'images/avatars/1.png'" alt="">
        </a>

        <template v-for="(item, m_index) in $store.state.system.menu" :key="m_index">
            <a :class="($store.state.system.active_subs_1 == m_index) ? 'bg-white' : ''"
                class="block my-2 text-center no-underlinep-1 cursor-pointer text-base font-normal rounded-l-lg "
                @click="toggleSideMenu(m_index, 'main')">
                <div :class="($store.state.system.active_subs_1 == m_index) ? 'bg-indigo-50' : ''"
                    class="inline-block w-10 h-10 rounded-full align-middle text-indigo-500 hover:bg-indigo-50  text-center pt-1">
                    <i :class="item.icon + ' text-2xl'"></i>
                </div>
            </a>
        </template>

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
    },
    data() {
        return {
            menu: {},
            isOpen: true,
        }
    },
    methods: {
        updateSidebarShow() {
            window.scrollTo(0, 0);
            if (window.innerWidth < this.$responsive_point) {
                this.$store.commit("system/sidebar_show", false);
            }
        },
        toggleSideMenu(m_index = '', t_index = '', s_index = '') {

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
