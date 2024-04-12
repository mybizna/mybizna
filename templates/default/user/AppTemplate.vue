<template>
    <template v-if="$store.getters['auth/loggedIn']">

        <div class="w-full z-10 shadow-lg bg-white">

            <div class="flex border-b border-gray-100 py-1">
                <div v-if="sidebar_show" class="flex-none w-48 "> </div>

                <div class="flex-none w-20">
                    <div class="flex justify-start pt-1 pl-1 mr-2 space-x-4 cursor-pointer text-blue-500">
                        <a @click="drawer" class="w-15 mr-2">
                            <i :class="$store.state.system.sidebar_show ? 'text-cyan-200' : ' text-blue-500'"
                                class="fas fa-bars text-2xl"></i>
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

        <div class="w-full z-10">
            <div class="flex">
                <div v-if="sidebar_show" class="flex-none w-56 border-r border-gray-100 shadow-lg bg-white z-2">
                    <positions name="user-sidebar"></positions>
                </div>
                <div class="flex-auto z-1">

                    <main class="p-0 z-1">
                        <router-view :key="$route.fullPath"></router-view>
                    </main>
                </div>
            </div>
        </div>

    </template>
    <template v-else>
        <div class="w-full z-10">
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
        AppTopbarIconAvatar: window.$filters.fetchComponent('templates/user/AppTopbarIconAvatar.vue'),
        AppTopbarIconOthers: window.$filters.fetchComponent('templates/user/AppTopbarIconOthers.vue'),
        AppSidebar: window.$filters.fetchComponent('templates/user/AppSidebar.vue'),
        AppTopbar: window.$filters.fetchComponent('templates/user/AppTopbar.vue'),
        AppTopbarActions: window.$filters.fetchComponent('templates/user/AppTopbarActions.vue'),
    },
    props: {
        windowWidth: { type: Number, default: window.innerWidth },
        windowHeight: { type: Number, default: window.innerHeight },
    },
    data() {
        return {
            team_menu: false,
            history_menu: false,
            sidebar_show: true,
            currentYear: new Date().getFullYear(),
        };
    },
    methods: {
        logout() {
            this.$store.commit("auth/logout");
        },
        drawer() {
            this.sidebar_show = !this.sidebar_show;
        },
    },
};
</script>

<style>
/*! CSS Used from: https://eduadmin-template.multipurposethemes.com/bs5/main/css/vendors_css.css */
/*! @import https://eduadmin-template.multipurposethemes.com/bs5/assets/vendor_components/bootstrap/dist/css/bootstrap.css */
.theme-primary.light-skin .sidebar-menu ul {
    padding-left: 2rem;
}

.theme-primary.light-skin .sidebar-menu ul {
    margin-top: 0;
    margin-bottom: 1rem;
}

.theme-primary.light-skin .sidebar-menu ul ul {
    margin-bottom: 0;
}

.theme-primary.light-skin .sidebar-menu a {
    color: #0080ff;
    text-decoration: none;
}

.theme-primary.light-skin .sidebar-menu a:hover {
    color: #0066cc;
}

.theme-primary.light-skin .sidebar-menu .position-relative {
    position: relative !important;
}

/*! end @import */
/*! @import https://eduadmin-template.multipurposethemes.com/bs5/assets/vendor_components/perfect-scrollbar/css/perfect-scrollbar.css */
.theme-primary.light-skin .sidebar-menu .ps {
    overflow: hidden !important;
    overflow-anchor: none;
    -ms-overflow-style: none;
    touch-action: auto;
    -ms-touch-action: auto;
}

.theme-primary.light-skin .sidebar-menu .ps__rail-x {
    display: none;
    opacity: 0;
    transition: background-color .2s linear, opacity .2s linear;
    -webkit-transition: background-color .2s linear, opacity .2s linear;
    height: 15px;
    bottom: 0px;
    position: absolute;
}

