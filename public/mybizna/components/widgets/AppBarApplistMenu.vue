<template>
    <div class="top-app-list">
        <a class="w-6 h-6 dropdown-toggle text-white" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <svg fill="#FFFFFF" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.36 122.88"
                style="enable-background:new 0 0 122.36 122.88" xml:space="preserve">
                <g>
                    <path class="st0"
                        d="M5.85,0h20.09c3.22,0,5.85,2.63,5.85,5.85v20.09c0,3.22-2.63,5.85-5.85,5.85H5.85C2.63,31.8,0,29.16,0,25.94 V5.85C0,2.63,2.63,0,5.85,0L5.85,0z M96.42,91.08h20.09c3.22,0,5.86,2.63,5.86,5.86v20.09c0,3.22-2.63,5.86-5.86,5.86H96.42 c-3.22,0-5.86-2.63-5.86-5.86V96.94C90.56,93.72,93.2,91.08,96.42,91.08L96.42,91.08z M51.14,91.08h20.09 c3.22,0,5.86,2.63,5.86,5.86v20.09c0,3.22-2.63,5.86-5.86,5.86H51.14c-3.22,0-5.85-2.63-5.85-5.86V96.94 C45.28,93.72,47.92,91.08,51.14,91.08L51.14,91.08z M5.85,91.08h20.09c3.22,0,5.85,2.63,5.85,5.86v20.09 c0,3.22-2.63,5.86-5.85,5.86H5.85c-3.22,0-5.85-2.63-5.85-5.86V96.94C0,93.72,2.63,91.08,5.85,91.08L5.85,91.08z M96.42,45.54 h20.09c3.22,0,5.86,2.63,5.86,5.86v20.09c0,3.22-2.63,5.86-5.86,5.86H96.42c-3.22,0-5.86-2.63-5.86-5.86V51.4 C90.56,48.18,93.2,45.54,96.42,45.54L96.42,45.54z M51.14,45.54h20.09c3.22,0,5.86,2.63,5.86,5.86v20.09 c0,3.22-2.63,5.86-5.86,5.86H51.14c-3.22,0-5.85-2.63-5.85-5.86V51.4C45.28,48.18,47.92,45.54,51.14,45.54L51.14,45.54z M5.85,45.54h20.09c3.22,0,5.85,2.63,5.85,5.86v20.09c0,3.22-2.63,5.86-5.85,5.86H5.85C2.63,77.34,0,74.7,0,71.48V51.4 C0,48.18,2.63,45.54,5.85,45.54L5.85,45.54z M96.42,0h20.09c3.22,0,5.86,2.63,5.86,5.85v20.09c0,3.22-2.63,5.85-5.86,5.85H96.42 c-3.22,0-5.86-2.63-5.86-5.85V5.85C90.56,2.63,93.2,0,96.42,0L96.42,0z M51.14,0h20.09c3.22,0,5.86,2.63,5.86,5.85v20.09 c0,3.22-2.63,5.85-5.86,5.85H51.14c-3.22,0-5.85-2.63-5.85-5.85V5.85C45.28,2.63,47.92,0,51.14,0L51.14,0z" />
                </g>
            </svg>
        </a>

        <div class="dropdown-menu dropdown-menu-end search-dropdown p-2 shadow-lg">
            <b>Apps</b>
            <div class="grid grid-cols-3">
                <template v-if="$store.state.system.menu_length">
                    <div v-for="(item, index) in $store.state.system.menu" :key="index" class="p-1">
                        <div
                            :class="'p-1 border rounded text-center ' + ($store.state.system.active_menu == index ? 'border-primary' : 'border-light')">
                            <a :href="'#' + item.path" :title="item.title" @click="loadModule(item.path, index)"
                                class="cursor-pointer app-bar-link text-center text-decoration-none">
                                <h2 :class="
                                    'border rounded-circle m-2 mt-0 ' +
                                    item.class_str
                                ">
                                    <i :class="item.icon"></i>
                                </h2>

                                <small class="text-black">
                                    {{ item.title }}
                                </small>
                            </a>
                        </div>
                    </div>
                </template>
            </div>
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
<style lang="scss">
.top-app-list {
    .dropdown-toggle:after {
        display: block;
        vertical-align: 0.6em;
        margin-left: 1.1em;
    }
}

.app-bar-link {
    margin: 0 auto;


    h2 {
        height: 48px;
        width: 48px;
        line-height: 48px;
        font-size: 24px;
        margin: 0 auto !important;
    }

    small {
        font-size: 12px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: block;
    }
}
</style>
