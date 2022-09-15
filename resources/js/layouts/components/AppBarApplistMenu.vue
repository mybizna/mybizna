<template>
    <div class="text-center">
        <v-menu v-model="menu" :close-on-content-click="false" anchor="bottom" right>
            <template v-slot:activator="{ props }">
                <v-badge color="success" :content="$store.state.system.menu_length" v-bind="props">
                    <div class="text-white" v-bind="attrs" v-on="on">
                        <i class="fas fa-tachometer-alt"></i>
                        Apps
                    </div>
                </v-badge>
            </template>

            <v-card max-width="300" min-width="250">
                <div class="row m-0">
                    <template v-if="menuIcons.length">
                        <div v-for="(item, index) in menuIcons" :key="index" class="col-sm-6 col-md-4 p-1">
                            <div class="p-1 border border-light rounded text-center">
                                <a href="#" :title="item.title" @click="loadModule(item.path, 'account')"
                                    class="app-bar-link text-center text-decoration-none">
                                    <h2 :class="
                                        'border rounded-circle m-2 mt-0 ' +
                                        item.class_str
                                    ">
                                        <i :class="item.icon"></i>
                                    </h2>

                                    <small class="text-black">{{
                                    item.title
                                    }}</small>
                                </a>
                            </div>
                        </div>
                    </template>

                    <template v-if="$store.state.system.menu_length">
                        <div v-for="(item, index) in $store.state.system.menu" :key="index"
                            class="col-sm-6 col-md-4 p-1">
                            <div class="p-1 border border-light rounded text-center">
                                <a href="#" :title="item.title" @click="loadModule(item.path, index)"
                                    class="app-bar-link text-center text-decoration-none">
                                    <h2 :class="
                                        'border rounded-circle m-2 mt-0 ' +
                                        item.class_str
                                    ">
                                        <i :class="item.icon"></i>
                                    </h2>

                                    <small class="text-black">{{
                                    item.title
                                    }}</small>
                                </a>
                            </div>
                        </div>
                    </template>
                </div>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn text @click="menu = false"> Cancel </v-btn>
                </v-card-actions>
            </v-card>
        </v-menu>
    </div>
</template>

<script>
import { useStore } from "vuex";

export default {
    setup () {
        const store = useStore();

        if (!store.state.system.has_menu) {
            store.dispatch("system/getMenu");
        }

    },

    data: () => ({
        fav: true,
        menu: false,
        message: false,
        hints: true,
        menuIcons: [
            {
                title: "dashboard",
                icon: "fas fa-tachometer-alt",
                path: "/dashboard",
                class_str: "text-danger border-danger",
            },
        ],
    }),

    methods: {
        loadModule (path, app) {
            this.$store.commit("system/active_menu", app);
            window.$router.push({
                name: path,
            });
        },
    },
};
</script>

<style lang="scss">
.user-profile-menu-content {
    .v-list-item {
        min-height: 2.5rem !important;
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