.theme-primary.light-skin .sidebar-menu .ps__rail-y {
    display: none;
    opacity: 0;
    transition: background-color .2s linear, opacity .2s linear;
    -webkit-transition: background-color .2s linear, opacity .2s linear;
    width: 15px;
    right: 0;
    position: absolute;
}

.theme-primary.light-skin .sidebar-menu .ps--active-y>.theme-primary.light-skin .sidebar-menu .ps__rail-y {
    display: block;
    background-color: transparent;
}

.theme-primary.light-skin .sidebar-menu .ps:hover>.ps__rail-x,
.theme-primary.light-skin .sidebar-menu .ps:hover>.ps__rail-y {
    opacity: 0.6;
}

.theme-primary.light-skin .sidebar-menu .ps .ps__rail-x:hover,
.theme-primary.light-skin .sidebar-menu .ps .ps__rail-y:hover,
.ps .ps__rail-x:focus,
.ps .ps__rail-y:focus {
    background-color: #eee;
    opacity: 0.9;
}

.theme-primary.light-skin .sidebar-menu .ps__thumb-x {
    background-color: #aaa;
    border-radius: 6px;
    transition: background-color .2s linear, height .2s ease-in-out;
    -webkit-transition: background-color .2s linear, height .2s ease-in-out;
    height: 3px;
    bottom: 1px;
    position: absolute;
}

.theme-primary.light-skin .sidebar-menu .ps__thumb-y {
    background-color: #aaa;
    border-radius: 6px;
    transition: background-color .2s linear, width .2s ease-in-out;
    -webkit-transition: background-color .2s linear, width .2s ease-in-out;
    width: 3px;
    right: 1px;
    position: absolute;
}

.theme-primary.light-skin .sidebar-menu .ps__rail-x:hover>.ps__thumb-x,
.theme-primary.light-skin .sidebar-menu .ps__rail-x:focus>.ps__thumb-x {
    background-color: #999;
    height: 11px;
}

.theme-primary.light-skin .sidebar-menu .ps__rail-y:hover>.ps__thumb-y,
.theme-primary.light-skin .sidebar-menu .ps__rail-y:focus>.ps__thumb-y {
    background-color: #999;
    width: 11px;
}

@media screen and (-ms-high-contrast: active),
(-ms-high-contrast: none) {
    .theme-primary.light-skin .sidebar-menu .ps {
        overflow: auto !important;
    }
}

/*! end @import */
/*! CSS Used from: https://eduadmin-template.multipurposethemes.com/bs5/main/css/style.css */
/*! @import https://eduadmin-template.multipurposethemes.com/bs5/main/css/color_theme.css */
.theme-primary a:hover,
.theme-primary a:active,
.theme-primary a:focus {
    color: #0052cc;
}

.theme-primary.light-skin .sidebar-menu>li.active.treeview>a {
    background: transparent;
    color: #0052cc !important;
}

.theme-primary.light-skin .sidebar-menu>li.active.treeview>a>i {
    color: #0052cc;
}

.theme-primary.light-skin .sidebar-menu>li.active.treeview>a:after {
    border-color: transparent #fafafa transparent transparent !important;
}

.theme-primary.light-skin .sidebar-menu>li.treeview .treeview-menu li a {
    color: #172b4c;
}

.theme-primary.light-skin .sidebar-menu>li:hover,
.theme-primary.light-skin .sidebar-menu>li:active,
.theme-primary.light-skin .sidebar-menu>li.active {
    background-color: rgba(0, 82, 204, 0);
    color: #0052cc;
    border-left: 5px solid rgba(0, 82, 204, 0);
}

.theme-primary.light-skin .sidebar-menu>li:hover a,
.theme-primary.light-skin .sidebar-menu>li:active a,
.theme-primary.light-skin .sidebar-menu>li.active a {
    color: #0052cc;
}

.theme-primary.light-skin .sidebar-menu>li:hover a>i,
.theme-primary.light-skin .sidebar-menu>li:active a>i,
.theme-primary.light-skin .sidebar-menu>li.active a>i {
    color: #172b4c;
    background-color: rgba(0, 82, 204, 0);
}

