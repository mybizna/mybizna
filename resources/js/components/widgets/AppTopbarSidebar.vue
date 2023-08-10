<template>
    <div class="w-full z-10 border-b border-dotted border-b-indigo-100 bg-indigo-500">

        <div class="flex">
            <div :class="visibles.length ? 'flex-none w-20' : 'flex-auto'">
                <div class="flex justify-start pt-1 pl-1 mr-2 space-x-4 cursor-pointer text-white">

                    <a v-if="!visibles.length" @click="drawer" class="w-15 mr-2">
                        <i :class="$store.state.system.sidebar_show ? 'text-cyan-200' : ' text-white'"
                            class="fas fa-bars text-2xl"></i>
                    </a>

                    <a @click="applist" class="w-15">
                        <i :class="$store.state.system.applist ? 'text-cyan-200' : ' text-white'"
                            class="fab fa-microsoft text-2xl "></i>

                        <div :class="$store.state.system.applist ? 'text-cyan-200' : 'text-white'"
                            class="inline-block text-sm font-bold  pl-1">
                            APP
                        </div>

                        <span
                            class="absolute inline-flex items-center justify-center w-4 h-4 leading-3 font-bold text-white bg-green-500 border border-white rounded-full top dark:border-gray-900 "
                            style="font-size: 9px !important;">
                            {{ $store.state.system.menu_length }}
                        </span>
                    </a>


                </div>
            </div>

            <div v-if="visibles.length" class="flex-auto">
                <ul id="main-menu" class="flex items-left justify-left bg-indigo-500">
                    <li class="py-2">
                        <div class="inline uppercase text-white text-sm font-bold">
                            {{ $store.state.system.menu[$store.state.system.active_menu]['title'] }}
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </li>
                    <li v-for="(visible, t_index) in visibles" :key="t_index" class="text-white px-1 py-2">
                        <a class="text-white" :href="'#' + visible.path"></a>
                        {{ visible.title }}
                    </li>
                    <li id="othersMenu" :class="hiddens.length ? '' : 'hidden'" class="group relative  py-2 px-1">
                        <a class="text-white hover:text-gray-300 cursor-pointer">Others</a>
                        <ul class="absolute hidden group-hover:block bg-white border shadow-l-lg mt-2 py-2 w-32 z-10">
                            <li v-for="(hidden, index) in hiddens" :key="index"><a :href="'#' + hidden.path"
                                    class="hover:text-gray-300 px-4 py-2 block">{{ hidden.title }}</a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>

            <div :class="visibles.length ? 'flex-none w-56' : 'flex-auto'" class="text-right">
                <div class="flex justify-end pt-1 pr-1 pb-1 mr-2 space-x-2 cursor-pointer">
                    <app-topbar-icon-others></app-topbar-icon-others>
                    <app-topbar-icon-avatar></app-topbar-icon-avatar>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import AppTopbarIconAvatar from "@/components/widgets/AppTopbarIconAvatar.vue";
import AppTopbarIconOthers from "@/components/widgets/AppTopbarIconOthers.vue";

export default {
    components: {
        AppTopbarIconAvatar,
        AppTopbarIconOthers,
    },
    setup() {
        return {};
    },

    props: {
        windowWidth: { type: String, default: window.innerWidth },
        windowHeight: { type: String, default: window.innerHeight },
    },
    watch: {
        // whenever question changes, this function will run
        '$store.state.system.menu'(newer, older) {

            var active_subs_1 = this.$store.state.system.active_subs_1;

            if (active_subs_1 == null) {
                active_subs_1 = 0;
            }

            this.menus = newer[active_subs_1]['menus'];

            this.handleResize()
        },
        '$store.state.system.active_subs_1'(newer, older) {
            this.menus = this.$store.state.system.menu[newer]['menus'];
            this.handleResize()
        },
    },
    data() {
        return {
            menus: [],
            hiddens: [],
            visibles: [],
        }
    },
    methods: {
        logout() {
            this.$store.commit("auth/logout");
        },
        drawer() {
            this.$store.commit("system/sidebar_show", !this.$store.state.system.sidebar_show);
        },
        applist() {
            this.$store.commit("system/sidebar_show", false);
            this.$store.commit("system/applist_show", !this.$store.state.system.applist_show);
        },
        handleResize() {
            // Handle resize event here
            //alert("handleResize");
            const availableSpace = window.innerWidth - 200 - 224;
            let totalWidth = 0;
            var visibles = [];
            var hiddens = [];


            console.log('this.menus');
            console.log(this.menus);

            for (const key in this.menus) {
                var item = this.menus[key];
                const itemWidth = this.measureTextWidth(item.title);
                totalWidth += itemWidth;

                if (totalWidth <= availableSpace) {
                    visibles.push(item);
                } else {
                    hiddens.push(item);
                }
            }

            console.log('visibles');
            console.log(visibles);
            console.log('hiddens');
            console.log(hiddens);


            this.visibles = visibles;
            this.hiddens = hiddens;
        },
        measureTextWidth(text) {
            const span = document.createElement('span');

            span.style.visibility = 'hidden';
            span.style.position = 'absolute';
            span.style.whiteSpace = 'nowrap';
            //span.style.fontSize = '14px';
            span.classList.add("px-1");
            span.textContent = text;

            document.body.appendChild(span);
            const width = span.offsetWidth;
            document.body.removeChild(span);
            return width;
        }
    },
    mounted() {
        window.addEventListener('resize', this.handleResize);
        window.addEventListener('load', this.handleResize);
    },
    beforeUnmount() {
        window.removeEventListener('resize', this.handleResize);
    },
};
</script>

<style lang="scss">
.user-profile-menu-content {
    .v-list-item {
        min-height: 2.5rem !important;
    }
}
</style>
