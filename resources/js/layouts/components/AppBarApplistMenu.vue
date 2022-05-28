<template>
    <div class="text-center">
        <v-menu
            v-model="menu"
            :close-on-content-click="false"
            anchor="bottom"
            right
        >
            <template v-slot:activator="{ props }">
                <v-badge color="success" content="3" v-bind="props">
                    <div class="text-white" v-bind="attrs" v-on="on">
                        <i class="fas fa-th"></i>
                        Apps
                    </div>
                </v-badge>
            </template>

            <v-card max-width="300">
                <div class="row m-0">
                    <div
                        v-for="(item, index) in menus"
                        :key="index"
                        class="col-sm-6 col-md-4 p-1"
                    >
                        <div
                            class="p-1 border border-light rounded text-center"
                        >

                            <router-link
                                :to="item.path"
                                :title="item.title"
                                class="app-bar-link text-center text-decoration-none"
                            >
                                <h2
                                    :class="
                                        'border rounded-circle m-2 mt-0 ' +
                                        item.class_str
                                    "
                                >
                                    <i :class="item.icon"></i>
                                </h2>

                                <small class="text-black">{{ item.title }}</small>
                            </router-link>
                        </div>
                    </div>

                    <div
                        v-for="(item, index) in menuIcons"
                        :key="index"
                        class="col-sm-6 col-md-4 p-1"
                    >
                        <div
                            class="p-1 border border-light rounded text-center"
                        >
                            <router-link
                                :to="item.url"
                                :title="item.title"
                                class="app-bar-link text-center text-decoration-none"
                            >
                                <h2
                                    :class="
                                        'border rounded-circle m-2 mt-0 ' +
                                        item.class_str
                                    "
                                >
                                    <i :class="item.icon"></i>
                                </h2>

                                <small class="text-black">{{
                                    item.title
                                }}</small>
                            </router-link>
                        </div>
                    </div>
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
import { computed } from "vue";
import { useStore } from "vuex";

export default {
    setup() {
        const store = useStore();

        if (!store.state.system.has_menu) {
            store.dispatch("system/getMenu");
        }

        console.log(store.state.system.has_menu);

        let menus = computed(function () {
            return store.state.system.menu;
        });

        console.log('xxxxxxxxxxxxxxxxxxx-------xxxxxxxxxxxxxxxxxx');
        console.log('');
        console.log('');

        console.log(menus.value);


        return { menus, };
    },

     computed: {
          menups() {
              var obj = window.$store.state.system.menu;
              var result = Object.keys(obj).map((key) => [Number(key), obj[key]]);

            return result;
          }
        },
    data: () => ({
        fav: true,
        menu: false,
        message: false,
        hints: true,
        menuIcons: [
            {
                title: "Account",
                icon: "fas fa-funnel-dollar",
                url: "/account",
                class_str: "text-primary border-primary",
            },
            {
                title: "Expenses",
                icon: "fas fa-money-bill",
                url: "/expense",
                class_str: "text-secondary border-secondary",
            },
            {
                title: "Sales",
                icon: "fas fa-receipt",
                url: "/Sales",
                class_str: "text-warning border-warning",
            },
            {
                title: "Products",
                icon: "fas fa-store",
                url: "/products",
                class_str: "text-danger border-danger",
            },
            {
                title: "Payment",
                icon: "fas fa-file-invoice-dollar",
                url: "/account",
                class_str: "text-black border-black",
            },
            {
                title: "Bill",
                icon: "fas fa-hand-holding-usd",
                url: "/expense",
                class_str: "text-success border-success",
            },
        ],
    }),
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
    small{
    font-size: 12px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: block;
    }
}
</style>