.theme-primary.light-skin .sidebar-menu>li.active {
    background-color: rgba(0, 82, 204, 0);
    color: #0052cc;
    border-left: 5px solid #0052cc;
}

.theme-primary.light-skin .sidebar-menu>li.active a {
    color: #0052cc;
    background-color: transparent;
}

.theme-primary.light-skin .sidebar-menu>li.active a>i {
    color: #0052cc;
    background-color: rgba(0, 82, 204, 0);
}

.theme-primary.light-skin .sidebar-menu>li.active .treeview-menu li.active {
    background-color: rgba(0, 82, 204, 0);
    color: #0052cc;
}

.theme-primary.light-skin .sidebar-menu>li.active .treeview-menu li.active a {
    color: #0052cc;
}

.theme-primary.light-skin .sidebar-menu>li.active .treeview-menu li.active a>i {
    color: #0052cc;
    background-color: rgba(0, 82, 204, 0);
}

.theme-primary.light-skin .sidebar-menu>li.active .treeview-menu li a>i {
    color: #172b4c;
    background-color: rgba(0, 82, 204, 0);
}

/*! end @import */
/*! @import https://eduadmin-template.multipurposethemes.com/bs5/assets/icons/font-awesome/css/font-awesome.css */
.theme-primary.light-skin .sidebar-menu .pull-right {
    float: right;
}

.theme-primary.light-skin .sidebar-menu .fa.pull-right {
    margin-left: .3em;
}

.theme-primary.light-skin .sidebar-menu .fa-angle-right:before {
    content: "\f105";
}

/*! end @import */
/*! @import https://eduadmin-template.multipurposethemes.com/bs5/assets/icons/icomoon/style.css */
[class^="icon-"] {
    font-family: 'icomoon' !important;
    speak: never;
    font-style: normal;
    font-weight: normal;
    font-variant: normal;
    text-transform: none;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

.icon-Cart .path1:before {
    content: "\e96b";
    opacity: 0.3;
}

.icon-Cart .path2:before {
    content: "\e96c";
    margin-left: -1em;
}

.icon-Chart-pie .path1:before {
    content: "\e97d";
    opacity: 0.3;
}

.icon-Chart-pie .path2:before {
    content: "\e97e";
    margin-left: -1em;
}

.icon-Layout-4-blocks .path1:before {
    content: "\ea5b";
}

.icon-Layout-4-blocks .path2:before {
    content: "\ea5c";
    margin-left: -1em;
    opacity: 0.3;
}

.icon-Layout-grid .path1:before {
    content: "\ea5f";
    opacity: 0.3;
}

.icon-Layout-grid .path2:before {
    content: "\ea60";
    margin-left: -1em;
}

.icon-Library .path1:before {
    content: "\eac9";
}

.icon-Library .path2:before {
    content: "\eaca";
    margin-left: -1em;
    opacity: 0.3;
}

.icon-User .path1:before {
    content: "\eb34";
    opacity: 0.3;
}

.icon-User .path2:before {
    content: "\eb35";
    margin-left: -1em;
}

.icon-File .path1:before {
    content: "\eb8d";
    opacity: 0.3;
}

.icon-File .path2:before {
    content: "\eb8e";
    margin-left: -1em;
}

.icon-File .path3:before {
    content: "\eb8f";
    margin-left: -1em;
}

.icon-Chat-check .path1:before {
    content: "\ed31";
    opacity: 0.3;
}

.icon-Chat-check .path2:before {
    content: "\ed32";
    margin-left: -1em;
}

.icon-Chat-locked .path1:before {
    content: "\ed35";
    opacity: 0.3;
}

.icon-Chat-locked .path2:before {
    content: "\ed36";
    margin-left: -1em;
}

.icon-Write .path1:before {
    content: "\ed94";
}

.icon-Write .path2:before {
    content: "\ed95";
    margin-left: -1em;
    opacity: 0.3;
}

.icon-Commit .path1:before {
    content: "\ed9b";
    opacity: 0.3;
}

.icon-Commit .path2:before {
    content: "\ed9c";
    margin-left: -1em;
}

/*! end @import */
a {
    color: #2f579a;
}

a:hover,
a:active,
a:focus {
    outline: 0;
    text-decoration: none;
}

.sidebar {
    padding-bottom: 10px;
}

.sidebar-menu {
    list-style: none;
    margin: 0 0px;
    /*padding: 15px 0px 50px 0px;*/
}

.sidebar-menu>li {
    position: relative;
    margin: 0 0px;
    padding-left: 5px;
    padding-right: 5px;
    border-radius: 0;
    border-left: 5px solid transparent;
}

.sidebar-menu>li:hover>a,
.sidebar-menu>li:active>a,
.sidebar-menu>li.active>a {
    opacity: 1;
    padding-left: 0px;
    padding-right: 0px;
}

.sidebar-menu>li:active>a,
.sidebar-menu>li.active>a,
.sidebar-menu>li:focus>a {
    font-weight: 500;
}

.sidebar-menu>li.treeview.menu-open {
    background-color: rgba(235, 237, 243, 0) !important;
}

.sidebar-menu>li.treeview.menu-open>a {
    opacity: 1;
}

.sidebar-menu>li>a {
    padding: 10px 0px;
    display: block;
}

.sidebar-menu>li>a>i {
    width: 30px;
    line-height: 28px;
    display: inline-block;
    vertical-align: middle;
    color: #172b4c;
    text-align: center;
    border-radius: 10px;
    margin-right: 5px;
    background-color: transparent;
}

.sidebar-menu>li:hover>a>i,
.sidebar-menu>li:active>a>i,
.sidebar-menu>li.active>a>i {
    color: #b5b5c3;
}

.sidebar-menu>li.menu-open>a>i,
.sidebar-menu li.menu-open>a>span {
    color: #6464f3;
}

.sidebar-menu li.header {
    padding: 10px 5px 0px;
    font-size: 12px;
    font-weight: 400;
    color: #080874;
    opacity: 0.5;
    text-transform: uppercase;
}

.sidebar-menu li>a>.pull-right-container>i {
    width: auto;
    height: auto;
    padding: 0;
    margin-right: 10px;
    -webkit-transition: transform .5s ease;
    -o-transition: transform .5s ease;
    transition: transform .5s ease;
}

.sidebar-menu li>a>.pull-right-container>.fa-angle-right {
    width: auto;
    height: auto;
    padding: 0;
    margin-right: 10px;
    -webkit-transition: transform .5s ease;
    -o-transition: transform .5s ease;
    transition: transform .5s ease;
}

.sidebar-menu .menu-open>a>.pull-right-container>.fa-angle-right {
    -webkit-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    -o-transform: rotate(90deg);
    transform: rotate(90deg);
}

.sidebar-menu .menu-open>a>.pull-right-container>i {
    -webkit-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    -o-transform: rotate(90deg);
    transform: rotate(90deg);
}

.sidebar-menu .active>.treeview-menu {
    display: block;
}

.sidebar-menu {
    white-space: nowrap;
    overflow: hidden;
}

.sidebar-menu>li.header {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: clip;
}

.sidebar-menu>li:hover.header,
.sidebar-menu>li:active.header,
.sidebar-menu>li:focus.header {
    background: transparent !important;
    border-color: transparent !important;
}

.sidebar-menu li>a {
    position: relative;
    font-weight: 500;
    opacity: 0.9;
    white-space: nowrap;
    align-items: center;
    line-height: 25px;
}

.sidebar-menu li>a>span {
    top: 3px;
    position: relative;
}

.sidebar-menu li>a>.pull-right-container {
    position: absolute;
    right: 0px;
    top: 50%;
    margin-top: -12px;
}

.sidebar-menu:hover {
    overflow: visible;
}

.sidebar-menu .treeview-menu>li.active>a {
    opacity: 1;
}

.sidebar-menu .treeview-menu>li.active>a:hover {
    opacity: 1;
}

.sidebar-menu .treeview-menu>li>a:hover {
    opacity: 1;
}

.treeview-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.treeview-menu .treeview-menu {
    padding-left: 20px;
}

.treeview-menu>li {
    margin: 0;
}

.treeview-menu>li>a {
    padding: 5px 5px 5px 25px;
    display: block;
    font-size: 1rem;
}

.treeview-menu>li>a>i {
    width: 20px;
    padding-right: 20px;
    padding-left: 10px;
}

@media (min-width: 768px) {
    .fixed .multinav {
        position: fixed;
        width: 270px;
        padding-bottom: 0;
        height: calc(100% - 80px);
    }

    .multinav .ps__rail-x {
        display: none !important;
    }
}

@media (max-width: 767px) {
    .fixed .multinav {
        position: fixed;
        width: 270px;
        padding-bottom: 0;
        height: calc(100% - 145px);
    }
}

/*! CSS Used from: https://eduadmin-template.multipurposethemes.com/bs5/main/css/skin_color.css */
.light-skin .sidebar-menu>li:hover>a,
.light-skin .sidebar-menu>li:active>a,
.light-skin .sidebar-menu>li.active>a {
    color: #172b4c;
}

.light-skin .sidebar-menu>li.active>a {
    background-color: #172b4c;
    color: #ffffff;
}

.light-skin .sidebar-menu>li.active>a>i {
    color: #ffffff;
}

.light-skin .sidebar-menu>li.active>a:after {
    content: " ";
    position: absolute;
    right: 0;
    top: 0;
    display: none;
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 22px 10px 22px 0;
    border-color: transparent #fafafa transparent transparent !important;
}

.light-skin .sidebar-menu>li.menu-open>a {
    color: #172b4c;
}

.light-skin .sidebar-menu>li>.treeview-menu {
    margin: 0 0px;
}

.light-skin .sidebar a {
    color: #172b4c;
}

.light-skin .sidebar a:hover {
    text-decoration: none;
}

/*! CSS Used fontfaces */
@font-face {
    font-family: 'icomoon';
    src: url('https://eduadmin-template.multipurposethemes.com/bs5/assets/icons/iconsmind/icomoon.eot?-rdmvgc');
    src: url('https://eduadmin-template.multipurposethemes.com/bs5/assets/icons/iconsmind/icomoon.eot?#iefix-rdmvgc') format('embedded-opentype'), url('https://eduadmin-template.multipurposethemes.com/bs5/assets/icons/iconsmind/icomoon.woff?-rdmvgc') format('woff'), url('https://eduadmin-template.multipurposethemes.com/bs5/assets/icons/iconsmind/icomoon.ttf?-rdmvgc') format('truetype'), url('https://eduadmin-template.multipurposethemes.com/bs5/assets/icons/iconsmind/icomoon.svg?-rdmvgc#icomoon') format('svg');
    font-weight: normal;
    font-style: normal;
}

@font-face {
    font-family: 'icomoon';
    src: url('https://eduadmin-template.multipurposethemes.com/bs5/assets/icons/icomoon/fonts/icomoon.eot?8vup1e');
    src: url('https://eduadmin-template.multipurposethemes.com/bs5/assets/icons/icomoon/fonts/icomoon.eot?8vup1e#iefix') format('embedded-opentype'), url('https://eduadmin-template.multipurposethemes.com/bs5/assets/icons/icomoon/fonts/icomoon.ttf?8vup1e') format('truetype'), url('https://eduadmin-template.multipurposethemes.com/bs5/assets/icons/icomoon/fonts/icomoon.woff?8vup1e') format('woff'), url('https://eduadmin-template.multipurposethemes.com/bs5/assets/icons/icomoon/fonts/icomoon.svg?8vup1e#icomoon') format('svg');
    font-weight: normal;
    font-style: normal;
    font-display: block;
}
</style>
